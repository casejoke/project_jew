<?php
class ModelCatalogOccasionGroup extends Model {
	
	public function getActiveOccasionGroup(){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "occasion_group 
			d LEFT JOIN " . DB_PREFIX . "occasion_group_description dd ON (d.occasion_group_id = dd.occasion_group_id) 
			WHERE d.status = '1' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'
		");

		return $query->rows;
	}
	public function getOccasionGroup($occasion_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "occasion_group d LEFT JOIN " . DB_PREFIX . "occasion_group_description dd ON (d.occasion_group_id = dd.occasion_group_id) WHERE d.occasion_group_id = '" . (int)$occasion_group_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getOccasionGroups($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "occasion_group d LEFT JOIN " . DB_PREFIX . "occasion_group_description dd ON (d.occasion_group_id = dd.occasion_group_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		$sort_data = array(
			'dd.title',
			'd.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY dd.title";
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

	public function getOccasionGroupDescriptions($occasion_group_id) {
		$occasion_group_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "occasion_group_description WHERE occasion_group_id = '" . (int)$occasion_group_id . "'");

		foreach ($query->rows as $result) {
			$occasion_group_description_data[$result['language_id']] = array(
				'title' => $result['title']
			);
		}

		return $occasion_group_description_data;
	}

	public function getTotalOccasionGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "occasion_group");

		return $query->row['total'];
	}
}