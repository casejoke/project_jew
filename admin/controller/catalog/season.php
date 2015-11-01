<?php
class ControllerCatalogSeason extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/season');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/season');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/season');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/season');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_season->addSeason($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/season', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/season');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/season');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_season->editSeason($this->request->get['season_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/season', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/season');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/season');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $season_id) {
				$this->model_catalog_season->deleteSeason($season_id);
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

			$this->response->redirect($this->url->link('catalog/season', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href' => $this->url->link('catalog/season', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('catalog/season/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/season/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['seasons'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$season_total = $this->model_catalog_season->getTotalSeasons();

		$results = $this->model_catalog_season->getSeasons($filter_data);

		foreach ($results as $result) {
			$data['seasons'][] = array(
				'season_id' => $result['season_id'],
				'title'        => $result['title'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'        => $this->url->link('catalog/season/edit', 'token=' . $this->session->data['token'] . '&season_id=' . $result['season_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		
		$data['column_season_date_begin'] = $this->language->get('column_season_date_begin');
		$data['column_season_date_end'] = $this->language->get('column_season_date_end');
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

		$data['sort_title'] = $this->url->link('catalog/season', 'token=' . $this->session->data['token'] . '&sort=dd.title' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('catalog/season', 'token=' . $this->session->data['token'] . '&sort=d.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $season_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/season', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($season_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($season_total - $this->config->get('config_limit_admin'))) ? $season_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $season_total, ceil($season_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/season_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['season_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['text_archive'] = $this->language->get('text_archive');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_draft'] = $this->language->get('text_draft');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_season_date_begin'] = $this->language->get('entry_season_date_begin');
		$data['entry_season_date_end'] = $this->language->get('entry_season_date_end');
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
			'href' => $this->url->link('catalog/season', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['season_id'])) {
			$data['action'] = $this->url->link('catalog/season/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/season/edit', 'token=' . $this->session->data['token'] . '&season_id=' . $this->request->get['season_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/season', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->get['season_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$season_info = $this->model_catalog_season->getSeason($this->request->get['season_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['season_id'])) {
			$data['season_id'] = $this->request->get['season_id'];
		} else {
			$data['season_id'] = 0;
		}

		if (isset($this->request->post['season_description'])) {
			$data['season_description'] = $this->request->post['season_description'];
		} elseif (isset($this->request->get['season_id'])) {
			$data['season_description'] = $this->model_catalog_season->getSeasonDescriptions($this->request->get['season_id']);
		} else {
			$data['season_description'] = array();
		}


		if (isset($this->request->post['season_date_begin'])) {
			$data['season_date_begin'] = $this->request->post['season_date_begin'];
		} elseif (!empty($season_info)) {
			$data['season_date_begin'] =  date('Y-m-d', strtotime($season_info['season_date_begin']));
		} else {
			$data['season_date_begin'] = date('Y-m-d', time() - 86400);
		}
		
		if (isset($this->request->post['season_date_end'])) {
			$data['season_date_end'] = $this->request->post['season_date_end'];
		} elseif (!empty($season_info)) {
			$data['season_date_end'] = date('Y-m-d', strtotime($season_info['season_date_end']));
		} else {
			$data['season_date_end'] = date('Y-m-d', time() - 86400);
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
		} elseif (!empty($season_info)) {
			$data['status'] = $season_info['status'];
		} else {
			$data['status'] = 1;
		}

		if (isset($this->request->post['visibility'])) {
			$data['visibility'] = $this->request->post['visibility'];
		} elseif (!empty($season_info)) {
			$data['visibility'] = $season_info['visibility'];
		} else {
			$data['visibility'] = 1;
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/season_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/season')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['season_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		}

		
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/season')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		

		return !$this->error;
	}

	
}