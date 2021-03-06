<?php
/**
 * Заявка для обыкновенных проектов
 */
class ControllerContestSend extends Controller {
	private $error = array();
	//создаем группу
	public function index(){


		$this->getView();
	}

	private function getView(){
		//подгрузим язык
		$this->load->language('contest/send');
		//SEO
		$this->document->setTitle($this->language->get('entry_title'));
		//$this->document->setDescription(substr(strip_tags(html_entity_decode($contest_info['meta_description'], ENT_QUOTES)), 0, 150) . '...');
		//$this->document->setKeywords($contest_info['meta_keyword']);




		//подгрузим модели
		$this->load->model('account/customer');
		$this->load->model('contest/contest');
		$this->load->model('contest/contest_field');
		$this->load->model('project/project');
		$this->load->model('group/group');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		$this->load->model('localisation/category_request');

//*************************** проверки ********************************//
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//проверка на то что заявка редактируется
$data['draft'] = true;
$result_request_information  = array();
$register_custom_field =array();





		//проверка на сушествование пользователя и логина в системе
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}
		$customer_id = $this->customer->getId();


		



			if(isset($this->request->get['customer_to_contest_id']) && $this->request->get['customer_to_contest_id']>0){
				$customer_to_contest_id = $this->request->get['customer_to_contest_id'];
				//получим инфу о заявке
				$result_request_information = $this->model_contest_contest->getInformationAboutRequest($customer_to_contest_id);

				$val  = unserialize($result_request_information['value']);
				$register_custom_field = $val['custom_fields'];

				/*print_r('<pre>');
				print_r($register_custom_field);
				print_r('</pre>');
				die();
				*/
			
			//!!!!!!!!!!!!!!!!!!!!!!!!!!
				//получим номер проекта котрый мы положили в пулл конкурса
				$project_id = $result_request_information['project_id'];;
				$contest_id = $result_request_information['contest_id'];


				$data['draft'] = ($result_request_information['status'] < 3)? false : true;
				$data['draft_check'] = ($result_request_information['status'] < 3)? false : true;
				$data['action'] = $this->url->link('contest/send', 'customer_to_contest_id='.$this->request->get['customer_to_contest_id'], 'SSL');
			 // print_r($result_request_information);


			}else{
				$project_id = $this->request->get['project_id'];
				$contest_id = $this->request->get['contest_id'];
				//проект для адаптации

				$data['action'] = $this->url->link('contest/send', 'contest_id='.$contest_id.'&project_id='.$project_id, 'SSL');
				$data['draft_check'] = false;
			}
			//проверка на сушествование конкурса
			$contest_info = array();
			$contest_info = $this->model_contest_contest->getContest($contest_id);
			if ( empty($contest_info) ){
				//редиректим на список конкурсов
				$this->session->data['redirect'] = $this->url->link('contest/contest', '', 'SSL');
				$this->response->redirect($this->url->link('contest/contest', '', 'SSL'));
			}
			//если конкурс в статусе работа - редирект
			//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!



