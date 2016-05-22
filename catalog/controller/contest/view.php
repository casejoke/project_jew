<?php
/**
 * Просмотр проекта
 */
class ControllerContestView extends Controller {
	public function index(){
		if ( !isset($this->request->get['contest_id']) ) {
			$this->session->data['redirect'] = $this->url->link('contest/contest', '', 'SSL');
			$this->response->redirect($this->url->link('contest/contest', '', 'SSL'));
			
		}
		
		$this->getView();
	}
	
	private function getView(){

		//************** проверки ***************//

		//если конкурс в статусе работа - редирект





		//подгрузим язык
		$this->load->language('contest/view');
		//выводим инфу о текщей проекте
		$contest_id = $this->request->get['contest_id'];
		//для шифрования
		$data['contest_id'] = $contest_id;

		//подгрузим модели
		$this->load->model('account/customer');
		$this->load->model('contest/contest');
		$this->load->model('tool/upload');
		$this->load->model('tool/image');
		$this->load->model('project/project');
		$contest_info = array();
		if (isset($this->request->get['contest_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$contest_info = $this->model_contest_contest->getContest($this->request->get['contest_id']);
		}
		//проверим сушествоание группы 
		if ( empty($contest_info) ){
			//редиректим на список 
			$this->session->data['redirect'] = $this->url->link('contest/contest', '', 'SSL');
			$this->response->redirect($this->url->link('contest/contest', '', 'SSL'));
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_contests'),
			'href' => $this->url->link('contest/contest', '', 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $contest_info['title'],
			'href' => $this->url->link('contest/view', 'contest_id=' . $data['contest_id'], 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		$this->document->setTitle($contest_info['title']);
		$this->document->setDescription(substr(strip_tags(html_entity_decode($contest_info['meta_description'], ENT_QUOTES)), 0, 150) . '...');
		//$this->document->setKeywords($contest_info['meta_keyword']);


		$data['entry_title'] 					= $this->language->get('entry_title');
		$data['entry_description'] 				= $this->language->get('entry_description');
		$data['entry_image'] 					= $this->language->get('entry_image');
		$data['entry_contest_birthday'] 		= $this->language->get('entry_contest_birthday');
		$data['entry_contest_email'] 			= $this->language->get('entry_contest_email'); 
		
		$data['entry_contest_dates'] 			= $this->language->get('entry_contest_dates'); 
		$data['entry_contest_date_start'] 		= $this->language->get('entry_contest_date_start'); 
		$data['entry_contest_datetime_end'] 	= $this->language->get('entry_contest_datetime_end'); 
		$data['entry_contest_date_rate'] 		= $this->language->get('entry_contest_date_rate'); 
		$data['entry_contest_date_result'] 		= $this->language->get('entry_contest_date_result'); 
		$data['entry_contest_date_finalist'] 	= $this->language->get('entry_contest_date_finalist'); 

		$data['entry_contest_organizer'] 		= $this->language->get('entry_contest_organizer'); 
		$data['entry_contest_budget'] 			= $this->language->get('entry_contest_budget');
		$data['entry_contest_propose'] 			= $this->language->get('entry_contest_propose'); 
		$data['entry_contest_location'] 		= $this->language->get('entry_contest_location'); 
		$data['entry_contest_members'] 			= $this->language->get('entry_contest_members'); 
		$data['entry_contest_contacts'] 		= $this->language->get('entry_contest_contacts'); 
		$data['entry_contest_timeline_text']	= $this->language->get('entry_contest_timeline_text'); 
		$data['entry_contest_budget']			= $this->language->get('entry_contest_budget'); 
		$data['entry_contest_maxprice']			= $this->language->get('entry_contest_maxprice'); 
		$data['entry_contest_totalprice']		= $this->language->get('entry_contest_totalprice'); 
		$data['entry_contest_downloads']		= $this->language->get('entry_contest_downloads'); 

		$data['text_create'] 					= $this->language->get('text_create');
		$data['text_member'] 					= $this->language->get('text_member');
		

		$data['contest_status']					= 	$contest_info['status'];
		$data['contest_type']					= 	$contest_info['type'];
		$data['contest_id']						= 	$contest_info['contest_id'];
		$data['contest_title'] 					=	html_entity_decode($contest_info['title'], ENT_QUOTES, 'UTF-8');
		$data['contest_description']			=	html_entity_decode($contest_info['description'], ENT_QUOTES, 'UTF-8');
		$data['contest_organizer'] 				=	html_entity_decode($contest_info['organizer'], ENT_QUOTES, 'UTF-8');
		$data['contest_propose'] 				=	html_entity_decode($contest_info['propose'], ENT_QUOTES, 'UTF-8');
		$data['contest_location'] 				=	html_entity_decode($contest_info['location'], ENT_QUOTES, 'UTF-8');
		$data['contest_members'] 				=	html_entity_decode($contest_info['members'], ENT_QUOTES, 'UTF-8');
		$data['contest_contacts'] 				=	html_entity_decode($contest_info['contacts'], ENT_QUOTES, 'UTF-8');
		$data['contest_timeline_text'] 			=	html_entity_decode($contest_info['timeline_text'], ENT_QUOTES, 'UTF-8');

		$data['contest_date_start'] 	=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_start']));
		$data['contest_datetime_end'] 	=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['datetime_end']));
		$data['contest_date_rate'] 		=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_rate']));
		$data['contest_date_result'] 	=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_result']));
		$data['contest_date_finalist'] 	=	rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_finalist']));

		$data['maxprice'] 				=	$contest_info['maxprice'];
		$data['totalprice'] 			=	$contest_info['totalprice'];

		//показыввем кнопку "подать заявку"
		$data['send_request'] = 1;
		if( strtotime($contest_info['datetime_end']) < strtotime(date('Y-m-d'))  ){
			$data['send_request'] = 0;
		}

		//показыввем победителей
		$data['winners'] = array();
		if( strtotime($contest_info['date_finalist']) < strtotime(date('Y-m-d'))  ){

			$relation_statuses = $this->model_project_project->getListRelationshipAdaptor();
			$res_relation_status = array();
			foreach ($relation_statuses as $vrs) {
				$res_relation_status[$vrs['relation_status_id']] = $vrs['relation_status_title'];
			}
			
			$filter_data = array();

			$results_customer = $this->model_account_customer->getCustomers($filter_data);
			$customers = array();
			foreach ($results_customer as $vrc) {
				$customers[$vrc['customer_id']] = array(
					'customer_name' 	=> $vrc['name'],
					'customer_link'		=> $this->url->link('account/info', 'ch=' . $vrc['customer_id'], 'SSL')

				);
			}

			$implode[] = (int)$contest_id;
			$filter_data = array();
			$filter_data = array(
				'filter_contest_id' => $implode,
				'filter_status'			=> 1
			);
			

			$filter_data = array();
			$results_projects = $this->model_project_project->getListProjects($filter_data);
			$projects = array();
			foreach ($results_projects as $result_p) {
				$projects[$result_p['project_id']] = array(
					'project_id'			=> $result_p['project_id'],
					'project_title'			=> $result_p['title'],
					'customer_id'      		=> $result_p['customer_id'],
					'project_link'			=> $this->url->link('project/view', 'project_id='.$result_p['project_id'], 'SSL')		
				);
			}
			



			//типы конкурса
			//1 - открытый
			//2 - по приглашению
			//3 - BP 
			//собираем победителей
			$data['winners'] = array();
			$filter_data = array();
			$filter_data = array(
				'filter_contest_id'	=> $data['contest_id']
			);

		
			

			
			


			$results_winners = $this->model_contest_contest->getCustomerForWinner($filter_data);
			
			foreach ($results_winners as $vcfw) {

				$adaptive_id_text = '';
				$adaptive_customer_name = '';
				$adaptive_status_text   = '';


				switch ((int)$data['contest_type']) {
					case '1':

						break;
					case '2':
						
						break;
					case '3':
							//проект котрый адаптирует
							$info_req = $this->model_contest_contest->getInfoRequest($vcfw['request_id']);
							$adaptive_id = $info_req['adaptive_id'];
							$adaptive_id_text = $projects[$adaptive_id]['project_title'];
							$adaptive_customer_id = $projects[$adaptive_id]['customer_id'];
	            			$adaptive_customer_name = $customers[$adaptive_customer_id]['customer_name'];//автор проекта

						break;
					default:
						
						break;
				}



				$data['winners'][] = array(
					'request_id'			=> $vcfw['request_id'],
					'place_id'				=> $vcfw['place_id'],
					'customer_name' 		=> $customers[$vcfw['customer_id']]['customer_name'],
					'adaptive_name'         	=>  $adaptive_customer_name,
					'adaptive_project_title'	=>  $adaptive_id_text,

				);

			}

			usort($data['winners'], 'sortByPlace');

		//print_r('<pre>');
		//	print_r($data['winners']);
		//	print_r('</pre>');

			
		}


		//die();

		
		

		//print_r($data['send_request']);


		$data['image'] = '';
		if (!empty($contest_info['image'])) {
			$data['image'] = $this->model_tool_image->resize($contest_info['image'], 800, 460,'w');
		} else {
			$data['image'] = '';
		}
		//ссылка на участие

		$data['text_im_deal'] 				= $this->language->get('text_im_deal');
		$data['im_deal']  = $this->url->link('contest/deal', 'contest_id=' . $data['contest_id'], 'SSL');	

		$data['add_project'] = $this->url->link('project/edit', '', 'SSL'); 
		
		//прикрепленные файлы
			//!!!!!!!!!!!  переписать
			$download_info = $this->model_contest_contest->getContestDownloads($contest_id);

			$data['contest_downloads'] = array();
			foreach ($download_info as $di) {
				//
				$download_file = $this->model_contest_contest->getDownload($di['download_id']);
				if (file_exists(DIR_DOWNLOAD . $download_file['filename'])) {
					$size = filesize(DIR_DOWNLOAD . $download_file['filename']);

					$i = 0;

					$suffix = array(
						'B',
						'KB',
						'MB',
						'GB',
						'TB',
						'PB',
						'EB',
						'ZB',
						'YB'
					);

					while (($size / 1024) > 1) {
						$size = $size / 1024;
						$i++;
					}

					$data['contest_downloads'][] = array(
						'date_added' => date($this->language->get('date_format_short'), strtotime($download_file['date_added'])),
						'name'       => $download_file['name'],
						'size'       => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
						'href'       => $this->url->link('contest/view/download', 'download_id=' . $download_file['download_id'], 'SSL')
					);
				}
				
			}

			//проверка на эксперта для данного конкурса
			//подтяем список конкурсов в котрых пользователь экспертом
			$customer_id = $this->customer->getId();
			$results_customer_expert_to_contests = array();
			$results_customer_expert_to_contests = $this->model_contest_contest->getContestForExpertCustomer($customer_id);
			$data['is_expert'] = false;
			foreach ($results_customer_expert_to_contests as $vcetc) {
				if($vcetc['contest_id'] == $contest_id){
					$data['is_expert'] = true;
					break;
				}
			}

		//добавм проверку на логин пользователя
		if (!$this->customer->isLogged()) {
			
		}else{

		}


		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_view.tpl')) {
			
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/contest/contest_view.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/contest/contest_view.tpl', $data));
		}


	}
	
	public function download() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/download', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('contest/contest');

		if (isset($this->request->get['download_id'])) {
			$download_id = $this->request->get['download_id'];
		} else {
			$download_id = 0;
		}

		$download_info = $this->model_contest_contest->getDownload($download_id);

		if ($download_info) {
			$file = DIR_DOWNLOAD . $download_info['filename'];
			$mask = basename($download_info['mask']);

			if (!headers_sent()) {
				if (file_exists($file)) {

					
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					/*
					header('Content-Type: application/pdf');
					header('Content-Disposition: inline; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Expires: 0');
					header('Content-Transfer-Encoding: binary');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					header('Accept-Ranges: bytes');
					*/
					if (ob_get_level()) {
						ob_end_clean();
					}

					readfile($file, 'rb');

					exit();
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}
		} else {
			$this->response->redirect($this->url->link('account/download', '', 'SSL'));
		}
	}

}