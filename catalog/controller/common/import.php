<?php
class ControllerCommonImport extends Controller {
	public function index(){
		$query = $this->db->query("SELECT * FROM  `modx_users` ,  `modx_user_attributes` WHERE  `modx_user_attributes`.id =  `modx_users`.id");

		print_r('<pre>');
		print_r($query->rows) ;
		print_r('</pre>');
		$data= array();
		
		foreach ($query->rows as $key => $value) {
			$data = array();
			$fullname = explode(' ', $value['fullname']);
			$data['firstname'] = '';
			$data['lastname']  = '';
			if(count($fullname) > 1){
				//значит есть и имя и фамилия
				$data['firstname'] = $fullname[0];
				$data['lastname']  = $fullname[1];
			}
			$data['email'] = $value['email'];
			print_r($fullname);
			
			print_r('<pre>');
			print_r($data) ;
			print_r('</pre>');
			
		/*	$data['firstname'] = 
			$data['lastname']
			$data['email']
			$data['image'] // подгрузить
			$data['telephone']
			$data['newsletter']
			$data['password']
			$data['firstname']
			$data['firstname']
			$data['firstname']
			$data['firstname']*/


		}
		

	}
}