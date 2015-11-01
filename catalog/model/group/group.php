<?php
class ModelGroupGroup extends Model {

	public function addGroup($data,$customer_id) {
		$this->event->trigger('pre.customer.init_group.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "init_group SET 
			customer_id = '" . (int)$customer_id . "',
			image = '" . $this->db->escape($data['image']) . "',
			group_birthday = '" . $this->db->escape($data['group_birthday']) . "',
			date_added = NOW()"
		);

		$init_group_id = $this->db->getLastId();

		foreach ($data['init_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "init_group_description SET 
				init_group_id = '" . (int)$init_group_id . "', 
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
				query = 'group_id=" . (int)$occasion_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}

	}
	public function editGroup($group_id, $data,$customer_id) {
		$this->event->trigger('pre.customer.init_group.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "init_group SET 
			customer_id = '" . (int)$customer_id . "',
			image = '" . $this->db->escape($data['image']) . "',
			group_birthday = '" . $this->db->escape($data['group_birthday']) . "'
			WHERE init_group_id = '" . (int)$group_id . "'"
		);

		$this->db->query("DELETE FROM " . DB_PREFIX . "init_group_description WHERE init_group_id = '" . (int)$group_id . "'");
		foreach ($data['init_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "init_group_description SET 
				init_group_id = '" . (int)$group_id . "', 
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

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'group_id=" . (int)$group_id . "'");
		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
				query = 'group_id=" . (int)$group_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}

	}
	public function getGroup($init_group_id) {
		$query = $this->db->query("SELECT DISTINCT  *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'group_id=" . (int)$init_group_id . "') AS keyword FROM " . DB_PREFIX . "init_group d LEFT JOIN " . DB_PREFIX . "init_group_description dd ON (d.init_group_id = dd.init_group_id) WHERE d.init_group_id = '" . (int)$init_group_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getGroupDescriptions($init_group_id) {
		$init_group_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "init_group_description WHERE init_group_id = '" . (int)$init_group_id . "'");
		
		foreach ($query->rows as $result) {
			$init_group_description_data[$result['language_id']] = array(
				'title' 		   => $result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $init_group_description_data;
	}

	public function getGroupsForAdmin($customer_id) {
		$query = $this->db->query("SELECT   * FROM " . DB_PREFIX . "init_group d LEFT JOIN " . DB_PREFIX . "init_group_description dd ON (d.init_group_id = dd.init_group_id) WHERE d.customer_id = '" . (int)$customer_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->rows;
	}

	public function getGroups() {
		$query = $this->db->query("SELECT   * FROM " . DB_PREFIX . "init_group d LEFT JOIN " . DB_PREFIX . "init_group_description dd ON (d.init_group_id = dd.init_group_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->rows;
	}

	

	public function getInviteGroups($data = array()) {

		$sql = "SELECT   * FROM " . DB_PREFIX . "customer_to_init_group ";

		$implode = array();

		if (!empty($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_customer_id'])) {
			$implode[] = "customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (!empty($data['filter_init_group_id'])) {
			$implode[] = "init_group_id = '" . (int)$data['filter_init_group_id'] . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}

	
	public function inviteCustomer($data){
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_to_init_group SET 
			init_group_id = '" . (int)$data['init_group_id'] . "',
			customer_id = '" . (int)$data['customer_id'] . "',
			status = '" . (int)$data['status'] . "',
			date_added = NOW()"
		);
	}

	public function inviteAgree($data){
		$this->db->query("UPDATE " . DB_PREFIX . "customer_to_init_group SET
			status = '1'
			WHERE init_group_id = '" . (int)$data['init_group_id'] . "' AND customer_id = '" . (int)$data['customer_id'] . "'"
		);
	}
	public function uninviteCustomer($data){
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_to_init_group WHERE 
			init_group_id = '" . (int)$data['init_group_id'] . "' AND customer_id = '" . (int)$data['customer_id'] . "'"
		);
	}



}