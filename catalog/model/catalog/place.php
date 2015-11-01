<?php
class ModelCatalogPlace extends Model {
	public function getPlace($place_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'place_id=" . (int)$place_id . "') AS keyword FROM " . DB_PREFIX . "place d LEFT JOIN " . DB_PREFIX . "place_description dd ON (d.place_id = dd.place_id) WHERE d.place_id = '" . (int)$place_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getPlaces($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "place d LEFT JOIN " . DB_PREFIX . "place_description dd ON (d.place_id = dd.place_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND d.status = '" . (int)$data['filter_status'] . "'";
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

	public function getPlaceDescriptions($place_id) {
		$place_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "place_description WHERE place_id = '" . (int)$place_id . "'");

		foreach ($query->rows as $result) {
			$place_description_data[$result['language_id']] = array(
				'title' => $result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $place_description_data;
	}

	public function getTotalPlaces() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "place");

		return $query->row['total'];
	}
	public function getPlaceImages($place_id) {
		$place_image_data = array();
		
		$place_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "place_image WHERE place_id = '" . (int)$place_id . "' ORDER BY place_image_id ASC");
		
		foreach ($place_image_query->rows as $place_image) {
			$place_image_description_data = array();
			 
			$place_image_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "place_image_description WHERE place_image_id = '" . (int)$place_image['place_image_id'] . "' AND place_id = '" . (int)$place_id . "'");
			
			foreach ($place_image_description_query->rows as $place_image_description) {			
				$place_image_description_data[$place_image_description['language_id']] = array(
					'title' => $place_image_description['title']
				);
			}
		
			$place_image_data[] = array(
				'place_image_description'  	=> $place_image_description_data,
				'link'                     	=> $place_image['link'],
				'image'                    	=> $place_image['image'],
				'sort_order'			    => $place_image['sort_order'],
			);
		}
		
		return $place_image_data;
	}
}