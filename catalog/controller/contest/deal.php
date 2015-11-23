<?php
class ControllerContestDeal extends Controller {
	private $error = array();
	public function index(){
		if ( !isset($this->request->get['contest_id']) ) {
			$this->session->data['redirect'] = $this->url->link('contest/contest', '', 'SSL');
			$this->response->redirect($this->url->link('contest/contest', '', 'SSL'));
			
		}
		
		$this->getView();
	}
	
	private function getView(){

		//************** проверки ***************//
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}
		//если конкурс в статусе работа - редирект


		//подгрузим язык
		$this->load->language('contest/deal');
		//SEO
		$this->document->setTitle($this->language->get('entry_title'));
		//$this->document->setDescription(substr(strip_tags(html_entity_decode($contest_info['meta_description'], ENT_QUOTES)), 0, 150) . '...');
		//$this->document->setKeywords($contest_info['meta_keyword']);

		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		



		$data['entry_title'] 				= $this->language->get('entry_title');
		$data['entry_description'] 			= $this->language->get('entry_description');
		$data['entry_image'] 				= $this->language->get('entry_image');
		$data['entry_contest_birthday'] 	= $this->language->get('entry_contest_birthday');
		$data['entry_contest_email'] 		= $this->language->get('entry_contest_email'); 
		
		$data['entry_contest_dates'] 		= $this->language->get('entry_contest_dates'); 
		$data['entry_contest_date_start'] 		= $this->language->get('entry_contest_date_start'); 
		$data['entry_contest_datetime_end'] 	= $this->language->get('entry_contest_datetime_end'); 
		$data['entry_contest_date_rate'] 		= $this->language->get('entry_contest_date_rate'); 
		$data['entry_contest_date_result'] 		= $this->language->get('entry_contest_date_result'); 
		$data['entry_contest_date_finalist'] 	= $this->language->get('entry_contest_date_finalist'); 

		$data['entry_contest_organizer'] 	= $this->language->get('entry_contest_organizer'); 
		$data['entry_contest_budget'] 		= $this->language->get('entry_contest_budget');
		$data['entry_contest_propose'] 		= $this->language->get('entry_contest_propose'); 
		$data['entry_contest_location'] 	= $this->language->get('entry_contest_location'); 
		$data['entry_contest_members'] 		= $this->language->get('entry_contest_members'); 
		$data['entry_contest_contacts'] 	= $this->language->get('entry_contest_contacts'); 
		$data['entry_contest_timeline_text']= $this->language->get('entry_contest_timeline_text'); 
		$data['entry_contest_budget']		= $this->language->get('entry_contest_budget'); 
		$data['entry_contest_maxprice']		= $this->language->get('entry_contest_maxprice'); 
		$data['entry_contest_totalprice']	= $this->language->get('entry_contest_totalprice'); 
		

		$data['text_create'] 				= $this->language->get('text_create');
		$data['text_member'] 				= $this->language->get('text_member');
		




		$contest_id = $this->request->get['contest_id'];
		//для шифрования
		$data['contest_id'] = $contest_id;

		

