<?php
class ControllerGroupInvite extends Controller {
	private $error = array();

	public function index(){
		//group-invite - сттраница для приглашения в группу
		//проверяем на вход лк
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		if (!isset($this->request->get['group_id'])) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		} 

		$data['group_id_hash'] = $this->request->get['group_id'];

		//добавим расчехление 
		$group_id = $this->request->get['group_id'];

		//делаем проверку на принадлежность администартора к группе
		$this->load->model('group/group');
		$customer_id = $this->customer->getId();

		$results_admingroup= $this->model_group_group->getGroupsForAdmin($customer_id);
		$isAdminGroup = false;
		foreach ($results_admingroup as $result) {
			if((int)$this->request->get['group_id'] == $result['init_group_id']){
				$isAdminGroup = true;
				break; 
			}
		}
		if (!$isAdminGroup) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}
		//подгрим языковой файл
		$this->load->language('group/invite');
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
			'text' => $this->language->get('text_group_invite'),
			'href' => $this->url->link('group/group', '', 'SSL')
		);

		

		$this->load->model('account/customer');
		$this->load->model('group/group');
		$this->load->model('tool/image');

		//подгрузим список пользователей уже состоящих в группе или ждущих подверждение
		$filter_data = array(	
			'filter_init_group_id' => $group_id,
		);
		$results_customer_in_group = array();
		$results_customer_in_group = $this->model_group_group->getInviteGroups($filter_data);
		$customer_in_group = array();
		foreach ($results_customer_in_group as $result_cig) {
			$customer_in_group[$result_cig['customer_id']] = array(
				'customer_id'	=> $result_cig['customer_id'],
				'status'		=> $result_cig['status']
			);
		}
		

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
			'filter_customer_id'	   => $customer_id,
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
			$status = 0;
			if ( array_key_exists( $result['customer_id'], $customer_in_group )) {
				$status = $customer_in_group[$result['customer_id']]['status'];
			}
			
			if($status != 1){
				$data['customers'][] = array(
					'customer_id'    			=> $result['customer_id'],
					'customer_id_hash'			=> $customer_id_hash,
					'customer_name'     		=> $result['name'],
					'customer_image'			=> $image,
					'customer_status_invite'	=> $status,	
					'action'		 			=> $actions 
				);
			}
			   	
			
			
		}
		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/group/group_invite.tpl')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/invite.js');
		} else {
			$this->document->addScript('catalog/view/theme/default/assets/js/invite.js');
		}
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/group/group_invite.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/group/group_invite.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/group/group_invite.tpl', $data));
		}

		
	}

	public function invite(){
		//приглашение в группу
		$json = array();
		//подгрузим языковой файл
		$this->load->language('group/invite');
		//догрузим модель
		$this->load->model('group/group');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$_post = $this->request->post;
			//a = customer_id
			//b = grour_id
			//ставим статус = 2 для подтверждения пользователем
			$data_post = array();
			$data_post['init_group_id'] = $_post['b'];
			$data_post['customer_id'] = $_post['a'];
			$data_post['status'] = 2;
			$this->model_group_group->inviteCustomer($data_post);
			//добавить проверочик
			if($this->error){
				$json['error'] = $this->error;
			}else{
				$json['success'] = true;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

	public function agree(){

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		$this->load->language('group/invite');
		//догрузим модель
		$this->load->model('group/group');
		

		if (($this->request->server['REQUEST_METHOD'] == 'GET') && $this->validateAgree()) {
			$_get = $this->request->get;
			$customer_id = $this->customer->getId();
			$data = array();
			$data['init_group_id'] = $_get['group_id'];
			$data['customer_id'] = $customer_id;
			$this->model_group_group->inviteAgree($data);

			$this->session->data['redirect'] = $this->url->link('group/invite/agree', '', 'SSL');
			$this->response->redirect($this->url->link('group/view', 'group_id='.$data['init_group_id'], 'SSL'));
		}
		

	}
	public function uninvite(){
		//приглашение в группу
		$json = array();
		//подгрузим языковой файл
		$this->load->language('group/invite');
		//догрузим модель
		$this->load->model('group/group');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$_post = $this->request->post;
			//a = customer_id
			//b = grour_id
			//ставим статус = 2 для подтверждения пользователем
			$data_post = array();
			$data_post['init_group_id'] = $_post['b'];
			$data_post['customer_id'] = $_post['a'];
			$data_post['status'] = 2;
			$this->model_group_group->uninviteCustomer($data_post);

			//добавить отправки 
			//добавить проверочик
			if($this->error){
				$json['error'] = $this->error;
			}else{
				$json['success'] = true;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

	protected function validate() {
		if (!$this->customer->isLogged()) {
			$this->error['login'] = $this->language->get('error_login');
			//проверка на логин
		}
		//проверка на уже сушествующий инвайт

		//проводим валидацию проверям логин и прочее
		return !$this->error;
	}
	protected function validateAgree() {
		if (!$this->customer->isLogged()) {
			$this->error['login'] = $this->language->get('error_login');
		}
		//проверка на уже сушествующий инвайт

		//проводим валидацию проверям логин и прочее
		return !$this->error;
	}

	
}