<?php
class ModelCatalogOccasion extends Model {
	public function addOccasion($data) {
		$this->event->trigger('pre.admin.occasion.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "occasion SET 
			occasion_season_id = '" . (int)$data['occasion_season_id'] . "',
			occasion_place_id = '" . (int)$data['occasion_place_id'] . "',
			price = '" . (int)$data['price'] . "',
			best_price = '" . (int)$data['best_price'] . "',
			occasion_date = '" . $this->db->escape($data['occasion_date']) . "',
			occasion_time = '" . $this->db->escape($data['occasion_time']) . "',
			visibility = '" . (int)$data['visibility'] . "',
			status = '" . (int)$data['status'] . "',
			date_added = NOW()");

		$occasion_id = $this->db->getLastId();

		foreach ($data['occasion_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_description SET 
				occasion_id = '" . (int)$occasion_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "',
				description = '" . $this->db->escape($value['description']) . "', 
				meta_title = '" . $this->db->escape($value['meta_title']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'
			");
		}

		if (isset($data['occasion_image'])) {
			foreach ($data['occasion_image'] as $occasion_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_image SET 
					occasion_id = '" . (int)$occasion_id . "', 
					link = '" .  $this->db->escape($occasion_image['link']) . "', 
					image = '" .  $this->db->escape($occasion_image['image']) . "', 
					sort_order = '" . (int)$occasion_image['sort_order'] . "'
				");

				$occasion_image_id = $this->db->getLastId();

				foreach ($occasion_image['occasion_image_description'] as $language_id => $occasion_image_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_image_description SET 
						occasion_image_id = '" . (int)$occasion_image_id . "', 
						language_id = '" . (int)$language_id . "', 
						occasion_id = '" . (int)$occasion_id . "', 
						title = '" .  $this->db->escape($occasion_image_description['title']) . "'
					");
				}
			}
		}

		if (isset($data['occasion_video'])) {
			foreach ($data['occasion_video'] as $occasion_video) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_video SET 
					occasion_id = '" . (int)$occasion_id . "', 
					link = '" .  $this->db->escape($occasion_video['link']) . "', 
					image = '" .  $this->db->escape($occasion_video['image']) . "', 
					sort_order = '" . (int)$occasion_video['sort_order'] . "'
				");

				$occasion_video_id = $this->db->getLastId();

				foreach ($occasion_video['occasion_video_description'] as $language_id => $occasion_video_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_video_description SET 
						occasion_video_id = '" . (int)$occasion_video_id . "', 
						language_id = '" . (int)$language_id . "', 
						occasion_id = '" . (int)$occasion_id . "', 
						title = '" .  $this->db->escape($occasion_video_description['title']) . "'
					");
				}
			}
		}
		if (isset($data['stats'])) {
			
			foreach ($data['stats'] as $stat) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "customer_stats SET 
					occasion_id = '" . (int)$occasion_id . "', 
					customer_id = '" . (int)$stat['customer_id'] . "', 
					occasion_group_id = '" . (int)$stat['occasion_group_id'] . "',
					occasion_date = '" . $this->db->escape($data['occasion_date']) . "',
					season_id = '" . (int)$stat['season_id'] . "', 
					goal = '" . (int)$stat['goal'] . "', 
					pass = '" . (int)$stat['pass'] . "', 
					mvp = '" . (int)$stat['mvp'] . "',
					date_added = NOW()");
			}
		}
		
		
		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
				query = 'occasion_id=" . (int)$occasion_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}

		if (isset($data['occasion_to_occasion_group'])) {
			foreach ($data['occasion_to_occasion_group'] as $occasion_occasion_group) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_to_occasion_group SET occasion_id = '" . (int)$occasion_id . "', occasion_group_id = '" . (int)$occasion_occasion_group['occasion_group_id'] . "'");
			}
		}

		$this->event->trigger('post.admin.occasion.add', $occasion_id);

