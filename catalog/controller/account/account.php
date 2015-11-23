<?php
class ControllerAccountAccount extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		$this->load->language('account/account');
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

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
 
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_my_account'] = $this->language->get('text_my_account');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_reward'] = $this->language->get('text_reward');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_recurring'] = $this->language->get('text_recurring');
		$data['text_logout'] = $this->language->get('text_logout');

		
		$data['address'] = $this->url->link('account/address', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['return'] = $this->url->link('account/return', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');
		$data['recurring'] = $this->url->link('account/recurring', '', 'SSL');
		$data['edit'] = $this->url->link('account/edit', '', 'SSL');
		$data['password'] = $this->url->link('account/password', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');

		
		if ($this->config->get('reward_status')) {
			$data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$data['reward'] = '';
		}
		

		//подгрузим модели
		$this->load->model('account/customer');
		$this->load->model('group/group');
		$this->load->model('project/project');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		//информация о пользователе
		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		}
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






		
		/******************* группы *******************/
		$data['text_add_group'] = $this->language->get('text_add_group');
		$data['add_group'] = $this->url->link('group/edit', '', 'SSL'); 

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

		
		//выведем приглашения в группы status = 2
		$filter_data = array();
		$filter_data = array(
			'filter_customer_id'	=>	$customer_id,
			'filter_status' 		=> 	2
		);
		$results_customer_invite_group = array();
		$results_customer_invite_group = $this->model_group_group->getInviteGroups($filter_data);
		$data['customer_invite_group'] = array();
		foreach ($results_customer_invite_group as $result_civg) {
			$data['customer_invite_group'][] = array(
				'group_id'	=> $result_civg['init_group_id'],
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

		/******************* /.группы *******************/

		/******************* проекты *******************/
		$data['text_add_project'] = $this->language->get('text_add_project');
		$data['add_project'] = $this->url->link('project/edit', '', 'SSL'); 

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

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/account.js');
		} else {
			$this->document->addScript('catalog/view/theme/default/assets/js/account.js');
		}


		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/account.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/account.tpl', $data));
		}
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function upload() {
		$this->load->language('tool/upload');

		$json = array();

		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));

			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
				$json['error'] = $this->language->get('error_filename');
			}

			// Allowed file extension types
			$allowed = array();

			$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));

			$filetypes = explode("\n", $extension_allowed);

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Allowed file mime types
			$allowed = array();

			$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));

			$filetypes = explode("\n", $mime_allowed);

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($this->request->files['file']['tmp_name']);

			if (preg_match('/\<\?php/i', $content)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Return any upload error
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!$json) {
			
			$code = md5(mt_rand());
			if (!$this->customer->isLogged()) {
				$file = $filename. '.' . $code ;
			}else{
				$customer_id = $this->customer->getId();
				$folder_name = md5($customer_id).'/';
				//создаем папку с назанием 
				if (!is_dir(DIR_UPLOAD . $folder_name)) {
					mkdir(DIR_UPLOAD . $folder_name, 0777);
				}
				$file = $folder_name . $filename. '.' . $code ;
				//code поправить!!!!!!!
			}
			
			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_UPLOAD . $file  );

			// Hide the uploaded file name so people can not link to it directly.
			$this->load->model('tool/upload');
			$this->load->model('account/customer');

			$json['code'] = $this->model_tool_upload->addUpload($filename, $file);

			//добавим изображение в аватар
			$this->model_account_customer->changeAvatar($json['code']);

			//рендерим изображение если это оно
			$json['thumb'] = $this->model_tool_upload->resize($file , 360, 490, 'h');

			$json['success'] = $this->language->get('text_upload');
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}


}