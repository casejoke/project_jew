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
		$data['text_none'] = $this->language->get('text_none');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['text_image_manager'] = $this->language->get('text_image_manager');
 		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');	

		$data['text_image'] = $this->language->get('text_image');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		
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

		$data['entry_weight_criteria'] = $this->language->get('entry_weight_criteria');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_criteria_title'] = $this->language->get('entry_criteria_title');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_direction_title'] = $this->language->get('entry_direction_title');
		
		

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
		$data['tab_expert'] 	= $this->language->get('tab_expert');
		$data['tab_request'] 	= $this->language->get('tab_request');
		$data['tab_timeline'] 	= $this->language->get('tab_timeline');
		$data['tab_files'] 		= $this->language->get('tab_files');
		
		$data['tab_criteria'] 	= $this->language->get('tab_criteria');
		$data['tab_direction'] 	= $this->language->get('tab_direction');
		$data['tab_seo'] 		= $this->language->get('tab_seo');
		$data['button_add'] 	= $this->language->get('button_add');
		$data['text_none']  	= $this->language->get('text_none');	
		
		// инициализация ошибок
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

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		if (isset($this->error['contest_experts'])) {
			$data['error_contest_experts'] = $this->error['contest_experts'];
		} else {
			$data['error_contest_experts'] = array();
		}

		if (isset($this->error['contest_criteria'])) {
			$data['error_contest_criteria'] = $this->error['contest_criteria'];
		} else {
			$data['error_contest_criteria'] = array();
		}

		if (isset($this->error['contest_direction'])) {
	      $data['error_contest_direction'] = $this->error['contest_direction'];
	    } else {
	      $data['error_contest_direction'] = array();
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
		
		
		if (isset($this->request->get['contest_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$contest_info = $this->model_contest_contest->getContest($this->request->get['contest_id']);
		}

		if (isset($this->request->get['occasion_id'])) {
			$data['contest_id'] = $this->request->get['contest_id'];
		} else {
			$data['contest_id'] = 0;
		}
		//********** описание конкурса ************//
		//поля из описания пконкурса
		if (isset($this->request->post['contest_description'])) {
			$data['contest_description'] = $this->request->post['contest_description'];
		} elseif (isset($this->request->get['contest_id'])) {
			$data['contest_description'] = $this->model_contest_contest->getContestDescriptions($this->request->get['contest_id'],false);
		} else {
			$data['contest_description'] = array();
		}


		if (isset($this->request->post['date_start'])) {
			$data['date_start'] = $this->request->post['date_start'];
		} elseif (!empty($contest_info)) {
			$data['date_start'] =  date('Y-m-d', strtotime($contest_info['date_start']));
		} else {
			$data['date_start'] = date('Y-m-d', time() - 86400);
		}
		if (isset($this->request->post['datetime_end'])) {
			$data['datetime_end'] = $this->request->post['datetime_end'];
		} elseif (!empty($contest_info)) {
			$data['datetime_end'] =  date('Y-m-d', strtotime($contest_info['datetime_end']));
		} else {
			$data['datetime_end'] = date('Y-m-d', time() - 86400);
		}
		if (isset($this->request->post['date_rate'])) {
			$data['date_rate'] = $this->request->post['date_rate'];
		} elseif (!empty($contest_info)) {
			$data['date_rate'] =  date('Y-m-d', strtotime($contest_info['date_rate']));
		} else {
			$data['date_rate'] = date('Y-m-d', time() - 86400);
		}
		if (isset($this->request->post['date_result'])) {
			$data['date_result'] = $this->request->post['date_result'];
		} elseif (!empty($contest_info)) {
			$data['date_result'] =  date('Y-m-d', strtotime($contest_info['date_result']));
		} else {
			$data['date_result'] = date('Y-m-d', time() - 86400);
		}
		if (isset($this->request->post['date_finalist'])) {
			$data['date_finalist'] = $this->request->post['date_finalist'];
		} elseif (!empty($contest_info)) {
			$data['date_finalist'] =  date('Y-m-d', strtotime($contest_info['date_finalist']));
		} else {
			$data['date_finalist'] = date('Y-m-d', time() - 86400);
		}

		
		if (isset($this->request->post['maxprice'])) {
			$data['maxprice'] = $this->request->post['maxprice'];
		} elseif (!empty($contest_info)) {
			$data['maxprice'] = $contest_info['maxprice'];
		} else {
			$data['maxprice'] = '';
		}
		if (isset($this->request->post['totalprice'])) {
			$data['totalprice'] = $this->request->post['totalprice'];
		} elseif (!empty($contest_info)) {
			$data['totalprice'] = $contest_info['totalprice'];
		} else {
			$data['totalprice'] = 1;
		}
		// получение типов конкурса
		$data['contest_types'] = $this->model_contest_contest->getContestTypes();
		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($contest_info)) {
			$data['type'] = $contest_info['type'];
		} else {
			$data['type'] = 1;
		}
		// получение статусов конкурса
		$data['contest_statuses'] = $this->model_contest_contest->getContestStatuses();
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($contest_info)) {
			$data['status'] = $contest_info['status'];
		} else {
			$data['status'] = 1;
		}

		//********** эксперты ************//
		//получим пользователей экспертов
		$this->load->model('sale/customer');
		$data['customers'] = array();

		$filter_data = array();
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


		//********** критерии ************//

		$data['contest_criterias']  = array();
		if (isset($this->request->post['contest_criteria'])) {
			$data['contest_criterias'] = $this->request->post['contest_criteria'];
		} elseif (isset($this->request->get['contest_id'])) {
			$data['contest_criterias']  = $this->model_contest_contest->getContestCriteria($this->request->get['contest_id']);
		} else {
			$data['contest_criterias']  = array();
		}

		//********** направления ************//

	    $data['contest_directions']  = array();
	    if (isset($this->request->post['contest_direction'])) {
	      $data['contest_directions'] = $this->request->post['contest_direction'];
	    } elseif (isset($this->request->get['contest_id'])) {
	      $data['contest_directions']  = $this->model_contest_contest->getContestDirection($this->request->get['contest_id']);
	    } else {
	      $data['contest_directions']  = array();
	    }

	    //********** Изображение для конкурса ************//
	    $this->load->model('tool/image');

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($contest_info['image'])) {
			$data['image'] = $contest_info['image'];
		} else {
			$data['image'] = '';
		}
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100,'h');
		} elseif (!empty($contest_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($contest_info['image'], 100, 100,'h');
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100,'h');
		}
		
		$data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100,'h');
		//********** Поля для заявки ************//
		if (isset($this->request->post['custom_fields'])) {
			$data['custom_fields'] = $this->request->post['custom_fields'];
		} elseif (!empty($contest_info)) {
			$data['custom_fields'] = unserialize($contest_info["contest_fields"]) ;
		} else {
			$data['custom_fields'] = array();
		}
		


			//подтянем список доступных категорий
		 	$this->load->model('localisation/category_request');
			$data['category_requestes'] = array();
			$filter_data = array(
				'order' => 'ASC'
			);
			$category_request_results = $this->model_localisation_category_request->getCategoryRequestes($filter_data);
			foreach ($category_request_results as $crr) {
		      	$data['category_requestes'][] = array(
		        	'category_request_id' 	=> $crr['category_request_id'],
		        	'name'            		=> $crr['name'],
		       	);
		    }
		    //подтянуть список полей для кактегорий
		    $this->load->model('contest/contest_field');
		  
			$filter_data = array(
				'order' => 'ASC'
			);
			$contest_fields_results = $this->model_contest_contest_field->getContestFields($filter_data); 
		   
			
			$data['contest_fields'] = array();
			foreach ($contest_fields_results as  $cfr) {

				if(!empty( $data['custom_fields'][$cfr['location']])){
					foreach ( $data['custom_fields'][$cfr['location']] as $cvalue) {

						if($cvalue['contest_field_id'] == $cfr['contest_field_id']){
							$status  		=  $cvalue['status'];
							$sort_order  	=  $cvalue['sort_order'];
							
						}
					}
				} else {
					$status  		=  0;
					$sort_order  	=  0;
				}
					$data['contest_fields'][$cfr['location']][] = array(
						'field_id'           	=> $cfr['contest_field_id'],
						'field_title'           => $cfr['name'],
						'field_type'          	=> $cfr['type'],
						'field_system'          => $cfr['field_system'],
						'field_system_table'    => $cfr['field_system_table'],

						'status'				=> $status,
						'sort_order'			=> $sort_order,
					);

			}
			foreach ($data['contest_fields'] as  $cfr) {
				usort($cfr, 'sortBySortOrder');
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

		    $data['system_fields'] = array();
		   	 //поля пользовтеля
		   /* $data['fields']['system'][] = array(
		    	'fields_name' 		=> 'firstname',
		    	'fields_title'		=> $this->language->get('firstname'),
		    	'fields_type' 		=> 'input',
		    	'fields_system' 	=> 1,
		    	'fields_required' 	=> 1
		    	


		    	'custom_field_id' => $result['custom_field_id'],
				'name'            => $result['name'],
				'location'        => $this->language->get('text_' . $result['location']),
				'type'            => $type,
				'status'          => $result['status'],
				'sort_order'      => $result['sort_order'],
		    );
		    $data['fields']['custom'] = array();*/
		    /*
		    $customer_fields = $this->model_sale_customer->getColumnNameCustomers();
		    print_r('<pre>');
		    print_r($customer_fields );
		    print_r('</pre>');
		    die();
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
			*/


		// получение списка файлов
		$data['contest_file'] =array();
		$this->load->model('catalog/download');
		$data['files'] = $this->model_catalog_download->getDownloads();
		



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