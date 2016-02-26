<?php
class ModelContestContestRequest extends Model {
	public function addRequest($data) {
		$this->cache->delete('customer_to_contest');
	}

	public function editRequest($customer_to_contest_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_to_contest SET 
			status = '" . (int)$data['status'] . "',
			comment = '" . $this->db->escape($data['comment']) . "'
		WHERE customer_to_contest_id = '" . (int)$customer_to_contest_id . "'");

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

		$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest WHERE status != 3";

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
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_to_contest WHERE status != 3");

		return $query->row['total'];
	}

	public function getTotalRequestsByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_to_contest WHERE country_id = '" . (int)$country_id . "'");

		return $query->row['total'];
	}
	
	public function getRequestStatusTypes(){
		//статусы заявки: 
		// 0 - не принята (есть комментарий)
		// 1 - принята  (видна экспертам и  ее можно оценивать)
		// 2 - не обработана () 
		//$_['text_status_not_accepted']      = 'Не одобрена';
		//$_['text_status_accepted']        	= 'Одобрена';
		//$_['text_status_processed']        	= 'В обработке';
		$data_request_status_types = array();
		$data_request_status_types[] = array(
			'request_status_type_id' => 0,
			'request_status_type_title' => 'Не одобрена'
		);
		$data_request_status_types[] = array(
			'request_status_type_id' => 1,
			'request_status_type_title' => 'Одобрена'
		);
		$data_request_status_types[] = array(
			'request_status_type_id' => 2,
			'request_status_type_title' => 'В обработке'
		);
		return $data_request_status_types;
	}
}