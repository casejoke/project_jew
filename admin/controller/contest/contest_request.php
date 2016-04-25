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
			$this->model_contest_contest_request->editRequest($this->request->get['customer_to_contest_id'], $this->request->post);

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


		//подтянем полный список конкурсов
		$this->load->model('contest/contest');
		$contests_results = $this->model_contest_contest->getContests();

		if (!empty($contests_results)){
			$contests = array();
			foreach ($contests_results as $result) {
				$contests[$result['contest_id']] = array(
					'contest_id' 	=> $result['contest_id'],
					'title'       	=> $result['title'],
					'contest_type'	=> $result['type'],
					'contest_date'	=> rus_date($this->language->get('default_date_format'), strtotime($result['date_start'])),
					'edit'        	=> $this->url->link('contest/contest/edit', 'token=' . $this->session->data['token'] . '&contest_id=' . $result['contest_id'] . $url, 'SSL')
				);
			}
		}


		$results_projects = $this->model_contest_contest->getProjects();
		$projects = array();
		foreach ($results_projects as $result_p) {
			$projects[$result_p['project_id']] = array(
				'project_id'			=> $result_p['project_id'],
				'project_title'			=> $result_p['title'],
				'customer_id'      => $result_p['customer_id'],
				'project_link'			=> $this->url->link('project/view', 'project_id='.$result_p['project_id'], 'SSL')		
			);
		}




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

			$contest_type = (!empty($contests[$result['contest_id']]))?$contests[$result['contest_id']]['contest_type']:0;



			$adaptive_id_text = '';
			$adaptive_customer_name = '';
			$adaptive_status_text   = '';

			switch ((int)$contest_type) {
				case '1':

					break;
				case '2':
					
					break;
				case '3':
						//проект котрый адаптирует
						$adaptive_id = $result['adaptive_id'];
						$adaptive_id_text = $projects[$adaptive_id]['project_title'];
						$adaptive_customer_id = $projects[$adaptive_id]['customer_id'];
            $adaptive_customer_name = $customers[$adaptive_customer_id]['name'];

            switch ((int)$result['adaptive_status']) {
								case '0':
									//заявка не проверена
									$adaptive_status_text = 'не проверена';
									break;
								case '1':
									//заявка не одобрена
									$adaptive_status_text = 'адаптация не одобрена';
									break;
								case '2':
									//заявка
									$adaptive_status_text = 'адаптация одобрена';
									break;

								default:
									$adaptive_status_text = 'не проверена';
									break;
							}
					break;
				default:
					
					break;
			}

			$data['contest_requests'][] = array(
				'customer_to_contest_id' 	=> $result['customer_to_contest_id'],
				'customer_name' 			 		=> $customers[$result['customer_id']]['name'],
				'adaptive_name'         	=> $adaptive_customer_name,
				'adaptive_title'					=> $adaptive_id_text,
				'contest_id'    					=> (!empty($contests[$result['contest_id']]))?$contests[$result['contest_id']]['title']:'',
				'project_link'						=> HTTP_CATALOG . 'index.php?route=project/view&project_id=' . $result['adaptive_id'],
				'status'   								=> $status_text,
				'adaptive_status'   			=> $adaptive_status_text,
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
		// инициализация подписей к полям
		$data['heading_title'] = $this->language->get('heading_title');
		$data['form_header'] = $this->language->get('form_header');

		$data['text_form'] = !isset($this->request->get['customer_to_contest_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');


		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_country'] = $this->language->get('entry_country');

		$data['tab_request'] 	= $this->language->get('tab_request');
		$data['tab_status'] 	= $this->language->get('tab_status');
		$data['tab_customer'] 	= $this->language->get('tab_customer');

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

		if (!isset($this->request->get['customer_to_contest_id'])) {
			$data['action'] = $this->url->link('contest/contest_request/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('contest/contest_request/edit', 'token=' . $this->session->data['token'] . '&customer_to_contest_id=' . $this->request->get['customer_to_contest_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['customer_to_contest_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$customer_to_contest_info = $this->model_contest_contest_request->getRequest($this->request->get['customer_to_contest_id']);
		}


		//статусы заявки:
		// 0 - не принята (есть комментарий)
		// 1 - принята  (видна экспертам и  ее можно оценивать)
		// 2 - не обработана ()
		//$_['text_status_not_accepted']      = 'Не одобрена';
		//$_['text_status_accepted']        	= 'Одобрена';
		//$_['text_status_processed']        	= 'В обработке';

		$data['request_status'] = $this->model_contest_contest_request->getRequestStatusTypes();

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($customer_to_contest_info)) {
			$data['status'] = $customer_to_contest_info['status'];
		} else {
			$data['status'] = 2;
		}

		$data['text_status_not_accepted'] 	= $this->language->get('text_status_not_accepted');
		$data['text_status_accepted'] 		= $this->language->get('text_status_accepted');
		$data['text_status_processed'] 		= $this->language->get('text_status_processed');



		//комментарий к заявки
		if (isset($this->request->post['comment'])) {
			$data['comment'] = $this->request->post['comment'];
		} elseif (!empty($customer_to_contest_info)) {
			$data['comment'] = $customer_to_contest_info['comment'];
		} else {
			$data['comment'] = '';
		}

		//информация о пользователе
		$customer_id = $customer_to_contest_info['customer_id'];
		$this->load->model('sale/customer');
		$customer_info = $this->model_sale_customer->getCustomer($customer_id);


		$data['lastname'] 	= $customer_info['lastname'];//фамилия
		$data['firstname'] 	= $customer_info['firstname'];//имя
		$data['email'] 		= $customer_info['email'];//мыло
		$data['telephone'] 		= $customer_info['telephone'];//мыло


		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['customer_to_contest_id'])) {
			$data['customer_to_contest_id'] = $this->request->get['customer_to_contest_id'];
		} else {
			$data['customer_to_contest_id'] = 0;
		}


		if (isset($this->request->get['customer_to_contest_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$request_info = $this->model_contest_contest_request->getRequest($this->request->get['customer_to_contest_id']);
		}
		//заявка
		//**************** сформируем данные заявки ******************//

	    //подтянем данные заявки
	    $request_value = unserialize($request_info['value']);
	    //конкурс на который подали заявку
	    //$contest_id и $contest_info
	    //пользователь который подал заявку
	    $request_customer_id = $customer_id;

    //подтянем список каетгорий для заявки на  конкурса
	$this->load->model('localisation/category_request');
	$this->load->model('contest/contest_field');
    $data['category_requestes'] = array();
    $filter_data = array(
      'order' => 'ASC'
    );
    $category_request_results = $this->model_localisation_category_request->getCategoryRequestes($filter_data);



    //подтянем поля для заполнения
    $results_contest_fields = $this->model_contest_contest_field->getContestFields();
    $contest_fields = array();
    foreach ($results_contest_fields as  $vccf) {
      $contest_fields[$vccf['contest_field_id']] = array(
        'contest_field_title'         => $vccf['name'],
        'contest_field_type'          => $vccf['type'],
        'contest_field_system'        => $vccf['field_system'],
        'contest_field_system_table'  => $vccf['field_system_table'],
      );
    }






    //раcкрутим заявку
    $data['customer_field'] = array();
    foreach ($category_request_results as $crr) {
        $data_for_category = array();
        foreach ($request_value['custom_fields'] as $kr => $vr) {
          if($crr['category_request_id'] == $kr){
            foreach ($vr as $vvr) {

              $type = $contest_fields[$vvr['field_id']]['contest_field_type'];
              $value_field = '';



              if(!empty($vvr['value'])){
                 $value_field = $vvr['value'];
              }


              if( $contest_fields[$vvr['field_id']]['contest_field_system'] == 'project_age' && ( !empty($vvr['value']) && is_array($vvr['value']) == true) ){
              	$type = 'list';
                $val_project_age = array();
                $result_project_age = $this->model_contest_contest_field->getProjectAges();
                foreach ($result_project_age  as $vpa) {
					foreach ($vvr['value'] as $vvvr) {
	                    if($vpa['contest_field_value_id'] == $vvvr){
	                      $val_project_age[] = array(
	                        'title' =>  $vpa['name']
	                      );
	                    }
                  	}
                }
                $value_field = $val_project_age;


              }

              if( $contest_fields[$vvr['field_id']]['contest_field_system'] == 'project_sex' && ( !empty($vvr['value']) && is_array($vvr['value']) == true) ){
              	$type = 'list';
                $val_project_sex = array();
                $result_project_sex = $this->model_contest_contest_field->getProjectSexs();
                foreach ($result_project_age  as $vpa) {
					foreach ($vvr['value'] as $vvvr) {
	                    if($vpa['contest_field_value_id'] == $vvvr){
	                      $val_project_sex[] = array(
	                        'title' =>  $vpa['name']
	                      );
	                    }
                  	}
                }
                $value_field = $val_project_sex;


              }

              if( $contest_fields[$vvr['field_id']]['contest_field_system'] == 'project_nationality' && ( !empty($vvr['value']) && is_array($vvr['value']) == true) ){
              	$type = 'list';
                $val_project_nationality = array();
                $result_project_nationality = $this->model_contest_contest_field->getProjectNationalitys();
                foreach ($result_project_nationality  as $vpa) {
					foreach ($vvr['value'] as $vvvr) {
	                    if($vpa['contest_field_value_id'] == $vvvr){
	                      $val_project_nationality[] = array(
	                        'title' =>  $vpa['name']
	                      );
	                    }
                  	}
                }
                $value_field = $val_project_nationality;


              }

              if( $contest_fields[$vvr['field_id']]['contest_field_system'] == 'project_professional' && ( !empty($vvr['value']) && is_array($vvr['value']) == true) ){
              	$type = 'list';
                $val_project_professional = array();
                $result_project_professional = $this->model_contest_contest_field->getProjectProfessionals();
                foreach ($result_project_professional  as $vpa) {
					foreach ($vvr['value'] as $vvvr) {
	                    if($vpa['contest_field_value_id'] == $vvvr){
	                      $val_project_professional[] = array(
	                        'title' =>  $vpa['name']
	                      );
	                    }
                  	}
                }
                $value_field = $val_project_professional;


              }

              if( $contest_fields[$vvr['field_id']]['contest_field_system'] == 'project_demographic' && ( !empty($vvr['value']) && is_array($vvr['value']) == true) ){
              	$type = 'list';
                $val_project_demographic = array();
                $result_project_demographic = $this->model_contest_contest_field->getProjectDemographics();
                foreach ($result_project_demographic  as $vpa) {
					foreach ($vvr['value'] as $vvvr) {
	                    if($vpa['contest_field_value_id'] == $vvvr){
	                      $val_project_demographic[] = array(
	                        'title' =>  $vpa['name']
	                      );
	                    }
                  	}
                }
                $value_field = $val_project_demographic;


              }


              $data_for_category[] = array(
                'field_id'    => $vvr['field_id'],
                'field_value' => $value_field,
                'field_title' => $contest_fields[$vvr['field_id']]['contest_field_title'],
                'field_type' => $type,
                'field_contest_system_table' => $contest_fields[$vvr['field_id']]['contest_field_system_table']
              );





            }
          }
        }

        $data['category_requestes'][] = array(
          'category_request_id'   => $crr['category_request_id'],
          'name'                => $crr['name'],
          'category_fields'     =>$data_for_category
        );
    }





		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('contest/contest_request_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'contest/contest_request')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		/*if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}*/

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
