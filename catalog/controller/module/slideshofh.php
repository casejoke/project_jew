<?php
class ControllerModuleSlideshowfh extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');
		$this->document->addScript('catalog/view/javascript/vendor/superslides/jquery.superslides.min.js');
		$this->document->addStyle('catalog/view/javascript/vendor/superslides/css/jquery.superslides.css');
		
		$data['banners'] = array();
		$results = $this->model_design_banner->getBanner($setting['banner_id']);
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/slideshowfh.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/slideshowfh.tpl', $data);
		} else {
			return $this->load->view('default/template/module/slideshowfh.tpl', $data);
		}
	}
}