		return $occasion_id;
	}

	public function editOccasion($occasion_id, $data) {
		$this->event->trigger('pre.admin.occasion.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "occasion SET 
			occasion_season_id = '" . (int)$data['occasion_season_id'] . "',
			occasion_place_id = '" . (int)$data['occasion_place_id'] . "',
			occasion_date = '" . $this->db->escape($data['occasion_date']) . "',
			occasion_time = '" . $this->db->escape($data['occasion_time']) . "',
			price = '" . (int)$data['price'] . "',
			best_price = '" . (int)$data['best_price'] . "',
			visibility = '" . (int)$data['visibility'] . "',
			status = '" . (int)$data['status'] . "'
			WHERE occasion_id = '" . (int)$occasion_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_description WHERE occasion_id = '" . (int)$occasion_id . "'");

		foreach ($data['occasion_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_description SET 
				occasion_id = '" . (int)$occasion_id . "', 
				language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['title']) . "',
				description = '" . $this->db->escape($value['description']) . "', 
				meta_title = '" . $this->db->escape($value['meta_title']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'
			");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'occasion_id=" . (int)$occasion_id . "'");
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
				query = 'occasion_id=" . (int)$occasion_id . "', 
				keyword = '" . $this->db->escape($data['keyword']) . "'
			");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_to_occasion_group WHERE occasion_id = '" . (int)$occasion_id . "'");
		if (isset($data['occasion_to_occasion_group'])) {
			foreach ($data['occasion_to_occasion_group'] as $occasion_occasion_group) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_to_occasion_group SET occasion_id = '" . (int)$occasion_id . "', occasion_group_id = '" . (int)$occasion_occasion_group['occasion_group_id'] . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_image WHERE occasion_id = '" . (int)$occasion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_image_description WHERE occasion_id = '" . (int)$occasion_id . "'");

		if (isset($data['occasion_image'])) {
			foreach ($data['occasion_image'] as $occasion_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_image SET 
					occasion_id = '" . (int)$occasion_id . "', 
					link = '" .  $this->db->escape($occasion_image['link']) . "', 
					image = '" .  $this->db->escape($occasion_image['image']) . "', 
					sort_order = '" . (int)$occasion_image['sort_order'] . "'
				");

				$occasion_image_id = $this->db->getLastId();

				foreach ($occasion_image['occasion_image_description'] as $language_id => $occasion_image_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_image_description SET 
						occasion_image_id = '" . (int)$occasion_image_id . "', 
						language_id = '" . (int)$language_id . "', 
						occasion_id = '" . (int)$occasion_id . "', 
						title = '" .  $this->db->escape($occasion_image_description['title']) . "'
					");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_video WHERE occasion_id = '" . (int)$occasion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_video_description WHERE occasion_id = '" . (int)$occasion_id . "'");

		if (isset($data['occasion_video'])) {
			foreach ($data['occasion_video'] as $occasion_video) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_video SET 
					occasion_id = '" . (int)$occasion_id . "', 
					link = '" .  $this->db->escape($occasion_video['link']) . "', 
					image = '" .  $this->db->escape($occasion_video['image']) . "', 
					sort_order = '" . (int)$occasion_video['sort_order'] . "'
				");

				$occasion_video_id = $this->db->getLastId();

				foreach ($occasion_video['occasion_video_description'] as $language_id => $occasion_video_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_video_description SET 
						occasion_video_id = '" . (int)$occasion_video_id . "', 
						language_id = '" . (int)$language_id . "', 
						occasion_id = '" . (int)$occasion_id . "', 
						title = '" .  $this->db->escape($occasion_video_description['title']) . "'
					");
				}
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_stats WHERE occasion_id = '" . (int)$occasion_id . "' ");
		if (isset($data['stats'])) {
			
			
			
			foreach ($data['stats'] as $stat) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "customer_stats SET 
					occasion_id = '" . (int)$occasion_id . "', 
					customer_id = '" . (int)$stat['customer_id'] . "', 
					occasion_group_id = '" . (int)$stat['occasion_group_id'] . "',
					season_id = '" . (int)$stat['season_id'] . "', 
					occasion_date = '" . $this->db->escape($data['occasion_date']) . "',
					goal = '" . (int)$stat['goal'] . "', 
					pass = '" . (int)$stat['pass'] . "', 
					mvp = '" . (int)$stat['mvp'] . "',
					date_added = NOW()");
			}
		}

		$this->event->trigger('post.admin.occasion.edit', $occasion_id);
	}

	public function deleteOccasion($occasion_id) {
		$this->event->trigger('pre.admin.occasion.delete', $occasion_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion WHERE occasion_id = '" . (int)$occasion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_description WHERE occasion_id = '" . (int)$occasion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'occasion_id=" . (int)$occasion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_image WHERE occasion_id = '" . (int)$occasion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_image_description WHERE occasion_id = '" . (int)$occasion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_video WHERE occasion_id = '" . (int)$occasion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_video_description WHERE occasion_id = '" . (int)$occasion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_to_occasion_group WHERE occasion_id = '" . (int)$occasion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_stats WHERE occasion_id = '" . (int)$occasion_id . "' ");
		$this->event->trigger('post.admin.occasion.delete', $occasion_id);
	}
	public function copyOccasion($occasion_id){
		$this->event->trigger('pre.admin.occasion.copy', $occasion_id);
		$query = $this->db->query("SELECT DISTINCT  *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'occasion_id=" . (int)$occasion_id . "') AS keyword FROM " . DB_PREFIX . "occasion d LEFT JOIN " . DB_PREFIX . "occasion_description dd ON (d.occasion_id = dd.occasion_id) WHERE d.occasion_id = '" . (int)$occasion_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		if ($query->num_rows) {
			$data = $query->row;
			$data['keyword'] = '';
			$data['status'] = '0';
			$data['visibility'] = '0';
			$data['occasion_description'] = $this->getOccasionDescriptions($occasion_id,true);
			$this->addOccasion($data);
		}
		$this->event->trigger('post.admin.occasion.copy', $occasion_id);
	}
	public function getOccasion($occasion_id) {
		$query = $this->db->query("SELECT DISTINCT  *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'occasion_id=" . (int)$occasion_id . "') AS keyword FROM " . DB_PREFIX . "occasion d LEFT JOIN " . DB_PREFIX . "occasion_description dd ON (d.occasion_id = dd.occasion_id) WHERE d.occasion_id = '" . (int)$occasion_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getOccasions($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "occasion d LEFT JOIN " . DB_PREFIX . "occasion_description dd ON (d.occasion_id = dd.occasion_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		$sort_data = array(
			'dd.title',
			'd.date_added',
			'd.occasion_date'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY d.occasion_date";
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

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getOccasionDescriptions($occasion_id,$copy = false) {
		$occasion_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "occasion_description WHERE occasion_id = '" . (int)$occasion_id . "'");
		
		foreach ($query->rows as $result) {
			$occasion_description_data[$result['language_id']] = array(
				'title' => (!$copy)? $result['title']:'copy_'.$result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $occasion_description_data;
	}

	public function getTotalOccasions() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "occasion");

		return $query->row['total'];
	}
	public function getOccasionImages($occasion_id) {
		$occasion_image_data = array();
		
		$occasion_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "occasion_image WHERE occasion_id = '" . (int)$occasion_id . "' ORDER BY occasion_image_id ASC");
		
		foreach ($occasion_image_query->rows as $occasion_image) {
			$occasion_image_description_data = array();
			 
			$occasion_image_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "occasion_image_description WHERE occasion_image_id = '" . (int)$occasion_image['occasion_image_id'] . "' AND occasion_id = '" . (int)$occasion_id . "'");
			
			foreach ($occasion_image_description_query->rows as $occasion_image_description) {			
				$occasion_image_description_data[$occasion_image_description['language_id']] = array(
					'title' => $occasion_image_description['title']
				);
			}
		
			$occasion_image_data[] = array(
				'occasion_image_description'  	=> $occasion_image_description_data,
				'link'                     	=> $occasion_image['link'],
				'image'                    	=> $occasion_image['image'],
				'sort_order'			    => $occasion_image['sort_order'],
			);
		}
		
		return $occasion_image_data;
	}
	public function getOccasionVideos($occasion_id) {
		$occasion_video_data = array();
		
		$occasion_video_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "occasion_video WHERE occasion_id = '" . (int)$occasion_id . "' ORDER BY occasion_video_id ASC");
		
		foreach ($occasion_video_query->rows as $occasion_video) {
			$occasion_video_description_data = array();
			 
			$occasion_video_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "occasion_video_description WHERE occasion_video_id = '" . (int)$occasion_video['occasion_video_id'] . "' AND occasion_id = '" . (int)$occasion_id . "'");
			
			foreach ($occasion_video_description_query->rows as $occasion_video_description) {			
				$occasion_video_description_data[$occasion_video_description['language_id']] = array(
					'title' => $occasion_video_description['title']
				);
			}
		
			$occasion_video_data[] = array(
				'occasion_video_description'  	=> $occasion_video_description_data,
				'link'                     	=> $occasion_video['link'],
				'image'                    	=> $occasion_video['image'],
				'sort_order'			    => $occasion_video['sort_order'],
			);
		}
		
		return $occasion_video_data;
	}
	public function getOccasionToOccasionGroup($occasion_id){
		$occasion_to_occasion_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "occasion_to_occasion_group WHERE occasion_id = '" . (int)$occasion_id . "'");

		foreach ($query->rows as $result) {
			$occasion_to_occasion_group_data[] = $result['occasion_group_id'];
		}

		return $occasion_to_occasion_group_data;
	}
}