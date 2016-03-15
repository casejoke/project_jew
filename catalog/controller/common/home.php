<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}


		//конкурсы
		$this->load->model('contest/contest');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');

		//подтянем все активные конкурсы
		$filter_data = array(
			'page' => 1,
			'limit' => 3,
			'start' => 0,
			'filter_status'	=> array('1')
		);
		$results_contests = $this->model_contest_contest->getContests($filter_data);
		$data['contests'] = array();
		foreach ($results_contests as $rc) {
			if (!empty($rc['image'])) {
				$image= $this->model_tool_image->resize($rc['image'], 300, 300,'h');
			}else{
				$image = $this->model_tool_image->resize('placeholder.png', 300, 300,'h');
			}

			$actions = array(
				'view'		=> $this->url->link('contest/view', 'contest_id='.$rc['contest_id'], 'SSL')
			);
			$data['contests'][] = array(
				'contest_id'				=> $rc['contest_id'],
				'contest_status'		=> $rc['status'],
				'contest_title'			=> (strlen(strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8'))) > 50 ? mb_strcut(strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8')), 0, 55) . '...' : strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8'))),
				'contest_image'			=> $image,
				'action'				=> $actions
			);
		}

		//конкурсы архивные
		$this->load->model('contest/contest');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');

		//подтянем все активные конкурсы
		$filter_data = array(
			'page' => 1,
			'limit' => 3,
			'start' => 0,
			'filter_status'	=> array('2')
		);
		$results_contests = $this->model_contest_contest->getContests($filter_data);
		$data['contests_archive'] = array();
		foreach ($results_contests as $rc) {
			if (!empty($rc['image'])) {
				$image= $this->model_tool_image->resize($rc['image'], 300, 300,'h');
			}else{
				$image = $this->model_tool_image->resize('placeholder.png', 300, 300,'h');
			}

			$actions = array(
				'view'		=> $this->url->link('contest/view', 'contest_id='.$rc['contest_id'], 'SSL')
			);
			$data['contests_archive'][] = array(
				'contest_id'				=> $rc['contest_id'],
				'contest_status'		=> $rc['status'],
				'contest_title'			=> (strlen(strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8'))) > 50 ? mb_strcut(strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8')), 0, 55) . '...' : strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8'))),
				'contest_image'			=> $image,
				'action'				=> $actions
			);
		}


		//последние новости проекта
		$this->load->model('catalog/news');
		
		$filter_data = array(
			'page' => 1,
			'limit' => 3,
			'start' => 0,
		);
	 
		$data['heading_title'] = $this->language->get('heading_title');
	 
		$results = $this->model_catalog_news->getAllNews($filter_data);
	 
		$data['all_news'] = array();

	 	$this->load->model('tool/image');
	 	$this->load->model('tool/upload');

		foreach ($results as $result) {
			if ($result['image']) {
			//	$image = $this->model_tool_image->resize($news['image'], 830, 400, 'w');
				$upload_info = $this->model_tool_upload->getUploadByCode($result['image']);
				$filename = $upload_info['filename'];
				$image = $this->model_tool_upload->resize($filename , 800, 460,'h');
			} else {
				$image = $this->model_tool_image->resize('placeholder.png',800, 460, 'w');
			}
			$data['all_news'][] = array (
				'title' 		=> html_entity_decode($result['title'], ENT_QUOTES),
				'image'			=> $image,
				'short_description' 	=> (strlen(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES))) > 100 ? substr(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES)), 0, 150) . '...' : strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES))),
				'view' 			=> $this->url->link('information/news/news', 'news_id=' . $result['news_id']),
				'date_added' 	=> date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}
	 



	 	
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}