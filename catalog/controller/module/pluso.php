<?php
class ControllerModulePluso extends Controller {
	public function index($setting) {
		$data['heading_title'] = '';
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/pluso.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/pluso.tpl', $data);
		} else {
			return $this->load->view('default/template/module/pluso.tpl', $data);
		}
	}
}