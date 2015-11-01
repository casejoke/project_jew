<?php 
class ControllerInformationOccasion extends Controller {
	private $error = array();

	public function index() {
		//список игр
		$this->language->load('information/occasion');
		$this->load->model('catalog/occasion');
		$this->load->model('catalog/season');
		$this->load->model('catalog/occasion_group');
		$this->load->model('catalog/place');
		$this->load->model('tool/image');
		$this->load->model('catalog/metro');
		//получим активный сезон 
		$season_active = $this->model_catalog_season->getActiveSeason();
		$data['heading_title'] = sprintf($this->language->get('heading_title_occasions'), $season_active['title']);
		$data['button_play'] = $this->language->get('button_play');
		$data['text_metro'] = $this->language->get('text_metro');
		$data['text_place'] = $this->language->get('text_place');
		$data['text_best_price'] = $this->language->get('text_best_price');//вынести в конфиг

		$this->document->setTitle($data['heading_title']);
		$main_image_path = 'catalog/timetable/main.jpg';
		
		if (is_file(DIR_IMAGE . $main_image_path)) {
		//if ( is_file(DIR_IMAGE . 'catalog/'. $main_image_path) ) {
			$data['main_image']= $this->model_tool_image->resize($main_image_path, 1920,1280,'h');
		
		}else {
			$data['main_image'] = $this->model_tool_image->resize('placeholder.png', 1920,1280,'h');
		}

	 	//получаем активные форматы
		$occasion_group_active = $this->model_catalog_occasion_group->getActiveOccasionGroup();
		$data['occasion_groups'] = array();
		foreach ($occasion_group_active as $occasion_group) {
			$data['occasion_groups'][] = array(
				'occasion_group_id' => $occasion_group['occasion_group_id'],
				'occasion_title' => $occasion_group['title']
			);
		}
		//получим списко метро
		$city_id = 1; //москва
		$metro_results = $this->model_catalog_metro->getList($city_id);
		$data['metro_results'] = array();
		foreach ($metro_results as $metro_result) {
			$data['metro_results'][$metro_result['id']] = array(
				'metro_id' => $metro_result['id'],
				'metro_title' => $metro_result['name']
			);
		}
		//получим активные места проведения
		$filter_data = array(
			//'filter_status'    => 1
		);
		$occasion_places = $this->model_catalog_place->getPlaces($filter_data);
		$data['places'] = array();
		foreach ($occasion_places as $place) {
			$data['places'][$place['place_id']] = array(
				'place_id' => $place['place_id'],
				'place_title' => $place['title'],
				'place_metro_id' => $place['metro_id']
			);
		}
		//получаем список с occasion_to_occasion_group
		$occasions_to_occasion_groups = $this->model_catalog_occasion->getOccasionsToOccasionGroups();
		$occasion_to_group = array();
		foreach ($occasions_to_occasion_groups as $og) {
			$occasion_to_group[] = array(
				'occasion_id' 		=> $og['occasion_id'],
				'occasion_group_id' => $og['occasion_group_id']
			);
		}
		//получим активные события (надо добавить зависимость от сезона мб?)
		date_default_timezone_set('UTC');
		$current_date = date($this->language->get('datetime_sql_format'), strtotime("-1 day", time() )); //date($this->language->get('datetime_sql_format'));
		$final_end = date($this->language->get('datetime_sql_format'), strtotime("+1 month", time() ));
		$filter_data = array(
			'season'	=> $season_active,
			'filter_status'    => 1,
			'filter_begin_date' => $current_date,
			'filter_end_date' => $final_end ,
			'sort' => 'd.occasion_date',
			'order' => 'ASC'
		);
	 	$occasions = $this->model_catalog_occasion->getOccasions($filter_data);
	 	$data['occasions'] = array();
		foreach ($occasions as $occasion) {
			foreach ($occasion_to_group as $occasion_to_group_val) {
				if( $occasion['occasion_id'] == $occasion_to_group_val['occasion_id']){
					
					$isset_best_price = ((int)$occasion['best_price'] > 0 )?true:false;
					$data['occasions'][$occasion_to_group_val['occasion_group_id']][] = array (
						'occasion_id' => $occasion['occasion_id'],
						'title' 		=> html_entity_decode($occasion['title'], ENT_QUOTES),
						'occasion_time' => $occasion['occasion_time'],
						'occasion_date_day'		=> rus_date($this->language->get('occasion_date_day_format'), strtotime($occasion['occasion_date'])),
						'occasion_date'		=> rus_date($this->language->get('occasion_date_day_date_format'), strtotime($occasion['occasion_date'])),
						'occasion_place_id' => $occasion['occasion_place_id'],
						'occasion_place_href' => $this->url->link('information/place/view', 'place_id=' . $occasion['occasion_place_id']),
						'occasion_group_id' => $occasion_to_group_val['occasion_group_id'],
						'price'	=> sprintf($this->language->get('text_price_format'),$occasion['price']),
						'best_price'	=> sprintf($this->language->get('text_price_format'),$occasion['best_price']),
						'isset_best_price' => $isset_best_price,
						'href'  => $this->url->link('information/occasion/view', 'occasion_id=' . $occasion['occasion_id'])
					//	'image'			=> $image,
					//	'short_description' 	=> (strlen(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES))) > 50 ? substr(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES)), 0, 50) . '...' : strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES))),
					//	'view' 			=> $this->url->link('information/occasion/occasion', 'occasion_id=' . $result['occasion_id']),
					);
				}
			}
		}
		
		$data['href_list_occasions'] = $this->url->link('information/occasion');
		$data['text_list_occasions'] = $this->language->get('text_list_occasions');
	 	

	 	$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');




		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/occasions_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/occasions_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/occasions_list.tpl', $data));
		}

	}
	public function reports(){
		//список отчетов
		$this->language->load('information/occasion');
		$this->load->model('catalog/occasion');
		$this->load->model('catalog/season');
		$this->load->model('catalog/occasion_group');
		$this->load->model('catalog/place');
		$this->load->model('tool/image');
		$this->load->model('catalog/metro');
		//получим активный сезон 
		$season_active = $this->model_catalog_season->getActiveSeason();
		$data['heading_title'] = $this->language->get('heading_title_reports');
		$data['button_watch'] = $this->language->get('button_watch');
		$data['text_metro'] = $this->language->get('text_metro');
		$data['text_place'] = $this->language->get('text_place');
		$data['text_best_price'] = $this->language->get('text_best_price');//вынести в конфиг
		$this->document->setTitle($data['heading_title']);
		$main_image_path = 'catalog/default/login.jpg';
		
		if (is_file(DIR_IMAGE . $main_image_path)) {
			$data['main_image']= $this->model_tool_image->resize($main_image_path, 1920,1280,'h');
		
		}else {
			$data['main_image'] = $this->model_tool_image->resize('placeholder.png', 1920,1280,'h');
		}

	 	//получаем активные форматы
		$occasion_group_active = $this->model_catalog_occasion_group->getActiveOccasionGroup();
		$data['occasion_groups'] = array();
		foreach ($occasion_group_active as $occasion_group) {
			$data['occasion_groups'][$occasion_group['occasion_group_id']] = array(
				'occasion_group_id' => $occasion_group['occasion_group_id'],
				'occasion_title' => $occasion_group['title']
			);
		}

		//получим списко метро
		$city_id = 1; //москва
		$metro_results = $this->model_catalog_metro->getList($city_id);
		$data['metro_results'] = array();
		foreach ($metro_results as $metro_result) {
			$data['metro_results'][$metro_result['id']] = array(
				'metro_id' => $metro_result['id'],
				'metro_title' => $metro_result['name']
			);
		}
		//получим активные места проведения
		$filter_data = array(
			//'filter_status'    => 1
		);
		$occasion_places = $this->model_catalog_place->getPlaces($filter_data);
		$data['places'] = array();
		foreach ($occasion_places as $place) {
			$data['places'][$place['place_id']] = array(
				'place_id' => $place['place_id'],
				'place_title' => $place['title'],
				'place_metro_id' => $place['metro_id']
			);
		}
		//получаем список с occasion_to_occasion_group
		$occasions_to_occasion_groups = $this->model_catalog_occasion->getOccasionsToOccasionGroups();
		$occasion_to_group = array();
		foreach ($occasions_to_occasion_groups as $og) {
			$occasion_to_group[] = array(
				'occasion_id' 		=> $og['occasion_id'],
				'occasion_group_id' => $og['occasion_group_id']
			);
		}

		//получим активные события (надо добавить зависимость от сезона мб?)
		date_default_timezone_set('UTC');
		$current_date = date($this->language->get('datetime_sql_format'), strtotime("-1 day", time() )); //date($this->language->get('datetime_sql_format'));
		$final_end = date($this->language->get('datetime_sql_format'), strtotime("+1 month", time() ));
		$filter_data = array(
			'season'	=> $season_active,
			'filter_status'    => 0,
			'sort' => 'd.occasion_date',
			'order' => 'DESC'
		);	

		$occasions = $this->model_catalog_occasion->getOccasions($filter_data);
	 	$data['occasions'] = array();
		foreach ($occasions as $occasion) {
			foreach ($occasion_to_group as $occasion_to_group_val) {
				if( $occasion['occasion_id'] == $occasion_to_group_val['occasion_id']){
					
					$isset_best_price = ((int)$occasion['best_price'] > 0 )?true:false;
					$data['occasions'][$occasion_to_group_val['occasion_group_id']][] = array (
						'occasion_id' => $occasion['occasion_id'],
						'title' 		=> html_entity_decode($occasion['title'], ENT_QUOTES),
						'occasion_time' => $occasion['occasion_time'],
						'occasion_date_day'		=> rus_date($this->language->get('occasion_date_day_format'), strtotime($occasion['occasion_date'])),
						'occasion_date'		=> rus_date($this->language->get('occasion_date_day_date_format'), strtotime($occasion['occasion_date'])),
						'occasion_place_id' => $occasion['occasion_place_id'],
						'occasion_place_href' => $this->url->link('information/place/view', 'place_id=' . $occasion['occasion_place_id']),
						'occasion_group_id' => $occasion_to_group_val['occasion_group_id'],
						'price'	=> sprintf($this->language->get('text_price_format'),$occasion['price']),
						'best_price'	=> sprintf($this->language->get('text_price_format'),$occasion['best_price']),
						'isset_best_price' => $isset_best_price,
						'href'  => $this->url->link('information/occasion/view', 'occasion_id=' . $occasion['occasion_id'])
					//	'image'			=> $image,
					//	'short_description' 	=> (strlen(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES))) > 50 ? substr(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES)), 0, 50) . '...' : strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES))),
					//	'view' 			=> $this->url->link('information/occasion/occasion', 'occasion_id=' . $result['occasion_id']),
					);
				}
			}
		}

		$data['href_list_occasions'] = $this->url->link('information/occasion');
		$data['text_list_occasions'] = $this->language->get('text_list_occasions');
	 	

	 	$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');




		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/occasions_report_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/occasions_report_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/occasions_report_list.tpl', $data));
		}
	}


	public function view(){
		if (isset($this->request->get['occasion_id'])) {
			$occasion_id = (int)$this->request->get['occasion_id'];
		} else {
			$this->response->redirect($this->url->link('common/home', '', 'SSL'));
		}
		$this->load->language('information/occasion');
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', '', 'SSL')
		);
		
		$data['button_play'] = $this->language->get('button_play');
		$data['text_metro'] = $this->language->get('text_metro');
		$data['text_place'] = $this->language->get('text_place');
		$data['text_best_price'] = $this->language->get('text_best_price');//вынести в конфиг

		
		$this->load->model('localisation/language');
		$this->load->model('catalog/occasion');
		$this->load->model('catalog/occasion_group');
		$this->load->model('catalog/season');
		$this->load->model('catalog/place');
		$this->load->model('tool/image');
		$this->load->model('catalog/metro');

		$language_results = $this->model_localisation_language->getLanguages();
		$language_code = $this->language->get('code');
		foreach ($language_results as $result) {
			if ($result['code'] == $language_code) {
				$language_id = $result['language_id'];
			}
		}
		//подтянем информацию о событии
		$occasion_info = $this->model_catalog_occasion->getOccasion($occasion_id);
		//Подтянем статус
		$occasion_status = $occasion_info['status'];
		

		$occasion_season_id = $occasion_info['occasion_season_id'];
		//сезон
		$data['occasion_season'] = $this->model_catalog_season->getSeason($occasion_season_id);
		//формат
		$data['occasion_groups'] = array();
		$occasion_groups = array();
		$occasion_groups = $this->model_catalog_occasion_group->getOccasionGroups();
		foreach ($occasion_groups as $occasion_group) {
			$data['occasion_groups'][$occasion_group['occasion_group_id']] = array(
				'occasion_group_id' => $occasion_group['occasion_group_id'],
				'title' 			=> $occasion_group['title']
			);
		}
		
		 $current_occasion_groups = $this->model_catalog_occasion->getOccasionToOccasionGroup($occasion_id);
		 $data['current_occasion_group'] = '';
		 
		 foreach ($current_occasion_groups as $group) {
		 	
		$data['current_occasion_group'] = $data['occasion_groups'][$group]['title'];
			break;
		 }


		//подтянем информацию о месте
		$occasion_place_id  = $occasion_info['occasion_place_id'];
		$data['occasion_place'] = $this->model_catalog_place->getPlace($occasion_place_id);
		$data['occasion_place']['href'] = $this->url->link('information/occasion/view', 'occasion_id=' . $occasion_id,'SSL');
		$data['occasion_place_description']=html_entity_decode($data['occasion_place']['description'], ENT_QUOTES);
		$data['occasion_place_address'] =html_entity_decode($data['occasion_place']['address'], ENT_QUOTES);
		

		//получим изображения стадиона
		$occasion_place_images = $this->model_catalog_place->getPlaceImages($occasion_place_id);
		$data['occasion_place']['images'] = array();
		foreach ($occasion_place_images as $occasion_place_image) {
			$data['occasion_place']['images'][] = array(
				'title' => $occasion_place_image['place_image_description'][$language_id]['title'],
				'image_full' => $this->model_tool_image->resize($occasion_place_image['image'], 1920,1280,'w'),
				'image' => $this->model_tool_image->resize($occasion_place_image['image'], 950,450,'w')
			);
		}
		//получим метро
		$metro = $this->model_catalog_metro->getMetroDescription($data['occasion_place']['metro_id']);
		$data['occasion_place']['metro_title'] = $metro['name'];
		$data['occasion'] = $occasion_info;
		
		//получим изображения события
		$occasion_images = $this->model_catalog_occasion->getOccasionImages($occasion_id);
		foreach ($occasion_images as $occasion_image) {
			$data['occasion']['images'][] = array(
				'title' => $occasion_image['occasion_image_description'][$language_id]['title'],
				'image_full' => $this->model_tool_image->resize($occasion_image['image'], 1920,1280,'w'),
				'image' => $this->model_tool_image->resize($occasion_image['image'], 950,450,'w')
			);
		}
		//получим видео для события
		$occasion_videos = $this->model_catalog_occasion->getOccasionVideos($occasion_id);
		foreach ($occasion_videos as $occasion_video) {
			$data['occasion']['videos'][] = array(
				'title' => $occasion_video['occasion_video_description'][$language_id]['title'],
				'link'  => $occasion_video['link']
			);
		}

		//основное изображение 
		if (!empty($data['occasion']['images'][0])) {
			$data['hero_image'] = $data['occasion']['images'][0]['image_full'];
		}else{
			$data['hero_image'] = $this->model_tool_image->resize('placeholder.png', 1920,1280,'h');
		}
		$date_occasion = rus_date($this->language->get('occasion_date_day_date_format'), strtotime($occasion_info['occasion_date']));
		$date_occasion_day = rus_date($this->language->get('occasion_date_day_format'), strtotime($occasion_info['occasion_date']));



		if($occasion_status != 1) {
			$template_name = '/template/information/report_occasion.tpl';
			//seo 
			$this->document->setTitle('Отчет - '.$occasion_info['meta_title']);
			$this->document->setDescription($occasion_info['meta_description']);
			$this->document->setKeywords($occasion_info['meta_keyword']);
			$data['heading_title'] = 'Отчет - '.sprintf($this->language->get('heading_title'),$occasion_info['title'],$date_occasion,$date_occasion_day) ;
			$data['text_description_heading'] = $this->language->get('text_description_heading');
		}else{
			$template_name = '/template/information/occasion.tpl';
			//seo 
			$this->document->setTitle($occasion_info['meta_title']);
			$this->document->setDescription($occasion_info['meta_description']);
			$this->document->setKeywords($occasion_info['meta_keyword']);
			$data['heading_title'] = sprintf($this->language->get('heading_title'),$occasion_info['title'],$date_occasion,$date_occasion_day) ;
			$data['text_description_heading'] = $this->language->get('text_description_heading');
		}
		


		
		$data['text_game_heading'] = sprintf($this->language->get('text_game_heading'), $occasion_info['title'],$data['occasion_place']['title']);
		$data['text_photo_place'] = $this->language->get('text_photo_place');
		$data['text_description_place'] = $this->language->get('text_description_place');
		$data['text_address_place'] = $this->language->get('text_address_place');
		$data['text_season'] = $this->language->get('text_season');
		
		$data['text_date'] = sprintf($this->language->get('text_date'),$date_occasion);
		$data['text_metro'] = $this->language->get('text_metro');
		$data['text_format_group'] = $this->language->get('text_format_group');
		$price = ((int)$occasion_info['best_price']>0)?$occasion_info['best_price']:$occasion_info['price'];
		$data['text_price'] = sprintf($this->language->get('text_price'),$price);
		$data['description'] = html_entity_decode($occasion_info['description'], ENT_QUOTES);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template_name)) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . $template_name, $data));
		} else {
			$this->response->setOutput($this->load->view('default'.$template_name, $data));
		}

	}
	public function ajaxsendrecord(){
		$json = array();
		$this->language->load('information/occasion');
		$this->load->model('catalog/occasion');
		$this->load->model('account/customer');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			//делаем проверку есть ли такой пользователь
			$data_customer = array();
			if (!$this->customer->isLogged()) {
				$customer_id = 0;
				if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
					$customer = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
					$customer_id = $customer['customer_id'];
				}else{
					$customer_id = $this->model_account_customer->addCustomer($this->request->post);
				}
				$data_customer = $this->request->post;
			}else{
				$customer_id = $this->customer->getId();

				$data_customer = $this->model_account_customer->getCustomer($customer_id);
				$data_customer['occasion_id'] = $this->request->post['occasion_id'];

			}
			
			
			$add_record = $this->model_catalog_occasion->addPlayerToOccasion($data_customer,$customer_id);
			//$this->session->data['success'] = $this->language->get('text_success');
			if ($add_record ) {
				$json['success'] = 1;
			}else{
				$this->error['warning'] = $this->language->get('error_warning');
				$json['error'] = $this->error;
			}
            
		}else {
			$json['error'] = $this->error;
        }
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	protected function validate() {
		if(!$this->customer->isLogged()){
			if ((utf8_strlen($this->request->post['firstname']) < 3) || (utf8_strlen($this->request->post['firstname']) > 100)) {
				$this->error['firstname'] = $this->language->get('error_customer_name');
			}
			if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 100)) {
				$this->error['telephone'] = $this->language->get('error_customer_phone');
			}
			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
				$this->error['email'] = $this->language->get('error_customer_email');
			}
		}
		if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	} 
	}
}