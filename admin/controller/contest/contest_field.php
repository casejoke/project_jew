<?php
class ControllerContestContestField extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('contest/contest_field');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest_field');

		$this->getList();
	}

	public function add() {
		$this->load->language('contest/contest_field');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest_field');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_contest_contest_field->addContestField($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('contest/contest_field');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest_field');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_contest_contest_field->editContestField($this->request->get['contest_field_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('contest/contest_field');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest_field');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $contest_field_id) {
				$this->model_contest_contest_field->deleteContestField($contest_field_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cfd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('contest/contest_field/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('contest/contest_field/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		

		//подтянем значение категорий
		$this->load->model('localisation/category_request');

		$filter_data = array(
	      'order' =>'ASC'
	    );
	    $location_results = $this->model_localisation_category_request->getCategoryRequestes($filter_data);

	    foreach ($location_results as $lr) {
	      	$data['category_requestes'][$lr['category_request_id']] = array(
		        'category_request_id' 	=> $lr['category_request_id'],
		        'title'            		=> $lr['name'],
	        );
	    }

		$data['contest_fields'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$contest_field_total = $this->model_contest_contest_field->getTotalContestFields();

		$results = $this->model_contest_contest_field->getContestFields($filter_data);

		foreach ($results as $result) {
			$type = '';

			switch ($result['type']) {
				case 'select':
					$type = $this->language->get('text_select');
					break;
				case 'radio':
					$type = $this->language->get('text_radio');
					break;
				case 'checkbox':
					$type = $this->language->get('text_checkbox');
					break;
				case 'input':
					$type = $this->language->get('text_input');
					break;
				case 'text':
					$type = $this->language->get('text_text');
					break;
				case 'textarea':
					$type = $this->language->get('text_textarea');
					break;
				case 'file':
					$type = $this->language->get('text_file');
					break;
				case 'date':
					$type = $this->language->get('text_date');
					break;
				case 'datetime':
					$type = $this->language->get('text_datetime');
					break;
				case 'time':
					$type = $this->language->get('text_time');
					break;
			}

			$data['contest_fields'][] = array(
				'contest_field_id' => $result['contest_field_id'],
				'name'            => $result['name'],
				'location'        => $data['category_requestes'][$result['location']]['title'],
				'type'            => $type,
				'status'          => $result['status'],
				'sort_order'      => $result['sort_order'],
				'edit'            => $this->url->link('contest/contest_field/edit', 'token=' . $this->session->data['token'] . '&contest_field_id=' . $result['contest_field_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_location'] = $this->language->get('column_location');
		$data['column_type'] = $this->language->get('column_type');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . '&sort=cfd.name' . $url, 'SSL');
		$data['sort_location'] = $this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . '&sort=cf.location' . $url, 'SSL');
		$data['sort_type'] = $this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . '&sort=cf.type' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . '&sort=cf.status' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . '&sort=cf.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $contest_field_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($contest_field_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($contest_field_total - $this->config->get('config_limit_admin'))) ? $contest_field_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $contest_field_total, ceil($contest_field_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('contest/contest_field_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['contest_field_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_choose'] = $this->language->get('text_choose');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_radio'] = $this->language->get('text_radio');
		$data['text_checkbox'] = $this->language->get('text_checkbox');
		$data['text_input'] = $this->language->get('text_input');
		$data['text_text'] = $this->language->get('text_text');
		$data['text_textarea'] = $this->language->get('text_textarea');
		$data['text_file'] = $this->language->get('text_file');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_datetime'] = $this->language->get('text_datetime');
		$data['text_time'] = $this->language->get('text_time');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_value'] = $this->language->get('entry_value');
		$data['entry_custom_value'] = $this->language->get('entry_custom_value');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_field_system'] = $this->language->get('entry_field_system');
		$data['help_sort_order'] = $this->language->get('help_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_contest_field_value_add'] = $this->language->get('button_contest_field_value_add');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['contest_field_value'])) {
			$data['error_contest_field_value'] = $this->error['contest_field_value'];
		} else {
			$data['error_contest_field_value'] = array();
		}

		if (isset($this->error['location'])) {
			$data['error_location'] = $this->error['location'];
		} else {
			$data['error_location'] = '';
		}


		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['contest_field_id'])) {
			$data['action'] = $this->url->link('contest/contest_field/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('contest/contest_field/edit', 'token=' . $this->session->data['token'] . '&contest_field_id=' . $this->request->get['contest_field_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('contest/contest_field', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['contest_field_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$contest_field_info = $this->model_contest_contest_field->getContestField($this->request->get['contest_field_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['contest_field_description'])) {
			$data['contest_field_description'] = $this->request->post['contest_field_description'];
		} elseif (isset($this->request->get['contest_field_id'])) {
			$data['contest_field_description'] = $this->model_contest_contest_field->getContestFieldDescriptions($this->request->get['contest_field_id']);
		} else {
			$data['contest_field_description'] = array();
		}

		//подтянем значение категорий
		$this->load->model('localisation/category_request');

		$filter_data = array(
	      'order' =>'ASC'
	    );
	    $location_results = $this->model_localisation_category_request->getCategoryRequestes($filter_data);
	    $data['category_requestes']  = array();
	    foreach ($location_results as $lr) {
	      	$data['category_requestes'][] = array(
		        'category_request_id' 	=> $lr['category_request_id'],
		        'title'            		=> $lr['name'],
	        );
	    }




		if (isset($this->request->post['location'])) {
			$data['location'] = $this->request->post['location'];
		} elseif (!empty($contest_field_info)) {
			$data['location'] = $contest_field_info['location'];
		} else {
			$data['location'] = '';
		}

		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($contest_field_info)) {
			$data['type'] = $contest_field_info['type'];
		} else {
			$data['type'] = '';
		}

		if (isset($this->request->post['value'])) {
			$data['value'] = $this->request->post['value'];
		} elseif (!empty($contest_field_info)) {
			$data['value'] = $contest_field_info['value'];
		} else {
			$data['value'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($contest_field_info)) {
			$data['status'] = $contest_field_info['status'];
		} else {
			$data['status'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($contest_field_info)) {
			$data['sort_order'] = $contest_field_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['contest_field_value'])) {
			$contest_field_values = $this->request->post['contest_field_value'];
		} elseif (isset($this->request->get['contest_field_id'])) {
			$contest_field_values = $this->model_contest_contest_field->getContestFieldValueDescriptions($this->request->get['contest_field_id']);
		} else {
			$contest_field_values = array();
		}

		$data['contest_field_values'] = array();

		foreach ($contest_field_values as $contest_field_value) {
			$data['contest_field_values'][] = array(
				'contest_field_value_id'          => $contest_field_value['contest_field_value_id'],
				'contest_field_value_description' => $contest_field_value['contest_field_value_description'],
				'sort_order'                     => $contest_field_value['sort_order']
			);
		}

		
		if (isset($this->request->post['required'])) {
			$data['required'] = $this->request->post['required'];
		} elseif (!empty($contest_field_info)) {
			$data['required'] = $contest_field_info['required'];
		} else {
			$data['required'] = '';
		}
		


		//подтянем список системных (постоянно есть в системе)
		$data['text_customer'] = $this->language->get('text_customer');
		$data['contest_field_system']['customer'] = array();

		$data['contest_field_system']['customer'][] = array(
			'field_title'          => $this->language->get('text_account_firstname'),
			'field_source'		   => 'customer',		
			'field_value' 		   => 'firstname'
		);
		$data['contest_field_system']['customer'][] = array(
			'field_title'          => $this->language->get('text_account_lastname'),
			'field_source'		   => 'customer',		
			'field_value' 		   => 'lastname'
		);
		$data['contest_field_system']['customer'][] = array(
			'field_title'          => $this->language->get('text_account_email'),
			'field_source'		   => 'customer',		
			'field_value' 		   => 'email'
		);
		$data['contest_field_system']['customer'][] = array(
			'field_title'          => $this->language->get('text_account_telephone'),
			'field_source'		   => 'customer',		
			'field_value' 		   => 'telephone'
		);


		if (isset($this->request->post['field_system'])) {
			$data['field_system'] = $this->request->post['field_system'];
		} elseif (!empty($contest_field_info)) {
			$data['field_system'] = $contest_field_info['field_system'];
		} else {
			$data['field_system'] = '';
		}

		if (isset($this->request->post['field_system_table'])) {
			$data['field_system_table'] = $this->request->post['field_system_table'];
		} elseif (!empty($contest_field_info)) {
			$data['field_system_table'] = $contest_field_info['field_system_table'];
		} else {
			$data['field_system_table'] = '';
		}




		$_['text_project_description_title']     	= 'Название проекта';
		$_['text_project_description_target']       = 'Цель проекта';
		$_['text_project_description_product']      = 'Продукт проекта';
		$_['text_project_description_description']  = 'Описание проекта';
		$_['text_project_description_result']     	= 'Результат проекта';
		$_['text_project_image']     				= 'Изображение проекта';
		$_['text_project_birthday']     	        = 'Дата создания проекта';
		$_['text_project_init_group_id']    		= 'Инициативная проекта';
		$_['text_project_budget']     				= 'Бюджет проекта';
		$_['text_project_age_status']     			= 'Возрастные группы проекта';
		$_['text_project_sex_status']     			= 'Пол';
		$_['text_project_nationality_status']     	= 'Национальные/релиниозные группы проекта';
		$_['text_project_professional_status']     	= 'Профессиональные группы проекта';
		$_['text_project_demographic_status']     	= 'Демографические группы проекта';

		$_['text_init_group_description_title']     = 'Название инициативной группы';
		$_['text_init_group_description_description']    = 'Описание инициативной группы';
		$_['text_init_group_image']   				= 'Изображение инициативной группы';
		$_['text_init_group_birthday']     	        = 'Дата создания инициативной группы';


		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('contest/contest_field_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'contest/contest_field')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['location'] == 0) {
			$this->error['location'] = sprintf($this->language->get('error_location'));
		}

		foreach ($this->request->post['contest_field_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}




		if (($this->request->post['type'] == 'select' || $this->request->post['type'] == 'radio' || $this->request->post['type'] == 'checkbox')) {
			if (!isset($this->request->post['contest_field_value'])) {
				$this->error['warning'] = $this->language->get('error_type');
			}

			if (isset($this->request->post['contest_field_value'])) {
				foreach ($this->request->post['contest_field_value'] as $contest_field_value_id => $contest_field_value) {
					foreach ($contest_field_value['contest_field_value_description'] as $language_id => $contest_field_value_description) {
						if ((utf8_strlen($contest_field_value_description['name']) < 1) || (utf8_strlen($contest_field_value_description['name']) > 128)) {
							$this->error['contest_field_value'][$contest_field_value_id][$language_id] = $this->language->get('error_custom_value');
						}
					}
				}
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'contest/contest_field')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}