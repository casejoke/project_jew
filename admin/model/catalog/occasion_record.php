<?php
class ModelCatalogOccasionRecord extends Model {
	public function addOccasionRecord($data) {
		$this->event->trigger('pre.admin.occasion_record.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_record SET author = '" . $this->db->escape($data['author']) . "', product_id = '" . (int)$data['product_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$occasion_record_id = $this->db->getLastId();

		$this->event->trigger('post.admin.occasion_record.add', $occasion_record_id);

		return $occasion_record_id;
	}

	public function editOccasionRecord($occasion_record_id, $data) {
		$this->event->trigger('pre.admin.occasion_record.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "occasion_record SET author = '" . $this->db->escape($data['author']) . "', product_id = '" . (int)$data['product_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE occasion_record_id = '" . (int)$occasion_record_id . "'");


		$this->event->trigger('post.admin.occasion_record.edit', $occasion_record_id);
	}

	public function deleteOccasionRecord($occasion_record_id) {
		$this->event->trigger('pre.admin.occasion_record.delete', $occasion_record_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "occasion_record WHERE occasion_record_id = '" . (int)$occasion_record_id . "'");


		$this->event->trigger('post.admin.occasion_record.delete', $occasion_record_id);
	}

	public function getOccasionRecord($occasion_record_id) {
	
	}

	public function getOccasionRecords($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "occasion_record ";

 		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
		//	$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_added";
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

	public function getTotalOccasionRecords($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "occasion_record ";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getTotalOccasionRecordsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "occasion_record WHERE status = '0'");

		return $query->row['total'];
	}
}