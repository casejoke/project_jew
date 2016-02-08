<?php
class ControllerAccountPromocode extends Controller {
	const CODE_LENGTH = 8;
	public function index(){
		$this->load->model('account/promocode');
	//	for ($i=0; $i < 5000; $i++) { 
			
			//$promocode = $this->_createCode();
		//	print_r('<pre>');
		//	print_r($promocode);
		//	print_r('</pre>');
			//$promocode_info = $this->model_account_promocode->getPromocodeDescription($promocode);
			//if (empty($promocode_info)) {
			//	$this->model_account_promocode->addPromocode($promocode);
			//}
			
	//	}

		$promocode_results = $this->model_account_promocode->getPromocodes();
    print_r('expression');
		foreach ($promocode_results as $value) {
		//	print_r('<pre>');
			print_r($value['promocode_id'].'<br>');
		//	print_r('</pre>');
		}
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
}