<?php  
class ControllerModuleRecordtooccasion extends Controller {
	public function index() {
		$this->load->language('module/occasiontorecord');

		$data['heading_title'] =  $this->language->get('heading_title');
		$data['text_registration_success'] = sprintf($this->language->get('text_registration_success'), $this->url->link('account/account', '', 'SSL'));

		$data['text_registration_logged_success'] = $this->language->get('text_registration_logged_success');
		$data['text_btn_play'] =  $this->language->get('text_btn_play');
		if($this->request->get['occasion_id']){
			$data['occasion_id'] = $this->request->get['occasion_id'];
		}else{
			$data['occasion_id'] = 0;
		}
	 	if (!$this->customer->isLogged()) {
			$template_name = '/template/module/occasion_group/occasion_record.tpl';
		}else{
			$template_name = '/template/module/occasion_group/occasion_record_logged.tpl';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template_name )) {
			return $this->load->view($this->config->get('config_template') . $template_name, $data);
		} else {
			return $this->load->view('default/' . $template_name , $data);
		}
	}
}