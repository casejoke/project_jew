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
		$this->load->model('account/customer');

		$filter_data = array();
		$filter_data = array(
			//'filter_name'              => $filter_name,
			//'filter_email'             => $filter_email,
			//'filter_customer_group_id' => $filter_customer_group_id,
			//'filter_status'            => $filter_status,
			//'filter_approved'          => $filter_approved,
			//'filter_date_added'        => $filter_date_added,
			//'filter_ip'                => $filter_ip,
			//'sort'                     => $sort,
			//'order'                    => $order,
			//'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			//'limit'                    => $this->config->get('config_limit_admin')
		);

		$results_customer = $this->model_account_customer->getCustomers($filter_data);
		$customers = array();
		foreach ($results_customer as $vrc) {
			$customers[$vrc['customer_id']] = array(
				'customer_name' 	=> $vrc['name'],
				'customer_link'		=> $this->url->link('account/info', 'ch=' . $vrc['customer_id'], 'SSL')

			);
		}

		//подтянем все активные группы
		$results_projects = $this->model_project_project->getProjects();
		$data['projects'] = array();
		foreach ($results_projects as $result_p) {
			if (!empty($result_p['image'])) {
				$upload_info = $this->model_tool_upload->getUploadByCode($result_p['image']);
				$filename = $upload_info['filename'];
				$image = $this->model_tool_upload->resize($filename , 178, 100,'w');
			} else {
				$image = $this->model_tool_image->resize('no-image.png', 178, 100,'w');
			}

			$actions = array(
				'view'		=> $this->url->link('project/view', 'project_id='.$result_p['project_id'], 'SSL')
			);
			$data['projects'][] = array(
				'project_id'			=> $result_p['project_id'],
				'project_customer'		=> $customers[$result_p['customer_id']],
				'project_birthday'		=> rus_date($this->language->get('date_day_date_format'), strtotime($result_p['project_birthday'])),
				'project_title'			=> html_entity_decode($result_p['title'], ENT_COMPAT, 'UTF-8'),
				'project_image'			=> $image,
				'action'				=> $actions
			);
		}


		//$data['admin_info'] = $this->model_account_customer->getCustomer($admin_id);
		//$data['link_admin'] = $this->url->link('account/info', 'ch=' . $admin_id_hash, 'SSL');


		$data['add_project'] = $this->url->link('project/edit', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customers.tpl')) {

			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/list.min.js');
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/projects.js');
		} else {
			$this->document->addScript('catalog/view/theme/default/assets/js/list.min.js');
			$this->document->addScript('catalog/view/theme/default/assets/js/projects.js');
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
