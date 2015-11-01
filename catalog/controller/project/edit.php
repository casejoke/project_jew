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
		$data['entry_image'] 			= $this->language->get('entry_image');
		$data['entry_project_birthday'] 	= $this->language->get('entry_project_birthday');
		$data['entry_project_email'] 		= $this->language->get('entry_project_email'); 
		
		$data['text_submit']  = !isset($this->request->get['project_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');


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

		//дата создания группы
		if (isset($this->request->post['project_birthday'])) {
			$data['project_birthday'] = $this->request->post['project_birthday'];
		} elseif (!empty($project_info)) {
			$data['project_birthday'] =  date('Y-m-d', strtotime($project_info['project_birthday']));
		} else {
			$data['project_birthday'] = date('Y-m-d', time() - 86400);
		}


/*

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