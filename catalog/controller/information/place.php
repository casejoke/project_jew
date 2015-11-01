<?php 
class ControllerInformationPlace extends Controller {
	public function index() {
		$this->language->load('information/place');
		$this->load->model('catalog/place');
		$this->load->model('tool/image');
		$data['heading_title'] = $this->language->get('heading_title_places');
		//seo
		$this->document->setTitle($data['heading_title']);
		$data['text_view'] = $this->language->get('text_view');
		//получим активные места проведения
		$filter_data = array(
			'filter_status'    => 1
		);
		$main_image_path = 'catalog/places/main.jpg';
		
		if (is_file(DIR_IMAGE . $main_image_path)) {
		//if ( is_file(DIR_IMAGE . 'catalog/'. $main_image_path) ) {
			$data['main_image']= $this->model_tool_image->resize($main_image_path, 1920,1280,'w');
		
		}else {
			$data['main_image'] = $this->model_tool_image->resize('placeholder.png', 1920,1280,'w');
		}


		$places = $this->model_catalog_place->getPlaces($filter_data);
		$data['places'] = array();
		foreach ($places as $place) {
			if (!empty($place['image'])) {
				$image= $this->model_tool_image->resize($place['image'], 500,200,'w');
			}else{
				$image = $this->model_tool_image->resize('placeholder.png', 500,200,'w');
			}
			$data['places'][] = array(
				'place_id' => $place['place_id'],
				'place_title' => $place['title'],
				'place_metro_id' => $place['metro_id'],
				'image' => $image,
				'place_href'  => $this->url->link('information/place/view', 'place_id=' . $place['place_id'])
			);
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/places_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/places_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/places_list.tpl', $data));
		}

	}
	public function view(){
		if (isset($this->request->get['place_id'])) {
			$place_id = (int)$this->request->get['place_id'];
		} else {
			$this->response->redirect($this->url->link('common/home', '', 'SSL'));
		}
		$this->load->language('information/place');
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
		//подтянем информацию о месте
		$place_info = $this->model_catalog_place->getPlace($place_id);
		//seo 
		$this->document->setTitle($place_info['meta_title']);
		$this->document->setDescription($place_info['meta_description']);
		$this->document->setKeywords($place_info['meta_keyword']);

		$data['heading_title'] = $place_info['title'];
		$data['description'] = html_entity_decode($place_info['description'], ENT_QUOTES);
		$data['place_address'] =html_entity_decode($place_info['address'], ENT_QUOTES);
		$data['latitude_longitude'] = $place_info['latitude_longitude'];
		//получим изображения стадиона
		$place_images = $this->model_catalog_place->getPlaceImages($place_id);
		$data['images'] = array();
		foreach ($place_images as $place_image) {
			$data['images'][] = array(
				'title' => $place_image['place_image_description'][$language_id]['title'],
				'image_full' => $this->model_tool_image->resize($place_image['image'], 1920,1280,'w'),
				'image' => $this->model_tool_image->resize($place_image['image'], 950,450,'w')
			);
		}
		//получим метро
		$metro = $this->model_catalog_metro->getMetroDescription($place_info['metro_id']);
		
		//основное изображение 
		if (!empty($data['images'][0])) {
			$data['hero_image'] = $data['images'][0]['image_full'];
		}else{
			$data['hero_image'] = $this->model_tool_image->resize('placeholder.png', 1920,1280,'w');
		}
		$data['heading_title'] = sprintf($this->language->get('heading_title'), $place_info['title'], $metro['name']); 
		$data['text_description_heading'] = $this->language->get('text_description_heading');
		$data['text_photo_place'] = $this->language->get('text_photo_place');
		$data['text_description_place'] = $this->language->get('text_description_place');
		$data['text_address_place'] = $this->language->get('text_address_place');
		$data['text_metro'] = $this->language->get('text_metro');


		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/place.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/place.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/place.tpl', $data));
		}

	}
}