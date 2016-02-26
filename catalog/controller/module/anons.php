<?php  
class ControllerModuleAnons extends Controller {
	public function index() {
		$this->language->load('module/anons');
		$this->load->model('catalog/news');
		
		$filter_data = array(
			'page' => 1,
			'limit' => 5,
			'start' => 0,
		);
	 
		$data['heading_title'] = $this->language->get('heading_title');
	 
		$results = $this->model_catalog_news->getListAnons($filter_data);
	 
		$data['all_news'] = array();
	 	$this->load->model('tool/image');
	 	$this->load->model('tool/upload');

		foreach ($results as $result) {
			if ($result['image']) {
			//	$image = $this->model_tool_image->resize($news['image'], 830, 400, 'w');
				$upload_info = $this->model_tool_upload->getUploadByCode($result['image']);
				$filename = $upload_info['filename'];
				$image = $this->model_tool_upload->resize($filename , 128, 128,'h');
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', 128, 128, 'h');
			}
			$data['all_news'][] = array (
				'title' 		=> html_entity_decode($result['title'], ENT_QUOTES),
				'image'			=> $image,
				'short_description' 	=> (strlen(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES))) > 50 ? substr(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES)), 0, 50) . '...' : strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES))),
				'view' 			=> $this->url->link('information/news/news', 'news_id=' . $result['news_id']),
				'date_added' 	=> date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}
	 
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/anons.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/anons.tpl', $data);
		} else {
			return $this->load->view('default/template/module/anons.tpl', $data);
		}
	}
}