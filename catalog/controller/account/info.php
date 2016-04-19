<?php
class ControllerAccountInfo extends Controller {
	//отдает инфу о пользователе для просмотра другим пользователем
	public function index() {
		/*if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}*/
	//	$this->response->redirect($this->url->link('common/home', '', 'SSL'));
		$this->load->language('account/info');
		$this->document->setTitle($this->language->get('heading_title'));
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		//получим инфу  о пользователе
		//$this->request->get['ch'] = id пользователя

		if (isset($this->request->get['ch']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			
			$this->load->model('account/customer');
			$this->load->model('group/group');
			$this->load->model('project/project');
			$this->load->model('contest/contest');
			$this->load->model('tool/upload');
			$this->load->model('tool/image');
			$this->load->model('account/promocode');

			$customer_info = $this->model_account_customer->getCustomer($this->request->get['ch']);
		} else{
			$this->response->redirect($this->url->link('account/customers', '', 'SSL'));
		}
		//стандартные поля
		$data['firstname'] = $customer_info['firstname'];
		$data['lastname'] = $customer_info['lastname'];
		$data['email'] = $customer_info['email'];
		$data['telephone'] = $customer_info['telephone'];

		$this->load->model('localisation/country');
		$country = $this->model_localisation_country->getCountry($customer_info['country_id']);
    $data['country'] = (!empty($country))?$country['name']:'';
		$data['city'] 			= $customer_info['city'];
		// Custom Fields
		$this->load->model('account/custom_field');
		$this->load->model('tool/upload');
		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));
		$data['account_custom_field'] = unserialize($customer_info['custom_field']);
		$this->load->model('tool/image');
		$this->load->model('tool/upload');
		if (!empty($customer_info) && !empty($customer_info['image'])){
			if(preg_match('/http/', $customer_info['image'])){
				$data['avatar'] = $customer_info['image'];
			}else{
				$upload_info = $this->model_tool_upload->getUploadByCode($customer_info['image']);
				$filename = $upload_info['filename'];
				if (is_file(DIR_UPLOAD . $filename)) {
					$data['avatar'] = $this->model_tool_upload->resize($filename , 360, 490, 'h');
				}else{
					$data['avatar'] = $this->model_tool_image->resize('account.jpg', 360, 490, 'h');
				}
			}
		}else{
			$data['avatar'] = $this->model_tool_image->resize('account.jpg', 360, 490, 'h');
		}

		//подтянем список проектов для данного пользователя
		$customer_id = $this->request->get['ch'];

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

		$data['customer_id'] = $customer_id;
		//группы где пользователь администратор
		$results_admin_groups = $this->model_group_group->getGroupsForAdmin($customer_id);

		$data['admin_init_groups'] = array();
		foreach ($results_admin_groups as $result) {
			$data['admin_init_groups'][] = array(
				'group_id'	=> $result['init_group_id']
			);
		}

		//группы в котрых состоит пользователь, но не администратор
		$data['customer_agree_groups'] = array();
		$filter_data = array();
		$filter_data = array(
			'filter_customer_id'	=>	$customer_id,
			'filter_status' 		=> 	1
		);
		$results_customer_agree_groups = array();
		$results_customer_agree_groups = $this->model_group_group->getInviteGroups($filter_data);
		$data['customer_agree_groups'] = array();
		foreach ($results_customer_agree_groups as $result_cag) {
			$data['customer_agree_groups'][] = array(
				'group_id'	=> $result_cag['init_group_id'],
			);
		}

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
			$win = 0;
			$promocode_action = $this->url->link('account/promocode/activate', 'project_id='.$result_pfc['project_id'], 'SSL');
			if(!empty($projects_winner[$result_pfc['project_id']])){
				$win = 1;

			}
			$data['projects_for_customer'][$result_pfc['project_id']] = array(
				'project_id'			=> $result_pfc['project_id'],
				'project_title'		=> $result_pfc['title'],
				'project_image'		=> $image,
				'project_winner'  	=> $win,
				'project_action'	=> $actions,
				'promocode_action'	=> $promocode_action
			);



		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account_info.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/account_info.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/account_info.tpl', $data));
		}
	}
}
