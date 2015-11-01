<?php
class ModelCatalogOccasionGroup extends Model {
	public function addOccasionGroup($data) {
		$this->event->trigger('pre.admin.occasion_group.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_group SET 
			visibility = '" . (int)$data['visibility'] . "',
			in_status = '" . (int)$data['in_status'] . "',
			status = '" . (int)$data['status'] . "',
			date_added = NOW()");

		$occasion_group_id = $this->db->getLastId();

		foreach ($data['occasion_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_group_description SET 
				occasion_group_id = '" . (int)$occasion_group_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "'
			");
		}

		$this->event->trigger('post.admin.occasion_group.add', $occasion_group_id);

		return $occasion_group_id;
	}

	public function editOccasionGroup($occasion_group_id, $data) {
		$this->event->trigger('pre.admin.occasion_group.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "occasion_group SET 
			visibility = '" . (int)$data['visibility'] . "',
			in_status = '" . (int)$data['in_status'] . "',
			status = '" . (int)$data['status'] . "'
			WHERE occasion_group_id = '" . (int)$occasion_group_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_group_description WHERE occasion_group_id = '" . (int)$occasion_group_id . "'");

		foreach ($data['occasion_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_group_description SET 
				occasion_group_id = '" . (int)$occasion_group_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "'
			");
		}

		$this->event->trigger('post.admin.occasion_group.edit', $occasion_group_id);
	}

	public function deleteOccasionGroup($occasion_group_id) {
		$this->event->trigger('pre.admin.occasion_group.delete', $occasion_group_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_group WHERE occasion_group_id = '" . (int)$occasion_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_group_description WHERE occasion_group_id = '" . (int)$occasion_group_id . "'");

		$this->event->trigger('post.admin.occasion_group.delete', $occasion_group_id);
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