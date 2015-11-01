<?php
class ControllerCatalogOccasion extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/occasion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/occasion');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/occasion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/occasion');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_occasion->addOccasion($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/occasion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/occasion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/occasion');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_occasion->editOccasion($this->request->get['occasion_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/occasion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/occasion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/occasion');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $occasion_id) {
				$this->model_catalog_occasion->deleteOccasion($occasion_id);
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

			$this->response->redirect($this->url->link('catalog/occasion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('catalog/occasion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/occasion');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $occasion_id) {
				$this->model_catalog_occasion->copyOccasion($occasion_id);
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

			$this->response->redirect($this->url->link('catalog/occasion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}
	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'd.occasion_date';
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
			'href' => $this->url->link('catalog/occasion', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('catalog/occasion/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/occasion/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['copy'] = $this->url->link('catalog/occasion/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['occasions'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$occasion_total = $this->model_catalog_occasion->getTotalOccasions();

		$results = $this->model_catalog_occasion->getOccasions($filter_data);

		foreach ($results as $result) {
			$data['occasions'][] = array(
				'occasion_id' => $result['occasion_id'],
				'title'       => $result['title'],
				'occasion_date_day'		=> rus_date($this->language->get('occasion_date_day_format'), strtotime($result['occasion_date'])),
				'occasion_date'		=> rus_date($this->language->get('occasion_date_day_date_format'), strtotime($result['occasion_date'])),
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'        => $this->url->link('catalog/occasion/edit', 'token=' . $this->session->data['token'] . '&occasion_id=' . $result['occasion_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		
		$data['column_occasion_date'] = $this->language->get('column_occasion_date');
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

		$data['sort_title'] = $this->url->link('catalog/occasion', 'token=' . $this->session->data['token'] . '&sort=dd.title' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('catalog/occasion', 'token=' . $this->session->data['token'] . '&sort=d.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $occasion_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/occasion', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($occasion_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($occasion_total - $this->config->get('config_limit_admin'))) ? $occasion_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $occasion_total, ceil($occasion_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/occasion/occasion_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['occasion_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['text_image_manager'] = $this->language->get('text_image_manager');
 		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');	

		$data['text_archive'] = $this->language->get('text_archive');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_draft'] = $this->language->get('text_draft');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_occasion_date'] = $this->language->get('entry_occasion_date');
		$data['entry_occasion_time'] = $this->language->get('entry_occasion_time');
		$data['entry_occasion_season_id'] = $this->language->get('entry_occasion_season_id');
		$data['entry_occasion_group_id'] = $this->language->get('entry_occasion_group_id');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_visibility'] = $this->language->get('entry_visibility');
		$data['entry_place'] = $this->language->get('entry_place');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_best_price'] = $this->language->get('entry_best_price');
		$data['entry_image_title'] = $this->language->get('entry_image_title');
		$data['entry_video_title'] = $this->language->get('entry_video_title');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_link_video'] = $this->language->get('entry_link_video');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_video'] = $this->language->get('tab_video');
		$data['tab_occasion_record'] = $this->language->get('tab_occasion_record');

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

		if (isset($this->error['price'])) {
			$data['error_price'] = $this->error['price'];
		} else {
			$data['error_price'] = '';
		}

		if (isset($this->error['occasion_place_id'])) {
			$data['error_place_id'] = $this->error['occasion_place_id'];
		} else {
			$data['error_place_id'] = '';
		}
		//*************** occasion_image error ************************//
		if (isset($this->error['occasion_image'])) {
			$data['error_occasion_image'] = $this->error['occasion_image'];
		} else {
			$data['error_occasion_image'] = array();
		}
		//*************** occasion_image error ************************//

		//*************** occasion_video error ************************//
		if (isset($this->error['occasion_video'])) {
			$data['error_occasion_video'] = $this->error['occasion_video'];
		} else {
			$data['error_occasion_video'] = array();
		}
		//*************** occasion_video error ************************//

		if (isset($this->error['customer'])) {
			$data['error_customer'] = $this->error['customer'];
		} else {
			$data['error_customer'] = array();
		}

		if (isset($this->error['season'])) {
			$data['error_season'] = $this->error['season'];
		} else {
			$data['error_season'] = array();
		}

		if (isset($this->error['occasion_group'])) {
			$data['error_occasion_group'] = $this->error['occasion_group'];
		} else {
			$data['error_occasion_group'] = array();
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
			'href' => $this->url->link('catalog/occasion', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['occasion_id'])) {
			$data['action'] = $this->url->link('catalog/occasion/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/occasion/edit', 'token=' . $this->session->data['token'] . '&occasion_id=' . $this->request->get['occasion_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/occasion', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->get['occasion_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$occasion_info = $this->model_catalog_occasion->getOccasion($this->request->get['occasion_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['occasion_id'])) {
			$data['occasion_id'] = $this->request->get['occasion_id'];
		} else {
			$data['occasion_id'] = 0;
		}

		if (isset($this->request->post['occasion_description'])) {
			$data['occasion_description'] = $this->request->post['occasion_description'];
		} elseif (isset($this->request->get['occasion_id'])) {
			$data['occasion_description'] = $this->model_catalog_occasion->getOccasionDescriptions($this->request->get['occasion_id'],false);
		} else {
			$data['occasion_description'] = array();
		}


		if (isset($this->request->post['occasion_date'])) {
			$data['occasion_date'] = $this->request->post['occasion_date'];
		} elseif (!empty($occasion_info)) {
			$data['occasion_date'] =  date('Y-m-d', strtotime($occasion_info['occasion_date']));
		} else {
			$data['occasion_date'] = date('Y-m-d', time() - 86400);
		}

		
		
		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($occasion_info)) {
			$data['keyword'] = $occasion_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		$this->load->model('catalog/place');
		$place_results = $this->model_catalog_place->getPlaces();
		$data['place_results'] = array();
		foreach ($place_results as $place_result) {
			$data['place_results'][] = array(
				'place_id' => $place_result['place_id'],
				'place_title' => $place_result['title']
			);
		}
	
		if (isset($this->request->post['occasion_place_id'])) {
			$data['occasion_place_id'] = $this->request->post['occasion_place_id'];
		} elseif (!empty($occasion_info)) {
			$data['occasion_place_id'] = $occasion_info['occasion_place_id'];
		} else {
			$data['occasion_place_id'] = '';
		}

		$this->load->model('catalog/season');
		$data['occasion_seasons'] = array();
		$seasons = array();
		$seasons = $this->model_catalog_season->getSeasons();
		foreach ($seasons as $season) {
			$data['occasion_seasons'][] = array(
				'season_id' => $season['season_id'],
				'title' 	=> $season['title']
			);
		}
		if (isset($this->request->post['occasion_season_id'])) {
			$data['occasion_season_id'] = $this->request->post['occasion_season_id'];
		} elseif (!empty($occasion_info)) {
			$data['occasion_season_id'] = $occasion_info['occasion_season_id'];
		} else {
			$data['occasion_season_id'] = '';
		}

		$this->load->model('catalog/occasion_group');
		$data['occasion_groups'] = array();
		$occasion_groups = array();
		$occasion_groups = $this->model_catalog_occasion_group->getOccasionGroups();
		foreach ($occasion_groups as $occasion_group) {
			$data['occasion_groups'][] = array(
				'occasion_group_id' => $occasion_group['occasion_group_id'],
				'title' 			=> $occasion_group['title']
			);
		}

		
		if (isset($this->request->post['occasion_to_occasion_group'])) {
			$data['occasion_to_occasion_group'] = $this->request->post['occasion_to_occasion_group'];
		} elseif (isset($this->request->get['occasion_id'])) {
			$data['occasion_to_occasion_group'] = $this->model_catalog_occasion->getOccasionToOccasionGroup($this->request->get['occasion_id']);
		} else {
			$data['occasion_to_occasion_group'] = array(0);
		}

		$this->load->model('tool/image');

		//********************* list-view-occasion image **********************/	

		if (isset($this->request->post['occasion_image'])) {
			$occasion_images = $this->request->post['occasion_image'];
		} elseif (isset($this->request->get['occasion_id'])) {
			$occasion_images = $this->model_catalog_occasion->getOccasionImages($this->request->get['occasion_id']);
		} else {
			$occasion_images = array();
		}

		$data['occasion_images'] = array();

		foreach ($occasion_images as $occasion_image) {
			if (is_file(DIR_IMAGE . $occasion_image['image'])) {
				$image = $occasion_image['image'];
				$thumb = $occasion_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['occasion_images'][] = array(
				'occasion_image_description' => $occasion_image['occasion_image_description'],
				'link'                     => $occasion_image['link'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($thumb, 100, 100,'h'),
				'sort_order'               => $occasion_image['sort_order']
			);
		}


		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100,'h');
		//********************* /.list-view-occasion image **********************/	
		//********************* list-view-occasion video **********************/	

		if (isset($this->request->post['occasion_video'])) {
			$occasion_videos = $this->request->post['occasion_video'];
		} elseif (isset($this->request->get['occasion_id'])) {
			$occasion_videos = $this->model_catalog_occasion->getOccasionVideos($this->request->get['occasion_id']);
		} else {
			$occasion_videos = array();
		}

		$data['occasion_videos'] = array();

		foreach ($occasion_videos as $occasion_video) {
			
			if (is_file(DIR_IMAGE . $occasion_video['image'])) {
				$image = $occasion_video['image'];
				$thumb = $occasion_video['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['occasion_videos'][] = array(
				'occasion_video_description' => $occasion_video['occasion_video_description'],
				'link'                     => $occasion_video['link'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($thumb, 100, 100,'h'),
				'sort_order'               => $occasion_video['sort_order']
			);
		}


		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100,'h');
		//********************* /.list-view-occasion image **********************/	
		//********************* /.list-view-occasion player **********************/	


		$this->load->model('sale/customer');
		$data['customers'] = array();
		$customers = array();
		$customers = $this->model_sale_customer->getCustomers();
		foreach ($customers as $customer) {
			$data['customers'][] = array(
				'customer_id' => $customer['customer_id'],
				'name' 	  => $customer['lastname'].' '.$customer['firstname']
			);
		}

		if (isset($this->request->post['stats'])) {
			$stats = $this->request->post['stats'];
		} elseif (isset($this->request->get['occasion_id'])) {
			$stats = $this->model_sale_customer->getStats($this->request->get['occasion_id']);
		} else {
			$stats = array();
		}

		$data['stats'] = array();

		foreach ($stats as $stat) {
			$data['stats'][] = array(
				'customer_id' 			=> $stat['customer_id'],
				'occasion_group_id' 	=> $stat['occasion_group_id'],
				'season_id' 			=> $stat['season_id'],
				'goal' 					=> $stat['goal'],
				'pass' 					=> $stat['pass'],
				'mvp' 					=> $stat['mvp']
			);
		}

		//********************* /.list-view-occasion player **********************/


		
//дописать подтяжку со статусами
//******************************************************************/
		$data['ar_status'] = array();
		$data['ar_status'][] = array(
			'status_id' => 0,
			'title'		=> $this->language->get('text_archive')
		);
		$data['ar_status'][] = array(
			'status_id' => 1,
			'title'		=> $this->language->get('text_active')
		);
		$data['ar_status'][] = array(
			'status_id' => 2,
			'title'		=> $this->language->get('text_draft')
		);
		
//******************************************************************/
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($occasion_info)) {
			$data['status'] = $occasion_info['status'];
		} else {
			$data['status'] = 1;
		}

		if (isset($this->request->post['occasion_time'])) {
			$data['occasion_time'] = $this->request->post['occasion_time'];
		} elseif (!empty($occasion_info)) {
			$data['occasion_time'] =  $occasion_info['occasion_time'];
		} else {
			$data['occasion_time'] = '19:00 - 20:30';
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($occasion_info)) {
			$data['price'] = $occasion_info['price'];
		} else {
			$data['price'] = 500;
		}

		if (isset($this->request->post['best_price'])) {
			$data['best_price'] = $this->request->post['best_price'];
		} elseif (!empty($occasion_info)) {
			$data['best_price'] = $occasion_info['best_price'];
		} else {
			$data['best_price'] = 0;
		}

		if (isset($this->request->post['visibility'])) {
			$data['visibility'] = $this->request->post['visibility'];
		} elseif (!empty($occasion_info)) {
			$data['visibility'] = $occasion_info['visibility'];
		} else {
			$data['visibility'] = 1;
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/occasion/occasion_form.tpl', $data));
	}

	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/occasion')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['occasion_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}

		}
		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['occasion_id']) && $url_alias_info['query'] != 'occasion_id=' . $this->request->get['occasion_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['occasion_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}
		if ( $this->request->post['occasion_place_id'] == 0 ) {
			$this->error['occasion_place_id'] = sprintf($this->language->get('error_place_id'));
		}

		if ( (utf8_strlen($this->request->post['price']) < 1)) {
			$this->error['price'] = sprintf($this->language->get('error_price'));
		}

		if (isset($this->request->post['occasion_image'])) {
			foreach ($this->request->post['occasion_image'] as $occasion_image_id => $occasion_image) {
				foreach ($occasion_image['occasion_image_description'] as $language_id => $occasion_image_description) {
					if ((utf8_strlen($occasion_image_description['title']) < 2) || (utf8_strlen($occasion_image_description['title']) >255)) {
						$this->error['occasion_image'][$occasion_image_id][$language_id] = $this->language->get('error_image_title'); 
					}					
				}
			}	
		}

		if (isset($this->request->post['occasion_video'])) {
			foreach ($this->request->post['occasion_video'] as $occasion_video_id => $occasion_video) {
				foreach ($occasion_video['occasion_video_description'] as $language_id => $occasion_video_description) {
					if ((utf8_strlen($occasion_video_description['title']) < 2) || (utf8_strlen($occasion_video_description['title']) >255)) {
						$this->error['occasion_video'][$occasion_video_id][$language_id] = $this->language->get('error_image_title'); 
					}					
				}
			}	
		}

		if (isset($this->request->post['stats'])) {
			foreach ($this->request->post['stats'] as $stats_id => $stat) {
				if (!$stat['season_id']) {
					$this->error['season'][$stats_id] = $this->language->get('error_season');
				}
				if (!$stat['customer_id']) {
					$this->error['customer'][$stats_id] = $this->language->get('error_customer');
				}
				if (!$stat['occasion_group_id']) {
					$this->error['occasion_group'][$stats_id] = $this->language->get('error_occasion_group');
				}
				

			}	
		}
		
		return !$this->error;
	}
	protected function validateCopy(){
		if (!$this->user->hasPermission('modify', 'catalog/occasion')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		//±!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! проверочку бы добавить

		return !$this->error;
	}
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/occasion')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		//±!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! проверочку бы добавить

		return !$this->error;
	}

	
}