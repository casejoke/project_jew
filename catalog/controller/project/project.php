<?php
/**
 * Инициативные группы
 */
class ControllerProjectProject extends Controller {
	public function index(){
		
		$this->getList();
	}
	private function getList(){
		//подгрузим язык
		$this->load->language('project/list');
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_project_invite'),
			'href' => $this->url->link('project/project', '', 'SSL')
		);

		$this->load->model('project/project');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		//подтянем все активные группы
		$results_projects = $this->model_project_project->getProjects();
		$data['projects'] = array();
		foreach ($results_projects as $result_p) {
			if (!empty($result_p['image'])) {
				$upload_info = $this->model_tool_upload->getUploadByCode($result_p['image']);
				$filename = $upload_info['filename'];
				$image = $this->model_tool_upload->resize($filename , 300, 300,'h');
			} else {
				$image = $this->model_tool_image->resize('no-image.png', 300, 300,'h');
			}

			$actions = array(
				'view'		=> $this->url->link('project/view', 'project_id='.$result_p['project_id'], 'SSL')
			);
			$data['projects'][] = array(
				'project_id'			=> $result_p['project_id'],
				'project_title'			=> (strlen(strip_tags(html_entity_decode($result_p['title'], ENT_COMPAT, 'UTF-8'))) > 50 ? mb_strcut(strip_tags(html_entity_decode($result_p['title'], ENT_COMPAT, 'UTF-8')), 0, 55) . '...' : strip_tags(html_entity_decode($result_p['title'], ENT_COMPAT, 'UTF-8'))),
				'project_image'			=> $image,
				'action'				=> $actions
			);
		}


		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/project/project_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/project/project_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/project/project_list.tpl', $data));
		}


	}

}