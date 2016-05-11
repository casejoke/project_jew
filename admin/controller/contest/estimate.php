<?php
class ControllerContestEstimate extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('contest/estimate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest');

		$this->getList();
	}

	public function add() {
	
		$this->load->language('contest/estimate');

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

			$this->response->redirect($this->url->link('contest/estimate', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getForm();
	}

	public function edit() {
		$this->load->language('contest/estimate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/contest');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_contest_contest->editEstimateContest($this->request->get['contest_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('contest/estimate', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('contest/estimate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contest/estimate');

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

			$this->response->redirect($this->url->link('contest/estimate', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
					'edit'        	=> $this->url->link('contest/estimate/edit', 'token=' . $this->session->data['token'] . '&contest_id=' . $result['contest_id'] . $url, 'SSL')
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

	
		$data['button_edit'] = $this->language->get('button_edit');

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

		$data['sort_title'] = $this->url->link('contest/estimate', 'token=' . $this->session->data['token'] . '&sort=dd.title' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('contest/estimate', 'token=' . $this->session->data['token'] . '&sort=d.date_added' . $url, 'SSL');

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
		$pagination->url = $this->url->link('contest/estimate', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($contest_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($contest_total - $this->config->get('config_limit_admin'))) ? $contest_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $contest_total, ceil($contest_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('contest/contest_estimate_list.tpl', $data));
	}


	protected function getForm() {
	
		// инициализация подписей к полям
		$data['heading_title'] = $this->language->get('heading_title');
		$data['form_header'] = $this->language->get('form_header');

		$data['text_form'] = !isset($this->request->get['contest_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

	
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] 	= $this->language->get('tab_general');
		$data['tab_expert'] 	= $this->language->get('tab_expert');
		
		$data['tab_criteria'] 	= $this->language->get('tab_criteria');
		
		// инициализация ошибок
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = '';

		if (!isset($this->request->get['contest_id'])) {
			$data['action'] = $this->url->link('contest/estimate/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('contest/estimate/edit', 'token=' . $this->session->data['token'] . '&contest_id=' . $this->request->get['contest_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('contest/estimate', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['contest_id'])) {
			$data['contest_id'] = $this->request->get['contest_id'];
		} else {
			$data['contest_id'] = 0;
		}
		
		
		if (isset($this->request->get['contest_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$contest_info = $this->model_contest_contest->getContest($this->request->get['contest_id']);
		}

		
		//получим список заявок для данного конкурса
		//у заявок статус одобрена status = 1
		$filter_data = array();
		$filter_data = array(
			'filter_status_id' 	=> 1,
			'filter_contest_id'	=> $data['contest_id']
		);
		$result_request_to_contest = $this->model_contest_contest->getRequestsForWinnerList($filter_data);


		//подтянем веса из описания конкурса
		$results_contest_criterias  = $this->model_contest_contest->getContestCriteria($this->request->get['contest_id']);
		$result_criterias = array();
		foreach ($results_contest_criterias as $vcc) {
			$result_criterias[$vcc['contest_criteria_id']] = array(
				'criteria_id'					=> $vcc['contest_criteria_id'],
				'criteria_weight'			=> $vcc['weight']
			);
		}

		//подтянем список всех пользователей
		$this->load->model('sale/customer');
		$filter_data = array();
		$results = $this->model_sale_customer->getCustomers($filter_data);
		$customers = array();
		foreach ($results as $result) {
			
			$customers[$result['customer_id']] = array(
				'customer_id'    => $result['customer_id'],
				'name'           => $result['name']
			);
		}

		//получим оценки и баллы для данных заявок
		$filter_data = array();
		$filter_data = array(
			'filter_contest_id'	=> $data['contest_id']
		);
		$result_estimate_to_contest = $this->model_contest_contest->getEstimateForWinnerList($filter_data);
		//customer_to_contest_id 	- id заявки
		//customer_id 						- id эксперта
		//value 									- id оценка
		//customer_to_contest_id - id заявки


		$estimate = array();
		$recommendation = array();
		foreach ($result_estimate_to_contest as $vetc) {
			$mark = array();
			$mark = unserialize($vetc['value']);
			$total = 0;
			
			if(!empty($mark['estimate_request'])){
				foreach ($mark['estimate_request'] as $km => $vm) {
					//$km - id критерия
					//$vm - оценка
					//вес = $result_criterias[$km]['criteria_weight']
					$total +=  $result_criterias[$km]['criteria_weight']*$vm;

				}
			}
			
			$estimate[$vetc['customer_to_contest_id']]=array(
				'request_scores' => $total
			);
			if(!empty($recommendation[$vetc['customer_to_contest_id']]['recommendation'] )){
				$recommendation[$vetc['customer_to_contest_id']]['recommendation'] += $vetc['recommendation'];
			}else{
				$recommendation[$vetc['customer_to_contest_id']]['recommendation'] = $vetc['recommendation'];
			}
			
		}
		

		$data['list_request'] = array();
		foreach ($result_request_to_contest as $vrtc) {
			$request_score = 0;
			if(!empty($estimate[$vrtc['customer_to_contest_id']]['request_scores'])){
				$request_score = $estimate[$vrtc['customer_to_contest_id']]['request_scores'];
			}
			$recommendation_score = 0;
			if(!empty($recommendation[$vrtc['customer_to_contest_id']]['recommendation'])){
				$recommendation_score = $recommendation[$vrtc['customer_to_contest_id']]['recommendation'];
			}
			

			$action = array();
			$action = array(
				'view_request' => $this->url->link('contest/contest_request/edit', 'token=' . $this->session->data['token'] . '&customer_to_contest_id=' . $vrtc['customer_to_contest_id'], 'SSL')
			);

			$place_id = 0;
			$filter_data = array(
				'filter_request_id'  => $vrtc['customer_to_contest_id']
			);
			$data_for_request = $this->model_contest_contest->getWinners($filter_data);



			if(!empty($data_for_request)){
				//значит место назначено
				$place_id = $data_for_request[0]['place_id'];
			}



			$data['list_request'][] = array(
				'customer_to_contest_id'	=>	$vrtc['customer_to_contest_id'],
				'customer_id'							=> 	$vrtc['customer_id'],
				'customer_name'							=> 	$customers[$vrtc['customer_id']]['name'],
				'contest_id'							=>  $vrtc['contest_id'],
				'adaptive_id'							=>  $vrtc['adaptive_id'],
				'project_id'							=>  $vrtc['project_id'],
				'recommendation_score'					=>  $recommendation_score,
				'score' 								=> 	$request_score,
				'place'									=>  $place_id,
				'action'								=>  $action
			);
		}
		//
		usort($data['list_request'], 'sortByScore');

		
		//подтянем количесвто мест
		$data['count_winner_place'] =  $contest_info['count_winner'];




		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('contest/contest_estimate_form.tpl', $data));
	}

	//add winner
	public function addWinner(){
		$json =	array();
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateWinner()) {
				$this->load->model('contest/contest');
				$this->model_contest_contest->addWinner($this->request->post);
				//добавить проверочик
					
			}
			if($this->error){
				$json['error'] = $this->error;
			}else{
				$json['success'] = true;
			}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	private function validateWinner(){
		//проверка на побкедителя
		return !$this->error;
	}
	//remove winner
	public function removeWinner(){

		$json =	array();
		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
				$this->load->model('contest/contest');
				$this->model_contest_contest->removeWinner($this->request->post);
				//добавить проверочик
					
			}
			if($this->error){
				$json['error'] = $this->error;
			}else{
				$json['success'] = true;
			}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getCountPlaceForContest(){
		$json =	array();
		//получим id конкурса
		$data = $this->request->post;

		$this->load->model('contest/contest');
		$contest_id = $data['contest_id'];
		//получим количество меств
		$contest_info = $this->model_contest_contest->getContest($contest_id);
		$count_winner =  $contest_info['count_winner'];
		
		//получим список победителей для данного конкурса из таюлицы oc_contest_winner
		//и получим места
		$filter_data = array(
			'filter_contest_id'  => $contest_id
		);
		$contest_winners = $this->model_contest_contest->getWinners($filter_data);
		$isset_winner_place = array();
		foreach ($contest_winners as $vcw) {
			$isset_winner_place[] = $vcw['place_id'];
		}
		
		for ($i=1; $i <= $count_winner; $i++) { 
			if(!in_array($i, $isset_winner_place)){
				$json[] = array(
					'place_id' 		=> $i,
					'place_title' => $i.' место'	
				);
			}
			
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}


	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'contest/estimate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		foreach ($this->request->post['contest_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}

		}
		

		if (isset($this->request->post['contest_criteria'])) {
			foreach ($this->request->post['contest_criteria'] as $contest_criteria_id => $contest_criteria) {
				foreach ($contest_criteria['contest_criteria_description'] as $language_id => $contest_criteria_description) {
					if ((utf8_strlen($contest_criteria_description['title']) < 2) || (utf8_strlen($contest_criteria_description['title']) >255)) {
						$this->error['contest_criteria'][$contest_criteria_id][$language_id] = $this->language->get('error_criteria_title'); 
					}					
				}
			}	
		}

		if (isset($this->request->post['contest_direction'])) {
      foreach ($this->request->post['contest_direction'] as $contest_direction_id => $contest_direction) {
        foreach ($contest_direction['contest_direction_description'] as $language_id => $contest_direction_description) {
          if ((utf8_strlen($contest_direction_description['title']) < 2) || (utf8_strlen($contest_direction_description['title']) >255)) {
            $this->error['contest_direction'][$contest_direction_id][$language_id] = $this->language->get('error_direction_title'); 
          }         
        }
      } 
    }


		if (empty($this->request->post['maxprice'])){
			//$this->error['maxprice'] = $this->language->get('error_empty');
		}



		

		return !$this->error;
	}
	protected function validateCopy(){
		if (!$this->user->hasPermission('modify', 'contest/estimate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		//±!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! проверочку бы добавить

		return !$this->error;
	}
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'contest/estimate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		//±!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! проверочку бы добавить

		return !$this->error;
	}

	
}