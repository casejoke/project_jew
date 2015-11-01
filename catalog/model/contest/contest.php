<?php
class ModelContestContest extends Model {

	public function addContest($data,$customer_id) {
		$this->event->trigger('pre.customer.contest.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "contest SET 
			customer_id = '" . (int)$customer_id . "',
			image = '" . $this->db->escape($data['image']) . "',
			contest_birthday = '" . $this->db->escape($data['contest_birthday']) . "',
			date_added = NOW()"
		);

		$contest_id = $this->db->getLastId();

		foreach ($data['contest_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contest_description SET 
				contest_id = '" . (int)$contest_id . "', 
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
				query = 'contest_id=" . (int)$occasion_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}

	}
	public function editContest($contest_id, $data,$customer_id) {
		$this->event->trigger('pre.customer.contest.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "contest SET 
			customer_id = '" . (int)$customer_id . "',
			image = '" . $this->db->escape($data['image']) . "',
			contest_birthday = '" . $this->db->escape($data['contest_birthday']) . "'
			WHERE contest_id = '" . (int)$contest_id . "'"
		);

		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_description WHERE contest_id = '" . (int)$contest_id . "'");
		foreach ($data['contest_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contest_description SET 
				contest_id = '" . (int)$contest_id . "', 
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

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'contest_id=" . (int)$contest_id . "'");
		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
				query = 'contest_id=" . (int)$contest_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}

	}
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

	public function getContests() {
		//$query = $this->db->query("SELECT   * FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.contest_id = dd.contest_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return array();//$query->rows;
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



}