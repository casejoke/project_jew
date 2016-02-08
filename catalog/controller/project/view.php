<?php
/**
 * Просмотр проекта
 */
class ControllerProjectView extends Controller {
	public function index(){
		if ( !isset($this->request->get['project_id']) ) {
			$this->session->data['redirect'] = $this->url->link('project/project', '', 'SSL');
			$this->response->redirect($this->url->link('project/project', '', 'SSL'));
			
		}
		
		$this->getView();
	}
	
	private function getView(){
		//подгрузим язык
		$this->load->language('project/view');
		//выводим инфу о текщей проекте
		$project_id = $this->request->get['project_id'];
		//для шифрования
		$data['project_id'] = $project_id;

		//подгрузим модели
		$this->load->model('account/customer');
		$this->load->model('project/project');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		$project_info = array();
		if (isset($this->request->get['project_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$project_info = $this->model_project_project->getProject($this->request->get['project_id']);
		}
		//проверим сушествоание проекта 
		if ( empty($project_info) ){
			//редиректим на список 
			$this->session->data['redirect'] = $this->url->link('project/project', '', 'SSL');
			$this->response->redirect($this->url->link('project/project', '', 'SSL'));
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_projects'),
			'href' => $this->url->link('project/project', '', 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $project_info['title'],
			'href' => $this->url->link('project/view', 'project_id=' . $data['project_id'], 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		$this->document->setTitle($project_info['title']);
		$this->document->setDescription(substr(strip_tags(html_entity_decode($project_info['meta_description'], ENT_QUOTES)), 0, 150) . '...');
		//$this->document->setKeywords($project_info['meta_keyword']);


		$data['entry_title'] 				= $this->language->get('entry_title');
		$data['entry_description'] 			= $this->language->get('entry_description');
		$data['entry_image'] 				= $this->language->get('entry_image');
		$data['entry_project_birthday'] 		= $this->language->get('entry_project_birthday');
		$data['entry_project_email'] 			= $this->language->get('entry_project_email'); 

		$data['text_create'] 				= $this->language->get('text_create');
		$data['text_member'] 				= $this->language->get('text_member');
		


		$data['project_title'] 		=	html_entity_decode($project_info['title'], ENT_QUOTES, 'UTF-8');
		$data['project_description'] 	=	html_entity_decode($project_info['description'], ENT_QUOTES, 'UTF-8');

		$data['image'] = '';
		if (!empty($project_info['image'])) {
			$upload_info = $this->model_tool_upload->getUploadByCode($project_info['image']);
			$filename = $upload_info['filename'];
			$data['image'] = $this->model_tool_upload->resize($filename , 800, 460,'w');
		} else {
			$data['image'] = $this->model_tool_image->resize('no-image.png', 800, 460,'w');
		}
		
		$data['project_birthday'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($project_info['project_birthday']));

		//подтянем администратора группы
		$admin_id = $project_info['customer_id'];
		$admin_id_hash = $admin_id;
		$data['admin_info'] = $this->model_account_customer->getCustomer($admin_id);
		$data['link_admin'] = $this->url->link('account/info', 'ch=' . $admin_id_hash, 'SSL');

		


		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/project/project_view.tpl')) {
			
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/project/project_view.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/project/project_view.tpl', $data));
		}


	}
	

}