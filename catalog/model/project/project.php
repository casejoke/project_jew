<?php
class ModelProjectProject extends Model {

	public function addProject($data,$customer_id) {
		$this->event->trigger('pre.customer.project.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "project SET 
			customer_id = '" . (int)$customer_id . "',
			image = '" . $this->db->escape($data['image']) . "',
			project_birthday = '" . $this->db->escape($data['project_birthday']) . "',
			date_added = NOW()"
		);

		$project_id = $this->db->getLastId();

		foreach ($data['project_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "project_description SET 
				project_id = '" . (int)$project_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "',
				description = '" . $this->db->escape($value['description']) . "'"
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

	}
	public function editProject($project_id, $data,$customer_id) {
		$this->event->trigger('pre.customer.project.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "project SET 
			customer_id = '" . (int)$customer_id . "',
			image = '" . $this->db->escape($data['image']) . "',
			project_birthday = '" . $this->db->escape($data['project_birthday']) . "'
			WHERE project_id = '" . (int)$project_id . "'"
		);

		$this->db->query("DELETE FROM " . DB_PREFIX . "project_description WHERE project_id = '" . (int)$project_id . "'");
		foreach ($data['project_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "project_description SET 
				project_id = '" . (int)$project_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "',
				description = '" . $this->db->escape($value['description']) . "'"
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



}