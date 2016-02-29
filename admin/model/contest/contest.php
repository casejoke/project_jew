<?php
class ModelContestContest extends Model {
	public function addContest($data) {
		$this->event->trigger('pre.admin.contest.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "contest SET 
			image = '" . $this->db->escape($data['image']) . "',
			type 			= '" . (int)$data['type'] . "',
			status 			= '" . (int)$data['status'] . "',
			count_winner 			= '" . (int)$data['count_winner'] . "',
			contest_fields 	= '" . $this->db->escape(isset($data['custom_fields']) ? serialize($data['custom_fields']) : '') . "',
			maxprice 		= '" . $this->db->escape($data['maxprice']) . "',
			totalprice 		= '" . $this->db->escape($data['totalprice']) . "',
			date_start 		= '" . $this->db->escape($data['date_start']) . "',
			datetime_end 	= '" . $this->db->escape($data['datetime_end']) . "',
			date_rate 		= '" . $this->db->escape($data['date_rate']) . "',
			date_result 	= '" . $this->db->escape($data['date_result']) . "',
			date_finalist 	= '" . $this->db->escape($data['date_finalist']) . "'");

		$contest_id = $this->db->getLastId();

		foreach ($data['contest_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contest_description SET 
				contest_id 			= '" . (int)$contest_id . "', 
				language_id 		= '" . (int)$language_id . "', 
				title 				= '" . $this->db->escape($value['title']) . "',
				meta_title 			= '" . $this->db->escape($value['meta_title']) . "',
				meta_description 	= '" . $this->db->escape($value['meta_description']) . "',
				meta_keyword 		= '" . $this->db->escape($value['meta_keyword']) . "',
				organizer 			= '" . $this->db->escape($value['organizer']) . "',
				propose 			= '" . $this->db->escape($value['propose']) . "',
				location 			= '" . $this->db->escape($value['location']) . "',
				members 			= '" . $this->db->escape($value['members']) . "',
				description 		= '" . $this->db->escape($value['description']) . "',
				contacts 			= '" . $this->db->escape($value['contacts']) . "',
				timeline_text 		= '" . $this->db->escape($value['timeline_text']) . "'");
		}
		
		// связанные эксперты
		if (!empty($data['contest_experts'])) {
			foreach ($data['contest_experts'] as $contest_expert) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "contest_expert SET 
					customer_id = '" . (int)$contest_expert['customer_id'] . "',
					contest_id  = '" . (int)$contest_id . "'
					
				");
			}
		}
		// связанные критерии
		if (isset($data['contest_criteria'])) {
			foreach ($data['contest_criteria'] as $contest_criteria) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "contest_criteria SET 
					contest_id 	= '" . (int)$contest_id . "', 
					weight 		= '" . (int)$contest_criteria['weight'] . "',
					sort_order 	= '" . (int)$contest_criteria['sort_order'] . "'
				");

				$contest_criteria_id = $this->db->getLastId();

				foreach ($contest_criteria['contest_criteria_description'] as $language_id => $contest_criteria_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_criteria_description SET 
						contest_criteria_id = '" . (int)$contest_criteria_id . "', 
						contest_id  = '" . (int)$contest_id . "',
						language_id = '" . (int)$language_id . "', 
						title = '" .  $this->db->escape($contest_criteria_description['title']) . "'
					");
				}
			}
		}
		// связанные направления
	  	if (isset($data['contest_direction'])) {
	      foreach ($data['contest_direction'] as $contest_direction) {
	        $this->db->query("INSERT INTO " . DB_PREFIX . "contest_direction SET 
	          contest_id  = '" . (int)$contest_id . "', 
	          sort_order  = '" . (int)$contest_direction['sort_order'] . "'
	        ");

	        $contest_direction_id = $this->db->getLastId();

	        foreach ($contest_direction['contest_direction_description'] as $language_id => $contest_direction_description) {
	          $this->db->query("INSERT INTO " . DB_PREFIX . "contest_direction_description SET 
	            contest_direction_id = '" . (int)$contest_direction_id . "', 
	            contest_id  = '" . (int)$contest_id . "',
	            language_id = '" . (int)$language_id . "', 
	            title = '" .  $this->db->escape($contest_direction_description['title']) . "'
	          ");
	        }
	      }
	    }	 

	    // связанные файлы
		if (!empty($data['contest_downloads'])) {
			foreach ($data['contest_downloads'] as $contest_download) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "contest_download SET 
					download_id = '" . (int)$contest_download['download_id'] . "',
					contest_id  = '" . (int)$contest_id . "'
				");
			}
		} 

		$this->event->trigger('post.admin.contest.add', $id);

		return $contest_id;
	}

	public function editContest($contest_id, $data) {
		$this->event->trigger('pre.admin.contest.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "contest SET 
			image = '" . $this->db->escape($data['image']) . "',
			type 			= '" . (int)$data['type'] . "',
			status 			= '" . (int)$data['status'] . "',
			maxprice 		= '" . $this->db->escape($data['maxprice']) . "',
			totalprice 		= '" . $this->db->escape($data['totalprice']) . "',
			count_winner 			= '" . (int)$data['count_winner'] . "',
			contest_fields = '" . $this->db->escape(isset($data['custom_fields']) ? serialize($data['custom_fields']) : '') . "',
			date_start 		= '" . $this->db->escape($data['date_start']) . "',
			datetime_end 	= '" . $this->db->escape($data['datetime_end']) . "',
			date_rate 		= '" . $this->db->escape($data['date_rate']) . "',
			date_result 	= '" . $this->db->escape($data['date_result']) . "',
			date_finalist 	= '" . $this->db->escape($data['date_finalist']) . "'
			WHERE contest_id = '" . (int)$contest_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_description WHERE contest_id = '" . (int)$contest_id . "'");

		foreach ($data['contest_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contest_description SET 
				contest_id 			= '" . (int)$contest_id . "', 
				language_id 		= '" . (int)$language_id . "', 
				title 				= '" . $this->db->escape($value['title']) . "',
				meta_title 			= '" . $this->db->escape($value['meta_title']) . "',
				meta_description 	= '" . $this->db->escape($value['meta_description']) . "',
				meta_keyword 		= '" . $this->db->escape($value['meta_keyword']) . "',
				organizer 			= '" . $this->db->escape($value['organizer']) . "',
				propose 			= '" . $this->db->escape($value['propose']) . "',
				location 			= '" . $this->db->escape($value['location']) . "',
				members 			= '" . $this->db->escape($value['members']) . "',
				description 		= '" . $this->db->escape($value['description']) . "',
				contacts 			= '" . $this->db->escape($value['contacts']) . "',
				timeline_text 		= '" . $this->db->escape($value['timeline_text']) . "'");
		}

		// связанные эксперты
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_expert WHERE contest_id = '" . (int)$contest_id . "'");
		if (isset($data['contest_experts'])) {
			foreach ($data['contest_experts'] as $contest_expert) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "contest_expert SET 
					customer_id = '" . (int)$contest_expert['customer_id'] . "',
					contest_id  = '" . (int)$contest_id . "'
					
				");
			}
		}


		// связанные критерии
		if (isset($data['contest_criteria'])) {
			//подтянем старые значения критерия
			$old_criteria_results = $this->getContestCriteria($contest_id); 

			
			$new_creiteria = array();

			foreach ($data['contest_criteria'] as $contest_criteria) {

				if(!empty($contest_criteria['contest_criteria_id'])){

					$contest_criteria_id = $contest_criteria['contest_criteria_id'];
					$new_creiteria[$contest_criteria_id] = $contest_criteria_id ;
					
					$this->db->query("UPDATE " . DB_PREFIX . "contest_criteria SET 
						contest_id 	= '" . (int)$contest_id . "', 
						weight 		= '" . (int)$contest_criteria['weight'] . "',
						sort_order 	= '" . (int)$contest_criteria['sort_order'] . "'
						WHERE contest_criteria_id = '" . (int)$contest_criteria_id . "'
					");
						foreach ($contest_criteria['contest_criteria_description'] as $language_id => $contest_criteria_description) {
							$this->db->query("UPDATE " . DB_PREFIX . "contest_criteria_description SET 
								contest_criteria_id = '" . (int)$contest_criteria_id . "', 
								contest_id  = '" . (int)$contest_id . "',
								language_id = '" . (int)$language_id . "', 
								title = '" .  $this->db->escape($contest_criteria_description['title']) . "'
							WHERE contest_criteria_id = '" . (int)$contest_criteria_id . "'");
						}
					
				}else{

					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_criteria SET 
						contest_id 	= '" . (int)$contest_id . "', 
						weight 		= '" . (int)$contest_criteria['weight'] . "',
						sort_order 	= '" . (int)$contest_criteria['sort_order'] . "'
					");
					$contest_criteria_id = $this->db->getLastId();

					foreach ($contest_criteria['contest_criteria_description'] as $language_id => $contest_criteria_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "contest_criteria_description SET 
							contest_criteria_id = '" . (int)$contest_criteria_id . "', 
							contest_id  = '" . (int)$contest_id . "',
							language_id = '" . (int)$language_id . "', 
							title = '" .  $this->db->escape($contest_criteria_description['title']) . "'
						");
					}
					
				}


			}
			
			$diff_critteria_old_new = array_diff_key($old_criteria_results, $new_creiteria);
			if(!empty($diff_critteria_old_new)){
				foreach ($diff_critteria_old_new as $vadk) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "contest_criteria WHERE contest_criteria_id = '" . (int)$vadk['contest_criteria_id'] . "'");
					$this->db->query("DELETE FROM " . DB_PREFIX . "contest_criteria_description WHERE contest_criteria_id = '" . (int)$vadk['contest_criteria_id'] . "'");
				}
			}
		}	

	// связанные направления	
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_direction WHERE contest_id = '" . (int)$contest_id . "'");
    $this->db->query("DELETE FROM " . DB_PREFIX . "contest_direction_description WHERE contest_id = '" . (int)$contest_id . "'");
	    if (isset($data['contest_direction'])) {
	      foreach ($data['contest_direction'] as $contest_direction) {
	        $this->db->query("INSERT INTO " . DB_PREFIX . "contest_direction SET 
	          contest_id  = '" . (int)$contest_id . "', 
	          sort_order  = '" . (int)$contest_direction['sort_order'] . "'
	        ");

	        $contest_direction_id = $this->db->getLastId();

	        foreach ($contest_direction['contest_direction_description'] as $language_id => $contest_direction_description) {
	          $this->db->query("INSERT INTO " . DB_PREFIX . "contest_direction_description SET 
	            contest_direction_id = '" . (int)$contest_direction_id . "', 
	            contest_id  = '" . (int)$contest_id . "',
	            language_id = '" . (int)$language_id . "', 
	            title = '" .  $this->db->escape($contest_direction_description['title']) . "'
	          ");
	        }
	      }
	    }	  
		
		  // связанные файлы
		  $this->db->query("DELETE FROM " . DB_PREFIX . "contest_download WHERE contest_id = '" . (int)$contest_id . "'");
			if (!empty($data['contest_downloads'])) {
				foreach ($data['contest_downloads'] as $contest_download) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_download SET 
						download_id = '" . (int)$contest_download['download_id'] . "',
						contest_id  = '" . (int)$contest_id . "'
					");
				}
			} 
		$this->event->trigger('post.admin.contest.edit', $contest_id);
	}

	public function deleteContest($contest_id) {
		$this->event->trigger('pre.admin.contest.delete', $contest_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "contest WHERE contest_id = '" . (int)$contest_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_description WHERE contest_id = '" . (int)$contest_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_expert WHERE contest_id = '" . (int)$contest_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_download WHERE contest_id = '" . (int)$contest_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_criteria WHERE contest_id = '" . (int)$contest_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_criteria_description WHERE contest_id = '" . (int)$contest_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_direction WHERE contest_id = '" . (int)$contest_id . "'");
    $this->db->query("DELETE FROM " . DB_PREFIX . "contest_direction_description WHERE contest_id = '" . (int)$contest_id . "'");
		$this->event->trigger('post.admin.contest.delete', $contest_id);
	}

	public function copyContest($contest_id){
		$this->event->trigger('pre.admin.contest.copy', $contest_id);
		$query = $this->db->query("SELECT DISTINCT  * FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.contest_id = dd.contest_id) WHERE d.contest_id = '" . (int)$contest_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		if ($query->num_rows) {
			$data = $query->row;
			$data['contest_description'] = $this->getContestDescriptions($contest_id,true);
			$this->addContest($data);
		}
		$this->event->trigger('post.admin.contest.copy', $contest_id);
	}

	public function addRequest($data=array(),$customer_id){

	}



	public function getContest($contest_id) {
		$query = $this->db->query("SELECT DISTINCT  *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'contest_id=" . (int)$contest_id . "') AS keyword FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.contest_id = dd.contest_id) WHERE d.contest_id = '" . (int)$contest_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getContests($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.contest_id = dd.contest_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		$sort_data = array(
			'dd.title',
			'd.date_start'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY d.date_start";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalContests() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "contest");

		return $query->row['total'];
	}

	public function getContestDescriptions($contest_id,$copy = false) {
		$contest_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_description WHERE contest_id = '" . (int)$contest_id . "'");
		
		foreach ($query->rows as $result) {
			
			foreach($result as $k => $v){
			
				$contest_description_data[$result['language_id']][$k] = $v;
			}
			
			if ($copy){
				
				$contest_description_data[$result['language_id']][$k] = 'copy_' . $contest_description_data[$result['language_id']]['title'];
			}
		}

		return $contest_description_data;
	}
	// получение связанных с конкурсом экспертов
	public function getContestExpert($contest_id) {
		
		$contest_expert = array();
		$contest_expert_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_expert WHERE contest_id = '" . (int)$contest_id . "'");
		if (!empty($contest_expert_query->rows)) {
			$sql = "SELECT * , CONCAT(lastname, ' ', firstname) AS name FROM " . DB_PREFIX . "customer";
			$implode = array();
			
			foreach ($contest_expert_query->rows as $customer_id) {
				$implode[] = (int)$customer_id['customer_id'];
			}

			$sql .= " WHERE customer_id IN (" . implode(',', $implode) . ")";
			$query = $this->db->query($sql);
			$contest_expert = $query->rows;
		}
		
		return $contest_expert;
	}
	//получение связанных файлов
	public function getContestDownload($contest_id) {
		
		$contest_download = array();
		$contest_download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_download WHERE contest_id = '" . (int)$contest_id . "'");


		if (!empty($contest_download_query->rows)) {
			$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			$implode = array();
			
			foreach ($contest_download_query->rows as $download_id) {
				$implode[] = (int)$download_id['download_id'];
			}

			$sql .= " AND d.download_id IN (" . implode(',', $implode) . ")";
			$query = $this->db->query($sql);

			$contest_download = $query->rows;
		}
		
		return $contest_download;
	}
	
	// получение связанных с конкурсом критериев
	public function getContestCriteria($contest_id) {
		$contest_criteria_data = array();
		
		$contest_criteria_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_criteria WHERE contest_id = '" . (int)$contest_id . "' ORDER BY sort_order ASC");
		
		foreach ($contest_criteria_query->rows as $contest_criteria) {
			$contest_criteria_description_data = array();
			 
			$contest_criteria_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_criteria_description WHERE contest_criteria_id = '" . (int)$contest_criteria['contest_criteria_id'] . "' AND contest_id = '" . (int)$contest_id . "'");
			
			foreach ($contest_criteria_description_query->rows as $contest_criteria_description) {			
				$contest_criteria_description_data[$contest_criteria_description['language_id']] = array(
					'title' => $contest_criteria_description['title']
				);
			}
		
			$contest_criteria_data[$contest_criteria['contest_criteria_id']] = array(
				'contest_criteria_id'			    => $contest_criteria['contest_criteria_id'],
				'contest_criteria_description'  	=> $contest_criteria_description_data,
				'weight'                     		=> $contest_criteria['weight'],
				'sort_order'			    		=> $contest_criteria['sort_order']
			);
		}
		
		return $contest_criteria_data;
	}

	// получение связанных с конкурсом направлений
	public function getContestDirection($contest_id) {
	    $contest_direction_data = array();
	    
	    $contest_direction_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_direction WHERE contest_id = '" . (int)$contest_id . "' ORDER BY sort_order ASC");
	    
	    foreach ($contest_direction_query->rows as $contest_direction) {
	      $contest_direction_description_data = array();
	       
	      $contest_direction_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_direction_description WHERE contest_direction_id = '" . (int)$contest_direction['contest_direction_id'] . "' AND contest_id = '" . (int)$contest_id . "'");
	      
	      foreach ($contest_direction_description_query->rows as $contest_direction_description) {      
	        $contest_direction_description_data[$contest_direction_description['language_id']] = array(
	          'title' => $contest_direction_description['title']
	        );
	      }
	    
	      $contest_direction_data[] = array(
	        'contest_direction_description'    => $contest_direction_description_data,
	        'sort_order'          => $contest_direction['sort_order']
	      );
	    }
	    
	    return $contest_direction_data;
	}

	
	// получение связанных с конкурсом файлов
	public function getContestFile($id){
		
		$files = array();
		
		$query = $this->db->query("SELECT * 
								   FROM " . DB_PREFIX . "contest_file");
		
		foreach ($query->rows as $result) {
		
			$files[] = $result['file_id'];
		}

		return $files;
	}

	public function getContestTypes(){
		$data_contest_types = array();
		$data_contest_types[] = array(
			'contest_type_id' => 1,
			'contest_type_title' => 'Открытый'
		);
		$data_contest_types[] = array(
			'contest_type_id' => 2,
			'contest_type_title' => 'По приглашению'
		);
		$data_contest_types[] = array(
			'contest_type_id' => 3,
			'contest_type_title' => 'Best Practice'
		);
		return $data_contest_types;
	}
	
	public function getContestStatuses(){
		$data_contest_status = array();
		$data_contest_status[] = array(
			'contest_status_id' => 0,
			'contest_status_title' => 'В работе'
		);
		$data_contest_status[] = array(
			'contest_status_id' => 1,
			'contest_status_title' => 'Активный'
		);
		$data_contest_status[] = array(
			'contest_status_id' => 2,
			'contest_status_title' => 'Архив'
		);
		return $data_contest_status;
	}

	public function getRequestsForWinnerList($data = array()) {

		if(empty($data)){
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest";
		}else{
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest WHERE";
		}

		$_str =array();

		if (!empty($data['filter_contest_id'])) {
			$_str[] =	" contest_id = '" . (int)$data['filter_contest_id'] . "'";
		}
		
		if (!empty($data['filter_status_id'])) {
			$_str[] = " status = '" . (int)$data['filter_status_id'] . "'";
		}
		
		
		$_sql = '' ;
		$i = 0;
		foreach ($_str as $vstr) {
			if($i > 0){
				$_sql .= ' AND'.$vstr;
			}else{
				$_sql .= $vstr;
			}
			$i++;
		}
		
		$query = $this->db->query($sql.$_sql);

		return $query->rows;
	}

	public function getEstimateForWinnerList($data = array()){
		if(empty($data)){
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_estimate";
		}else{
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_estimate WHERE";
		}

		$_str =array();

		if (!empty($data['filter_contest_id'])) {
			$_str[] =	" contest_id = '" . (int)$data['filter_contest_id'] . "'";
		}
		
		if (!empty($data['filter_status_id'])) {
			$_str[] = " status = '" . (int)$data['filter_status_id'] . "'";
		}
		
		
		$_sql = '' ;
		$i = 0;
		foreach ($_str as $vstr) {
			if($i > 0){
				$_sql .= ' AND'.$vstr;
			}else{
				$_sql .= $vstr;
			}
			$i++;
		}
		
		$query = $this->db->query($sql.$_sql);

		return $query->rows;
	}

	public function addWinner($data = array()){
		//инфо о конкурсе
		$contest_info = $this->getContest((int)$data['contest_id']);
		$this->db->query("INSERT INTO " . DB_PREFIX . "contest_winner SET 
			request_id 		= '" . (int)$data['request_id'] . "',
			contest_id 		= '" . (int)$data['contest_id'] . "',
			contest_type_id = '" . $contest_info['type'] . "',
			customer_id 	= '" . (int)$data['customer_id'] . "',
			project_id		= '" . (int)$data['project_id'] . "',	
			place_id 		= '" . (int)$data['place_id'] . "',
			date_added 		= NOW()
		");

	}
	public function removeWinner($data = array()){
		//инфо о конкурсе
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_winner WHERE 
			request_id 		= '" . (int)$data['request_id'] . "'
		");

	}

	public function getWinners($data = array()){
		if(empty($data)){
			$sql = "SELECT * FROM " . DB_PREFIX . "contest_winner";
		}else{
			$sql = "SELECT * FROM " . DB_PREFIX . "contest_winner WHERE";
		}

		$_str =array();

		if (!empty($data['filter_contest_id'])) {
			$_str[] =	" contest_id = '" . (int)$data['filter_contest_id'] . "'";
		}
		
		if (!empty($data['filter_request_id'])) {
			$_str[] = " request_id = '" . (int)$data['filter_request_id'] . "'";
		}
		
		
		$_sql = '' ;
		$i = 0;
		foreach ($_str as $vstr) {
			if($i > 0){
				$_sql .= ' AND'.$vstr;
			}else{
				$_sql .= $vstr;
			}
			$i++;
		}
		
		$query = $this->db->query($sql.$_sql);

		return $query->rows;
	}







	
}