<?php
class ControllerContestContest extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('contest/contest');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest');

		$this->getList();
	}

	public function add() {
	
		$this->load->language('contest/contest');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_contest_contest->addContest($this->request->post);

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

			$this->response->redirect($this->url->link('contest/contest', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getForm();
	}

	public function edit() {
		$this->load->language('contest/contest');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_contest_contest->editContest($this->request->get['contest_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('contest/contest', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('contest/contest');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $contest_id) {
				$this->model_contest_contest->deleteContest($contest_id);
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

			$this->response->redirect($this->url->link('contest/contest', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('contest/contest');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $contest_id) {
				$this->model_contest_contest->copyContest($contest_id);
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

			$this->response->redirect($this->url->link('contest/contest', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}
	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'd.contest_date';
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

		$data['add'] = $this->url->link('contest/contest/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('contest/contest/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['copy'] = $this->url->link('contest/contest/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['contests'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$contest_total = $this->model_contest_contest->getTotalContests();

		$contests_results = $this->model_contest_contest->getContests($filter_data);
		
		if (!empty($contests_results)){
			
			foreach ($contests_results as $result) {
				$data['contests'][] = array(
					'contest_id' 	=> $result['contest_id'],
					'title'       	=> $result['title'],
					'contest_date'	=> rus_date($this->language->get('default_date_format'), strtotime($result['date_start'])),
					'edit'        	=> $this->url->link('contest/contest/edit', 'token=' . $this->session->data['token'] . '&contest_id=' . $result['contest_id'] . $url, 'SSL')
				);
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		
		$data['column_contest_date'] = $this->language->get('column_contest_date');
		$data['column_title'] = $this->language->get('column_title');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_copy'] = $this->language->get('button_copy');
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

		$data['sort_title'] = $this->url->link('contest/contest', 'token=' . $this->session->data['token'] . '&sort=dd.title' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('contest/contest', 'token=' . $this->session->data['token'] . '&sort=d.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $contest_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('contest/contest', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($contest_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($contest_total - $this->config->get('config_limit_admin'))) ? $contest_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $contest_total, ceil($contest_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('contest/contest_list.tpl', $data));
	}


	protected function getForm() {
	
		// инициализация подписей к полям
		$data['heading_title'] = $this->language->get('heading_title');
		$data['form_header'] = $this->language->get('form_header');

		$data['text_form'] = !isset($this->request->get['id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_organizer'] = $this->language->get('entry_organizer');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_propose'] = $this->language->get('entry_propose');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_members'] = $this->language->get('entry_members');
		$data['entry_maxprice'] = $this->language->get('entry_maxprice');
		$data['entry_totalprice'] = $this->language->get('entry_totalprice');
		$data['entry_directions'] = $this->language->get('entry_directions');
		$data['entry_contacts'] = $this->language->get('entry_contacts');		
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_datetime_end'] = $this->language->get('entry_datetime_end');
		$data['entry_date_rate'] = $this->language->get('entry_date_rate');
		$data['entry_date_result'] = $this->language->get('entry_date_result');
		$data['entry_date_finalist'] = $this->language->get('entry_date_finalist');
		$data['entry_timeline_text'] = $this->language->get('entry_timeline_text');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_direction_add'] = $this->language->get('button_direction_add');
		$data['button_direction_remove'] = $this->language->get('button_direction_remove');
		$data['button_file_add'] = $this->language->get('button_file_add');
		$data['button_file_remove'] = $this->language->get('button_file_remove');
		$data['button_expert_remove'] = $this->language->get('button_expert_remove');
		$data['button_expert_add'] = $this->language->get('button_expert_add');
		$data['button_criteria_remove'] = $this->language->get('button_criteria_remove');
		$data['button_criteria_add'] = $this->language->get('button_criteria_add');

		$data['tab_general'] 	= $this->language->get('tab_general');
		$data['tab_timeline'] 	= $this->language->get('tab_timeline');
		$data['tab_files'] 		= $this->language->get('tab_files');
		$data['tab_expert'] 	= $this->language->get('tab_expert');
		$data['tab_criteria'] 	= $this->language->get('tab_criteria');
		$data['tab_direction'] 	= $this->language->get('tab_direction');
		$data['tab_seo'] 		= $this->language->get('tab_seo');
		$data['button_add'] 	= $this->language->get('button_add');
		$data['text_none']  	= $this->language->get('text_none');	
		
		// инициализация ошибок
		foreach($this->error as $field => $error){
			
			$data["error_$field"] = $error;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['contest_experts'])) {
			$data['error_contest_experts'] = $this->error['contest_experts'];
		} else {
			$data['error_contest_experts'] = array();
		}

		$url = '';

		if (!isset($this->request->get['contest_id'])) {
			$data['action'] = $this->url->link('contest/contest/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('contest/contest/edit', 'token=' . $this->session->data['token'] . '&contest_id=' . $this->request->get['contest_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('contest/contest', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['contest_id'])) {
			$data['contest_id'] = $this->request->get['contest_id'];
		} else {
			$data['contest_id'] = 0;
		}
		
		// передача данных в форму
		if (isset($this->request->post['contest_description'])) {
		
			// при валидации
			$data = array_merge($data, $this->request->post);
		} 
		elseif (isset($this->request->get['id'])) {
		
			// при выборе из бд
			$data['contest_direction'] = $this->model_contest_contest->getContestDirections($this->request->get['id']);
			$data['contest_description'] = $this->model_contest_contest->getContestDescriptions($this->request->get['id'],false);	
			$data['contest_file'] = $this->model_contest_contest->getContestFile($this->request->get['id']);
			$data['contest_expert'] = $this->model_contest_contest->getContestExpert($this->request->get['id']);
			$data['contest_criteria'] = $this->model_contest_contest->getContestCriteria($this->request->get['id']);
		
			$data = array_merge(
				$data, 
				$this->model_contest_contest->getContest($this->request->get['id'])
			);
		} 
		else {
			
			// при новой пустой модели
			$data['contest_file'] = $data['contest_expert'] = $data['contest_criteria'] = array();
		}
		
		// получение типов конкурса
		$data['contest_types'] = $this->model_contest_contest->getContestTypes();
		
		// получение статусов конкурса
		$data['contest_statuses'] = $this->model_contest_contest->getContestStatuses();
		
		// получение списка файлов
		$this->load->model('catalog/download');
		$data['files'] = $this->model_catalog_download->getDownloads();
		
		
		$this->load->model('user/user');
		$data['experts'] = $this->model_user_user->getUsers(array('user_group_id'=>11));

//**************************************************************************************************************///
		
		//********** эксперты ************//
		//получим пользователей экспертов
		$this->load->model('sale/customer');
		$data['customers'] = array();

		$filter_data = array(

		);
		$results_customers = $this->model_sale_customer->getCustomers($filter_data);

		foreach ($results_customers as $rc) {
			$data['customers'][] = array(
				'customer_id'    => $rc['customer_id'],
				'name'           => $rc['name']
			);
		}

		// получение списка экспертов
		if (isset($this->request->post['contest_experts'])) {
			$contest_experts = $this->request->post['contest_experts'];
		} elseif (isset($this->request->get['contest_id'])) {
			$contest_experts = $this->model_contest_contest->getContestExpert($this->request->get['contest_id']);
		} else {
			$contest_experts = array();
		}
		$data['contest_experts'] = array();
		foreach ($contest_experts as $contest_expert) {
			$data['contest_experts'][] = array(
				'customer_id'    => $contest_expert['customer_id']
			);
		}
		//********** Поля для заявки ************//





		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('contest/contest_form.tpl', $data));
	}

	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'contest/contest')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		

		
		foreach ($this->request->post['contest_description'] as $language_id => $value) {
		
			$not_empty = array('title', 'organizer', 'description');
			
			foreach($not_empty as $k => $field){
				
				if (empty($value[$field])){
				
					$this->error[$field][$language_id] = $this->language->get('error_empty');
				}
			}
		}
		
		if (empty($this->request->post['maxprice'])){
			$this->error['maxprice'] = $this->language->get('error_empty');
		}

		if (isset($this->request->post['contest_experts'])) {
			foreach ($this->request->post['contest_experts'] as $stats_id => $ce) {
				if (!$ce['customer_id']) {  
					$this->error['contest_experts'][$stats_id]= $this->language->get('error_expert_customer_id');
				}
			}	
		}

		return !$this->error;
	}
	protected function validateCopy(){
		if (!$this->user->hasPermission('modify', 'contest/contest')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		//±!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! проверочку бы добавить

		return !$this->error;
	}
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'contest/contest')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		//±!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! проверочку бы добавить

		return !$this->error;
	}

	
}