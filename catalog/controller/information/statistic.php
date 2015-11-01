<?php 
class ControllerInformationStatistic extends Controller {
	private $error = array();

	public function index() {

		$this->language->load('information/statistic');
		$this->load->model('catalog/statistic');
		$this->load->model('catalog/season');
		$this->load->model('catalog/occasion_group');
		//получим активный сезон 
		$season_active = $this->model_catalog_season->getActiveSeason();
		$data['heading_title'] = sprintf($this->language->get('heading_title'), $season_active['title']);
		$this->document->setTitle($data['heading_title']);
		
		//получаем список игроков
		$filter_data = array(
			'filter_status' => 1
		);

		$list_customers = $this->model_catalog_statistic->getCustomers($filter_data);
		
		$result_list_customers 	=	array();
		foreach ($list_customers as $customer) {
			$result_list_customers[$customer['customer_id']] = array(
				'customer_id' 	=> $customer['customer_id'],
				'name' 			=>$customer['name']
			);

		}

		//получим разбивку по типам
		//получаем активные форматы
		$occasion_group_active = $this->model_catalog_occasion_group->getActiveOccasionGroup();
		$data['occasion_groups'] = array();
		foreach ($occasion_group_active as $occasion_group) {
			$data['occasion_groups'][] = array(
				'occasion_group_id' => $occasion_group['occasion_group_id'],
				'occasion_title' 	=> $occasion_group['title']
			);
		}

		//получим статистику для данного сезона

		$season_id 	=	$season_active['season_id'];
		$list_statistics = $this->model_catalog_statistic->getStatisticForSeason($season_id);

		

		$result_list_statistics = array();
		foreach ($data['occasion_groups'] as $occasion_group) {
			foreach ($list_statistics as $stat) {
				if($stat['occasion_group_id'] == $occasion_group['occasion_group_id']){
					$result_group_list_statistics[$stat['occasion_group_id']][] = array(
						'customer_id'		=>$stat['customer_id'],
						'occasion_id'		=>$stat['occasion_id'],
						'occasion_group_id'	=>$stat['occasion_group_id'],					//игровые дни
						'goal' 				=> $stat['goal'],		//гол
			            'pass' 				=> $stat['pass'],		//пасс
			            'mvp'  				=> $stat['mvp']			//игрок дня
			        );
				} 
			}
		}



		$final_list_statistics = array();
		foreach ($data['occasion_groups'] as $occasion_group) {
			if(!empty($result_group_list_statistics[$occasion_group['occasion_group_id']])){
				/**************************************************************************/
				foreach ($result_group_list_statistics[$occasion_group['occasion_group_id']] as $value_stat) {
					/**************************************************************************/
					if(!empty($final_list_statistics[$occasion_group['occasion_group_id']][$value_stat['customer_id']] )){
    					/**************************************************************************/
			          	$final_list_statistics[$occasion_group['occasion_group_id']][$value_stat['customer_id']] = array(
			            	'customer_id'=>$value_stat['customer_id'],
			            	'customer_name' 	=> $result_list_customers[$value_stat['customer_id']]['name'],
			            	'day'   => ($final_list_statistics[$occasion_group['occasion_group_id']][$value_stat['customer_id']]['day']+1),         //игровые дни
			            	'goal'  => $final_list_statistics[$occasion_group['occasion_group_id']][$value_stat['customer_id']]['goal'] + $value_stat['goal'],    //гол
			                'pass'  => $final_list_statistics[$occasion_group['occasion_group_id']][$value_stat['customer_id']]['pass'] + $value_stat['pass'],    //пасс
			                'mvp'   => $final_list_statistics[$occasion_group['occasion_group_id']][$value_stat['customer_id']]['mvp']  + $value_stat['mvp']      //игрок дня
		              	);
			        } else{
			          	$final_list_statistics[$occasion_group['occasion_group_id']][$value_stat['customer_id']]= array(
				            'customer_id'		=>$value_stat['customer_id'],
				            'customer_name' 	=> $result_list_customers[$value_stat['customer_id']]['name'],
				            'day'   => 1,         //игровые дни
				            'goal'  => $value_stat['goal'],   //гол
				            'pass'  => $value_stat['pass'],   //пасс
				            'mvp'   => $value_stat['mvp']     //игрок дня
		              	);
		              	/**************************************************************************/
			        }
					/**************************************************************************/
				}
				/**************************************************************************/
			}
			
		}
		
		$data['list_statistics'] = array();
		foreach ($final_list_statistics as $k => $va) {
			foreach ($va as  $fs) {
				$data['list_statistics_score'][$k][$fs['customer_id']] =  ($fs['goal']+$fs['pass']);

		 		$data['list_statistics'][$k][$fs['customer_id']] = array(
					'customer_id'		=> $fs['customer_id'],
		            'customer_name' 	=> $fs['customer_name'],
		            'day'   			=> $fs['day'],         
		            'goal'  			=> $fs['goal'],  
		            'pass'  			=> $fs['pass'], 
		            'mvp'   			=> $fs['mvp'],
		            'score'				=> $fs['goal']+$fs['pass']
		 		);
			}
		}
	 	foreach ($data['list_statistics_score'] as $k_score => $v_score) {
	 		arsort($data['list_statistics_score'][$k_score]);
	 	}
	 	

	 	$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');




		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/statistics_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/statistics_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/statistics_list.tpl', $data));
		}

	}
	
	
}
function  custom_sort($a,$b){
		return strtolower($a['score']) > strtolower($b['score']);
	}