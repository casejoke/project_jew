<?php
/**
 * Просмотр проекта
 */
class ControllerContestView extends Controller {
	public function index(){
		if ( !isset($this->request->get['contest_id']) ) {
			$this->session->data['redirect'] = $this->url->link('contest/contest', '', 'SSL');
			$this->response->redirect($this->url->link('contest/contest', '', 'SSL'));
			
		}
		
		$this->getView();
	}
	
	private function getView(){

		//************** проверки ***************//

		//если конкурс в статусе работа - редирект





		//подгрузим язык
		$this->load->language('contest/view');
		//выводим инфу о текщей проекте
		$contest_id = $this->request->get['contest_id'];
		//для шифрования
		$data['contest_id'] = $contest_id;

		//подгрузим модели
		$this->load->model('account/customer');
		$this->load->model('contest/contest');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		$contest_info = array();
		if (isset($this->request->get['contest_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$contest_info = $this->model_contest_contest->getContest($this->request->get['contest_id']);
		}
		//проверим сушествоание группы 
		if ( empty($contest_info) ){
			//редиректим на список 
			$this->session->data['redirect'] = $this->url->link('contest/contest', '', 'SSL');
			$this->response->redirect($this->url->link('contest/contest', '', 'SSL'));
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_contests'),
			'href' => $this->url->link('contest/contest', '', 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $contest_info['title'],
			'href' => $this->url->link('contest/view', 'contest_id=' . $data['contest_id'], 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		$this->document->setTitle($contest_info['title']);
		$this->document->setDescription(substr(strip_tags(html_entity_decode($contest_info['meta_description'], ENT_QUOTES)), 0, 150) . '...');
		//$this->document->setKeywords($contest_info['meta_keyword']);


		$data['entry_title'] 				= $this->language->get('entry_title');
		$data['entry_description'] 			= $this->language->get('entry_description');
		$data['entry_image'] 				= $this->language->get('entry_image');
		$data['entry_contest_birthday'] 	= $this->language->get('entry_contest_birthday');
		$data['entry_contest_email'] 		= $this->language->get('entry_contest_email'); 
		
		$data['entry_contest_dates'] 		= $this->language->get('entry_contest_dates'); 
		$data['entry_contest_date_start'] 		= $this->language->get('entry_contest_date_start'); 
		$data['entry_contest_datetime_end'] 	= $this->language->get('entry_contest_datetime_end'); 
		$data['entry_contest_date_rate'] 		= $this->language->get('entry_contest_date_rate'); 
		$data['entry_contest_date_result'] 		= $this->language->get('entry_contest_date_result'); 
		$data['entry_contest_date_finalist'] 	= $this->language->get('entry_contest_date_finalist'); 

		$data['entry_contest_organizer'] 	= $this->language->get('entry_contest_organizer'); 
		$data['entry_contest_budget'] 		= $this->language->get('entry_contest_budget');
		$data['entry_contest_propose'] 		= $this->language->get('entry_contest_propose'); 
		$data['entry_contest_location'] 	= $this->language->get('entry_contest_location'); 
		$data['entry_contest_members'] 		= $this->language->get('entry_contest_members'); 
		$data['entry_contest_contacts'] 	= $this->language->get('entry_contest_contacts'); 
		$data['entry_contest_timeline_text']= $this->language->get('entry_contest_timeline_text'); 
		$data['entry_contest_budget']		= $this->language->get('entry_contest_budget'); 
		$data['entry_contest_maxprice']		= $this->language->get('entry_contest_maxprice'); 
		$data['entry_contest_totalprice']	= $this->language->get('entry_contest_totalprice'); 
		

		$data['text_create'] 				= $this->language->get('text_create');
		$data['text_member'] 				= $this->language->get('text_member');
		


		$data['contest_title'] 		=	html_entity_decode($contest_info['title'], ENT_QUOTES, 'UTF-8');
		$data['contest_description'] 	=	html_entity_decode($contest_info['description'], ENT_QUOTES, 'UTF-8');
		$data['contest_organizer'] 	=	html_entity_decode($contest_info['organizer'], ENT_QUOTES, 'UTF-8');
		$data['contest_propose'] 	=	html_entity_decode($contest_info['propose'], ENT_QUOTES, 'UTF-8');
		$data['contest_location'] 	=	html_entity_decode($contest_info['location'], ENT_QUOTES, 'UTF-8');
		$data['contest_members'] 	=	html_entity_decode($contest_info['members'], ENT_QUOTES, 'UTF-8');
		$data['contest_contacts'] 	=	html_entity_decode($contest_info['contacts'], ENT_QUOTES, 'UTF-8');
		$data['contest_timeline_text'] 	=	html_entity_decode($contest_info['timeline_text'], ENT_QUOTES, 'UTF-8');

		$data['contest_date_start'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_start']));
		$data['contest_datetime_end'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['datetime_end']));
		$data['contest_date_rate'] 			=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_rate']));
		$data['contest_date_result'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_result']));
		$data['contest_date_finalist'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_finalist']));

		$data['image'] = '';
		if (!empty($contest_info['image'])) {
			$data['image'] = $this->model_tool_image->resize($contest_info['image'], 800, 460,'w');
		} else {
			$data['image'] = $this->model_tool_image->resize('no-image.png', 800, 460,'w');
		}
		//ссылка на участие

		$data['text_im_deal'] 				= $this->language->get('text_im_deal');
		$data['im_deal']  = $this->url->link('contest/deal', 'contest_id=' . $data['contest_id'], 'SSL');	

		//добавм проверку на логин пользователя
		if (!$this->customer->isLogged()) {
			
		}else{

		}


		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_view.tpl')) {
			
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/contest/contest_view.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/contest/contest_view.tpl', $data));
		}


	}
	

}