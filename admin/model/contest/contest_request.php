<?php
class ModelContestContestRequest extends Model {
	public function addRequest($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_to_contest SET status = '" . (int)$data['status'] . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', country_id = '" . (int)$data['country_id'] . "'");

		$this->cache->delete('customer_to_contest');
	}

	public function editRequest($customer_to_contest_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_to_contest SET status = '" . (int)$data['status'] . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', country_id = '" . (int)$data['country_id'] . "' WHERE customer_to_contest_id = '" . (int)$customer_to_contest_id . "'");

		$this->cache->delete('customer_to_contest');
	}

	public function deleteRequest($customer_to_contest_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_to_contest WHERE customer_to_contest_id = '" . (int)$customer_to_contest_id . "'");

		$this->cache->delete('customer_to_contest');
	}

	public function getRequest($customer_to_contest_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_to_contest WHERE customer_to_contest_id = '" . (int)$customer_to_contest_id . "'");

		return $query->row;
	}


	public function getRequests($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest";

		$sort_data = array(
			'customer_id',
			'contest_id',
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

	public function getRequestsByCountryId($country_id) {
		$customer_to_contest_data = $this->cache->get('customer_to_contest.' . (int)$country_id);

		if (!$customer_to_contest_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_to_contest WHERE country_id = '" . (int)$country_id . "' AND status = '1' ORDER BY name");

			$customer_to_contest_data = $query->rows;

			$this->cache->set('customer_to_contest.' . (int)$country_id, $customer_to_contest_data);
		}

		return $customer_to_contest_data;
	}

	public function getTotalRequests() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_to_contest");

		return $query->row['total'];
	}

	public function getTotalRequestsByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_to_contest WHERE country_id = '" . (int)$country_id . "'");

		return $query->row['total'];
	}
}