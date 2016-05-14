<?php
class ControllerAccountAccount extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		$this->load->language('account/account');
		$this->document->setTitle($this->language->get('heading_title'));
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->session->data['warning'])) {
			$data['warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$data['warning'] = '';
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_my_account'] = $this->language->get('text_my_account');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_reward'] = $this->language->get('text_reward');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_recurring'] = $this->language->get('text_recurring');
		$data['text_logout'] = $this->language->get('text_logout');


		$data['address'] = $this->url->link('account/address', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['return'] = $this->url->link('account/return', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');
		$data['recurring'] = $this->url->link('account/recurring', '', 'SSL');
		$data['edit'] = $this->url->link('account/edit', '', 'SSL');
		$data['password'] = $this->url->link('account/password', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');


		if ($this->config->get('reward_status')) {
			$data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$data['reward'] = '';
		}


		//подгрузим модели
		$this->load->model('account/customer');
		$this->load->model('group/group');
		$this->load->model('project/project');
		$this->load->model('contest/contest');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		$this->load->model('account/promocode');
		//информация о пользователе
		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		}
		$customer_id = $this->customer->getId();
		//стандартные поля
		$data['firstname'] 	= $customer_info['firstname'];
		$data['lastname'] 	= $customer_info['lastname'];
		$data['email'] 			= $customer_info['email'];
		$data['telephone'] 	= $customer_info['telephone'];
		$this->load->model('localisation/country');
		$country = $this->model_localisation_country->getCountry($customer_info['country_id']);
    $data['country'] = (!empty($country))?$country['name']:'';
		$data['city'] 			= $customer_info['city'];

		// Custom Fields
		$this->load->model('account/custom_field');
		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));
		$data['account_custom_field'] = unserialize($customer_info['custom_field']);

		if (!empty($customer_info) && !empty($customer_info['image'])){
			if(preg_match('/http/', $customer_info['image'])){
				$data['avatar'] = $customer_info['image'];
			}else{
				$upload_info = $this->model_tool_upload->getUploadByCode($customer_info['image']);
				$filename = $upload_info['filename'];
				if (is_file(DIR_UPLOAD . $filename)) {
					$data['avatar'] = $this->model_tool_upload->resize($filename , 360, 490, 'h');
				}else{
					$data['avatar'] = $this->model_tool_image->resize('account.jpg', 360, 490, 'h');
				}
			}
		}else{
			$data['avatar'] = $this->model_tool_image->resize('account.jpg', 360, 490, 'h');
		}







		/******************* группы *******************/
		$data['text_add_group'] = $this->language->get('text_add_group');
		$data['add_group'] = $this->url->link('group/edit', '', 'SSL');

		//подтянем все активные группы
		//сделать рефактор заменить на IN () как getInfoCustomersForGroups
		$results_groups = $this->model_group_group->getGroups();
		$data['init_groups'] = array();
		foreach ($results_groups as $result_g) {
			if (!empty($result_g['image'])) {
				$upload_info = $this->model_tool_upload->getUploadByCode($result_g['image']);
				$filename = $upload_info['filename'];
				$image = $this->model_tool_upload->resize($filename , 300, 300,'h');
			} else {
				$image = $this->model_tool_image->resize('no-image.png', 300, 300,'h');
			}

			$filter_data = array();
			$filter_data = array(
				'filter_status' 		=> 	1,
				'filter_init_group_id'	=>	$result_g['init_group_id']
			);
			$results_count_customer_in_group = array();
			$results_count_customer_in_group = $this->model_group_group->getInviteGroups($filter_data);

			$count = count($results_count_customer_in_group)+1;

			$actions = array(
				'view'		=> $this->url->link('group/view', 'group_id='.$result_g['init_group_id'], 'SSL'),
				'edit'		=> $this->url->link('group/edit', 'group_id='.$result_g['init_group_id'], 'SSL'),
				'invite'	=> $this->url->link('group/invite', 'group_id='.$result_g['init_group_id'], 'SSL'),
				'agree'		=> $this->url->link('group/invite/agree', 'group_id='.$result_g['init_group_id'], 'SSL')
			);
			$data['init_groups'][$result_g['init_group_id']] = array(
				'group_id'				=> $result_g['init_group_id'],
				'group_title'			=> $result_g['title'],
				'group_image'			=> $image,
				'group_customer_count' 	=> $count,
				'action'				=> $actions
			);
		}

		$data['customer_id'] = $customer_id;
		//группы где пользователь администратор
		$results_admin_groups = $this->model_group_group->getGroupsForAdmin($customer_id);

		$data['admin_init_groups'] = array();
		foreach ($results_admin_groups as $result) {
			$data['admin_init_groups'][] = array(
				'group_id'	=> $result['init_group_id']
			);
		}


		//выведем приглашения в группы status = 2
		$filter_data = array();
		$filter_data = array(
			'filter_customer_id'	=>	$customer_id,
			'filter_status' 		=> 	2
		);
		$results_customer_invite_group = array();
		$results_customer_invite_group = $this->model_group_group->getInviteGroups($filter_data);
		$data['customer_invite_group'] = array();
		foreach ($results_customer_invite_group as $result_civg) {
			$data['customer_invite_group'][] = array(
				'group_id'	=> $result_civg['init_group_id'],
			);
		}


		//группы в котрых состоит пользователь, но не администратор
		$data['customer_agree_groups'] = array();
		$filter_data = array();
		$filter_data = array(
			'filter_customer_id'	=>	$customer_id,
			'filter_status' 		=> 	1
		);
		$results_customer_agree_groups = array();
		$results_customer_agree_groups = $this->model_group_group->getInviteGroups($filter_data);
		$data['customer_agree_groups'] = array();
		foreach ($results_customer_agree_groups as $result_cag) {
			$data['customer_agree_groups'][] = array(
				'group_id'	=> $result_cag['init_group_id'],
			);
		}

		/******************* /.группы *******************/

		/******************* проекты *******************/
		$data['text_add_project'] = $this->language->get('text_add_project');
		$data['add_project'] = $this->url->link('project/edit', '', 'SSL');

		//подтяем проекты победители где пользователь я вяляется админом
		$filter_data = array();
		$filter_data = array(
			'filter_customer_id'	=>	$customer_id
		);

		$results_projects_winners = $this->model_project_project->getProjectsWinner($filter_data);
		$projects_winner = array();
		foreach ($results_projects_winners as $rpw) {
			$projects_winner[$rpw['project_id']] = array(
				'project_id' => $rpw['project_id']
			);
		}




		//информация о проектах где пользователь я вляется admin
		$results_projects_for_customer = $this->model_project_project->getProjectsForAdmin($customer_id);
		$data['projects_for_customer'] = array();
		$projects_for_customer = array();
		foreach ($results_projects_for_customer  as $result_pfc) {

			if (!empty($result_pfc['image'])) {
				$upload_info = $this->model_tool_upload->getUploadByCode($result_pfc['image']);
				$filename = $upload_info['filename'];
				$image = $this->model_tool_upload->resize($filename , 300, 300,'h');
			} else {
				$image = $this->model_tool_image->resize('no-image.png', 300, 300,'h');
			}
			$actions = array();
			$actions = array(
				'edit'	=>	$this->url->link('project/edit', 'project_id='.$result_pfc['project_id'], 'SSL')
			);
			$win = 0;
			$promocode_action = $this->url->link('account/promocode/activate', 'project_id='.$result_pfc['project_id'], 'SSL');
			if(!empty($projects_winner[$result_pfc['project_id']])){
				$win = 1;

			}
			$projects_for_customer[] = $result_pfc['project_id'];
			$data['projects_for_customer'][$result_pfc['project_id']] = array(
				'project_id'			=> $result_pfc['project_id'],
				'project_title'		=> $result_pfc['title'],
				'project_image'		=> $image,
				'project_winner'  	=> $win,
				'project_action'	=> $actions,
				'promocode_action'	=> $promocode_action
			);



		}
		/******************* /.проекты *******************/

		/******************* конкурсы *******************/
		//информация о конкурсах еа которые подана заявка
		//заявка на котрые отклонена
		//завка на котрые проиграна
		//завка на которые выиграна

		//статусы заявки:
		// 0 - не принята (есть комментарий)
		// 1 - принята  (видна экспертам и  ее можно оценивать)
		// 2 - не обработана ()
		//$_['text_status_not_accepted']      = 'Не одобрена';
		//$_['text_status_accepted']        	= 'Одобрена';
		//$_['text_status_processed']        	= 'В обработке';


		//подтянем проекты пользователя с которыми он может участвовать в конкурсах BestPractice
		//тоеть те проекты котрые он подал в пулл для данного конкурса 1 проект = 1 конкурс
		$filter_data = array();
		$filter_data = array(
			'filter_customer_id'	=>	$customer_id
		);

		$results_project_for_adaptors = $this->model_project_project->getListAdapiveProjects($filter_data);

		$project_adaptor_for_contest = array();
		foreach ($results_project_for_adaptors as $vpfa) {
			$project_adaptor_for_contest[$vpfa['contest_id']] = $vpfa['project_id'];

		}

		//подтянем все конкурсы
		$results_contests = $this->model_contest_contest->getContests();
		$contests = array();
		$contest_only_bestpractice  = array();
		foreach ($results_contests as $rc) {
			if (!empty($rc['image'])) {
				$image= $this->model_tool_image->resize($rc['image'], 300, 300,'h');
			}else{
				$image = $this->model_tool_image->resize('placeholder.png', 300, 300,'h');
			}
			$contests[$rc['contest_id']] = array(
				'contest_id'			=> $rc['contest_id'],
				'project_id'			=> (!empty($project_adaptor_for_contest[$rc['contest_id']]))?$project_adaptor_for_contest[$rc['contest_id']] : 0,
				'contest_type'			=> $rc['type'],
				'contest_title'			=> $rc['title'],
			//	'contest_title_old'			=> (strlen(strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8'))) > 50 ? mb_strcut(strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8')), 0, 55) . '...' : strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8'))),
				'contest_image'			=> $image
			);
			if($rc['type'] == 3 ){
				$contest_only_bestpractice[] = $rc['contest_id'];
			}

		}


		//подтянем сипсок заявок для данного пользователя!!!!!
		$filter_data = array();
		$filter_data = array(
			'filter_customer_id' 	=> 	$customer_id
		);
		$results_customer_req_contest = $this->model_contest_contest->getRequestForCustomer($filter_data);


		$data['requests_for_customer'] = array();
		foreach ($results_customer_req_contest as $vcc) {
			$status = '';
			switch ($vcc['status']) {
				case '0':
					//заявка отклонена
					$status = $this->language->get('text_status_not_accepted');
					break;
				case '1':
					//заявка принята
					$status = $this->language->get('text_status_accepted');
					break;
				case '2':
					//заявка в обработке
					$status = $this->language->get('text_status_processed');
					break;
				case '3':
					//заявка - черновик
					$status = $this->language->get('text_status_draft');
					break;
				default:
					$status = $this->language->get('text_status_processed');
					break;
			}
			$astatus = '';
			switch ($vcc['adaptive_status']) {
				case '0':
					//заявка не проверена
					$astatus = 'не проверена';
					break;
				case '1':
					//заявка не одобрена
					$astatus = 'адаптация не одобрена';
					break;
				case '2':
					//заявка
					$astatus = 'адаптация одобрена';
					break;

				default:
					$astatus = 'не проверена';
					break;
			}


			//добавить проверку на дату приема заявок с конкурса
			switch ((int)$contests[$vcc['contest_id']]['contest_type']) {
				case '1':
					$action_not_accepted = $this->url->link('contest/send', 'customer_to_contest_id='.$vcc['customer_to_contest_id'], 'SSL');

					//contest_id=4&project_id=155&adaptive_id=2
					break;
				case '2':
						$action_not_accepted = $this->url->link('contest/send', 'customer_to_contest_id='.$vcc['customer_to_contest_id'], 'SSL');

						//contest_id=4&project_id=155&adaptive_id=2
						break;
				case '3':
					$action_not_accepted = $this->url->link('contest/sendbest', 'customer_to_contest_id='.$vcc['customer_to_contest_id'], 'SSL');

					//contest_id=4&project_id=155&adaptive_id=2
					break;

				default:
					$action_not_accepted = $this->url->link('contest/deal', 'contest_id='.$vcc['contest_id'], 'SSL');
					break;
			}

			$comment = '';
			$comment .= ($vcc['comment'])?'Комментарий администратора: '.$vcc['comment']:'';
			$comment .= ($vcc['adaptor_comment'])?'<br>Комментарий адаптора: '.$vcc['adaptor_comment']:'';

			$data['requests_for_customer'][] = array(
				'contest_id' 			=> $vcc['contest_id'],
				'request_status'		=> $vcc['status'],
				'request_status_text'	=> $status,
				'request_astatus_text'	=> ((int)$contests[$vcc['contest_id']]['contest_type'] == 3) ? $astatus : '',
				'request_comment'		=> html_entity_decode($comment, ENT_QUOTES, 'UTF-8'),
				'contest_title'			=> $contests[$vcc['contest_id']]['contest_title'],
				'contest_image'			=> $contests[$vcc['contest_id']]['contest_image'],
				'action_not_accepted'   => $action_not_accepted,
				'action_request_view'	=> $this->url->link('contest/requestview', 'customer_to_contest_id='.$vcc['customer_to_contest_id'], 'SSL')
			);
		}

		$customers = array();
		$results = $this->model_account_customer->getCustomers();
		foreach ($results as $result) {
			if(preg_match('/http/', $result['image'])){
				$image = $result['image'];
			}else{
				if (is_file(DIR_IMAGE . $result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 400, 400, 'h');
				}else{
					$image = $this->model_tool_image->resize('no-image.png', 400, 400, 'h');
				}
			}
			$customer_id_hash = $result['customer_id'];
			$customers[$result['customer_id']] = array(
				'customer_id'    				=> $result['customer_id'],
				'customer_id_hash'			=> $customer_id_hash,
				'customer_name'     		=> $result['name'],
				'customer_image'				=> $image
			);
		}


		//добавим механизм согласования заявки для BestPractice
		//$projects_for_customer - список проектов где автор является текущий пользователь
		//подтянем сипсок заявок  где пользователь != заявителем и  adaptive_id равен одному из его проектов

		$filter_data = array();
		$filter_data = array(

			'filter_array_project_customer_id' 	=>	$projects_for_customer,
			'filter_array_contest_id' 			=>	$contest_only_bestpractice
		);

		//список заявок, только для bestpractice, в которых использовали проекты пользователя
		$results_list_approved_request = $this->model_contest_contest->getRequestForApproved($filter_data);
		$data['list_approved_request'] = array();
		$data['list_approved_request_yes'] = array();
		foreach ($results_list_approved_request as $vlar) {
			//если 2 - одобрена
			//если 1 - то не одобрена
			//если 0 то не оценена
			if($vlar['adaptive_status']!=2){
				$data['list_approved_request'][] = array(
					'customer_to_contest_id'	=>  $vlar['customer_to_contest_id'],
					'contest_title' 			=>	$contests[$vlar['contest_id']]['contest_title'],
					'customer_name' 			=> 	$customers[$vlar['customer_id']]['customer_name'],
					'adaptive_name' 			=> 	$data['projects_for_customer'][$vlar['adaptive_id']]['project_title'],
					'expert_evaluate'			=> 	$this->url->link('contest/aestimate', 'request_id='.$vlar['customer_to_contest_id'], 'SSL')
				);
			}

			if($vlar['adaptive_status'] == 2){
				$data['list_approved_request_yes'][] = array(
					'customer_to_contest_id'	=>  $vlar['customer_to_contest_id'],
					'contest_title' 			=>	$contests[$vlar['contest_id']]['contest_title'],
					'customer_name' 			=> 	$customers[$vlar['customer_id']]['customer_name'],
					'adaptive_name' 			=> 	$data['projects_for_customer'][$vlar['adaptive_id']]['project_title'],
					'expert_evaluate'			=> 	$this->url->link('contest/aestimate', 'request_id='.$vlar['customer_to_contest_id'], 'SSL')
				);
			}

		}



/*
		print_r('<pre>');
		print_r($results_list_approved_request);
		print_r('</pre>');
		die();
*/


		/**************** про экспертов ***********************/
		//если пользователь эксперта

	$data['request_for_expert'] = array();
//проверка на то что пользователь является ли вообще экспертом
if ($customer_info['customer_expert']) {
		//подтянем все активные конкурсы
		$results_contests = $this->model_contest_contest->getContests();
		$contests = array();
		foreach ($results_contests as $rc) {
			if (!empty($rc['image'])) {
				$image= $this->model_tool_image->resize($rc['image'], 300, 300,'h');
			}else{
				$image = $this->model_tool_image->resize('placeholder.png', 300, 300,'h');
			}

			$actions = array(
				'view'		=> $this->url->link('contest/view', 'contest_id='.$rc['contest_id'], 'SSL')
			);
			$contests[$rc['contest_id']] = array(
				'contest_id'			=> $rc['contest_id'],
				'contest_title'			=> html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8'),
				'contest_image'			=> $image,
				'contest_type'	=> $rc['type'],
				'action'				=> $actions
			);
		}

		//подтяем список конкурсов в котрых пользователь экспертом
		$results_customer_expert_to_contests = $this->model_contest_contest->getContestForExpertCustomer($customer_id);
		$implode = array();
		$data['customer_expert_to_contests'] = array();
		foreach ($results_customer_expert_to_contests as $vcetc) {

			if (!empty($contests[$vcetc['contest_id']])) {
				$data['customer_expert_to_contests'][] = array(
					'contest_id'		=> $vcetc['contest_id'],

					'contest_title'	=> $contests[$vcetc['contest_id']]['contest_title'],
					'contest_image'	=> $contests[$vcetc['contest_id']]['contest_image']
				);
				//собираем массив конкурсов по котрым делаем запрос
				$implode[] = (int)$vcetc['contest_id'];
			}

		}




		//подтянем список заявок для каждого конкурса и текущего пользователя
		//$implode список конкурсов для запроса где пользователь эксперто
		//подтянем из табли customer_to_contest заявки со  статусом = 1 (прошла модерацию)и где конкурс IN ($implode)
		//сформирем финальный список для эксперта

		$filter_data = array();
		$filter_data = array(
			'filter_contest_id' => $implode,
			'filter_status'			=> 1
		);
		//узнаем что уже оценивали 
		$results_estimate_for_expert = $this->model_contest_contest->getEstimateForCustomer($customer_id);
		foreach ($results_estimate_for_expert as $vrefe) {
			$estimate[$vrefe['customer_to_contest_id']] = array(
				'customer_id' => $vrefe['customer_id']
			);
		}


		$data['request_for_expert'] = array();
		if(!empty($implode)){
			$filter_data = array();
			$filter_data = array(
				'filter_contest_id' => $implode,
				'filter_status'			=> 1
			);
			//получим все заявки для данного пользователя в качестве эксперта
			$results_request_for_expert = $this->model_contest_contest->getRequestForCustomer($filter_data);
			


			$filter_data = array();
			$results_projects = $this->model_project_project->getListProjects($filter_data);
			$projects = array();
			foreach ($results_projects as $result_p) {
				$projects[$result_p['project_id']] = array(
					'project_id'			=> $result_p['project_id'],
					'project_title'			=> $result_p['title'],
					'customer_id'      => $result_p['customer_id'],
					'project_link'			=> $this->url->link('project/view', 'project_id='.$result_p['project_id'], 'SSL')		
				);
			}
			

			foreach ($results_request_for_expert as $vrfe) {
				//получим тип конкурса
				$contest_type = (!empty($contests[$vrfe['contest_id']]))?$contests[$vrfe['contest_id']]['contest_type']:0;
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
							$adaptive_id = $vrfe['adaptive_id'];
							$adaptive_id_text = $projects[$adaptive_id]['project_title'];
							$adaptive_customer_id = $projects[$adaptive_id]['customer_id'];
	            			$adaptive_customer_name = $customers[$adaptive_customer_id]['customer_name'];//автор проекта

	            switch ((int)$vrfe['adaptive_status']) {
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


				$status_estimate = 0;
				if(empty($estimate[$vrfe['customer_to_contest_id']])){
					$status_estimate = 1;
				}
				

					$data['request_for_expert'][] = array(

						'customer_to_contest_id'	=>  $vrfe['customer_to_contest_id'],
						'contest_title' 			=>	$contests[$vrfe['contest_id']]['contest_title'],
						'customer_name' 			=> 	$customers[$vrfe['customer_id']]['customer_name'],
						'adaptive_name'         	=>  $adaptive_customer_name,
						'adaptive_project_title'	=>  $adaptive_id_text,
						'status_estimate'			=>  $status_estimate,
						'expert_evaluate'			=> 	$this->url->link('contest/estimate', 'request_id='.$vrfe['customer_to_contest_id'], 'SSL')
					);
				


			}
/*
			print_r('<pre>');
			print_r($data['request_for_expert']);
			print_r('</pre>');
			die();
*/
		}





}//проверка на эксперта
		//получим список проектов из таблицы победителей для данного пользователя

		$result_project_winner = $this->model_contest_contest->getWinnerContest($customer_id);
		$project_activate_promocode = array();


		foreach ($result_project_winner as $vpap) {
			if (!empty ($vpap['promocode_id']) ){
				$project_activate_promocode[$vpap['promocode_id']] = array(
					'project_id'	=> $vpap['project_id'],
				);
			}

		}

		//промокоды
		$data['activate_promocode'] = $this->url->link('account/promocode', '', 'SSL');

		//получим список активированных промокодв из табличи промокоды
		//cстатусы промокодов
		//0 исользованный - потрачен на активацию конкурса
		//1 активный  - можно отдавать кому угодно
		//2 активи
		$results_list_promocode = $this->model_account_promocode->getListPromocodeForCustomer($customer_id);
		$data['list_promocode'] = array();
		$data['isset_promocode'] = 0;
/*
		foreach ($results_list_promocode as $vlp) {

			if($vlp['status'] == 0 ){

				$project_id		= $project_activate_promocode[$vlp['promocode_id']]['project_id'];

				$project_title  = $data['projects_for_customer'][$project_id]['project_title'];

				$data['list_promocode'][] = array(
					'promocode_id' 	=> $vlp['promocode_id'],
					'project_id'	=> $project_id,
					'project_title'	=> $project_title
				);
			}
			if($vlp['status'] == 2){
				$data['isset_promocode'] = 1;
			}

		}
*/
		//уведомления

		$data['customer_notice'] = array();






		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/account.js');
		} else {
			$this->document->addScript('catalog/view/theme/default/assets/js/account.js');
		}


		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/account.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/account.tpl', $data));
		}
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function upload() {
		$this->load->language('tool/upload');

		$json = array();

		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));

			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}

			// Allowed file extension types
			$allowed = array();

			$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));

			$filetypes = explode("\n", $extension_allowed);

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Allowed file mime types
			$allowed = array();

			$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));

			$filetypes = explode("\n", $mime_allowed);

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($this->request->files['file']['tmp_name']);

			if (preg_match('/\<\?php/i', $content)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Return any upload error
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!$json) {

			$code = md5(mt_rand());
			if (!$this->customer->isLogged()) {
				$file = $filename. '.' . $code ;
			}else{
				$customer_id = $this->customer->getId();
				$folder_name = md5($customer_id).'/';
				//создаем папку с назанием
				if (!is_dir(DIR_UPLOAD . $folder_name)) {
					mkdir(DIR_UPLOAD . $folder_name, 0777);
				}
				$file = $folder_name . $filename. '.' . $code ;
				//code поправить!!!!!!!
			}

			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_UPLOAD . $file  );

			// Hide the uploaded file name so people can not link to it directly.
			$this->load->model('tool/upload');
			$this->load->model('account/customer');

			$json['code'] = $this->model_tool_upload->addUpload($filename, $file);

			//добавим изображение в аватар
			$this->model_account_customer->changeAvatar($json['code']);

			//рендерим изображение если это оно
			$json['thumb'] = $this->model_tool_upload->resize($file , 360, 490, 'h');

			$json['success'] = $this->language->get('text_upload');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}


}
