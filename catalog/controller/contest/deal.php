<?php
class ControllerContestDeal extends Controller {
	private $error = array();
	public function index(){
		if ( !isset($this->request->get['contest_id']) ) {
			$this->session->data['redirect'] = $this->url->link('contest/contest', '', 'SSL');
			$this->response->redirect($this->url->link('contest/contest', '', 'SSL'));
			
		}
		
		$this->getView();
	}
	
	private function getView(){

		//************** проверки ***************//
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}
		//если конкурс в статусе работа - редирект

		$contest_id = $this->request->get['contest_id'];
		//для шифрования
		$data['contest_id'] = $contest_id;


		$this->load->model('contest/contest');
		$contest_info = array();
		if (isset($this->request->get['contest_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$contest_info = $this->model_contest_contest->getContest($this->request->get['contest_id']);
		}

		//проверим сушествоание конкурса 
		if ( empty($contest_info) ){
			//редиректим на список 
			$this->session->data['redirect'] = $this->url->link('contest/contest', '', 'SSL');
			$this->response->redirect($this->url->link('contest/contest', '', 'SSL'));
		}
	

		switch ((int)$contest_info['type']) {
			case '1':
				$this->dealSimpleContest($contest_info);
				break;
			case '2':
				$this->dealSimpleContest($contest_info);
				break;
			case '3':
				$this->dealBestContest($contest_info);
				break;	
			default:
				$this->dealSimpleContest($contest_info);
				break;
		}
		
	}


	protected function dealSimpleContest($contest_info){
		//для простых конкурсов где учствуют свои проекты
		//может подать ограниченное количестовзаявкок (регулируется в начтройках)
		//
		$contest_id = $this->request->get['contest_id'];
		//для шифрования
		$data['contest_id'] = $contest_id;
		//подгрузим язык
		$this->load->language('contest/deal');
		//SEO
		$this->document->setTitle($this->language->get('entry_title'));
		//$this->document->setDescription(substr(strip_tags(html_entity_decode($contest_info['meta_description'], ENT_QUOTES)), 0, 150) . '...');
		//$this->document->setKeywords($contest_info['meta_keyword']);

		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		



		$data['entry_title'] 				= $this->language->get('entry_title');
		$data['entry_description'] 			= $this->language->get('entry_description');
		$data['entry_image'] 				= $this->language->get('entry_image');
		$data['entry_contest_birthday'] 	= $this->language->get('entry_contest_birthday');
		$data['entry_contest_email'] 		= $this->language->get('entry_contest_email'); 
		
		$data['entry_contest_dates'] 		= $this->language->get('entry_contest_dates'); 
		$data['entry_contest_date_start'] 		= $this->language->get('entry_contest_date_start'); 
		$data['entry_contest_datetime_end'] 	= $this->language->get('entry_contest_datetime_end'); 
		$data['entry_contest_date_rate'] 		= $this->language->get('entry_contest_date_rate'); 
		$data['entry_contest_date_result'] 		= $this->language->get('entry_contest_date_result'); 
		$data['entry_contest_date_finalist'] 	= $this->language->get('entry_contest_date_finalist'); 

		$data['entry_contest_organizer'] 	= $this->language->get('entry_contest_organizer'); 
		$data['entry_contest_budget'] 		= $this->language->get('entry_contest_budget');
		$data['entry_contest_propose'] 		= $this->language->get('entry_contest_propose'); 
		$data['entry_contest_location'] 	= $this->language->get('entry_contest_location'); 
		$data['entry_contest_members'] 		= $this->language->get('entry_contest_members'); 
		$data['entry_contest_contacts'] 	= $this->language->get('entry_contest_contacts'); 
		$data['entry_contest_timeline_text']= $this->language->get('entry_contest_timeline_text'); 
		$data['entry_contest_budget']		= $this->language->get('entry_contest_budget'); 
		$data['entry_contest_maxprice']		= $this->language->get('entry_contest_maxprice'); 
		$data['entry_contest_totalprice']	= $this->language->get('entry_contest_totalprice'); 
		

		$data['text_create'] 				= $this->language->get('text_create');
		$data['text_member'] 				= $this->language->get('text_member');
		

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_contests'),
			'href' => $this->url->link('contest/contest', '', 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $contest_info['title'],
			'href' => $this->url->link('contest/view', 'contest_id=' . $data['contest_id'], 'SSL')
		);

		//подгрузим модели
		$this->load->model('account/customer');
		
		$this->load->model('project/project');
		$this->load->model('group/group');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');



		
		

		





		$data['contest_title'] 		=	html_entity_decode($contest_info['title'], ENT_QUOTES, 'UTF-8');
		$data['contest_description'] 	=	html_entity_decode($contest_info['description'], ENT_QUOTES, 'UTF-8');
		$data['contest_organizer'] 	=	html_entity_decode($contest_info['organizer'], ENT_QUOTES, 'UTF-8');
		$data['contest_propose'] 	=	html_entity_decode($contest_info['propose'], ENT_QUOTES, 'UTF-8');
		$data['contest_location'] 	=	html_entity_decode($contest_info['location'], ENT_QUOTES, 'UTF-8');
		$data['contest_members'] 	=	html_entity_decode($contest_info['members'], ENT_QUOTES, 'UTF-8');
		$data['contest_contacts'] 	=	html_entity_decode($contest_info['contacts'], ENT_QUOTES, 'UTF-8');
		$data['contest_timeline_text'] 	=	html_entity_decode($contest_info['timeline_text'], ENT_QUOTES, 'UTF-8');

		$data['contest_date_start'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_start']));
		$data['contest_datetime_end'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['datetime_end']));
		$data['contest_date_rate'] 			=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_rate']));
		$data['contest_date_result'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_result']));
		$data['contest_date_finalist'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_finalist']));

		$data['image'] = '';
		if (!empty($contest_info['image'])) {
			$data['image'] = $this->model_tool_image->resize($contest_info['image'], 800, 460,'w');
		} else {
			$data['image'] = $this->model_tool_image->resize('no-image.png', 800, 460,'w');
		}
		//ссылка на участие

		$data['text_im_deal'] 				= $this->language->get('text_im_deal');
		$data['im_deal']  = $this->url->link('contest/deal', 'contest_id=' . $data['contest_id'], 'SSL');	

		
		//информация о пользователе
		$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		$customer_id = $this->customer->getId();
		//стандартные поля
		$data['firstname'] = $customer_info['firstname'];
		$data['lastname'] = $customer_info['lastname'];
		$data['email'] = $customer_info['email'];
		$data['telephone'] = $customer_info['telephone'];

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
				$data['avatar'] = $this->model_tool_upload->resize($filename , 360, 490, 'h');
			}
		}else{
			$data['avatar'] = $this->model_tool_image->resize('account.jpg', 360, 490, 'h');
		}

		/**************** проверка ***************/
		//проверка на участие
		$filter_data = array();
		$filter_data = array(
			'filter_customer_id' 	=> 	$customer_id,
			'filter_contest_id'		=>	$contest_id,
			'filter_no_acepted'		=>  1
		);
		$result_customer_req_contest = $this->model_contest_contest->getRequestForCustomer($filter_data);

		//проверка на количесто заявок от данного пользователя
		if(count($result_customer_req_contest) > 0){
			$this->session->data['warning'] = $this->language->get('text_contest_error');
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}




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

		//группы где пользователь администратор
		$results_admin_groups = $this->model_group_group->getGroupsForAdmin($customer_id);

		$data['admin_init_groups'] = array();
		foreach ($results_admin_groups as $result) {
			$data['admin_init_groups'][] = array(
				'group_id'	=> $result['init_group_id']
			);
		}

		//подтянем информацию ос ушествующих у пользователя проетках
		//информация о проектах где пользователь я вляется admin
		$results_projects_for_customer = $this->model_project_project->getProjectsForAdmin($customer_id);
		$data['projects_for_customer'] = array();
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
			$data['projects_for_customer'][] = array(
				'project_id'		=> $result_pfc['project_id'],
				'project_title'		=> $result_pfc['title'],
				'project_image'		=> $image,
				'prject_action'		=> $actions
			);

		}
		/******************* /.проекты *******************/

		$data['action'] = $this->url->link('contest/send', 'contest_id='.$contest_id, 'SSL');


		///нужна ли группа для участия в конкурсе?????

		



		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_deal.tpl')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/contest.js');
		} else {
			$this->document->addScript('catalog/view/theme/default/assets/js/contest.js');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_deal.tpl')) {
			
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/contest/contest_deal.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/contest/contest_deal.tpl', $data));
		}
	}
	protected function dealBestContest($contest_info){
		//для конкурса BestPractice
		//1 пользователь должен быть победителем (или иметь промокод при использовани котрого указывает какой проект из его выиграл)
		//2 пользоватлеь может подать 2 заявки (наврно нужно регулировать), то есть выбирает проект котрые будет адаптировать
		//
	  $contest_id = $this->request->get['contest_id'];
	  $customer_id = $this->customer->getId();
	  //проверяем является пользователь победителем, то есть еслть ли уне гопроект который где либо победил кроме конкурсов бест практики
	  $is_winner = false;

	  //получим список конкурсов где пользователь был победителем,
	  //если у пользователя есть проект победитель в каком то конкурсе 

	  //выведем список проектов для адаптации
	  //1 пользователь указывает проект для участия в  текущем конкурсе (при этом проект должен быть помечен как победитель)
	  //2 пользоватеь выбирает проект для адаптации
	  //3 заполняет заявку - на основе полей указанных   
	  //подгрузим модели
		$this->load->model('account/customer');
		$this->load->model('group/group');
		$this->load->model('project/project');
		$this->load->model('contest/contest');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');


/* search filter */
//возраст

		$filter_data = array();
		$age_statuses_results = $this->model_project_project->getAgeStatuses($filter_data);
		$data['age_statuses']  = array();
		foreach ($age_statuses_results as $ssr) {
			$data['age_statuses'][]  = array(
				'age_status_id'	=> $ssr['age_status_id'],
				'title'  => $ssr['name']
			);
		}

/* search filter */
	  //1 при помощи промокода мы метим проект как победитель (тоесть засовываем его в таблицу победителей contest_winner, в поле конкурс == 0, ), //чуть позже


	  //2 при заходе на конкурс видит свои проект победители (исключая + те котрые он выбрал зарание) и кладу его в таблицу oc_contest_adaptor 
	  //3 те проекты котрые сейчас в oc_contest_adaptor (тоесть их можно адаптировать) проект на выбор для адаптации 
	  //4 введем в таблицу победителей поле adapter_id (id проекта  котрый пользовател выбрал и победил)
	  //5 заявка наполнятеся на отснове данных  о выбранно проетке и пользователе
	  //6 по заявку надо внести поле adapter_id - для отсечения

	  	//информация о проектах где пользователь я вляется admin
	  //1
	  $results_projects_for_customer = $this->model_project_project->getProjectsForAdmin($customer_id);
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
			if(!empty($projects_winner[$result_pfc['project_id']])){
				$win = 1;
			}
			$projects_for_customer[$result_pfc['project_id']] = array(
				'project_id'			=> $result_pfc['project_id'],
				'project_title'		=> $result_pfc['title'],
				'project_image'		=> $image,
				'project_winner'  => $win,
				'prject_action'		=> $actions
			);
		}

		
		$data['contest_href'] = $this->url->link('contest/view', 'contest_id='.$contest_id, 'SSL');
		$data['add_project'] = $this->url->link('project/edit', '', 'SSL'); 

		//получим список проектов из таблицы contest_adaptor где customer_id=customer_id AND contest_id=contest_id
		//узнаем подавал ли пользователь на адаптацию свой проект 
	  	$results_personal_adaptive_projects = $this->model_contest_contest->getPersonalAdaptive($customer_id,$contest_id);

	  	
	  	$data['my_adaptive'] =0;
	  	$data['my_adaptive_projects_for_contest'] = array();
	  	if(!empty($results_personal_adaptive_projects)){
	  		foreach ($results_personal_adaptive_projects as $vrpap) {
	  			$data['my_adaptive_projects_for_contest'][] = $vrpap['project_id'];
	  			$data['my_adaptive'] = $vrpap['project_id'];
	  		}
	  		
	  	}
	  	
	  	



	
	  	$results_customer_winner = $this->model_contest_contest->getWinnerContest($customer_id);
	 	$data['my_project'] = array();
	 	foreach ($results_customer_winner as $vcw) {
	 			
		 			$data['my_project'][] = array(
		 				'project_id'			=> $vcw['project_id'],
						'project_title'		=> $projects_for_customer[$vcw['project_id']]['project_title'],
						'project_image'		=> $projects_for_customer[$vcw['project_id']]['project_image'],
						'project_status'	=> (in_array($vcw['project_id'], $data['my_adaptive_projects_for_contest']))?'1':'0'
		 			);
	 			
	 	}

	 	
	 	//подтягиваем проекты котрые предназначены для адаптации
	 	//список всех проекты
	 	$results_projects = $this->model_project_project->getProjects();
		$projects = array();
		foreach ($results_projects as $result_p) {
			if (!empty($result_p['image'])) {
				$upload_info = $this->model_tool_upload->getUploadByCode($result_p['image']);
				$filename = $upload_info['filename'];
				$image = $this->model_tool_upload->resize($filename , 300, 300,'h');
			} else {
				$image = $this->model_tool_image->resize('no-image.png', 300, 300,'h');
			}

			$actions = array(
				'view'		=> $this->url->link('project/view', 'project_id='.$result_p['project_id'], 'SSL')
			);
			$projects[$result_p['project_id']] = array(
				'project_id'			=> $result_p['project_id'],
				'project_title'			=> (strlen(strip_tags(html_entity_decode($result_p['title'], ENT_COMPAT, 'UTF-8'))) > 40 ? mb_strcut(strip_tags(html_entity_decode($result_p['title'], ENT_COMPAT, 'UTF-8')), 0, 40) . '...' : strip_tags(html_entity_decode($result_p['title'], ENT_COMPAT, 'UTF-8'))),
				'project_image'			=> $image,
				'project_age' 			=> unserialize($result_p['project_age']),
				'action'				=> $actions
			);
		}

		
		
	
		//получим список проектов  из заявок для данного конкурса (те проекты котрые исключаем из  списка adaptive_id)
		$results_request_projects_for_adaptive = $this->model_project_project->getProjectsFromRequestForContest($customer_id,$contest_id);
		$project_request_adaptive = array();
		//список проектов которые уже поданы в заявку данным пользователем 
		foreach ($results_request_projects_for_adaptive as $vpra) {
			$project_request_adaptive[$vpra['adaptive_id']] = array(
				'adaptive_id' => $vpra['adaptive_id']
			);
		}
		
		//получим список проектов для адаптации из  таблицы contest_adaptor
		$results_adaptive_projects = $this->model_project_project->getProjectsForAdaptive($customer_id);
		$data['adaptive_projects'] = array();
		foreach ($results_adaptive_projects as $vrap) {
			if(empty($project_request_adaptive[$vrap['project_id']])){
				$data['adaptive_projects'][] = array(
	 				'project_id'			=> $vrap['project_id'],
					'project_title'		=> $projects[$vrap['project_id']]['project_title'],
					'project_image'		=> $projects[$vrap['project_id']]['project_image'],
					'project_action'		=> $projects[$vrap['project_id']]['action'],
					'project_age'     => $projects[$vrap['project_id']]['project_age'][0]
	 			);
			}
			
		}

		



		//для шифрования
		$data['contest_id'] = $contest_id;
		//подгрузим язык
		$this->load->language('contest/deal');
		//SEO
		$this->document->setTitle('Заявка');
		//$this->document->setDescription(substr(strip_tags(html_entity_decode($contest_info['meta_description'], ENT_QUOTES)), 0, 150) . '...');
		//$this->document->setKeywords($contest_info['meta_keyword']);

		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		



		$data['entry_title'] 				= $this->language->get('entry_title');
		$data['entry_description'] 			= $this->language->get('entry_description');
		$data['entry_image'] 				= $this->language->get('entry_image');
		$data['entry_contest_birthday'] 	= $this->language->get('entry_contest_birthday');
		$data['entry_contest_email'] 		= $this->language->get('entry_contest_email'); 
		
		$data['entry_contest_dates'] 		= $this->language->get('entry_contest_dates'); 
		$data['entry_contest_date_start'] 		= $this->language->get('entry_contest_date_start'); 
		$data['entry_contest_datetime_end'] 	= $this->language->get('entry_contest_datetime_end'); 
		$data['entry_contest_date_rate'] 		= $this->language->get('entry_contest_date_rate'); 
		$data['entry_contest_date_result'] 		= $this->language->get('entry_contest_date_result'); 
		$data['entry_contest_date_finalist'] 	= $this->language->get('entry_contest_date_finalist'); 

		$data['entry_contest_organizer'] 	= $this->language->get('entry_contest_organizer'); 
		$data['entry_contest_budget'] 		= $this->language->get('entry_contest_budget');
		$data['entry_contest_propose'] 		= $this->language->get('entry_contest_propose'); 
		$data['entry_contest_location'] 	= $this->language->get('entry_contest_location'); 
		$data['entry_contest_members'] 		= $this->language->get('entry_contest_members'); 
		$data['entry_contest_contacts'] 	= $this->language->get('entry_contest_contacts'); 
		$data['entry_contest_timeline_text']= $this->language->get('entry_contest_timeline_text'); 
		$data['entry_contest_budget']		= $this->language->get('entry_contest_budget'); 
		$data['entry_contest_maxprice']		= $this->language->get('entry_contest_maxprice'); 
		$data['entry_contest_totalprice']	= $this->language->get('entry_contest_totalprice'); 
		

		$data['text_create'] 				= $this->language->get('text_create');
		$data['text_member'] 				= $this->language->get('text_member');
		

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_contests'),
			'href' => $this->url->link('contest/contest', '', 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $contest_info['title'],
			'href' => $this->url->link('contest/view', 'contest_id=' . $data['contest_id'], 'SSL')
		);

		//подгрузим модели
		$this->load->model('account/customer');
		
		$this->load->model('project/project');
		$this->load->model('group/group');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');

		$data['contest_title'] 		=	html_entity_decode($contest_info['title'], ENT_QUOTES, 'UTF-8');
		$data['contest_description'] 	=	html_entity_decode($contest_info['description'], ENT_QUOTES, 'UTF-8');
		$data['contest_organizer'] 	=	html_entity_decode($contest_info['organizer'], ENT_QUOTES, 'UTF-8');
		$data['contest_propose'] 	=	html_entity_decode($contest_info['propose'], ENT_QUOTES, 'UTF-8');
		$data['contest_location'] 	=	html_entity_decode($contest_info['location'], ENT_QUOTES, 'UTF-8');
		$data['contest_members'] 	=	html_entity_decode($contest_info['members'], ENT_QUOTES, 'UTF-8');
		$data['contest_contacts'] 	=	html_entity_decode($contest_info['contacts'], ENT_QUOTES, 'UTF-8');
		$data['contest_timeline_text'] 	=	html_entity_decode($contest_info['timeline_text'], ENT_QUOTES, 'UTF-8');

		$data['contest_date_start'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_start']));
		$data['contest_datetime_end'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['datetime_end']));
		$data['contest_date_rate'] 			=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_rate']));
		$data['contest_date_result'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_result']));
		$data['contest_date_finalist'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_finalist']));

		$data['image'] = '';
		if (!empty($contest_info['image'])) {
			$data['image'] = $this->model_tool_image->resize($contest_info['image'], 800, 460,'w');
		} else {
			$data['image'] = $this->model_tool_image->resize('no-image.png', 800, 460,'w');
		}
		//ссылка на участие

		$data['text_im_deal'] 				= $this->language->get('text_im_deal');
		$data['im_deal']  = $this->url->link('contest/deal', 'contest_id=' . $data['contest_id'], 'SSL');	

		
		//информация о пользователе
		$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		$customer_id = $this->customer->getId();
		//стандартные поля
		$data['firstname'] = $customer_info['firstname'];
		$data['lastname'] = $customer_info['lastname'];
		$data['email'] = $customer_info['email'];
		$data['telephone'] = $customer_info['telephone'];

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
				$data['avatar'] = $this->model_tool_upload->resize($filename , 360, 490, 'h');
			}
		}else{
			$data['avatar'] = $this->model_tool_image->resize('account.jpg', 360, 490, 'h');
		}

		/**************** проверка ***************/
		//проверка на участие
		$filter_data = array();
		$filter_data = array(
			'filter_customer_id' 	=> 	$customer_id,
			'filter_contest_id'		=>	$contest_id,
			'filter_no_acepted'		=>  1
		);
		$result_customer_req_contest = $this->model_contest_contest->getRequestForCustomer($filter_data);

		
	  	if(count($result_customer_req_contest) > 2){
			$this->session->data['warning'] = 'Количество заявок на конкурс ограничено';
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}
		$data['action'] = $this->url->link('contest/sendbest', 'contest_id='.$contest_id, 'SSL');

		///нужна ли группа для участия в конкурсе?????

		

		//фильтр проектов

		//получим списки фильтров
		//целевые аудиториии
		//пол

		$filter_data = array();
		$sex_statuses_results = $this->model_project_project->getSexStatuses($filter_data);
		$data['sex_statuses']  = array();
		foreach ($sex_statuses_results as $ssr) {
			$data['sex_statuses'][$ssr['sex_status_id']] = array(
				'filtet_id'				=> $ssr['sex_status_id'],
				'filter_title'  	=> $ssr['name']
			);
		}

		//возраст
		$filter_data = array();
		$age_statuses_results = $this->model_project_project->getAgeStatuses($filter_data);
		$data['age_statuses']  = array();
		foreach ($age_statuses_results as $ssr) {
			$data['age_statuses'][]  = array(
				'filtet_id'				=> $ssr['age_status_id'],
				'filter_title'  	=> $ssr['name']
			);
		}

		//национальность и религия
		$filter_data = array();
		$nationality_statuses_results = $this->model_project_project->getNationalityStatuses($filter_data);
		$data['nationality_statuses']  = array();
		foreach ($nationality_statuses_results as $ssr) {
			$data['nationality_statuses'][]  = array(
				'filtet_id'				=> $ssr['nationality_status_id'],
				'filter_title'  	=> $ssr['name']
			);
		}


		//профессиональный статус
		$filter_data = array();
		$professional_statuses_results = $this->model_project_project->getProfessionalStatuses($filter_data);
		$data['professional_statuses']  = array();
		foreach ($professional_statuses_results as $psr) {
			$data['professional_statuses'][]  = array(
				'filtet_id'				=> $psr['professional_status_id'],
				'filter_title'  	=> $psr['name']
			);
		}

		//демографический статус
		$filter_data = array();
		$demographic_statuses_results = $this->model_project_project->getDemographicStatuses($filter_data);
		$data['demographic_statuses']  = array();
		foreach ($demographic_statuses_results as $psr) {
			$data['demographic_statuses'][]  = array(
				'filtet_id'				=> $psr['demographic_status_id'],
				'filter_title'  	=> $psr['name']
			);
		}







		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_deal.tpl')) {
				$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/mixitup.min.js');
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/contest_best.js');

		} else {
			$this->document->addScript('catalog/view/theme/default/assets/js/mixitup.min.js');
			$this->document->addScript('catalog/view/theme/default/assets/js/contest_best.js');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_best_deal.tpl')) {
			
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/contest/contest_best_deal.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/contest/contest_best_deal.tpl', $data));
		}



		
	}
	protected function validate() {
		

		foreach ($this->request->post['project_description'] as $language_id => $value) {
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