<?php
class ControllerProjectEdit extends Controller {
	private $error = array();
	//создаем группу
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		//подгрузим язык
		$this->load->language('project/edit');
		

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/project', '', 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		
		


		//подгрузим модели
		$this->load->model('account/customer');
		$this->load->model('group/group');
		$this->load->model('project/project');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		//информация о пользователе
		$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		$customer_id = $this->customer->getId();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (isset($this->request->get['project_id'])) {
				$this->model_project_project->editProject($this->request->get['project_id'], $this->request->post,$customer_id);
			} else {
				$this->model_project_project->addProject($this->request->post,$customer_id);
			}
			
			$this->session->data['success'] = !isset($this->request->get['project_id']) ? $this->language->get('text_create_success') : $this->language->get('text_edit_success');
			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $customer_id,
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);

			$this->model_account_activity->addActivity('edit project', $activity_data);
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}

		//

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}



		$data['entry_title'] 			= $this->language->get('entry_title');
		$data['entry_description'] 		= $this->language->get('entry_description');
		$data['entry_target'] 			= $this->language->get('entry_target');
		$data['entry_result'] 			= $this->language->get('entry_result');
		$data['entry_product'] 			= $this->language->get('entry_product');
		$data['entry_project_status'] 			= $this->language->get('entry_project_status');
		$data['entry_project_budget'] 			= $this->language->get('entry_project_budget');
		$data['entry_image'] 			= $this->language->get('entry_image');
		$data['entry_project_birthday'] 	= $this->language->get('entry_project_birthday');
		$data['entry_project_email'] 		= $this->language->get('entry_project_email'); 
		$data['entry_sex_status'] 		= $this->language->get('entry_sex_status'); 
		$data['entry_age_status'] 		= $this->language->get('entry_age_status'); 
		$data['entry_init_group'] 		= $this->language->get('entry_init_group'); 
		$data['entry_nationality_status'] 		= $this->language->get('entry_nationality_status'); 
		$data['entry_professional_status'] 		= $this->language->get('entry_professional_status'); 
		$data['entry_demographic_status'] 		= $this->language->get('entry_demographic_status'); 
		$data['text_submit']  = !isset($this->request->get['project_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');


		$data['text_none'] 		= $this->language->get('text_none'); 

		$this->document->setTitle(!isset($this->request->get['project_id']) ? $this->language->get('heading_title_add_project') : $this->language->get('heading_title_edit_project'));
		$data['heading_title'] 	= !isset($this->request->get['project_id']) ? $this->language->get('heading_title_add_project') : $this->language->get('heading_title_edit_project');

		//прописывает action для формы
		if (isset($this->request->get['project_id'])) {
			$data['action'] = $this->url->link('project/edit', 'project_id='.$this->request->get['project_id'], 'SSL');
		} else {
			$data['action'] = $this->url->link('project/edit', '', 'SSL');
		}
		
		

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		$project_info = array();
		if (isset($this->request->get['project_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$project_info = $this->model_project_project->getProject($this->request->get['project_id']);
		}

		//добавим проверку на админа группы
		if(!empty($project_info) && $project_info['customer_id'] != $customer_id){
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if (isset($this->request->get['project_id'])) {
			$data['project_id'] = $this->request->get['project_id'];
		} else {
			$data['project_id'] = 0;
		}
		//подтянем поля зависимы от языка
		if (isset($this->request->post['project_description'])) {
			$data['project_description'] = $this->request->post['project_description'];
		} elseif (isset($this->request->get['project_id'])) {
			$data['project_description'] = $this->model_project_project->getProjectDescriptions($this->request->get['project_id']);
		} else {
			$data['project_description'] = array();
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($project_info['image'])) {
			$data['image'] = $project_info['image'];
		} else {
			$data['image'] = '';
		}


		if (!empty($this->request->post['image'])) {
			$upload_info = $this->model_tool_upload->getUploadByCode($this->request->post['image']);
			$filename = $upload_info['filename'];
			$data['thumb'] = $this->model_tool_upload->resize($filename , 300, 300,'h');
		} elseif (!empty($project_info['image'])) {
			$upload_info = $this->model_tool_upload->getUploadByCode($project_info['image']);
			$filename = $upload_info['filename'];

			$data['thumb'] = $this->model_tool_upload->resize($filename , 300, 300,'h');
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no-image.png', 300, 300,'h');
		}
		
		$data['no_image'] = $this->model_tool_image->resize('noimage.png', 300, 300,'h');
		$data['placeholder'] = $this->model_tool_image->resize('noimage.png', 300, 300,'h');


		//список групп админа проекта
		//$customer_id
		//группы где пользователь администратор
		$results_admin_groups = $this->model_group_group->getGroupsForAdmin($customer_id);

		$data['admin_init_groups'] = array();
		foreach ($results_admin_groups as $result) {
			$data['init_groups'][] = array(
				'group_id'		=> $result['init_group_id'],
				'group_title' => $result['title']
			);
		}

		if (isset($this->request->post['init_group_id'])) {
			$data['project_init_group_id'] = $this->request->post['project_init_group_id'];
		} elseif (!empty($project_info)) {
			$data['project_init_group_id'] = $project_info['project_init_group_id'];
		} else {
			$data['project_init_group_id'] = 0;
		}





		//дата создания проекта
		if (isset($this->request->post['project_birthday'])) {
			$data['project_birthday'] = $this->request->post['project_birthday'];
		} elseif (!empty($project_info)) {
			$data['project_birthday'] =  date('Y-m-d', strtotime($project_info['project_birthday']));
		} else {
			$data['project_birthday'] = date('Y-m-d', time() - 86400);
		}

		//бюджет проекта
		if (isset($this->request->post['project_budget'])) {
			$data['project_budget'] = $this->request->post['project_budget'];
		} elseif (!empty($project_info)) {
			$data['project_budget'] = $project_info['project_budget'];
		} else {
			$data['project_budget'] = '';
		}
		//валюта проекта
		$this->load->model('localisation/currency');

		$data['currencies'] = array();

		$results = $this->model_localisation_currency->getCurrencies();

		foreach ($results as $result) {
			if ($result['status']) {
				$data['currencies'][] = array(
					'currency_id'  => $result['currency_id'],
					'title'        => $result['title'],
					'code'         => $result['code'],
					'symbol_left'  => $result['symbol_left'],
					'symbol_right' => $result['symbol_right']
				);
			}
		}

		if (isset($this->request->post['project_currency_id'])) {
			$data['project_currency_id'] = $this->request->post['project_currency_id'];
		} elseif (!empty($project_info)) {
			$data['project_currency_id'] = $project_info['project_currency_id'];
		} else {
			$data['project_currency_id'] = '';
		}

		//подгрузим список статусов для проекта
		$filter_data = array();
		$project_statuses_results = $this->model_project_project->getProjectStatuses($filter_data);
		$data['project_statuses']  = array();
		foreach ($project_statuses_results as $psr) {
			$data['project_statuses'][]  = array(
				'project_status_id' 	=> $psr['project_status_id'],
				'project_status_title' 	=> $psr['name']
			);
		}

		if (isset($this->request->post['project_status_id'])) {
			$data['project_status_id'] = $this->request->post['project_status_id'];
		} elseif (!empty($project_info)) {
			$data['project_status_id'] = $project_info['project_status_id'];
		} else {
			$data['project_status_id'] = 0;
		}

		//целевые аудиториии
		//пол

		$filter_data = array();
		$sex_statuses_results = $this->model_project_project->getSexStatuses($filter_data);
		$data['sex_statuses']  = array();
		$data['sex_statuses_desc'] = array();
		foreach ($sex_statuses_results as $ssr) {
			$data['sex_statuses'][]  = $ssr['sex_status_id'];
		}
		foreach ($sex_statuses_results as $ssr) {
			$data['sex_statuses_desc'][$ssr['sex_status_id']] = array(
				'title'  => $ssr['name']
			);
		}
		if (isset($this->request->post['sex_status'])) {
			$data['sex_status'] = $this->request->post['sex_status'];
		} elseif (!empty($project_info)) {
			if(!empty($project_info['project_sex'])){
				$data['sex_status'] = unserialize($project_info['project_sex']);
			}else{
				$data['sex_status'] = array();
			}
		} else {
			$data['sex_status'] = array();
		}


		//возраст
		$filter_data = array();
		$age_statuses_results = $this->model_project_project->getAgeStatuses($filter_data);
		$data['age_statuses']  = array();
		$data['age_statuses_desc'] = array();
		foreach ($age_statuses_results as $ssr) {
			$data['age_statuses'][]  = $ssr['age_status_id'];
		}
		foreach ($age_statuses_results as $ssr) {
			$data['age_statuses_desc'][$ssr['age_status_id']] = array(
				'title'  => $ssr['name']
			);
		}
		if (isset($this->request->post['age_status'])) {
			$data['age_status'] = $this->request->post['age_status'];
		} elseif (!empty($project_info)) {
			if(!empty($project_info['project_age'])){
				$data['age_status'] = unserialize($project_info['project_age']);
			}else{
				$data['age_status'] = array();
			}
		} else {
			$data['age_status'] = array();
		}

		//национальность ю религия
		$filter_data = array();
		$nationality_statuses_results = $this->model_project_project->getNationalityStatuses($filter_data);
		$data['nationality_statuses']  = array();
		$data['nationality_statuses_desc'] = array();
		foreach ($nationality_statuses_results as $ssr) {
			$data['nationality_statuses'][]  = $ssr['nationality_status_id'];
		}
		foreach ($nationality_statuses_results as $ssr) {
			$data['nationality_statuses_desc'][$ssr['nationality_status_id']] = array(
				'title'  => $ssr['name']
			);
		}
		if (isset($this->request->post['nationality_status'])) {
			$data['nationality_status'] = $this->request->post['nationality_status'];
		} elseif (!empty($project_info)) {
			if(!empty($project_info['project_nationality'])){
				$data['nationality_status'] = unserialize($project_info['project_nationality']);
			}else{
				$data['nationality_status'] = array();
			}
		} else {
			$data['nationality_status'] = array();
		}
		
		//профессиональный статус

    	$filter_data = array();
		$professional_statuses_results = $this->model_project_project->getProfessionalStatuses($filter_data);
		$data['professional_statuses']  = array();
		$data['professional_statuses_desc'] = array();
		foreach ($professional_statuses_results as $ssr) {
			$data['professional_statuses'][]  = $ssr['professional_status_id'];
		}
		foreach ($professional_statuses_results as $ssr) {
			$data['professional_statuses_desc'][$ssr['professional_status_id']] = array(
				'title'  => $ssr['name']
			);
		}
		if (isset($this->request->post['professional_status'])) {
			$data['professional_status'] = $this->request->post['professional_status'];
		} elseif (!empty($project_info)) {
			if(!empty($project_info['project_professional'])){
				$data['professional_status'] = unserialize($project_info['project_professional']);
			}else{
				$data['professional_status'] = array();
			}
		} else {
			$data['professional_status'] = array();
		}

		//демографический статус
		$filter_data = array();
		$demographic_statuses_results = $this->model_project_project->getDemographicStatuses($filter_data);
		$data['demographic_statuses']  = array();
		$data['demographic_statuses_desc'] = array();
		foreach ($demographic_statuses_results as $ssr) {
			$data['demographic_statuses'][]  = $ssr['demographic_status_id'];
		}
		foreach ($demographic_statuses_results as $ssr) {
			$data['demographic_statuses_desc'][$ssr['demographic_status_id']] = array(
				'title'  => $ssr['name']
			);
		}
		if (isset($this->request->post['demographic_status'])) {
			$data['demographic_status'] = $this->request->post['demographic_status'];
		} elseif (!empty($project_info)) {
			if(!empty($project_info['project_demographic'])){
				$data['demographic_status'] = unserialize($project_info['project_demographic']);
			}else{
				$data['demographic_status'] = array();
			}
		} else {
			$data['demographic_status'] = array();
		}
/*
				'sex_title' 		=> $ssr['name']

		//видимость группы ????
		if (isset($this->request->post['visibility'])) {
			$data['visibility'] = $this->request->post['visibility'];
		} elseif (!empty($project_info)) {
			$data['visibility'] = $project_info['visibility'];
		} else {
			$data['visibility'] = 1;
		}

		//статус группы
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($project_info)) {
			$data['status'] = $project_info['status'];
		} else {
			$data['status'] = 1;
		}
		*/
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/project/project_form.tpl')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/project.js');
		} else {
			$this->document->addScript('catalog/view/theme/default/assets/js/project.js');
		}
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/project/project_form.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/project/project_form.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/project/project_form.tpl', $data));
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