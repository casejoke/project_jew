<?php
class ModelProjectProject extends Model {

	public function addProject($data,$customer_id) {
		$this->event->trigger('pre.customer.project.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "project SET 
			customer_id = '" . (int)$customer_id . "',
			image = '" . $this->db->escape($data['image']) . "',
			project_birthday = '" . $this->db->escape($data['project_birthday']) . "',
			project_init_group_id = '" . (int)$data['project_init_group_id']. "', 
			project_status_id = '" . (int)$data['project_status_id']. "', 
			visibility = '" . (int)$data['project_visibility']. "', 
			project_relation_id = '" . (int)$data['project_relation_id']. "', 
			project_age = '" . (isset($data['age_status']) ? $this->db->escape(serialize($data['age_status'])) : '') . "',
			project_sex = '" . (isset($data['sex_status']) ? $this->db->escape(serialize($data['sex_status'])) : '') . "',
			project_nationality = '" . (isset($data['nationality_status']) ? $this->db->escape(serialize($data['nationality_status'])) : '') . "',
			project_professional = '" . (isset($data['professional_status']) ? $this->db->escape(serialize($data['professional_status'])) : '') . "',
			project_demographic = '" . (isset($data['demographic_status']) ? $this->db->escape(serialize($data['demographic_status'])) : '') . "',
			project_budget = '" . (int)$data['project_budget']. "', 
			project_currency_id = '" . (int)$data['project_currency_id']. "',
			date_added = NOW()"
		);

		$project_id = $this->db->getLastId();

		foreach ($data['project_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "project_description SET 
				project_id = '" . (int)$project_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "',
				description = '" . $this->db->escape($value['description']) . "',
				target = '" . $this->db->escape($value['target']) . "',
				product = '" . $this->db->escape($value['product']) . "',
				result = '" . $this->db->escape($value['result']) . "'"
			);
			/*
				visibility = '" . (int)$data['visibility'] . "',
			status = '" . (int)$data['status'] . "',
	
			
				meta_title = '" . $this->db->escape($value['meta_title']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'*/
		}

		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
				query = 'project_id=" . (int)$occasion_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}
		return $project_id;

	}
	public function addProjectI($data,$customer_id) {
		$this->event->trigger('pre.customer.project.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "project SET 
			customer_id = '" . (int)$customer_id . "',
			project_mod_id = '" . (int)$data['project_mod_id']. "',
			image = '" . $this->db->escape($data['image']) . "',
			project_birthday = '" . $this->db->escape($data['project_birthday']) . "',
			project_init_group_id = '" . (int)$data['project_init_group_id']. "', 
			project_status_id = '" . (int)$data['project_status_id']. "', 
			visibility = '" . (int)$data['project_visibility']. "', 
			project_relation_id = '" . (int)$data['project_relation_id']. "', 
			project_age = '" . (isset($data['age_status']) ? $this->db->escape(serialize($data['age_status'])) : '') . "',
			project_sex = '" . (isset($data['sex_status']) ? $this->db->escape(serialize($data['sex_status'])) : '') . "',
			project_nationality = '" . (isset($data['nationality_status']) ? $this->db->escape(serialize($data['nationality_status'])) : '') . "',
			project_professional = '" . (isset($data['professional_status']) ? $this->db->escape(serialize($data['professional_status'])) : '') . "',
			project_demographic = '" . (isset($data['demographic_status']) ? $this->db->escape(serialize($data['demographic_status'])) : '') . "',
			project_budget = '" . (int)$data['project_budget']. "', 
			project_currency_id = '" . (int)$data['project_currency_id']. "',
			date_added = NOW()"
		);

		$project_id = $this->db->getLastId();

		foreach ($data['project_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "project_description SET 
				project_id = '" . (int)$project_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "',
				description = '" . $this->db->escape($value['description']) . "',
				target = '" . $this->db->escape($value['target']) . "',
				product = '" . $this->db->escape($value['product']) . "',
				result = '" . $this->db->escape($value['result']) . "'"
			);
			/*
				visibility = '" . (int)$data['visibility'] . "',
			status = '" . (int)$data['status'] . "',
	
			
				meta_title = '" . $this->db->escape($value['meta_title']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'*/
		}

		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
				query = 'project_id=" . (int)$occasion_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}

		return $project_id;
	}
	public function editProject($project_id, $data,$customer_id) {
		$this->event->trigger('pre.customer.project.edit', $data);
		$this->db->query("UPDATE " . DB_PREFIX . "project SET 
			customer_id = '" . (int)$customer_id . "',
			image = '" . $this->db->escape($data['image']) . "',
			project_birthday = '" . $this->db->escape($data['project_birthday']) . "',
			project_init_group_id = '" . (int)$data['project_init_group_id']. "', 
			project_status_id = '" . (int)$data['project_status_id']. "', 
			visibility = '" . (int)$data['project_visibility']. "', 
			project_relation_id = '" . (int)$data['project_relation_id']. "', 
			project_age = '" . (isset($data['age_status']) ? $this->db->escape(serialize($data['age_status'])) : '') . "',
			project_sex = '" . (isset($data['sex_status']) ? $this->db->escape(serialize($data['sex_status'])) : '') . "',
			project_nationality = '" . (isset($data['nationality_status']) ? $this->db->escape(serialize($data['nationality_status'])) : '') . "',
			project_professional = '" . (isset($data['professional_status']) ? $this->db->escape(serialize($data['professional_status'])) : '') . "',
			project_demographic = '" . (isset($data['demographic_status']) ? $this->db->escape(serialize($data['demographic_status'])) : '') . "',
			project_budget = '" . (int)$data['project_budget']. "', 
			project_currency_id = '" . (int)$data['project_currency_id']. "'
			WHERE project_id = '" . (int)$project_id . "'"
		);

		$this->db->query("DELETE FROM " . DB_PREFIX . "project_description WHERE project_id = '" . (int)$project_id . "'");
		foreach ($data['project_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "project_description SET 
				project_id = '" . (int)$project_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "',
				description = '" . $this->db->escape($value['description']) . "',
				target = '" . $this->db->escape($value['target']) . "',
				product = '" . $this->db->escape($value['product']) . "',
				result = '" . $this->db->escape($value['result']) . "'"
			);
			/*
				visibility = '" . (int)$data['visibility'] . "',
			status = '" . (int)$data['status'] . "',
	
			description = '" . $this->db->escape($value['description']) . "', 
				meta_title = '" . $this->db->escape($value['meta_title']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'*/
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'project_id=" . (int)$project_id . "'");
		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
				query = 'project_id=" . (int)$project_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}

	}
	public function getProject($project_id) {
		$query = $this->db->query("SELECT DISTINCT  *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'project_id=" . (int)$project_id . "') AS keyword FROM " . DB_PREFIX . "project d LEFT JOIN " . DB_PREFIX . "project_description dd ON (d.project_id = dd.project_id) WHERE d.project_id = '" . (int)$project_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getProjectDescriptions($project_id) {
		$project_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "project_description WHERE project_id = '" . (int)$project_id . "'");
		
		foreach ($query->rows as $result) {
			$project_description_data[$result['language_id']] = array(
				'title' 		   => $result['title'],
				'description'      => $result['description'],
				'target'      	   => $result['target'],
				'product'     	   => $result['product'],
				'result'      	   => $result['result'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $project_description_data;
	}

	public function getProjectsForAdmin($customer_id) {
		$query = $this->db->query("SELECT   * FROM " . DB_PREFIX . "project d LEFT JOIN " . DB_PREFIX . "project_description dd ON (d.project_id = dd.project_id) WHERE d.customer_id = '" . (int)$customer_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->rows;
	}

	public function getProjects() {
		$query = $this->db->query("SELECT   * FROM " . DB_PREFIX . "project d LEFT JOIN " . DB_PREFIX . "project_description dd ON (d.project_id = dd.project_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->rows;
	}

	public function getListProjects($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "project d LEFT JOIN " . DB_PREFIX . "project_description dd ON (d.project_id = dd.project_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";



		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		$sort_data = array(
			'dd.title',
			'd.date_start'
		);

		if (!empty($data['filter_contest_id'])) {
			
			if(count($data['filter_contest_id']) > 1){
				$_str[] .= " contest_id IN (" . implode(',', $data['filter_contest_id']) . ")";
			}else{
				//если один конкурс
				$contest_id = $data['filter_contest_id'][0];
				$_str[] .= " contest_id = '" . (int)$contest_id . "'";
			}
		} else{
			//$_str[] .= " contest_id = '0'";
		}

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$_str[] .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY d.date_added";
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

	public function getInviteProjects($data = array()) {

		$sql = "SELECT   * FROM " . DB_PREFIX . "customer_to_project ";

		$implode = array();

		if (!empty($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_customer_id'])) {
			$implode[] = "customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (!empty($data['filter_project_id'])) {
			$implode[] = "project_id = '" . (int)$data['filter_project_id'] . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}

	
	public function inviteCustomer($data){
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_to_project SET 
			project_id = '" . (int)$data['project_id'] . "',
			customer_id = '" . (int)$data['customer_id'] . "',
			status = '" . (int)$data['status'] . "',
			date_added = NOW()"
		);
	}

	public function inviteAgree($data){
		$this->db->query("UPDATE " . DB_PREFIX . "customer_to_project SET
			status = '1'
			WHERE project_id = '" . (int)$data['project_id'] . "' AND customer_id = '" . (int)$data['customer_id'] . "'"
		);
	}
	public function uninviteCustomer($data){
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_to_project WHERE 
			project_id = '" . (int)$data['project_id'] . "' AND customer_id = '" . (int)$data['customer_id'] . "'"
		);
	}
	public function getProjectsForAdaptive($customer_id){

		$sql = "SELECT * FROM " . DB_PREFIX . "contest_adaptor WHERE customer_id != '".(int)$customer_id."' ";
		//получаю проекты для адаптации исключая свои
		$query = $this->db->query($sql);
		
		return $query->rows;
		
	}

	public function getListAdapiveProjects($data =array()){

		
		if(empty($data)){
			$sql = "SELECT * FROM " . DB_PREFIX . "contest_adaptor";
		}else{
			$sql = "SELECT * FROM " . DB_PREFIX . "contest_adaptor WHERE";
		}

		$_str =array();

		
		if (!empty($data['filter_customer_id'])) {
			$_str[] =	" customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (!empty($data['filter_contest_id'])) {
			$_str[] = "contest_id = '" . (int)$data['filter_contest_id'] . "'";
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



	public function getProjectsFromRequestForContest($customer_id,$contest_id){
		//получим список проектов для адптации  из заявок для данного конкурса
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest WHERE customer_id = '".(int)$customer_id."' AND contest_id = '".(int)$contest_id."'";
		$query = $this->db->query($sql);
		
		return $query->rows;
	}


	public function getProjectsWinner($data = array()){
		if(empty($data)){
			$sql = "SELECT * FROM " . DB_PREFIX . "contest_winner";
		}else{
			$sql = "SELECT * FROM " . DB_PREFIX . "contest_winner WHERE";
		}

		$_str =array();

		
		if (!empty($data['filter_customer_id'])) {
			$_str[] =	" customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		//statss = 1 значит модератор разрешил оценивать
		if (!empty($data['filter_contest_type_id'])) {
			$_str[] = " contest_type_id = '" . (int)$data['filter_contest_type_id'] . "'";
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

	///список статусов для проекта

	//статусы для проекта
 	public function getProjectStatuses($data = array()) {
	    if ($data) {
	      $sql = "SELECT * FROM " . DB_PREFIX . "project_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

	      $sql .= " ORDER BY name";

	      if (isset($data['order']) && ($data['order'] == 'DESC')) {
	        $sql .= " DESC";
	      } else {
	        $sql .= " ASC";
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
	    } else {
	      $project_status_data = $this->cache->get('project_status.' . (int)$this->config->get('config_language_id'));

	      if (!$project_status_data) {
	        $query = $this->db->query("SELECT project_status_id, name FROM " . DB_PREFIX . "project_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

	        $project_status_data = $query->rows;

	        $this->cache->set('project_status.' . (int)$this->config->get('config_language_id'), $project_status_data);
	      }

	      return $project_status_data;
	    }
	  } 

	public function getSexStatuses($data = array()) {
	    if ($data) {
	      $sql = "SELECT * FROM " . DB_PREFIX . "sex_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

	      $sql .= " ORDER BY name";

	      if (isset($data['order']) && ($data['order'] == 'DESC')) {
	        $sql .= " DESC";
	      } else {
	        $sql .= " ASC";
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
	    } else {
	      $sex_status_data = $this->cache->get('sex_status.' . (int)$this->config->get('config_language_id'));

	      if (!$sex_status_data) {
	        $query = $this->db->query("SELECT sex_status_id, name FROM " . DB_PREFIX . "sex_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

	        $sex_status_data = $query->rows;

	        $this->cache->set('sex_status.' . (int)$this->config->get('config_language_id'), $sex_status_data);
	      }

	      return $sex_status_data;
	    }
  	}
  	//возратсы для проекта
  	public function getAgeStatuses($data = array()) {
	    if ($data) {
	      $sql = "SELECT * FROM " . DB_PREFIX . "age_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

	      $sql .= " ORDER BY name";

	      if (isset($data['order']) && ($data['order'] == 'DESC')) {
	        $sql .= " DESC";
	      } else {
	        $sql .= " ASC";
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
	    } else {
	      $age_status_data = $this->cache->get('age_status.' . (int)$this->config->get('config_language_id'));

	      if (!$age_status_data) {
	        $query = $this->db->query("SELECT age_status_id, name FROM " . DB_PREFIX . "age_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

	        $age_status_data = $query->rows;

	        $this->cache->set('age_status.' . (int)$this->config->get('config_language_id'), $age_status_data);
	      }

	      return $age_status_data;
	    }
	  }

	  public function getNationalityStatuses($data = array()) {
	    if ($data) {
	      $sql = "SELECT * FROM " . DB_PREFIX . "nationality_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

	      $sql .= " ORDER BY name";

	      if (isset($data['order']) && ($data['order'] == 'DESC')) {
	        $sql .= " DESC";
	      } else {
	        $sql .= " ASC";
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
	    } else {
	      $nationality_status_data = $this->cache->get('nationality_status.' . (int)$this->config->get('config_language_id'));

	      if (!$nationality_status_data) {
	        $query = $this->db->query("SELECT nationality_status_id, name FROM " . DB_PREFIX . "nationality_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

	        $nationality_status_data = $query->rows;

	        $this->cache->set('nationality_status.' . (int)$this->config->get('config_language_id'), $nationality_status_data);
	      }

	      return $nationality_status_data;
	    }
	  }

  	public function getProfessionalStatuses($data = array()) {
	    if ($data) {
	      $sql = "SELECT * FROM " . DB_PREFIX . "professional_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

	      $sql .= " ORDER BY name";

	      if (isset($data['order']) && ($data['order'] == 'DESC')) {
	        $sql .= " DESC";
	      } else {
	        $sql .= " ASC";
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
	    } else {
	      $professional_status_data = $this->cache->get('professional_status.' . (int)$this->config->get('config_language_id'));

	      if (!$professional_status_data) {
	        $query = $this->db->query("SELECT professional_status_id, name FROM " . DB_PREFIX . "professional_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

	        $professional_status_data = $query->rows;

	        $this->cache->set('professional_status.' . (int)$this->config->get('config_language_id'), $professional_status_data);
	      }

	      return $professional_status_data;
	    }
	  }

  	public function getDemographicStatuses($data = array()) {
	    if ($data) {
	      $sql = "SELECT * FROM " . DB_PREFIX . "demographic_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

	      $sql .= " ORDER BY name";

	      if (isset($data['order']) && ($data['order'] == 'DESC')) {
	        $sql .= " DESC";
	      } else {
	        $sql .= " ASC";
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
	    } else {
	      $demographic_status_data = $this->cache->get('demographic_status.' . (int)$this->config->get('config_language_id'));

	      if (!$demographic_status_data) {
	        $query = $this->db->query("SELECT demographic_status_id, name FROM " . DB_PREFIX . "demographic_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

	        $demographic_status_data = $query->rows;

	        $this->cache->set('demographic_status.' . (int)$this->config->get('config_language_id'), $demographic_status_data);
	      }

	      return $demographic_status_data;
	    }
	  }

	  public function getListRelationshipAdaptor(){
	  	$data_relation_status = array();
			$data_relation_status[] = array(
				'relation_status_id' 		=> 1,
				'relation_status_title' => 'Консультации',
				'relation_status_href'	=> $this->url->link('account/account', '', 'SSL')
			);
			$data_relation_status[] = array(
				'relation_status_id' 		=> 2,
				'relation_status_title' => 'Партнерство',
				'relation_status_href'	=> $this->url->link('account/account', '', 'SSL')
			);
			$data_relation_status[] = array(
				'relation_status_id' 		=> 3,
				'relation_status_title' => 'Франчайзинг',
				'relation_status_href'	=> $this->url->link('account/account', '', 'SSL')
			);

			return $data_relation_status;

	  }

}