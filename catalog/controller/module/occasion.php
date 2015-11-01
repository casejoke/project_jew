<?php  
class ControllerModuleOccasion extends Controller {
	public function index() {
		$this->language->load('module/occasion');
		$this->load->model('catalog/occasion');
		$this->load->model('catalog/season');
		$this->load->model('catalog/occasion_group');
		$this->load->model('catalog/place');
		$this->load->model('tool/image');
		$this->load->model('catalog/metro');
		//получим активный сезон 
		$season_active = $this->model_catalog_season->getActiveSeason();
		$data['heading_title'] = sprintf($this->language->get('heading_title'), $season_active['title']);
		$data['button_play'] = $this->language->get('button_play');
		$data['text_metro'] = $this->language->get('text_metro');
		$data['text_place'] = $this->language->get('text_place');
		$data['text_best_price'] = $this->language->get('text_best_price');//вынести в конфиг
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
				'place_metro_id' => $place['metro_id'],
				'place_href'  => $this->url->link('information/place/view', 'place_id=' . $place['place_id'])
			);
		}
		//получаем список с occasion_to_occasion_group
		$occasions_to_occasion_groups = $this->model_catalog_occasion->getOccasionsToOccasionGroups();
		$data['occasion_to_group'] = array();
		foreach ($occasions_to_occasion_groups as $occasion_to_group) {
			$data['occasion_to_group'][] = array(
				'occasion_id' 		=> $occasion_to_group['occasion_id'],
				'occasion_group_id' => $occasion_to_group['occasion_group_id']
			);
		}
		//получим активные события (надо добавить зависимость от сезона мб?)
		//date_default_timezone_set('UTC');
		date_default_timezone_set( 'Europe/Moscow' );

		$current_date = date($this->language->get('datetime_sql_format'), strtotime("today", time() )); //date($this->language->get('datetime_sql_format'));
		$final_end = date($this->language->get('datetime_sql_format'), strtotime("+1 month", time() ));
		$filter_data = array(
			
			'filter_status'    => 1,
			'filter_begin_date' => $current_date,
			'filter_end_date' => $final_end ,
			'sort' => 'd.occasion_date',
			'order' => 'ASC'
		);	
		$occasions = $this->model_catalog_occasion->getOccasions($filter_data);
	 	$data['occasions'] = array();
		foreach ($occasions as $occasion) {
			foreach ($data['occasion_to_group'] as $occasion_to_group_val) {
				if( $occasion['occasion_id'] == $occasion_to_group_val['occasion_id']){
					$isset_best_price = ((int)$occasion['best_price'] > 0 )?true:false;
					$data['occasions'][] = array (
						'occasion_id' => $occasion['occasion_id'],
						'title' 		=> html_entity_decode($occasion['title'], ENT_QUOTES),
						'occasion_time' => $occasion['occasion_time'],
						'occasion_date_day'		=> rus_date($this->language->get('occasion_date_day_format'), strtotime($occasion['occasion_date'])),
						'occasion_date'		=> rus_date($this->language->get('occasion_date_day_date_format'), strtotime($occasion['occasion_date'])),
						'occasion_place_id' => $occasion['occasion_place_id'],
						'occasion_group_id' => $occasion_to_group_val['occasion_group_id'],
						'price'	=> sprintf($this->language->get('text_price_format'),$occasion['price']),
						'best_price'	=> sprintf($this->language->get('text_price_format'),$occasion['best_price']),
						'isset_best_price' => $isset_best_price,
						'href'  => $this->url->link('information/occasion/view', 'occasion_id=' . $occasion['occasion_id']),
					//	'image'			=> $image,
					//	'short_description' 	=> (strlen(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES))) > 50 ? substr(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES)), 0, 50) . '...' : strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES))),
					//	'view' 			=> $this->url->link('information/occasion/occasion', 'occasion_id=' . $result['occasion_id']),
					);
				}
			}
		}
		
		$data['href_list_occasions'] = $this->url->link('information/occasion');
		$data['text_list_occasions'] = $this->language->get('text_list_occasions');
	 
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/occasions/occasions.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/occasions/occasions.tpl', $data);
		} else {
			return $this->load->view('default/template/module/occasions/occasions.tpl', $data);
		}
	}
}