			//проверка на сушествование проекта
			$project_info = array();
			$project_info = $this->model_project_project->getProject($project_id);
			if ( empty($project_info) ){
				//редиректим на список проектов
				//$this->session->data['redirect'] = $this->url->link('project/project', '', 'SSL');
			//	$this->response->redirect($this->url->link('project/project', '', 'SSL'));
				}else{
					$admin_project_id = $project_info['customer_id'];
					//проверка на админа группы
					if ( $admin_project_id != $customer_id ){
						//редиректим на список проектов
						$this->session->data['redirect'] = $this->url->link('project/project', '', 'SSL');
						$this->response->redirect($this->url->link('project/project', '', 'SSL'));
					}
				}


//*************************** проверки ********************************//

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {



			if(isset($this->request->get['customer_to_contest_id']) && $this->request->get['customer_to_contest_id']>0){

        $this->model_contest_contest->editRequest($this->request->post,$this->request->get['customer_to_contest_id']);
        $this->session->data['success'] = 'Заявка отредактирована/отправлена';

      }else{
				$adaptive_id = 0;
				//сначала добавляем новый проект
				$data_post  = array();
				$data_post = $this->request->post;
				// информация о проекте  12 категория
				$project_title = '';
				if(!empty($data_post['custom_fields'][12])){
					foreach ($data_post['custom_fields'][12] as $vdp) {

						if($vdp['field_id'] == 13){

							$project_title = $vdp['value'] ;
						}
					}
				}
				if(!empty($data_post[15])){
					foreach ($data_post[15] as $vdpb) {
						if($vdpb['field_id'] == 27){

						}
					}
				}

				$data_post['image'] = '';
				$data_post['project_birthday'] = '';
				$data_post['project_init_group_id'] = '';
				$data_post['project_budget'] = '';
				$data_post['project_status_id'] = 2;
				$data_post['project_visibility'] = 1;
				$data_post['project_relation_id'] = 1;
				$data_post['project_currency_id'] = 4;
				$data_post['project_description'][2] = array(
										'title' => $project_title,
										'target' => '',
										'product' => '',
										'description' => '',
										'result' => ''
				);
			
				$project_id = $this->model_project_project->addProject($data_post,$customer_id);
				if($project_id){
					$this->model_contest_contest->addRequest($this->request->post,$customer_id,$contest_id,$adaptive_id,$project_id);
	        //отправляю проектв $project_id  в копилку проектов
	      //  $this->model_contest_contest->addAdaptive($customer_id,$contest_id,$project_id);
					if($this->request->post['draft']){
						$this->session->data['success'] = 'Заявка сохранена';
					}else{
						$this->session->data['success'] = $this->language->get('text_contest_success');
					}
	        
				}


      }

		//	$this->model_contest_contest->addRequestToContest($this->request->post,$customer_id,$contest_id);
		//	$this->session->data['success'] = $this->language->get('text_contest_success');
			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $customer_id,
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);

