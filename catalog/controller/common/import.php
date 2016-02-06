<?php
class ControllerCommonImport extends Controller {
	public function index(){
		/*$query = $this->db->query("SELECT * FROM  `modx_users` ,  `modx_user_attributes` WHERE  `modx_user_attributes`.id =  `modx_users`.id");


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
			print_r('<pre>');
			print_r($data) ;
			print_r('</pre>');
			$customer_id = $this->model_account_customer->addC($data);
			print_r('<pre>');
			print_r('Создали пользователя с ID = '.$customer_id) ;
			print_r('</pre>');


			if(is_file(DIR_OLD_IMAGE.$value['photo'])){
				$old_im = explode('/', $value['photo']);
			
				$file_name = $old_im[count($old_im)-1];
				// Sanitize the filename
				$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($file_name, ENT_QUOTES, 'UTF-8')));
				$customer_id = $customer_id;

				$folder_name = md5($customer_id).'/';
				$code = md5(mt_rand());
				//создаем папку с назанием 
				if (!is_dir(DIR_UPLOAD . $folder_name)) {
					mkdir(DIR_UPLOAD . $folder_name, 0777);
				}
				$file = $folder_name . $filename. '.' . $code ;
				
				
				copy(DIR_OLD_IMAGE.$value['photo'], DIR_UPLOAD . $file);
				
				
				$this->load->model('tool/upload');
				$this->load->model('account/customer');
				$code_= $this->model_tool_upload->addUpload($file_name, $file);
				print_r($code_);
				//добавим изображение в аватар
				$this->db->query("UPDATE " . DB_PREFIX . "customer SET image = '" . $code_ . "' WHERE customer_id = '" . (int)$customer_id . "'");
				print_r('<pre>');
				print_r('добавили изображение в аватар пользователя с ID = '.$customer_id) ;
				print_r('</pre>');
			}
			

		}*/
		
		//импорт групп

		//получение инфы о группах
		//ели конте группа то  parent = 5
		$query = $this->db->query("SELECT * FROM  `modx_site_content` WHERE parent = 5");
		foreach ($query->rows as $key => $value) {
			$data = array();
			print_r('---------- ИНФА О ГРУППЕ ----------');
			print_r('<pre>');
			print_r($value) ;
			print_r('</pre>');
			
			$query_group_info 		= $this->db->query("SELECT tmplvarid,value FROM  `modx_site_content` , `modx_site_tmplvar_contentvalues` WHERE  `modx_site_content`.id = `modx_site_tmplvar_contentvalues`.contentid AND `modx_site_content`.id = '".(int)$value['id']."'");
			print_r('---------- ДОП ИНФА О ГРУППЕ ----------');
			$image_group = '';
			foreach ($query_group_info->rows as $k => $ivalue) {
				print_r('<pre>');
				print_r($ivalue) ;
				print_r('</pre>');
				if($ivalue['tmplvarid'] == 1){
					$image_group = $ivalue['value'];
				}

			}

			$data['customer_id'] = $title_group;
			$data['image'] = $title_group;
			$data['group_birthday'] = $value['createdon'];
			$data['customer_id'] = $title_group;
			$data['customer_id'] = $title_group;
			$data['customer_id'] = $title_group;

			$data['init_group_description'][2]['title'] 		= $value['pagetitle'];
			$data['init_group_description'][2]['description'] 	= $value['content'];

			print_r('<pre>');
				print_r($data) ;
				print_r('</pre>');
			
		}
/*
			$query = $this->db->query("SELECT id,pagetitle,description,content FROM  `modx_site_content` WHERE parent = 5 AND id = 612");
		
			
				foreach ($query->rows as $key => $value) {
					print_r('о групе');
					print_r('<pre>');
					print_r($value) ;
					print_r('</pre>');
					//получаю доп инфу о группе/проекте 
					$query = $this->db->query("SELECT tmplvarid,value FROM  `modx_site_content` , `modx_site_tmplvar_contentvalues` WHERE  `modx_site_content`.id = `modx_site_tmplvar_contentvalues`.contentid AND `modx_site_content`.id = 612");
					print_r('<pre>');
					//modx_site_tmplvars -здесь хранятся сведния об id значения поля
					print_r($query->rows) ;	
					//tmplvarid - 7  мыло админа группы
					print_r('</pre>');

					//получить инфу о проектах этой группы выбрать tmplvarid == 5 и это будет parent для проектов , в данно случа value = 613
					//получаем список проектов для данной группы
					$query = $this->db->query("SELECT id,pagetitle FROM  `modx_site_content` WHERE parent = 613");
					print_r('список проектов');
					print_r('<pre>');

					//modx_site_tmplvars -здесь хранятся сведния об id значения поля
					print_r($query->rows) ;	
					//далее аналогично груупапам получаем доп инфу о проекте к примеру 1830
					print_r('</pre>');
					$query = $this->db->query("SELECT tmplvarid,value FROM  `modx_site_content` , `modx_site_tmplvar_contentvalues` WHERE  `modx_site_content`.id = `modx_site_tmplvar_contentvalues`.contentid AND `modx_site_content`.id = 1830");
					print_r('<pre>');
					//modx_site_tmplvars -здесь хранятся сведния об id значения поля
					print_r($query->rows) ;	
					print_r('</pre>');

					//получили спислок пользователей входящих в группу по имени группы

					$query = $this->db->query("SELECT * FROM  `modx_member_groups` g LEFT JOIN  `modx_membergroup_names` gd  ON (g.user_group = gd.id)  WHERE gd.name LIKE 'АМУТА'");
					print_r('<pre>');
					print_r($query->rows) ;	
					//получю поле member= участники группы
					print_r('</pre>');
				}
			

			//

			//получение администратора и других пользователее этой группы


*/




	}
}