<?php
class ModelCatalogPlace extends Model {
	public function addPlace($data) {
		$this->event->trigger('pre.admin.place.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "place SET 
			image = '" . $this->db->escape($data['image']) . "',
			metro_id = '" . (int)$data['metro_id'] . "',
			latitude_longitude = '" . $this->db->escape($data['latitude_longitude']) . "',
			visibility = '" . (int)$data['visibility'] . "',
			status = '" . (int)$data['status'] . "',
			date_added = NOW()");

		$place_id = $this->db->getLastId();
		foreach ($data['place_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "place_description SET 
				place_id = '" . (int)$place_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "',
				address = '" . $this->db->escape($value['address']) . "',
				description = '" . $this->db->escape($value['description']) . "', 
				meta_title = '" . $this->db->escape($value['meta_title']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'
			");
		}

		if (isset($data['place_image'])) {
			foreach ($data['place_image'] as $place_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "place_image SET 
					place_id = '" . (int)$place_id . "', 
					link = '" .  $this->db->escape($place_image['link']) . "', 
					image = '" .  $this->db->escape($place_image['image']) . "', 
					sort_order = '" . (int)$place_image['sort_order'] . "'
				");

				$place_image_id = $this->db->getLastId();

				foreach ($place_image['place_image_description'] as $language_id => $place_image_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "place_image_description SET 
						place_image_id = '" . (int)$place_image_id . "', 
						language_id = '" . (int)$language_id . "', 
						place_id = '" . (int)$place_id . "', 
						title = '" .  $this->db->escape($place_image_description['title']) . "'
					");
				}
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
				query = 'place_id=" . (int)$place_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}
		$this->cache->delete('place');

		$this->event->trigger('post.admin.place.add', $place_id);

		return $place_id;
	}

	public function editPlace($place_id, $data) {
		$this->event->trigger('pre.admin.place.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "place SET 
			image = '" . $this->db->escape($data['image']) . "',
			metro_id = '" . (int)$data['metro_id'] . "',
			latitude_longitude = '" . $this->db->escape($data['latitude_longitude']) . "',
			visibility = '" . (int)$data['visibility'] . "',
			status = '" . (int)$data['status'] . "'
			WHERE place_id = '" . (int)$place_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "place_description WHERE place_id = '" . (int)$place_id . "'");

		foreach ($data['place_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "place_description SET 
				place_id = '" . (int)$place_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "',
				address = '" . $this->db->escape($value['address']) . "',
				description = '" . $this->db->escape($value['description']) . "', 
				meta_title = '" . $this->db->escape($value['meta_title']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'
			");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'place_id=" . (int)$place_id . "'");
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
				query = 'place_id=" . (int)$place_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "place_image WHERE place_id = '" . (int)$place_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "place_image_description WHERE place_id = '" . (int)$place_id . "'");

		if (isset($data['place_image'])) {
			foreach ($data['place_image'] as $place_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "place_image SET 
					place_id = '" . (int)$place_id . "', 
					link = '" .  $this->db->escape($place_image['link']) . "', 
					image = '" .  $this->db->escape($place_image['image']) . "', 
					sort_order = '" . (int)$place_image['sort_order'] . "'
				");

				$place_image_id = $this->db->getLastId();

				foreach ($place_image['place_image_description'] as $language_id => $place_image_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "place_image_description SET 
						place_image_id = '" . (int)$place_image_id . "', 
						language_id = '" . (int)$language_id . "', 
						place_id = '" . (int)$place_id . "', 
						title = '" .  $this->db->escape($place_image_description['title']) . "'
					");
				}
			}
		}

		$this->cache->delete('place');

		$this->event->trigger('post.admin.place.edit', $place_id);
	}

	public function deletePlace($place_id) {
		$this->event->trigger('pre.admin.place.delete', $place_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "place WHERE place_id = '" . (int)$place_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "place_description WHERE place_id = '" . (int)$place_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'place_id=" . (int)$place_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "place_image WHERE place_id = '" . (int)$place_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "place_image_description WHERE place_id = '" . (int)$place_id . "'");

		$this->cache->delete('place');
		$this->event->trigger('post.admin.place.delete', $place_id);
	}

	public function getPlace($place_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'place_id=" . (int)$place_id . "') AS keyword FROM " . DB_PREFIX . "place d LEFT JOIN " . DB_PREFIX . "place_description dd ON (d.place_id = dd.place_id) WHERE d.place_id = '" . (int)$place_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getPlaces($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "place d LEFT JOIN " . DB_PREFIX . "place_description dd ON (d.place_id = dd.place_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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

	public function getPlaceDescriptions($place_id) {
		$place_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "place_description WHERE place_id = '" . (int)$place_id . "'");

		foreach ($query->rows as $result) {
			$place_description_data[$result['language_id']] = array(
				'title' => $result['title'],
				'description'      => $result['description'],
				'address'      	   => $result['address'],
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