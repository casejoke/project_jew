<?php
class ControllerCommonImport extends Controller {
	public function index(){
		
		
		
		
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
	public function project(){
		print_r('импорт проектов');
		$i=1;
		$this->load->model('tool/upload');
		$this->load->model('account/customer');
		$this->load->model('group/group');
		$this->load->model('project/project');

		$results_groups = $this->model_group_group->getGroups();
		foreach ($results_groups as $vgg) {
			print_r('<pre>');
			print_r($vgg['mod_group_id']);
			print_r('</pre>');
			
			//id владельца проекта
			$customer_id = $vgg['customer_id'];
			$init_group_id = $vgg['init_group_id'];
			if($vgg['mod_group_id']!=0){
				
				$query_group_info 		= $this->db->query("SELECT tmplvarid,value FROM  `modx_site_content` , `modx_site_tmplvar_contentvalues` WHERE  `modx_site_content`.id = `modx_site_tmplvar_contentvalues`.contentid AND `modx_site_content`.id = '".(int)$vgg['mod_group_id']."'");
				$group_parent_id = 0;
				foreach ($query_group_info->rows  as  $vqqi) {
					//получаем parent для проектов
					if($vqqi['tmplvarid'] == 5){
						print_r('<pre>');
						print_r('parent для проектов'.$vqqi['value']);
						print_r('</pre>');
						$group_parent_id = $vqqi['value'];
					}
				}

				$project_for_group = array();

				if($group_parent_id > 0){

					$query_projects = $this->db->query("SELECT * FROM  `modx_site_content` WHERE parent = '".(int)$group_parent_id."'");

					if(!empty($query_projects->rows)){
						///Значит есть проекты
						foreach ($query_projects->rows as $vqp) {
							//print_r($vqp);
							//получим доп инфу о проекте
							$query_project_info = $this->db->query("SELECT tmplvarid,value FROM  `modx_site_content` , `modx_site_tmplvar_contentvalues` WHERE  `modx_site_content`.id = `modx_site_tmplvar_contentvalues`.contentid AND `modx_site_content`.id = '".(int)$vqp['id']."'");
							$description_project = $vqp['content'];
							$product_project = '';
							$target_project = '';
							$result_project = '';
							$image_project = '';
							foreach ($query_project_info->rows as $vqpi) {
								//цельпроекта
								
								if($vqpi['tmplvarid'] == 108){
									$target_project .= $vqpi['value'] ;
								}
								if($vqpi['tmplvarid'] == 111){
									$target_project .= $vqpi['value'] ;
								}
								//продукт проекта
								
								if($vqpi['tmplvarid'] == 116){
									$product_ = explode('||', $vqpi['value']);
									if(!empty($product_)){
										$product_project = '<ul>';
										foreach ($product_ as $vp) {
											
											$product_project .= '<li>'.$vp.'</li>';

										}
										$product_project .= '</ul>';
									}
									
								}
								
								//описание проекта
								
								if($vqpi['tmplvarid'] == 110){
									$description_project .= $vqpi['value'];
								}
								//результатпроекта
								
								if($vqpi['tmplvarid'] ==109){
									$result_project .= $vqpi['value'];
									
								}
								if($vqpi['tmplvarid'] ==114){
									$result_project .= $vqpi['value'];
									
								}

								if($vqpi['tmplvarid'] == 46 ){
									$is_image = explode('|', $vqpi['value']);
									
									if(count($is_image) == 1){
										$image_project = $vqpi['value'];
									}
									
									
								}
								//бюджет проекта

								print_r('<pre>');
								//print_r($vqpi);
								print_r('</pre>');
							}
							$data_desc = array();
							$data_desc[2]['title'] 			=  $vqp['pagetitle'];
				            $data_desc[2]['description'] 	=  $description_project;
				            $data_desc[2]['target']			=  $target_project;
				            $data_desc[2]['product']		=  $product_project;
				            $data_desc[2]['result']			=  $result_project;

							$project_for_group[] = array(
								'customer_id' 			=> $customer_id,
								'init_group_id' 		=> $init_group_id,
								'project_birthday'		=> date("Y-m-d H:i:s", $vqp['createdon']),
								'project_status_id'		=> 3,
								'project_init_group_id' => $init_group_id,
								'image' 				=> '',
								'image1' 				=> $image_project,
								'project_currency_id'   => '',
								'project_budget'		=> '',
								'project_description'   => $data_desc
							);

							//break;

						}

						print_r('<pre>');
						print_r($i);
						print_r($project_for_group);
						print_r('</pre>');

						foreach ($project_for_group as $vpg) {
							//break;
							//добавляем проект
							$customer_id =  $vpg['customer_id'];
							$project_id = $this->model_project_project->addProjectI($vpg,$customer_id);
							print_r('добавили проект ,'.$project_id);
							if(is_file(DIR_OLD_IMAGE.$vpg['image1'])){
								print_r(DIR_OLD_IMAGE.$vpg['image1']);
								$old_im = explode('/', $vpg['image1']);
							
								$file_name = $old_im[count($old_im)-1];
								// Sanitize the filename
								$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($file_name, ENT_QUOTES, 'UTF-8')));
								$customer_id = $vpg['customer_id'];

								$folder_name = md5($customer_id).'/';
								$code = md5(mt_rand());
								//создаем папку с назанием 
								if (!is_dir(DIR_UPLOAD . $folder_name)) {
									mkdir(DIR_UPLOAD . $folder_name, 0777);
								}
								$file = $folder_name . $filename. '.' . $code ;
								copy(DIR_OLD_IMAGE.$vpg['image1'], DIR_UPLOAD . $file);
								$code_= $this->model_tool_upload->addUpload($file_name, $file);
								print_r($code_);
								//добавим изображение в аватар
								$this->db->query("UPDATE " . DB_PREFIX . "project SET image = '" . $code_ . "' WHERE project_id = '" . (int)$project_id . "'");
								print_r('<pre>');
								print_r('добавили изображение в для группы пользователя с ID = '.$customer_id) ;
								print_r('</pre>');
							}

							//die();
							
						}


						$i++;
					}
					
				}
				
			}

			print_r('<pre>');
			print_r('----------------------------');
			print_r('</pre>');
		}

