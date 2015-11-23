<?php
/**
 * Конкурсы
 */
class ControllerContestContest extends Controller {
	public function index(){
		
		$this->getList();
	}
	private function getList(){
		//подгрузим язык
		$this->load->language('contest/list');
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
			'text' => $this->language->get('text_contest_invite'),
			'href' => $this->url->link('contest/contest', '', 'SSL')
		);

		$this->load->model('contest/contest');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		//подтянем все активные группы
		$results_contests = $this->model_contest_contest->getContests();
		$data['contests'] = array();
		foreach ($results_contests as $rc) {
			if (!empty($rc['image'])) {
				$image= $this->model_tool_image->resize($rc['image'], 300, 300,'h');
			}else{
				$image = $this->model_tool_image->resize('placeholder.png', 300, 300,'h');
			}

			$actions = array(
				'view'		=> $this->url->link('contest/view', 'contest_id='.$rc['contest_id'], 'SSL')
			);
			$data['contests'][] = array(
				'contest_id'			=> $rc['contest_id'],
				'contest_title'			=> (strlen(strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8'))) > 50 ? mb_strcut(strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8')), 0, 55) . '...' : strip_tags(html_entity_decode($rc['title'], ENT_COMPAT, 'UTF-8'))),
				'contest_image'			=> $image,
				'action'				=> $actions
			);
		}


		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/contest/contest_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/contest/contest_list.tpl', $data));
		}


	}

}