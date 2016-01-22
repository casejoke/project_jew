<?php
class ControllerContestContestRequest extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('contest/contest_request');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest_request');

		$this->getList();
	}

	public function add() {
		$this->load->language('contest/contest_request');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest_request');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_contest_contest_request->addRequest($this->request->post);

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

			$this->response->redirect($this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('contest/contest_request');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest_request');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_contest_contest_request->editRequest($this->request->get['zone_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('contest/contest_request');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest_request');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $zone_id) {
				$this->model_contest_contest_request->deleteRequest($zone_id);
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

			$this->response->redirect($this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {


		//статусы заявки: 
		// 0 - не принята (есть комментарий)
		// 1 - принята  (видна экспертам и  ее можно оценивать)
		// 2 - не обработана () 
		//$_['text_status_not_accepted']      = 'Не одобрена';
		//$_['text_status_accepted']        	= 'Одобрена';
		//$_['text_status_processed']        	= 'В обработке';


		

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
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
			'href' => $this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('contest/contest_request/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('contest/contest_request/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

	//	$contests_results = $this->model_contest_contest->getContests($filter_data);
		//подтянем полный список конкурсов
		/*if (!empty($contests_results)){
			
			foreach ($contests_results as $result) {
				$data['contests'][] = array(
					'contest_id' 	=> $result['contest_id'],
					'title'       	=> $result['title'],
					'contest_date'	=> rus_date($this->language->get('default_date_format'), strtotime($result['date_start'])),
					'edit'        	=> $this->url->link('contest/contest/edit', 'token=' . $this->session->data['token'] . '&contest_id=' . $result['contest_id'] . $url, 'SSL')
				);
			}
		}*/

		$data['contest_requests'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$contest_request_total = $this->model_contest_contest_request->getTotalRequests();

		$results = $this->model_contest_contest_request->getRequests($filter_data);
			// 0 - не принята (есть комментарий)
		// 1 - принята  (видна экспертам и  ее можно оценивать)
		// 2 - не обработана () 
		//$_['text_status_not_accepted']      = 'Не одобрена';
		//$_['text_status_accepted']        	= 'Одобрена';
		//$_['text_status_processed']        	= 'В обработк
		$data['text_status_not_accepted'] 	= $this->language->get('text_status_not_accepted');
		$data['text_status_accepted'] 			= $this->language->get('text_status_accepted');
		$data['text_status_processed'] 			= $this->language->get('text_status_processed');
		foreach ($results as $result) {

			$status_text = '';

			switch ((int)$result['status']) {
				case '0':
					$status_text = $this->language->get('text_status_not_accepted');
					break;
				case '1':
					$status_text = $this->language->get('text_status_accepted');
					break;
				case '2':
					$status_text = $this->language->get('text_status_processed');
					break;	
				default:
					$status_text = $this->language->get('text_status_processed');
					break;
			}


			$data['contest_requests'][] = array(
				'customer_to_contest_id' 	=> $result['customer_to_contest_id'],
				'customer_id' 						=> $result['customer_id'],
				'contest_id'    					=> $result['contest_id'],
				'status'    							=> $status_text,
				'date_added'    					=> rus_date($this->language->get('datetime_format'), strtotime($result['date_added'])),
				'edit'    								=> $this->url->link('contest/contest_request/edit', 'token=' . $this->session->data['token'] . '&customer_to_contest_id=' . $result['customer_to_contest_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] 		= $this->language->get('heading_title');

		$data['text_list'] 			= $this->language->get('text_list');
		$data['text_no_results'] 	= $this->language->get('text_no_results');
		$data['text_confirm'] 		= $this->language->get('text_confirm');

		$data['column_customer'] 	= $this->language->get('column_customer');
		$data['column_contest'] 	= $this->language->get('column_contest');
		$data['column_status'] 		= $this->language->get('column_status');
		$data['column_action'] 		= $this->language->get('column_action');

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

	
		$data['sort_contest_id'] = $this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . '&sort=contest_id' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $contest_request_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($contest_request_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($contest_request_total - $this->config->get('config_limit_admin'))) ? $contest_request_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $contest_request_total, ceil($contest_request_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('contest/contest_request_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['zone_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_country'] = $this->language->get('entry_country');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
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
			'href' => $this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['zone_id'])) {
			$data['action'] = $this->url->link('contest/contest_request/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('contest/contest_request/edit', 'token=' . $this->session->data['token'] . '&zone_id=' . $this->request->get['zone_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['zone_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$zone_info = $this->model_contest_contest_request->getRequest($this->request->get['zone_id']);
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($zone_info)) {
			$data['status'] = $zone_info['status'];
		} else {
			$data['status'] = '1';
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($zone_info)) {
			$data['name'] = $zone_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['code'])) {
			$data['code'] = $this->request->post['code'];
		} elseif (!empty($zone_info)) {
			$data['code'] = $zone_info['code'];
		} else {
			$data['code'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = $this->request->post['country_id'];
		} elseif (!empty($zone_info)) {
			$data['country_id'] = $zone_info['country_id'];
		} else {
			$data['country_id'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('contest/contest_request_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'contest/contest_request')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'contest/contest_request')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/store');
		$this->load->model('sale/customer');
		$this->load->model('marketing/affiliate');
		$this->load->model('localisation/geo_zone');

		foreach ($this->request->post['selected'] as $zone_id) {
			if ($this->config->get('config_zone_id') == $zone_id) {
				$this->error['warning'] = $this->language->get('error_default');
			}

			$store_total = $this->model_setting_store->getTotalStoresByRequestId($zone_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}

			$address_total = $this->model_sale_customer->getTotalAddressesByRequestId($zone_id);

			if ($address_total) {
				$this->error['warning'] = sprintf($this->language->get('error_address'), $address_total);
			}

			$affiliate_total = $this->model_marketing_affiliate->getTotalAffiliatesByRequestId($zone_id);

			if ($affiliate_total) {
				$this->error['warning'] = sprintf($this->language->get('error_affiliate'), $affiliate_total);
			}

			$zone_to_geo_contest_request_total = $this->model_localisation_geo_zone->getTotalRequestToGeoRequestByRequestId($zone_id);

			if ($zone_to_geo_contest_request_total) {
				$this->error['warning'] = sprintf($this->language->get('error_zone_to_geo_zone'), $zone_to_geo_contest_request_total);
			}
		}

		return !$this->error;
	}
}