		//$query = $this->db->query("SELECT id,pagetitle FROM  `modx_site_content` WHERE parent = 613");

	
	}
	public function group(){
		/*
		//импорт групп
		$this->load->model('tool/upload');
		$this->load->model('account/customer');
		$this->load->model('group/group');
		//получение инфы о группах
		//ели конте группа то  parent = 5

		$data_group = array();
		$query = $this->db->query("SELECT * FROM  `modx_site_content` WHERE parent = 5");
		foreach ($query->rows as $value) {
			$data = array();
			//print_r('---------- ИНФА О ГРУППЕ ----------');
			//print_r('<pre>');
			//print_r($value) ;
			//print_r('</pre>');
			
			$query_group_info 		= $this->db->query("SELECT tmplvarid,value FROM  `modx_site_content` , `modx_site_tmplvar_contentvalues` WHERE  `modx_site_content`.id = `modx_site_tmplvar_contentvalues`.contentid AND `modx_site_content`.id = '".(int)$value['id']."'");
			//print_r('---------- ДОП ИНФА О ГРУППЕ ----------');
			$image_group = '';
			$mail_customer = '';
			$customer_id = 0;
			$customer= array();
			foreach ($query_group_info->rows as $k => $ivalue) {
				//print_r('<pre>');
				//print_r($ivalue) ;
				//print_r('</pre>');
				if($ivalue['tmplvarid'] == 1){
					$image_group = $ivalue['value'];
				}

				if($ivalue['tmplvarid'] == 7){

					$mail_customer = $ivalue['value'];
					$customer = $this->model_account_customer->getCustomerByEmail($mail_customer);
					//print_r($customer);
				}

			}
			//получим список пользователейй
			$isset_group = false;
		$query_members = $this->db->query("SELECT * FROM  `modx_member_groups` g LEFT JOIN  `modx_membergroup_names` gd  ON (g.user_group = gd.id)  WHERE gd.name LIKE '".$this->db->escape($value['pagetitle'])."'");
		
		$members_final = array();
		if(!empty($query_members->rows) || !empty($customer)){
			
			if (!empty($customer)) {
				$customer_id = $customer['customer_modx_id'];	
			}else{


				//$customer_id = $query_members->rows;
				foreach ($query_members->rows as $vqm) {
					$customer_id = $vqm['member'];
					break;

				}

			}
			
			//получим массив пользователей состояших в группах
			foreach ($query_members->rows as $vfm) {
				if( $vfm['member'] != $customer_id){
					$query = $this->db->query("SELECT * FROM  `" . DB_PREFIX . "customer` WHERE customer_modx_id = '".(int)$vfm['member']."'");
					$r_customer = $query->row;
					$members_final[] = array(
						'customer_id' => $r_customer['customer_id']
					);
				}
				
			}
			$isset_group = true;
		}else{
			$isset_group = false;
		}

			
			$data['mod_group_id'] = $value['id'];
			$data['mail_customer'] = $mail_customer;
			//$data['image'] = $title_group;
			$data['group_birthday'] = date("Y-m-d H:i:s", $value['createdon']);;
			$data['customer_id'] = $customer_id;
			$data['isset_group'] = $isset_group;
			//$data['customer_id'] = $title_group;
			//$data['customer_id'] = $title_group;

		//	$data['init_group_description'][2]['title'] 		= $value['pagetitle'];
		//	$data['init_group_description'][2]['description'] 	= $value['content'];

			//print_r('<pre>');
			//print_r($data) ;
			//print_r('</pre>');

			if( !isset($data_group[$this->db->escape($value['pagetitle'])])  && (!empty($query_members->rows) || !empty($customer)) ){
				$data_desc = array();
					$data_desc[2]['title'] 		= $value['pagetitle'];
		            $data_desc[2]['description'] 	= $value['content'];
		        $query = $this->db->query("SELECT * FROM  `" . DB_PREFIX . "customer` WHERE customer_modx_id = '".(int)$customer_id."'");
				$r_customer = $query->row;

				



				$data_group[$this->db->escape($value['pagetitle'])] = array(
					'mod_group_id' 		=> $value['id'],
					'group_birthday' 	=> date("Y-m-d H:i:s", $value['createdon']),
					'customer_id' 		=> $r_customer['customer_id'],
					'image'				=> $image_group,
					'members'			=> $members_final,
					'init_group_description'=>$data_desc
				);


			}
			
			
		}

			//создаем группу
			
			foreach ($data_group as $vdata) {
				$group_id = $this->model_group_group->addGroupM($vdata,$vdata['customer_id']);
				print_r('<pre>');
				print_r('создали группу '.$group_id);
				print_r('</pre>');

				//добавим пользователей в группы
				if(!empty($vdata['members'])){
					foreach ($vdata['members'] as $vm) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "customer_to_init_group SET 
							init_group_id = '" . (int)$group_id . "',
							customer_id = '" . (int)$vm['customer_id'] . "',
							status = '1',
							date_added = NOW()"
						);
					}
				}


				if(is_file(DIR_OLD_IMAGE.$vdata['image'])){
					$old_im = explode('/', $vdata['image']);
				
					$file_name = $old_im[count($old_im)-1];
					// Sanitize the filename
					$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($file_name, ENT_QUOTES, 'UTF-8')));
					$customer_id = $vdata['customer_id'];

					$folder_name = md5($customer_id).'/';
					$code = md5(mt_rand());
					//создаем папку с назанием 
					if (!is_dir(DIR_UPLOAD . $folder_name)) {
						mkdir(DIR_UPLOAD . $folder_name, 0777);
					}
					$file = $folder_name . $filename. '.' . $code ;
					copy(DIR_OLD_IMAGE.$vdata['image'], DIR_UPLOAD . $file);
					$code_= $this->model_tool_upload->addUpload($file_name, $file);
					print_r($code_);
					//добавим изображение в аватар
					$this->db->query("UPDATE " . DB_PREFIX . "init_group SET image = '" . $code_ . "' WHERE init_group_id = '" . (int)$group_id . "'");
					print_r('<pre>');
					print_r('добавили изображение в для группы пользователя с ID = '.$customer_id) ;
					print_r('</pre>');
				}
				

			}
			*/
			
	}
	public function customer(){
		/*
		$query = $this->db->query("SELECT * FROM  `modx_users` ,  `modx_user_attributes` WHERE  `modx_user_attributes`.id =  `modx_users`.id");


		$data= array();
		$this->load->model('tool/upload');
		$this->load->model('account/customer');
		foreach ($query->rows as $key => $value) {
			$data = array();
			$fullname = explode(' ', trim($value['fullname']));
			$data['firstname'] = '';
			$data['lastname']  = '';
			print_r('expression '.count($fullname));
			if(count($fullname) > 1){
				//значит есть и имя и фамилия
				$data['firstname'] = $fullname[0];
				$data['lastname']  = $fullname[1];
			}else{
				if(!empty($value['mobilephone'])){
					$data['firstname'] = trim($value['mobilephone']);
				}else{
					$data['firstname'] = '';
				}
				
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
			

		}
		*/
		
	}
}