<?php
class ControllerAccountCustomers extends Controller {
	//
	public function index() {
		//подгрим языковой файл
		$this->load->language('account/customers');
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_customers'),
			'href' => $this->url->link('account/customers', '', 'SSL')
		);

		

		$this->load->model('account/customer');
		$this->load->model('tool/image');

		//подгрузим список пользователей (не экпертов и  исключая текущего пользователя)
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_approved'])) {
			$filter_approved = $this->request->get['filter_approved'];
		} else {
			$filter_approved = 1;
		}

		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$data['customers'] = array();
		$filter_data = array();
		$filter_data = array(
			'filter_name'              => $filter_name,
			//'filter_email'             => $filter_email,
			//'filter_customer_group_id' => $filter_customer_group_id,
			'filter_status'            => $filter_status,
			'filter_approved'          => $filter_approved,
			//'filter_date_added'        => $filter_date_added,
			//'filter_ip'                => $filter_ip,
			'sort'                     => $sort,
			'order'                    => $order,
			//'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			//'limit'                    => $this->config->get('config_limit_admin')
		);

		$results = $this->model_account_customer->getCustomers($filter_data);

			//добавить неболшое шифрование!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		foreach ($results as $result) {
			if(preg_match('/http/', $result['image'])){
				$image = $result['image'];
			}else{
				if (is_file(DIR_IMAGE . $result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 400, 400, 'h');
				}else{
					$image = $this->model_tool_image->resize('no-image.png', 400, 400, 'h');
				}
			}
			$customer_id_hash = $result['customer_id'];
			$actions = array();
			$actions = array(
				'invite'	=> $this->url->link('group/invite/invite', '', 'SSL'),
				'uninvite'	=> $this->url->link('group/invite/uninvite', '', 'SSL'),
				'info'		=> $this->url->link('account/info', 'ch=' . $customer_id_hash, 'SSL'),
			);
			
				$data['customers'][] = array(
					'customer_id'    			=> $result['customer_id'],
					'customer_id_hash'			=> $customer_id_hash,
					'customer_name'     		=> $result['name'],
					'customer_image'			=> $image,
					'action'		 			=> $actions 
				);
			   	
			
			
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customers.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/customers.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customers.tpl', $data));
		}

		
		
	}
}