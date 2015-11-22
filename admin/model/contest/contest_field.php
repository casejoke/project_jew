<?php
class ModelContestContestField extends Model {
	public function addContestField($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "contest_field` SET 
			type = '" . $this->db->escape($data['type']) . "', 
			field_system = '" . $this->db->escape($data['field_system']) . "', 
			field_system_table = '" . $this->db->escape($data['field_system_table']) . "', 
			value = '" . $this->db->escape($data['value']) . "', 
			location = '" . $this->db->escape($data['location']) . "', 
			status = '" . (int)$data['status'] . "', 
			sort_order = '" . (int)$data['sort_order'] . "'
		");

		$contest_field_id = $this->db->getLastId();

		foreach ($data['contest_field_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contest_field_description SET contest_field_id = '" . (int)$contest_field_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		

		if (isset($data['contest_field_value'])) {
			foreach ($data['contest_field_value'] as $contest_field_value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "contest_field_value SET contest_field_id = '" . (int)$contest_field_id . "', sort_order = '" . (int)$contest_field_value['sort_order'] . "'");

				$contest_field_value_id = $this->db->getLastId();

				foreach ($contest_field_value['contest_field_value_description'] as $language_id => $contest_field_value_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_field_value_description SET contest_field_value_id = '" . (int)$contest_field_value_id . "', language_id = '" . (int)$language_id . "', contest_field_id = '" . (int)$contest_field_id . "', name = '" . $this->db->escape($contest_field_value_description['name']) . "'");
				}
			}
		}
	}

	public function editContestField($contest_field_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "contest_field` SET 
			type = '" . $this->db->escape($data['type']) . "', 
			field_system = '" . $this->db->escape($data['field_system']) . "', 
			field_system_table = '" . $this->db->escape($data['field_system_table']) . "', 
			value = '" . $this->db->escape($data['value']) . "', 
			location = '" . $this->db->escape($data['location']) . "', 
			status = '" . (int)$data['status'] . "', 
			sort_order = '" . (int)$data['sort_order'] . "' WHERE contest_field_id = '" . (int)$contest_field_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_field_description WHERE contest_field_id = '" . (int)$contest_field_id . "'");

		foreach ($data['contest_field_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contest_field_description SET contest_field_id = '" . (int)$contest_field_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		

		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_field_value WHERE contest_field_id = '" . (int)$contest_field_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contest_field_value_description WHERE contest_field_id = '" . (int)$contest_field_id . "'");

		if (isset($data['contest_field_value'])) {
			foreach ($data['contest_field_value'] as $contest_field_value) {
				if ($contest_field_value['contest_field_value_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_field_value SET contest_field_value_id = '" . (int)$contest_field_value['contest_field_value_id'] . "', contest_field_id = '" . (int)$contest_field_id . "', sort_order = '" . (int)$contest_field_value['sort_order'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_field_value SET contest_field_id = '" . (int)$contest_field_id . "', sort_order = '" . (int)$contest_field_value['sort_order'] . "'");
				}

				$contest_field_value_id = $this->db->getLastId();

				foreach ($contest_field_value['contest_field_value_description'] as $language_id => $contest_field_value_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "contest_field_value_description SET contest_field_value_id = '" . (int)$contest_field_value_id . "', language_id = '" . (int)$language_id . "', contest_field_id = '" . (int)$contest_field_id . "', name = '" . $this->db->escape($contest_field_value_description['name']) . "'");
				}
			}
		}
	}

	public function deleteContestField($contest_field_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "contest_field` WHERE contest_field_id = '" . (int)$contest_field_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "contest_field_description` WHERE contest_field_id = '" . (int)$contest_field_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "contest_field_value` WHERE contest_field_id = '" . (int)$contest_field_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "contest_field_value_description` WHERE contest_field_id = '" . (int)$contest_field_id . "'");
	}

	public function getContestField($contest_field_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "contest_field` cf LEFT JOIN " . DB_PREFIX . "contest_field_description cfd ON (cf.contest_field_id = cfd.contest_field_id) WHERE cf.contest_field_id = '" . (int)$contest_field_id . "' AND cfd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getContestFields($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "contest_field` cf LEFT JOIN " . DB_PREFIX . "contest_field_description cfd ON (cf.contest_field_id = cfd.contest_field_id) WHERE cfd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cfd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$sql .= " AND cfcg.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}

		$sort_data = array(
			'cfd.name',
			'cf.type',
			'cf.location',
			'cf.status',
			'cf.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY cf.sort_order";
		}

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
	}

	public function getContestFieldDescriptions($contest_field_id) {
		$contest_field_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_field_description WHERE contest_field_id = '" . (int)$contest_field_id . "'");

		foreach ($query->rows as $result) {
			$contest_field_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $contest_field_data;
	}
	
	public function getContestFieldValue($contest_field_value_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_field_value cfv LEFT JOIN " . DB_PREFIX . "contest_field_value_description cfvd ON (cfv.contest_field_value_id = cfvd.contest_field_value_id) WHERE cfv.contest_field_value_id = '" . (int)$contest_field_value_id . "' AND cfvd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	
	public function getContestFieldValues($contest_field_id) {
		$contest_field_value_data = array();

		$contest_field_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_field_value cfv LEFT JOIN " . DB_PREFIX . "contest_field_value_description cfvd ON (cfv.contest_field_value_id = cfvd.contest_field_value_id) WHERE cfv.contest_field_id = '" . (int)$contest_field_id . "' AND cfvd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cfv.sort_order ASC");

		foreach ($contest_field_value_query->rows as $contest_field_value) {
			$contest_field_value_data[$contest_field_value['contest_field_value_id']] = array(
				'contest_field_value_id' => $contest_field_value['contest_field_value_id'],
				'name'                  => $contest_field_value['name']
			);
		}

		return $contest_field_value_data;
	}
	
	

	public function getContestFieldValueDescriptions($contest_field_id) {
		$contest_field_value_data = array();

		$contest_field_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_field_value WHERE contest_field_id = '" . (int)$contest_field_id . "'");

		foreach ($contest_field_value_query->rows as $contest_field_value) {
			$contest_field_value_description_data = array();

			$contest_field_value_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_field_value_description WHERE contest_field_value_id = '" . (int)$contest_field_value['contest_field_value_id'] . "'");

			foreach ($contest_field_value_description_query->rows as $contest_field_value_description) {
				$contest_field_value_description_data[$contest_field_value_description['language_id']] = array('name' => $contest_field_value_description['name']);
			}

			$contest_field_value_data[] = array(
				'contest_field_value_id'          => $contest_field_value['contest_field_value_id'],
				'contest_field_value_description' => $contest_field_value_description_data,
				'sort_order'                     => $contest_field_value['sort_order']
			);
		}

		return $contest_field_value_data;
	}

	public function getTotalContestFields() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "contest_field`");

		return $query->row['total'];
	}
}