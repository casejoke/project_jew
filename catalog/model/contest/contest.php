<?php
class ModelContestContest extends Model {

	public function getContest($contest_id) {
		$query = $this->db->query("SELECT DISTINCT  *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'contest_id=" . (int)$contest_id . "') AS keyword FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.contest_id = dd.contest_id) WHERE d.contest_id = '" . (int)$contest_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getContestDescriptions($contest_id) {
		$contest_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_description WHERE contest_id = '" . (int)$contest_id . "'");
		
		foreach ($query->rows as $result) {
			$contest_description_data[$result['language_id']] = array(
				'title' 		   => $result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $contest_description_data;
	}

	public function getContestsForAdmin($customer_id) {
		$query = $this->db->query("SELECT   * FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.contest_id = dd.contest_id) WHERE d.customer_id = '" . (int)$customer_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->rows;
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

	public function getInviteContests($data = array()) {

		$sql = "SELECT   * FROM " . DB_PREFIX . "customer_to_contest ";

		$implode = array();

		if (!empty($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_customer_id'])) {
			$implode[] = "customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (!empty($data['filter_contest_id'])) {
			$implode[] = "contest_id = '" . (int)$data['filter_contest_id'] . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}

	
	public function inviteCustomer($data){
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_to_contest SET 
			contest_id = '" . (int)$data['contest_id'] . "',
			customer_id = '" . (int)$data['customer_id'] . "',
			status = '" . (int)$data['status'] . "',
			date_added = NOW()"
		);
	}

	public function inviteAgree($data){
		$this->db->query("UPDATE " . DB_PREFIX . "customer_to_contest SET
			status = '1'
			WHERE contest_id = '" . (int)$data['contest_id'] . "' AND customer_id = '" . (int)$data['customer_id'] . "'"
		);
	}
	public function uninviteCustomer($data){
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_to_contest WHERE 
			contest_id = '" . (int)$data['contest_id'] . "' AND customer_id = '" . (int)$data['customer_id'] . "'"
		);
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
		
			$contest_criteria_data[] = array(
				'contest_criteria_description'  	=> $contest_criteria_description_data,
				'weight'                     		=> $contest_criteria['weight'],
				'sort_order'			    => $contest_criteria['sort_order']
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



}