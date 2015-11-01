<?php
class ControllerGroupEdit extends Controller {
	private $error = array();
	//создаем группу
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		//подгрузим язык
		$this->load->language('group/edit');
		

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/group', '', 'SSL')
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
		$this->load->model('group/group');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		//информация о пользователе
		$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		$customer_id = $this->customer->getId();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (isset($this->request->get['group_id'])) {
				$this->model_group_group->editGroup($this->request->get['group_id'], $this->request->post,$customer_id);
			} else {
				$this->model_group_group->addGroup($this->request->post,$customer_id);
			}
			
			$this->session->data['success'] = !isset($this->request->get['group_id']) ? $this->language->get('text_create_success') : $this->language->get('text_edit_success');
			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $customer_id,
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);

			$this->model_account_activity->addActivity('edit group', $activity_data);
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
		$data['entry_group_birthday'] 	= $this->language->get('entry_group_birthday');
		$data['entry_group_email'] 		= $this->language->get('entry_group_email'); 
		
		$data['text_submit']  = !isset($this->request->get['group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');


		$this->document->setTitle(!isset($this->request->get['group_id']) ? $this->language->get('heading_title_add_group') : $this->language->get('heading_title_edit_group'));
		$data['heading_title'] 	= !isset($this->request->get['group_id']) ? $this->language->get('heading_title_add_group') : $this->language->get('heading_title_edit_group');

		//прописывает action для формы
		if (isset($this->request->get['group_id'])) {
			$data['action'] = $this->url->link('group/edit', 'group_id='.$this->request->get['group_id'], 'SSL');
		} else {
			$data['action'] = $this->url->link('group/edit', '', 'SSL');
		}
		
		

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		$group_info = array();
		if (isset($this->request->get['group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$group_info = $this->model_group_group->getGroup($this->request->get['group_id']);
		}

		//добавим проверку на админа группы
		if(!empty($group_info) && $group_info['customer_id'] != $customer_id){
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if (isset($this->request->get['group_id'])) {
			$data['group_id'] = $this->request->get['group_id'];
		} else {
			$data['group_id'] = 0;
		}
		//подтянем поля зависимы от языка
		if (isset($this->request->post['init_group_description'])) {
			$data['init_group_description'] = $this->request->post['init_group_description'];
		} elseif (isset($this->request->get['group_id'])) {
			$data['init_group_description'] = $this->model_group_group->getGroupDescriptions($this->request->get['group_id']);
		} else {
			$data['init_group_description'] = array();
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($group_info['image'])) {
			$data['image'] = $group_info['image'];
		} else {
			$data['image'] = '';
		}


		if (!empty($this->request->post['image'])) {
			$upload_info = $this->model_tool_upload->getUploadByCode($this->request->post['image']);
			$filename = $upload_info['filename'];
			$data['thumb'] = $this->model_tool_upload->resize($filename , 300, 300,'h');
		} elseif (!empty($group_info['image'])) {
			$upload_info = $this->model_tool_upload->getUploadByCode($group_info['image']);
			$filename = $upload_info['filename'];

			$data['thumb'] = $this->model_tool_upload->resize($filename , 300, 300,'h');
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no-image.png', 300, 300,'h');
		}
		
		$data['no_image'] = $this->model_tool_image->resize('noimage.png', 300, 300,'h');
		$data['placeholder'] = $this->model_tool_image->resize('noimage.png', 300, 300,'h');

		//дата создания группы
		if (isset($this->request->post['group_birthday'])) {
			$data['group_birthday'] = $this->request->post['group_birthday'];
		} elseif (!empty($group_info)) {
			$data['group_birthday'] =  date('Y-m-d', strtotime($group_info['group_birthday']));
		} else {
			$data['group_birthday'] = date('Y-m-d', time() - 86400);
		}


/*

		//видимость группы ????
		if (isset($this->request->post['visibility'])) {
			$data['visibility'] = $this->request->post['visibility'];
		} elseif (!empty($group_info)) {
			$data['visibility'] = $group_info['visibility'];
		} else {
			$data['visibility'] = 1;
		}

		//статус группы
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($group_info)) {
			$data['status'] = $group_info['status'];
		} else {
			$data['status'] = 1;
		}
		*/
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/group/group_form.tpl')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/group.js');
		} else {
			$this->document->addScript('catalog/view/theme/default/assets/js/group.js');
		}
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/group/group_form.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/group/group_form.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/group/group_form.tpl', $data));
		}

	}

	protected function validate() {
		

		foreach ($this->request->post['init_group_description'] as $language_id => $value) {
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