		//подгрузим модели
		$this->load->model('account/customer');
		$this->load->model('contest/contest');
		$this->load->model('project/project');
		$this->load->model('group/group');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		$contest_info = array();
		if (isset($this->request->get['contest_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$contest_info = $this->model_contest_contest->getContest($this->request->get['contest_id']);
		}
		//проверим сушествоание группы 
		if ( empty($contest_info) ){
			//редиректим на список 
			$this->session->data['redirect'] = $this->url->link('contest/contest', '', 'SSL');
			$this->response->redirect($this->url->link('contest/contest', '', 'SSL'));
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_contests'),
			'href' => $this->url->link('contest/contest', '', 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $contest_info['title'],
			'href' => $this->url->link('contest/view', 'contest_id=' . $data['contest_id'], 'SSL')
		);





		$data['contest_title'] 		=	html_entity_decode($contest_info['title'], ENT_QUOTES, 'UTF-8');
		$data['contest_description'] 	=	html_entity_decode($contest_info['description'], ENT_QUOTES, 'UTF-8');
		$data['contest_organizer'] 	=	html_entity_decode($contest_info['organizer'], ENT_QUOTES, 'UTF-8');
		$data['contest_propose'] 	=	html_entity_decode($contest_info['propose'], ENT_QUOTES, 'UTF-8');
		$data['contest_location'] 	=	html_entity_decode($contest_info['location'], ENT_QUOTES, 'UTF-8');
		$data['contest_members'] 	=	html_entity_decode($contest_info['members'], ENT_QUOTES, 'UTF-8');
		$data['contest_contacts'] 	=	html_entity_decode($contest_info['contacts'], ENT_QUOTES, 'UTF-8');
		$data['contest_timeline_text'] 	=	html_entity_decode($contest_info['timeline_text'], ENT_QUOTES, 'UTF-8');

		$data['contest_date_start'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_start']));
		$data['contest_datetime_end'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['datetime_end']));
		$data['contest_date_rate'] 			=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_rate']));
		$data['contest_date_result'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_result']));
		$data['contest_date_finalist'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_finalist']));

		$data['image'] = '';
		if (!empty($contest_info['image'])) {
			$data['image'] = $this->model_tool_image->resize($contest_info['image'], 800, 460,'w');
		} else {
			$data['image'] = $this->model_tool_image->resize('no-image.png', 800, 460,'w');
		}
		//ссылка на участие

		$data['text_im_deal'] 				= $this->language->get('text_im_deal');
		$data['im_deal']  = $this->url->link('contest/deal', 'contest_id=' . $data['contest_id'], 'SSL');	

		
		//информация о пользователе
		$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		$customer_id = $this->customer->getId();
		//стандартные поля
		$data['firstname'] = $customer_info['firstname'];
		$data['lastname'] = $customer_info['lastname'];
		$data['email'] = $customer_info['email'];
		$data['telephone'] = $customer_info['telephone'];

		// Custom Fields
		$this->load->model('account/custom_field');
		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));
		$data['account_custom_field'] = unserialize($customer_info['custom_field']);

		if (!empty($customer_info) && !empty($customer_info['image'])){
			if(preg_match('/http/', $customer_info['image'])){
				$data['avatar'] = $customer_info['image'];
			}else{
				$upload_info = $this->model_tool_upload->getUploadByCode($customer_info['image']);
				$filename = $upload_info['filename'];
				$data['avatar'] = $this->model_tool_upload->resize($filename , 360, 490, 'h');
			}
		}else{
			$data['avatar'] = $this->model_tool_image->resize('account.jpg', 360, 490, 'h');
		}
		//подтянем все активные группы
		//сделать рефактор заменить на IN () как getInfoCustomersForGroups
		$results_groups = $this->model_group_group->getGroups();
		$data['init_groups'] = array();
		foreach ($results_groups as $result_g) {
			if (!empty($result_g['image'])) {
				$upload_info = $this->model_tool_upload->getUploadByCode($result_g['image']);
				$filename = $upload_info['filename'];
				$image = $this->model_tool_upload->resize($filename , 300, 300,'h');
			} else {
				$image = $this->model_tool_image->resize('no-image.png', 300, 300,'h');
			}

			$filter_data = array();
			$filter_data = array(
				'filter_status' 		=> 	1,
				'filter_init_group_id'	=>	$result_g['init_group_id']
			);
			$results_count_customer_in_group = array();
			$results_count_customer_in_group = $this->model_group_group->getInviteGroups($filter_data);

			$count = count($results_count_customer_in_group)+1;

			$actions = array(
				'view'		=> $this->url->link('group/view', 'group_id='.$result_g['init_group_id'], 'SSL'),
				'edit'		=> $this->url->link('group/edit', 'group_id='.$result_g['init_group_id'], 'SSL'),
				'invite'	=> $this->url->link('group/invite', 'group_id='.$result_g['init_group_id'], 'SSL'),
				'agree'		=> $this->url->link('group/invite/agree', 'group_id='.$result_g['init_group_id'], 'SSL')
			);
			$data['init_groups'][$result_g['init_group_id']] = array(
				'group_id'				=> $result_g['init_group_id'],
				'group_title'			=> $result_g['title'],
				'group_image'			=> $image,
				'group_customer_count' 	=> $count,
				'action'				=> $actions
			);
		}

		//группы где пользователь администратор
		$results_admin_groups = $this->model_group_group->getGroupsForAdmin($customer_id);

		$data['admin_init_groups'] = array();
		foreach ($results_admin_groups as $result) {
			$data['admin_init_groups'][] = array(
				'group_id'	=> $result['init_group_id']
			);
		}

		//подтянем информацию ос ушествующих у пользователя проетках
		//информация о проектах где пользователь я вляется admin
		$results_projects_for_customer = $this->model_project_project->getProjectsForAdmin($customer_id);
		$data['projects_for_customer'] = array();
		foreach ($results_projects_for_customer  as $result_pfc) {

			if (!empty($result_pfc['image'])) {
				$upload_info = $this->model_tool_upload->getUploadByCode($result_pfc['image']);
				$filename = $upload_info['filename'];
				$image = $this->model_tool_upload->resize($filename , 300, 300,'h');
			} else {
				$image = $this->model_tool_image->resize('no-image.png', 300, 300,'h');
			}
			$actions = array();
			$actions = array(
				'edit'	=>	$this->url->link('project/edit', 'project_id='.$result_pfc['project_id'], 'SSL') 
			);
			$data['projects_for_customer'][] = array(
				'project_id'		=> $result_pfc['project_id'],
				'project_title'		=> $result_pfc['title'],
				'project_image'		=> $image,
				'prject_action'		=> $actions
			);

		}
		/******************* /.проекты *******************/

		$data['action'] = $this->url->link('contest/send', 'contest_id='.$contest_id, 'SSL');


		///нужна ли группа для участия в конкурсе?????

	



		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_deal.tpl')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/contest.js');
		} else {
			$this->document->addScript('catalog/view/theme/default/assets/js/contest.js');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_deal.tpl')) {
			
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/contest/contest_deal.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/contest/contest_deal.tpl', $data));
		}


	}
	protected function validate() {
		

		foreach ($this->request->post['project_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
/*
			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
*/
		}
/*
		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}
*/
		return !$this->error;
	}

}