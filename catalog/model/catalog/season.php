<?php
class ModelCatalogSeason extends Model {
	public function getActiveSeason(){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "season d LEFT JOIN " . DB_PREFIX . "season_description dd ON (d.season_id = dd.season_id) WHERE d.status = '1' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getSeason($season_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "season d LEFT JOIN " . DB_PREFIX . "season_description dd ON (d.season_id = dd.season_id) WHERE d.season_id = '" . (int)$season_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getSeasons($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "season d LEFT JOIN " . DB_PREFIX . "season_description dd ON (d.season_id = dd.season_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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

	public function getSeasonDescriptions($season_id) {
		$season_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "season_description WHERE season_id = '" . (int)$season_id . "'");

		foreach ($query->rows as $result) {
			$season_description_data[$result['language_id']] = array(
				'title' => $result['title']
			);
		}

		return $season_description_data;
	}

	public function getTotalSeasons() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "season");

		return $query->row['total'];
	}
}