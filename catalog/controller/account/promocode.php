<?php
class ControllerAccountPromocode extends Controller {
	const CODE_LENGTH = 8;
	private $error = array();
	public function index(){
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
			$data_post['promocode']   = $_post['b'];
			$data_post['customer_id'] = $_post['a'];
			$this->load->model('account/promocode');
			$this->model_account_promocode->activatePromocode($_post['b'],$_post['a']);
			$json['redirect'] = $this->url->link('account/account', '', 'SSL');
			$json['success'] = true;
			
		}else{
			$json['error'] = $this->error;
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));


	}
	public function activate(){
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		$this->load->model('project/project');

		//проверка на сушествование проекта
		$project_info = array();
		if (isset($this->request->get['project_id'])) {
			$project_info = $this->model_project_project->getProject($this->request->get['project_id']);
		}
		if ( empty($project_info) ){
			//редиректим на список проектов
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}

		$customer_id = $this->customer->getId();
		$this->load->model('account/promocode');
		//активируем промокод
		$promocode_id = $this->model_account_promocode->initPromocode($customer_id );
		//добавляем проект в победители
		$cwinn_id = $this->model_account_promocode->addWinnerContestBest($this->request->get['project_id'],$customer_id,$promocode_id);
		if($cwinn_id){
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}
		

	}
	protected function validate(){
		if (!$this->customer->isLogged()) {
			$this->error['login'] = $this->language->get('error_login');
			//проверка на логин
		}
		$this->load->model('account/promocode');
		$_post = $this->request->post;
		$promocode_info = $this->model_account_promocode->getPromocodeDescription($_post['b']);
		if(empty($promocode_info)){
			$this->error['promocode'] = 'Промокод не валидный, или уже активирован!';
		}
		if(isset($promocode_info['status']) && $promocode_info['status'] != 1){
			$this->error['promocode'] = 'Промокод не валидный, или уже активирован!';
		}
		if(isset($promocode_info['status']) && $promocode_info['status'] == 0){
			$this->error['promocode'] = 'Промокод не валидный, или уже активирован!';
		}
		
		return !$this->error;
	}

    protected function _createCode(){
      /*  $chars = array ('A', 'B', 'C', 'D', 'E', 'F', 'G',
            'H', 'I', 'J', 'K', 'L', 'M', 'N', '0', 'P',
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $code = '';
        for ($i = 0; $i < self::CODE_LENGTH; $i++) {
            $code .= $chars[rand(0, count($chars) - 1)];
        }*/
        $code = substr(md5(microtime()), rand(0,99), self::CODE_LENGTH);

        $max = ceil(self::CODE_LENGTH / 32);
		$random = '';
		for ($i = 0; $i < $max; $i ++) {
		$random .= md5(microtime(true).mt_rand(10000,90000));
		}
		$code =  substr($random, 0, self::CODE_LENGTH);

        return $code;
    }
    protected function temmFun(){
    	$this->load->model('account/promocode');
		/*for ($i=0; $i < 10; $i++) { 
			
			$promocode = $this->_createCode();
			print_r('<pre>');
			print_r($promocode);
			print_r('</pre>');
			$promocode_info = $this->model_account_promocode->getPromocodeDescription($promocode);
			if (empty($promocode_info)) {
				$this->model_account_promocode->addPromocode($promocode);
			}
			
		}
    */
    $promocode_results = $this->model_account_promocode->getPromocodes();
    print_r('expression');
		foreach ($promocode_results as $value) {
			print_r('<pre>');
			print_r($value['promocode_id'].'<br>');
			print_r('</pre>');
		}
    }
}