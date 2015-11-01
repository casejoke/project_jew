<?php
class ControllerCommonStats extends Controller {
	public function index() {
		$this->load->language('common/stats');

		$data['text_complete_status'] = $this->language->get('text_complete_status');
		$data['text_processing_status'] = $this->language->get('text_processing_status');
		$data['text_other_status'] = $this->language->get('text_other_status');
		
		return $this->load->view('common/stats.tpl', $data);
	}
}