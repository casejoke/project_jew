<?php
class ControllerCatalogOccasionGroup extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/occasion_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/occasion_group');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/occasion_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/occasion_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_occasion_group->addOccasionGroup($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/occasion_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/occasion_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/occasion_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_occasion_group->editOccasionGroup($this->request->get['occasion_group_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/occasion_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/occasion_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/occasion_group');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $occasion_group_id) {
				$this->model_catalog_occasion_group->deleteOccasionGroup($occasion_group_id);
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

			$this->response->redirect($this->url->link('catalog/occasion_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'dd.title';
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
			'href' => $this->url->link('catalog/occasion_group', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('catalog/occasion_group/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/occasion_group/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['occasion_groups'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$occasion_group_total = $this->model_catalog_occasion_group->getTotalOccasionGroups();

		$results = $this->model_catalog_occasion_group->getOccasionGroups($filter_data);

		foreach ($results as $result) {
			$data['occasion_groups'][] = array(
				'occasion_group_id' => $result['occasion_group_id'],
				'title'        => $result['title'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'        => $this->url->link('catalog/occasion_group/edit', 'token=' . $this->session->data['token'] . '&occasion_group_id=' . $result['occasion_group_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		
		$data['column_occasion_group_date_begin'] = $this->language->get('column_occasion_group_date_begin');
		$data['column_occasion_group_date_end'] = $this->language->get('column_occasion_group_date_end');
		$data['column_title'] = $this->language->get('column_title');

		$data['column_date_added'] = $this->language->get('column_date_added');
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

		$data['sort_title'] = $this->url->link('catalog/occasion_group', 'token=' . $this->session->data['token'] . '&sort=dd.title' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('catalog/occasion_group', 'token=' . $this->session->data['token'] . '&sort=d.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $occasion_group_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/occasion_group', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($occasion_group_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($occasion_group_total - $this->config->get('config_limit_admin'))) ? $occasion_group_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $occasion_group_total, ceil($occasion_group_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/occasion_group/occasion_group_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['occasion_group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['text_archive'] = $this->language->get('text_archive');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_draft'] = $this->language->get('text_draft');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_occasion_group_date_begin'] = $this->language->get('entry_occasion_group_date_begin');
		$data['entry_occasion_group_date_end'] = $this->language->get('entry_occasion_group_date_end');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_visibility'] = $this->language->get('entry_visibility');
		

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
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
			'href' => $this->url->link('catalog/occasion_group', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['occasion_group_id'])) {
			$data['action'] = $this->url->link('catalog/occasion_group/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/occasion_group/edit', 'token=' . $this->session->data['token'] . '&occasion_group_id=' . $this->request->get['occasion_group_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/occasion_group', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->get['occasion_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$occasion_group_info = $this->model_catalog_occasion_group->getOccasionGroup($this->request->get['occasion_group_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['occasion_group_id'])) {
			$data['occasion_group_id'] = $this->request->get['occasion_group_id'];
		} else {
			$data['occasion_group_id'] = 0;
		}

		if (isset($this->request->post['occasion_group_description'])) {
			$data['occasion_group_description'] = $this->request->post['occasion_group_description'];
		} elseif (isset($this->request->get['occasion_group_id'])) {
			$data['occasion_group_description'] = $this->model_catalog_occasion_group->getOccasionGroupDescriptions($this->request->get['occasion_group_id']);
		} else {
			$data['occasion_group_description'] = array();
		}



		$data['ar_status'] = array();
		//дописать подтяжку со статусами
//******************************************************************/
		$data['ar_status'][] = array(
			'status_id' => 0,
			'title'		=> $this->language->get('text_archive')
		);
		$data['ar_status'][] = array(
			'status_id' => 1,
			'title'		=> $this->language->get('text_active')
		);
		$data['ar_status'][] = array(
			'status_id' => 2,
			'title'		=> $this->language->get('text_draft')
		);
//******************************************************************/
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($occasion_group_info)) {
			$data['status'] = $occasion_group_info['status'];
		} else {
			$data['status'] = 1;
		}

		if (isset($this->request->post['visibility'])) {
			$data['visibility'] = $this->request->post['visibility'];
		} elseif (!empty($occasion_group_info)) {
			$data['visibility'] = $occasion_group_info['visibility'];
		} else {
			$data['visibility'] = 1;
		}

		$data['ar_in_status'] = array();
		//дописать подтяжку со статусами
//******************************************************************/
		$data['ar_in_status'][] = array(
			'status_id' => 0,
			'title'		=> 'Не учитывать в статистике'
		);
		$data['ar_in_status'][] = array(
			'status_id' => 1,
			'title'		=> 'Учитывать в статистике'
		);
//******************************************************************/
		if (isset($this->request->post['in_status'])) {
			$data['in_status'] = $this->request->post['in_status'];
		} elseif (!empty($occasion_group_info)) {
			$data['in_status'] = $occasion_group_info['in_status'];
		} else {
			$data['in_status'] = 1;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/occasion_group/occasion_group_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/occasion_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['occasion_group_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		}

		
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/occasion_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		

		return !$this->error;
	}

	
}