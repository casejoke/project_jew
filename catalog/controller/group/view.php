<?php
/**
 * Просмотр Инициативной группы
 */
class ControllerGroupView extends Controller {
	public function index(){
		if ( !isset($this->request->get['group_id']) ) {
			$this->session->data['redirect'] = $this->url->link('group/group', '', 'SSL');
			$this->response->redirect($this->url->link('group/group', '', 'SSL'));
			
		}
		
		$this->getView();
	}
	
	private function getView(){
		//подгрузим язык
		$this->load->language('group/view');
		//выводим инфу о текщей группе
		$group_id = $this->request->get['group_id'];
		//для шифтрования
		$data['group_id'] = $group_id;

		//подгрузим модели
		$this->load->model('account/customer');
		$this->load->model('group/group');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		$group_info = array();
		if (isset($this->request->get['group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$group_info = $this->model_group_group->getGroup($this->request->get['group_id']);
		}
		//проверим сушествоание группы 
		if ( empty($group_info) ){
			//редиректим на список 
			$this->session->data['redirect'] = $this->url->link('group/group', '', 'SSL');
			$this->response->redirect($this->url->link('group/group', '', 'SSL'));
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_groups'),
			'href' => $this->url->link('group/group', '', 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $group_info['title'],
			'href' => $this->url->link('group/view', 'group_id=' . $data['group_id'], 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		$this->document->setTitle($group_info['title']);
		$this->document->setDescription(substr(strip_tags(html_entity_decode($group_info['meta_description'], ENT_QUOTES)), 0, 150) . '...');
		//$this->document->setKeywords($group_info['meta_keyword']);


		$data['entry_title'] 				= $this->language->get('entry_title');
		$data['entry_description'] 			= $this->language->get('entry_description');
		$data['entry_image'] 				= $this->language->get('entry_image');
		$data['entry_group_birthday'] 		= $this->language->get('entry_group_birthday');
		$data['entry_group_email'] 			= $this->language->get('entry_group_email'); 

		$data['text_create'] 				= $this->language->get('text_create');
		$data['text_member'] 				= $this->language->get('text_member');
		


		$data['group_title'] 		=	html_entity_decode($group_info['title'], ENT_QUOTES, 'UTF-8');
		$data['group_description'] 	=	html_entity_decode($group_info['description'], ENT_QUOTES, 'UTF-8');

		$data['image'] = '';
		if (!empty($group_info['image'])) {
			$upload_info = $this->model_tool_upload->getUploadByCode($group_info['image']);
			$filename = $upload_info['filename'];
			$data['image'] = $this->model_tool_upload->resize($filename , 800, 460,'w');
		} else {
			$data['image'] = $this->model_tool_image->resize('no-image.png', 800, 460,'w');
		}
		
		$data['group_birthday'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($group_info['group_birthday']));

		//подтянем администратора группы
		$admin_id = $group_info['customer_id'];
		$admin_id_hash = $admin_id;
		$data['admin_info'] = $this->model_account_customer->getCustomer($admin_id);
		$data['link_admin'] = $this->url->link('account/info', 'ch=' . $admin_id_hash, 'SSL');

		//подтянем остальных пользователей для данноой группы	
		$data['customer_agree_groups'] = array();
		$filter_data = array();
		$filter_data = array(
			'filter_init_group_id'	=>	$this->request->get['group_id'],
			'filter_status' 		=> 	1
		);
		$results_customer_agree_groups = array();
		$results_customer_agree_groups = $this->model_group_group->getInviteGroups($filter_data);
		$data['customer_agree_groups'] = array();
		$data['customer_agree_groups'][] = $admin_id;
		foreach ($results_customer_agree_groups as $result_cag) {
			$data['customer_agree_groups'][] = $result_cag['customer_id'];
		}

		$data['count_customers'] = count($data['customer_agree_groups'])+1;
		//подтянем информацию о пользователях
		$results_customer_for_group = array();

		$results_customer_for_group = $this->model_account_customer->getInfoCustomersForGroups($data['customer_agree_groups']);

		
		foreach ($results_customer_for_group as $result_cfg) {
			if(preg_match('/http/', $result_cfg['image'])){
				$image = $result_cfg['image'];
			}else{
				if (!empty($result_cfg['image'])) {
					$upload_info = $this->model_tool_upload->getUploadByCode($result_cfg['image']);
					$filename = $upload_info['filename'];
					$image = $this->model_tool_upload->resize($filename , 300, 300,'h');
				} else {
					$image = $this->model_tool_image->resize('no-image.png', 300, 300,'h');
				}
				
			}
			$customer_id_hash = $result_cfg['customer_id'];
			$actions = array(
				'info'		=> $this->url->link('account/info', 'ch=' . $customer_id_hash, 'SSL'),
			);
			$data['customers'][] = array(
				'customer_id'    			=> $result_cfg['customer_id'],
				'customer_id_hash'			=> $customer_id_hash,
				'customer_name'     		=> $result_cfg['name'],
				'customer_image'			=> $image,
				'action'		 			=> $actions 
			);
		}


		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/group/group_view.tpl')) {
			
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/group/group_view.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/group/group_view.tpl', $data));
		}


	}
	

}