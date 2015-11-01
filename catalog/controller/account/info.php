<?php
class ControllerAccountInfo extends Controller {
	//отдает инфу о пользователе для просмотра другим пользователем
	public function index() {
		
		die();
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/info/account_info.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/account/info/account_info.tpl', $data);
		} else {
			return $this->load->view('default/template/account/info/account_info.tpl', $data);
		}
	}
}