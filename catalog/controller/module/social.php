<?php
class ControllerModuleSocial extends Controller {
	public function index($setting) {
		$data['heading_title'] = '';
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/social.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/social.tpl', $data);
		} else {
			return $this->load->view('default/template/module/social.tpl', $data);
		}
	}
}