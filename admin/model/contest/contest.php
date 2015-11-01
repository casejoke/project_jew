<?php
class ModelContestContest extends Model {
	public function addContest($data) {
		$this->event->trigger('pre.admin.contest.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "contest SET 
			type 			= '" . (int)$data['type'] . "',
			status 			= '" . (int)$data['status'] . "',
			maxprice 		= '" . (int)$data['maxprice'] . "',
			totalprice 		= '" . (int)$data['totalprice'] . "',
			date_start 		= '" . $this->db->escape($data['date_start']) . "',
			datetime_end 	= '" . $this->db->escape($data['datetime_end']) . "',
			date_rate 		= '" . $this->db->escape($data['date_rate']) . "',
			date_result 	= '" . $this->db->escape($data['date_result']) . "',
			date_finalist 	= '" . $this->db->escape($data['date_finalist']) . "'");

		$id = $this->db->getLastId();

		foreach ($data['contest_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contest_description SET 
				id 			= '" . (int)$id . "', 
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
		
		// связанные направления
		if (isset($data['contest_direction'])) {
		
			$lang_ids = array();
		
			foreach ($data['contest_direction'] as $language_id => $directions) {

				foreach ($directions as $k => $one_direction) {
				
					if (!empty($one_direction)){
				
						if (!isset($lang_ids[$k])){
							
							$this->db->query("INSERT INTO " . DB_PREFIX . "contest_direction SET 
								parent_id = '" . (int)$id . "'
							");
			
							$lang_ids[$k] = $this->db->getLastId();
						}
							
						$this->db->query("INSERT INTO " . DB_PREFIX . "contest_direction_description SET 
							id = '" . (int)$lang_ids[$k] . "', 
							language_id = '" . (int)$language_id . "', 
							title = '" .  $this->db->escape($one_direction) . "'
						");
					}					
				}
			}
		}
		
		// связанные файлы
		if (isset($data['contest_file']) && count($data['contest_file'])) {
		
			$data['contest_file'] = array_unique($data['contest_file']);
			
			foreach ($data['contest_file'] as $download_id) {
				
				if ($download_id > 0){
					
					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_file SET 
						file_id = '" . (int)$download_id . "', 
						parent_id = '" . (int)$id . "'");
				}	
			}
		}
		
		// связанные эксперты
		if (isset($data['contest_expert']) && count($data['contest_expert'])) {
		
			$data['contest_expert'] = array_unique($data['contest_expert']);
			
			foreach ($data['contest_expert'] as $expert_id) {
				
				if ($expert_id > 0){
					
					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_expert SET 
						user_id = '" . (int)$expert_id . "', 
						parent_id = '" . (int)$id . "'");
				}	
			}
		}
		
		// связанные критерии
		if (isset($data['contest_criteria'])) {
		
			$lang_ids = array();
			$weight = $data['contest_criteria']['weight'];
			unset($data['contest_criteria']['weight']);
		
			foreach ($data['contest_criteria'] as $language_id => $criterias) {

				foreach ($criterias['title'] as $k => $one_criteria) {
				
					if (!empty($one_criteria)){
				
						if (!isset($lang_ids[$k])){
							
							$this->db->query("INSERT INTO " . DB_PREFIX . "contest_criteria SET 
								parent_id = '" . (int)$id . "',
								weight = '" . (int)$weight[$k] . "'
							");
			
							$lang_ids[$k] = $this->db->getLastId();
						}
							
						$this->db->query("INSERT INTO " . DB_PREFIX . "contest_criteria_description SET 
							id = '" . (int)$lang_ids[$k] . "', 
							language_id = '" . (int)$language_id . "', 
							title = '" .  $this->db->escape($one_criteria) . "'
						");
					}					
				}
			}
		}

		$this->event->trigger('post.admin.contest.add', $id);

		return $id;
	}

	public function editContest($id, $data) {
		$this->event->trigger('pre.admin.contest.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "contest SET 
			type 			= '" . (int)$data['type'] . "',
			status 			= '" . (int)$data['status'] . "',
			maxprice 		= '" . (int)$data['maxprice'] . "',
			totalprice 		= '" . (int)$data['totalprice'] . "',
			date_start 		= '" . $this->db->escape($data['date_start']) . "',
			datetime_end 	= '" . $this->db->escape($data['datetime_end']) . "',
			date_rate 		= '" . $this->db->escape($data['date_rate']) . "',
			date_result 	= '" . $this->db->escape($data['date_result']) . "',
			date_finalist 	= '" . $this->db->escape($data['date_finalist']) . "'
			WHERE id = '" . (int)$id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_description WHERE id = '" . (int)$id . "'");

		foreach ($data['contest_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contest_description SET 
				id 			= '" . (int)$id . "', 
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
		
		// связанные направления
		
		$this->db->query("DELETE cd.*, cdd.* 
						  FROM " . DB_PREFIX . "contest_direction cd
						  LEFT JOIN " . DB_PREFIX . "contest_direction_description cdd
						  ON cd.id = cdd.id
						  WHERE parent_id = '" . (int)$id . "'");
		
		if (isset($data['contest_direction'])) {
		
			$lang_ids = array();
		
			foreach ($data['contest_direction'] as $language_id => $directions) {

				foreach ($directions as $k => $one_direction) {
				
					if (!empty($one_direction)){
				
						if (!isset($lang_ids[$k])){
							
							$this->db->query("INSERT INTO " . DB_PREFIX . "contest_direction SET 
								parent_id = '" . (int)$id . "'
							");
			
							$lang_ids[$k] = $this->db->getLastId();
						}
							
						$this->db->query("INSERT INTO " . DB_PREFIX . "contest_direction_description SET 
							id = '" . (int)$lang_ids[$k] . "', 
							language_id = '" . (int)$language_id . "', 
							title = '" .  $this->db->escape($one_direction) . "'
						");
					}					
				}
			}
		}
		
		// связанные файлы
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_file
						  WHERE parent_id = '" . (int)$id . "'");
						  
		if (isset($data['contest_file']) && count($data['contest_file'])) {
			
			foreach ($data['contest_file'] as $download_id) {
				
				if ($download_id > 0){
					
					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_file SET 
						file_id = '" . (int)$download_id . "', 
						parent_id = '" . (int)$id . "'");
				}					
			}
		}

		// связанные эксперты
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_expert
						  WHERE parent_id = '" . (int)$id . "'");
						  
		if (isset($data['contest_expert']) && count($data['contest_expert'])) {
			
			foreach ($data['contest_expert'] as $expert_id) {
				
				if ($expert_id > 0){
					
					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_expert SET 
						user_id = '" . (int)$expert_id . "', 
						parent_id = '" . (int)$id . "'");
				}	
			}
		}
		
		// связанные критерии
						  
		$this->db->query("DELETE cc.*, ccd.* 
						  FROM " . DB_PREFIX . "contest_criteria cc
						  LEFT JOIN " . DB_PREFIX . "contest_criteria_description ccd
						  ON cc.id = ccd.id
						  WHERE parent_id = '" . (int)$id . "'
						  ORDER BY cc.id ASC");
						  
		if (isset($data['contest_criteria'])) {
		
			$lang_ids = array();
			$weight = $data['contest_criteria']['weight'];
			unset($data['contest_criteria']['weight']);
		
			foreach ($data['contest_criteria'] as $language_id => $criterias) {

				foreach ($criterias['title'] as $k => $one_criteria) {
				
					if (!empty($one_criteria)){
				
						if (!isset($lang_ids[$k])){
							
							$this->db->query("INSERT INTO " . DB_PREFIX . "contest_criteria SET 
								parent_id = '" . (int)$id . "',
								weight = '" . (int)$weight[$k] . "'
							");
			
							$lang_ids[$k] = $this->db->getLastId();
						}
							
						$this->db->query("INSERT INTO " . DB_PREFIX . "contest_criteria_description SET 
							id = '" . (int)$lang_ids[$k] . "', 
							language_id = '" . (int)$language_id . "', 
							title = '" .  $this->db->escape($one_criteria) . "'
						");
					}					
				}
			}
		}

		$this->event->trigger('post.admin.contest.edit', $id);
	}

	public function deleteContest($id) {
		$this->event->trigger('pre.admin.contest.delete', $id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "contest WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_description WHERE id = '" . (int)$id . "'");
		$this->event->trigger('post.admin.contest.delete', $id);
	}
	public function copyContest($id){
		$this->event->trigger('pre.admin.contest.copy', $id);
		$query = $this->db->query("SELECT DISTINCT  * FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.id = dd.id) WHERE d.id = '" . (int)$id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		if ($query->num_rows) {
			$data = $query->row;
			$data['contest_description'] = $this->getContestDescriptions($id,true);
			$this->addContest($data);
		}
		$this->event->trigger('post.admin.contest.copy', $id);
	}
	public function getContest($id) {
		$query = $this->db->query("SELECT DISTINCT  *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'id=" . (int)$id . "') AS keyword FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.id = dd.id) WHERE d.id = '" . (int)$id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getContests($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.id = dd.id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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

	public function getContestDescriptions($id,$copy = false) {
		$contest_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_description WHERE id = '" . (int)$id . "'");
		
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
	
	// получение связанных с конкурсом направлений
	public function getContestdirections($id) {
		
		$directions = array();

		$query = $this->db->query("SELECT * 
								   FROM " . DB_PREFIX . "contest_direction cd,
								   		" . DB_PREFIX . "contest_direction_description cdd 
								   WHERE cd.parent_id = '" . (int)$id . "' AND cd.id = cdd.id
								   ORDER BY cd.id");
		
		foreach ($query->rows as $k => $result) {
		
			$directions[$result['id']][$result['language_id']] = $result;
		}

		return $directions;
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
	
	// получение связанных с конкурсом экспертов
	public function getContestExpert($id){
		
		$files = array();
		
		$query = $this->db->query("SELECT * 
								   FROM " . DB_PREFIX . "contest_expert");
		
		foreach ($query->rows as $result) {
		
			$files[] = $result['user_id'];
		}

		return $files;
	}
	
	// получение связанных с конкурсом критериев
	public function getContestCriteria($id) {
		
		$criteria = array();

		$query = $this->db->query("SELECT * 
								   FROM " . DB_PREFIX . "contest_criteria cc,
								   		" . DB_PREFIX . "contest_criteria_description ccd 
								   WHERE cc.parent_id = '" . (int)$id . "' AND cc.id = ccd.id");
		
		foreach ($query->rows as $result) {
		
			$criteria[$result['id']][$result['language_id']] = $result;
		}

		return $criteria;
	}
	
	public function getContestTypes(){
		
		return array('Открытый', 'По приглашению');
	}
	
	public function getContestStatuses(){
		
		return array('В работе', 'Активный', 'Закрыт', 'Завершен', 'Архив');
	}

	public function getTotalContests() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "contest");

		return $query->row['total'];
	}
}