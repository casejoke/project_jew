<?php
class ControllerCommonImport extends Controller {
	public function index(){
		$query = $this->db->query("SELECT * FROM  `modx_users` ,  `modx_user_attributes` WHERE  `modx_user_attributes`.id =  `modx_users`.id");

		$data= array();
		$this->load->model('tool/upload');
		$this->load->model('account/customer');
		foreach ($query->rows as $key => $value) {
			$data = array();
			$fullname = explode(' ', $value['fullname']);
			$data['firstname'] = '';
			$data['lastname']  = '';
			if(count($fullname) > 1){
				//значит есть и имя и фамилия
				$data['firstname'] = $fullname[0];
				$data['lastname']  = $fullname[1];
			}else{
				$data['firstname'] = '';
				$data['lastname']  = $fullname[0];
			}
			$data['email'] 						= $value['email'];
			$data['newsletter'] 			= 1;
			$data['customer_modx_id'] = $value['id'];
			$data['telephone'] 				= $value['phone'];
			$data['password'] 				= $value['password'];
			$data['salt']							= $value['salt'];
			$data['image']						= '';
			/*print_r('<pre>');
			print_r($data) ;
			print_r('</pre>');
			//$customer_id = $this->model_account_customer->addC($data);
			print_r('<pre>');
			print_r('Создали пользователя с ID = '.$customer_id) ;
			print_r('</pre>');
			// Sanitize the filename
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));
			$customer_id = $this->customer->getId();
			$folder_name = md5($customer_id).'/';
			//создаем папку с назанием 
			if (!is_dir(DIR_UPLOAD . $folder_name)) {
				mkdir(DIR_UPLOAD . $folder_name, 0777);
			}
			$file = $folder_name . $filename. '.' . $code ;

			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_UPLOAD . $file  );

			print_r($fullname);*/


			break;
		}
		
		///про группы

			//$query = $this->db->query("SELECT * FROM  `modx_member_groups` ,  `modx_user_group_roles` WHERE  `modx_user_group_roles`.id =  `modx_member_groups`.role");
			//$query = $this->db->query("SELECT * FROM  `modx_member_groups` ,  `modx_user_group_roles` ,  `modx_users` WHERE  `modx_user_group_roles`.id =  `modx_member_groups`.role AND  `modx_users`.id =  `modx_member_groups`.member");
			//посос пользователя для группы
			//если у группы несколько то rank = 0 == admin
			$query = $this->db->query("SELECT * FROM  `modx_membergroup_names` ,  `modx_member_groups` WHERE  `modx_member_groups`.`user_group` =  `modx_membergroup_names`.id AND `modx_member_groups`.`user_group` = 72");
			
			print_r('<pre>');
			print_r($query->rows) ;
			print_r('</pre>');
			//получение инфы о группе
			$query = $this->db->query("SELECT * FROM  `modx_site_content` WHERE contentid = 72");
			print_r('<pre>');
			print_r($query->rows) ;
			print_r('</pre>');
	}
}