			$this->model_account_activity->addActivity('add request to contest', $activity_data);

			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}







		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (!empty($this->error['custom_fields'])) {
			$data['error_custom_field'] = $this->error['custom_fields'];
		} else {
			$data['error_custom_field'] = array();
		}


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
			'href' => $this->url->link('contest/view', 'contest_id=' . $contest_id, 'SSL')
		);

		$data['entry_title'] 							= $this->language->get('entry_title');
		$data['entry_description'] 				= $this->language->get('entry_description');
		$data['entry_image'] 							= $this->language->get('entry_image');
		$data['entry_contest_birthday'] 	= $this->language->get('entry_contest_birthday');
		$data['entry_contest_email'] 			= $this->language->get('entry_contest_email');

		$data['entry_contest_dates'] 					= $this->language->get('entry_contest_dates');
		$data['entry_contest_date_start'] 		= $this->language->get('entry_contest_date_start');
		$data['entry_contest_datetime_end'] 	= $this->language->get('entry_contest_datetime_end');
		$data['entry_contest_date_rate'] 			= $this->language->get('entry_contest_date_rate');
		$data['entry_contest_date_result'] 		= $this->language->get('entry_contest_date_result');
		$data['entry_contest_date_finalist'] 	= $this->language->get('entry_contest_date_finalist');

		$data['entry_contest_organizer'] 		= $this->language->get('entry_contest_organizer');
		$data['entry_contest_budget'] 			= $this->language->get('entry_contest_budget');
		$data['entry_contest_propose'] 			= $this->language->get('entry_contest_propose');
		$data['entry_contest_location'] 		= $this->language->get('entry_contest_location');
		$data['entry_contest_members'] 			= $this->language->get('entry_contest_members');
		$data['entry_contest_contacts'] 		= $this->language->get('entry_contest_contacts');
		$data['entry_contest_timeline_text']	= $this->language->get('entry_contest_timeline_text');
		$data['entry_contest_budget']				= $this->language->get('entry_contest_budget');
		$data['entry_contest_maxprice']			= $this->language->get('entry_contest_maxprice');
		$data['entry_contest_totalprice']		= $this->language->get('entry_contest_totalprice');

		$data['text_create'] 					= $this->language->get('text_create');
		$data['text_member'] 					= $this->language->get('text_member');
		$data['text_submit'] 					= $this->language->get('text_submit');
		$data['text_select']  				= $this->language->get('text_select');


		$data['contest_title'] 						=	html_entity_decode($contest_info['title'], ENT_QUOTES, 'UTF-8');
		$data['contest_description'] 			=	html_entity_decode($contest_info['description'], ENT_QUOTES, 'UTF-8');
		$data['contest_organizer'] 				=	html_entity_decode($contest_info['organizer'], ENT_QUOTES, 'UTF-8');
		$data['contest_propose'] 					=	html_entity_decode($contest_info['propose'], ENT_QUOTES, 'UTF-8');
		$data['contest_location'] 				=	html_entity_decode($contest_info['location'], ENT_QUOTES, 'UTF-8');
		$data['contest_members'] 					=	html_entity_decode($contest_info['members'], ENT_QUOTES, 'UTF-8');
		$data['contest_contacts'] 				=	html_entity_decode($contest_info['contacts'], ENT_QUOTES, 'UTF-8');
		$data['contest_timeline_text'] 		=	html_entity_decode($contest_info['timeline_text'], ENT_QUOTES, 'UTF-8');

		$data['contest_date_start'] 			=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_start']));
		$data['contest_datetime_end'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['datetime_end']));
		$data['contest_date_rate'] 				=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_rate']));
		$data['contest_date_result'] 			=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_result']));
		$data['contest_date_finalist'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_finalist']));

		$data['image'] = '';
		if (!empty($contest_info['image'])) {
			$data['image'] = $this->model_tool_image->resize($contest_info['image'], 800, 460,'w');
		} else {
			$data['image'] = $this->model_tool_image->resize('no-image.png', 800, 460,'w');
		}


//************************* информация о пользователе *************************//
		$customer_info = $this->model_account_customer->getCustomer($customer_id);

		//стандартные поля
		$data['firstname'] = $customer_info['firstname'];
		$data['lastname'] = $customer_info['lastname'];
		$data['email'] = $customer_info['email'];
		$data['telephone'] = $customer_info['telephone'];

		// Custom Fields
		$this->load->model('account/custom_field');
		//$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));
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

//************************* информация о группах *************************//
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
				'group_description'=> html_entity_decode($result_g['description'], ENT_QUOTES, 'UTF-8'),
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






//************************* информация о проекте *************************//
$project_title = '';
$project_description  = '';
$data['image'] = '';
$project_birthday = '';
$admin_id = $customer_id ;
$init_group_information = '';
if(!empty($project_info)){
	$project_title      = html_entity_decode($project_info['title'], ENT_QUOTES, 'UTF-8');
	$project_description  = html_entity_decode($project_info['description'], ENT_QUOTES, 'UTF-8');


	if (!empty($project_info['image'])) {
		$upload_info = $this->model_tool_upload->getUploadByCode($project_info['image']);
		$filename = $upload_info['filename'];
		$data['image'] = $this->model_tool_upload->resize($filename , 800, 460,'w');
	} else {
		$data['image'] = $this->model_tool_image->resize('no-image.png', 800, 460,'w');
	}

	$project_birthday     = rus_date($this->language->get('date_day_date_format'), strtotime($project_info['project_birthday']));

	//************************* инфо огруппе *************************//
			//подтянем администратора группы если есть группа и в данном конкурсе нужна группа
			$admin_id = $project_info['customer_id'];

			$init_group_information = (!empty($data['init_groups'][$project_info['project_init_group_id']]))?$data['init_groups'][$project_info['project_init_group_id']]:'' ;

}

//************************* информация о конкурсе *************************//

//подтянем поля для заполнения
//СИСТЕМНЫЕ ПОЛЯ
$data['contest_field_system']['customer'] = array();
//поля пользователя
$data['contest_field_system']['customer']['firstname'] = array(
	'field_value_r'         => $customer_info['firstname'],
	'field_type'          => 'text'
);
$data['contest_field_system']['customer']['lastname'] = array(
	'field_value_r'         => $customer_info['lastname'],
	'field_type'          => 'text'
);
$data['contest_field_system']['customer']['email'] = array(
	'field_value_r'         => $customer_info['email'],
	'field_type'          => 'text'
);
$data['contest_field_system']['customer']['telephone'] = array(
	'field_value_r'         => $customer_info['telephone'],
	'field_type'          => 'text'
);



$data['contest_field_system']['init_group'] = array();
//поля для группы
$data['contest_field_system']['init_group']['title'] = array(
'field_value_r'         => (!empty($init_group_information))? $init_group_information['group_title']:'',
'field_type'            => 'text'
);
$data['contest_field_system']['init_group']['group_description'] = array(
'field_value_r'         => (!empty($init_group_information))?$init_group_information['group_description']:'',
'field_type'          => 'textarea'
);
///!!!!!!!!!!
//поля для проекта
$data['contest_field_system']['project'] = array();
$data['contest_field_system']['project']['title'] = array(
'field_value_r'         => $project_title,
'field_type'          => 'text'
);

$data['contest_field_system']['project']['project_budget'] = array(
'field_value_r'         => '',
'field_type'          => 'text'
);
$data['contest_field_system']['project']['description'] = array(
'field_value_r'         => (!empty($project_info))?$project_description:'',
'field_type'          => 'textarea'
);
$data['contest_field_system']['project']['target'] = array(
'field_value_r'         => (!empty($project_info))?$project_info['target']:'',
'field_type'          => 'target'
);
$data['contest_field_system']['project']['product'] = array(
'field_value_r'         => (!empty($project_info))?$project_info['product']:'',
'field_type'       		=> 'textarea'
);
$data['contest_field_system']['project']['result'] = array(
'field_value_r'         => (!empty($project_info))?$project_info['result']:'',
'field_type'       => 'textarea'
);
$data['contest_field_system']['project']['project_birthday'] = array(
'field_value_r'         => (!empty($project_info))?$project_info['project_birthday']:'',
'field_type'       => 'textarea'
);

//

$data['contest_field_system']['project']['project_age'] = array(
'field_value'         => $this->model_contest_contest_field->getProjectAges(),
'field_value_r'       => (!empty($project_info))?unserialize($project_info['project_age']):array(),
'field_type'          => 'checkbox'
);

$data['contest_field_system']['project']['project_sex'] = array(
'field_value'         => $this->model_contest_contest_field->getProjectSexs(),
'field_value_r'       => (!empty($project_info))?unserialize($project_info['project_sex']):array(),
'field_type'          => 'checkbox'
);

$data['contest_field_system']['project']['project_nationality'] = array(
'field_value'         => $this->model_contest_contest_field->getProjectNationalitys(),
'field_value_r'       => (!empty($project_info))?unserialize($project_info['project_nationality']):array(),
'field_type'          => 'checkbox'
);

$data['contest_field_system']['project']['project_professional'] = array(
'field_value'         => $this->model_contest_contest_field->getProjectProfessionals(),
'field_value_r'       => (!empty($project_info))?unserialize($project_info['project_professional']):array(),
'field_type'          => 'checkbox'
);

$data['contest_field_system']['project']['project_demographic'] = array(
'field_value'         => $this->model_contest_contest_field->getProjectDemographics(),
'field_value_r'       => (!empty($project_info))?unserialize($project_info['project_demographic']):array(),
'field_type'          => 'checkbox'
);



/*
		//поля для проекта




		$data['contest_field_system']['project'][] = array(
			'field_title'          => $this->language->get('text_project_birthday'),
			'field_source'		   => 'project',
			'field_value' 		   => 'project_birthday'
		);
		$data['contest_field_system']['project'][] = array(
			'field_title'          => $this->language->get('text_project_status_id'),
			'field_source'		   => 'project',
			'field_value' 		   => 'project_status_id'
		);
		$data['contest_field_system']['project'][] = array(
			'field_title'          => $this->language->get('text_project_age'),
			'field_source'		   => 'project',
			'field_value' 		   => 'project_age'
		);
		$data['contest_field_system']['project'][] = array(
			'field_title'          => $this->language->get('text_project_sex'),
			'field_source'		   => 'project',
			'field_value' 		   => 'project_sex'
		);
		$data['contest_field_system']['project'][] = array(
			'field_title'          => $this->language->get('text_project_nationality'),
			'field_source'		   => 'project',
			'field_value' 		   => 'project_nationality'
		);
		$data['contest_field_system']['project'][] = array(
			'field_title'          => $this->language->get('text_project_professional'),
			'field_source'		   => 'project',
			'field_value' 		   => 'project_professional'
		);
		$data['contest_field_system']['project'][] = array(
			'field_title'          => $this->language->get('text_project_demographic'),
			'field_source'		   => 'project',
			'field_value' 		   => 'project_demographic'
		);

		$data['contest_field_system']['project'][] = array(
			'field_title'          => $this->language->get('text_project_currency_id'),
			'field_source'		   => 'project',
			'field_value' 		   => 'project_currency_id'
		);
		$data['contest_field_system']['project'][] = array(
			'field_title'          => $this->language->get('text_project_image'),
			'field_source'		   => 'project',
			'field_value' 		   => 'project_image'
		);
		*/


		  //подтянем список каетгорий для заявки на  конкурса
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
/**********/

	    //подтянуть список всех полей заявки для каждой категории
		  $this->load->model('contest/contest_field');
		  $filter_data = array(
				'order' => 'ASC'
			);
			$contest_fields_results = $this->model_contest_contest_field->getContestFields($filter_data);
			/*
			 			[contest_field_id] => 6
            [type] => textarea
            [field_system] => custom
            [field_system_table] => custom
            [value] =>
            [location] => 14 // id группы в заявке
            [required] => 0
            [status] => 1
            [sort_order] => 0
            [language_id] => 2
            [name] => Дополнителное образование

      */
/**********/
      //поля которые записаны именно в данном конкурсе
			$data['custom_fields'] = unserialize($contest_info["contest_fields"]) ;

/**********/
			//получим список все полей
			$contest_fields = array();

			foreach ($contest_fields_results as  $cfr) {
				//проверка если вдруг добавили новое поле а вконкурсе его нет
				//проверяем сушествоваени к аегории
				if(!empty( $data['custom_fields'][$cfr['location']])){
					//проверяем что такая категория есть в самом конкурсе
					//прокрутим поля именно в конкурсе
					foreach ( $data['custom_fields'][$cfr['location']] as $cvalue) {

						if($cvalue['contest_field_id'] == $cfr['contest_field_id']){

							$status  		=  $cvalue['status'];
							$sort_order  	=  $cvalue['sort_order'];
							break;
						}

					}

				} else {
					$status  		=  0;
					$sort_order  	=  0;
				}



				$contest_fields_value = '';
				//дклаем проверку на системное или нет поле $cfr['field_system'] => custom - не системное
				if ( ($cfr['type'] == 'select' || $cfr['type'] == 'radio' || $cfr['type'] == 'checkbox') && $cfr['field_system'] == 'custom' )  {
					//если не системны и пречисляемый тип
					$contest_fields_value = $this->model_contest_contest_field->getContestFieldValues($cfr['contest_field_id']);
					$type = $cfr['type'];

					$val_r = array();//значение в заявке
				if(!empty($register_custom_field[$cfr['location']])){
						foreach ($register_custom_field[$cfr['location']] as $vrcf) {
							if($vrcf['field_id'] == $cfr['contest_field_id']){

								$val_r = (!empty($vrcf['value']))?$vrcf['value']:array();
							}
						}
					}
				}elseif ($cfr['type'] == 'file'){
			          $contest_fields_value = array();//$data['register_custom_field'][$cfr['contest_field_id']]['field_value'];

			          $type = $cfr['type'];

			          $val_r = '';//значение в заявке
			          if(!empty($register_custom_field[$cfr['location']])){
			            foreach ($register_custom_field[$cfr['location']] as $vrcf) {
			              if($vrcf['field_id'] == $cfr['contest_field_id']){
			                
			                $val_r = array();
			                if(!empty($vrcf['value'])){
			                  foreach ($vrcf['value'] as $vcfv) {
			                    $file_name = '';
			                    if(!empty($vcfv)){
			                      $upload_info = $this->model_tool_upload->getUploadByCode($vcfv);
			                      $file_name = $upload_info['name'];
			                    }
			                    $val_r[] = array(
			                      'value'     => $vcfv,
			                      'file_name' => $file_name
			                    );
			                  }
			                }


			              }
			            }
			          }

				}elseif ($cfr['field_system'] != 'custom'){


					$type = $data['contest_field_system'][$cfr['field_system_table']][$cfr['field_system']]['field_type'];

					if(  $type == 'select' || $type == 'radio' || $type == 'checkbox' ){

						$contest_fields_value = $data['contest_field_system'][$cfr['field_system_table']][$cfr['field_system']]['field_value'];
						//если тип поля системный и перечисляемый
						if(empty($result_request_information['status'])){
							$val_r = $data['contest_field_system'][$cfr['field_system_table']][$cfr['field_system']]['field_value_r'];
						}else{
							$val_r = array();//значение в заявке
							//print_r(expression)
							if(!empty($register_custom_field[$cfr['location']])){

								foreach ($register_custom_field[$cfr['location']] as $vrcf) {
									if($vrcf['field_id'] == $cfr['contest_field_id']){
										$val_r = (!empty($vrcf['value']))?$vrcf['value']:array();
									}
								}

							}
						}
						/*****/	
					}else{
							//си=стемное поле
						 $contest_fields_value = '';
					 	if(!isset($result_request_information['status'])){
	           		
	           		$val_r = $data['contest_field_system'][$cfr['field_system_table']][$cfr['field_system']]['field_value_r'];
	           	
	           		//print_r('<pre>');
		            //	print_r('--->>'.$vrcf['field_id']);
		            //print_r('</pre>');

	          } else {
	              $val_r = '';//значение в заявке
	              if(!empty($register_custom_field[$cfr['location']])){

	                foreach ($register_custom_field[$cfr['location']] as $vrcf) {

	                //	print_r('--->>'.$vrcf['field_id']);
	                  
	                  if($vrcf['field_id'] == $cfr['contest_field_id']){
	                    $val_r = (!empty($vrcf['value']))?$vrcf['value'] : '';
	                  }


	                }

	              }
	            
	          }
	            //$cfr['location'] - категория
	            //$val_r - занчения из заявки
	          /*  print_r('<pre>');
	            print_r($cfr['location'].' ---- '.$val_r.' ---- '.$result_request_information['status']);
	            print_r('</pre>');
	            print_r('<pre>');
	            print_r($result_request_information);
	            print_r('</pre>');
							print_r('<pre>');
	           // print_r($register_custom_field);
	            print_r('</pre>');*/
	            

						/******/
					}



					///print_r($contest_fields_value);

				}else{
					//если не системны и не перечитсялемый
					$contest_fields_value = '';//$data['register_custom_field'][$cfr['contest_field_id']]['field_value'];;
					$type = $cfr['type'];

					$val_r = '';//значение в заявке
						if(!empty($register_custom_field[$cfr['location']])){
						foreach ($register_custom_field[$cfr['location']] as $vrcf) {
							if($vrcf['field_id'] == $cfr['contest_field_id']){
								$val_r = $vrcf['value'];
							}
						}
					}


				}

/*
				$contest_fields_value = '';
				//дклаем проверку на системное или нет поле $cfr['field_system'] => custom - не системное
				if ( ($cfr['type'] == 'select' || $cfr['type'] == 'radio' || $cfr['type'] == 'checkbox') && $cfr['field_system'] == 'custom' )  {
					//если пречисляемый тип и не системны
					$contest_fields_value = $this->model_contest_contest_field->getContestFieldValues($cfr['contest_field_id']);
					$type = $cfr['type'];

				}elseif ($cfr['field_system'] != 'custom') {
					//если тип поля системный
					$contest_fields_value = $data['contest_field_system'][$cfr['field_system_table']][$cfr['field_system']]['field_value'];
					$type = $data['contest_field_system'][$cfr['field_system_table']][$cfr['field_system']]['field_type'];


					///print_r($contest_fields_value);

				}else{
					//если не системны и не перечитсялемый
					$contest_fields_value = '';
					$type = $cfr['type'];
				}*/

				$contest_fields[$cfr['location']][] = array(
					'contest_field_id'              => $cfr['contest_field_id'],

					'contest_field_title'           => $cfr['name'],
					'contest_field_description'     => $cfr['description'],

					'contest_field_value'           => $contest_fields_value,
					'contest_field_type'            => $type,

					'contest_field_system'          => $cfr['field_system'],
					'contest_field_system_table'    => $cfr['field_system_table'],

					'contest_field_status'      => $status,
					'sort_order'          => $sort_order,

					'value_r'                       =>  $val_r
				);



		}
/*
		print_r('<pre>');
		print_r($contest_fields_results);
		print_r('</pre>');

die();*/

		//фнализированный массив с подстановкой
		$data['contest_fields'] = array();
		foreach ($contest_fields as $key_cf => $value_cf) {
			foreach ($value_cf as $v_cf) {
				if( $v_cf['contest_field_status']!= 0 ){
					$data['contest_fields'][$key_cf][] = array(
						'contest_field_id'              => $v_cf['contest_field_id'],
						'contest_field_title'           => $v_cf['contest_field_title'],
						'contest_field_description'     => $v_cf['contest_field_description'],
						'contest_field_value'           => $v_cf['contest_field_value'],
						'contest_field_type'            => $v_cf['contest_field_type'],
						'contest_field_system'          => $v_cf['contest_field_system'],
						'contest_field_system_table'    => $v_cf['contest_field_system_table'],
						'contest_field_status'          => $v_cf['contest_field_status'],
						'sort_order'                    => $v_cf['sort_order'],
						'value_r'                       => $v_cf['value_r'],
					);
					usort($data['contest_fields'][$key_cf], 'sortBySortOrder');
				}
			}
		}



/*
		print_r('<pre>');
		print_r($data['contest_fields']);
		print_r('</pre>');
		die();
*/



		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_send.tpl')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/send.js');
		} else {
			$this->document->addScript('catalog/view/theme/default/assets/js/send.js');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');




		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_send.tpl')) {

			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/contest/contest_send.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/contest/contest_send.tpl', $data));
		}


	}
	protected function validate() {
		//подтянем все сушествующие поля и правила для них
		//подтянуть список всех полей заявки для каждой категории
		  $this->load->model('contest/contest_field');
		  $filter_data = array(
				'order' => 'ASC'
			);
			$contest_fields_results = $this->model_contest_contest_field->getContestFields($filter_data);
			/*
			 			[contest_field_id] => 6
            [type] => textarea
            [field_system] => custom
            [field_system_table] => custom
            [value] =>
            [location] => 14 // id группы в заявке
            [required] => 0
            [status] => 1
            [sort_order] => 0
            [language_id] => 2
            [name] => Дополнителное образование

      		*/


      //подтянем список каетгорий для заявки на  конкурса
			$filter_data = array(
				'order' => 'ASC'
			);
			$category_request_results = $this->model_localisation_category_request->getCategoryRequestes($filter_data);
			foreach ($category_request_results as $crr) {
				if(!empty($this->request->post['custom_fields'][$crr['category_request_id']])){
					foreach ($this->request->post['custom_fields'][$crr['category_request_id']] as $category_key => $vcf) {

						//проверяем на обязательность заполнения
						foreach ($contest_fields_results as $value_cfr) {
							if ($value_cfr['contest_field_id'] == $vcf['field_id']) {
								//

								//$this->error['custom_fields'][$vcf['field_id']] = $this->language->get('error_email');

							}
						}
					}
				}

	    	}




		/*






		foreach ($this->request->post['project_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
		//		$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['description']) < 3) {
		//		$this->error['description'][$language_id] = $this->language->get('error_description');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}

		}

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
