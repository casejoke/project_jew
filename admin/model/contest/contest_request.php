<?php
class ModelContestContestRequest extends Model {
	public function addRequest($data) {
		$this->cache->delete('customer_to_contest');
	}

	public function editRequest($customer_to_contest_id, $data) {

		$request_info = $this->getInformationAboutRequest($customer_to_contest_id);

		 $this->load->model('sale/customer');
		 $customer_info = $this->model_sale_customer->getCustomer($request_info['customer_id']);
			 
			
		 $message = 'Статус вашей заявки изменился. Узнать статус можно в личном кабинете.';
		 $subject = 'Сайт  - уведомление';

			//отправляем письмо адаптору ()

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($subject);
			$mail->setHtml($message);
			$mail->send();



		$this->db->query("UPDATE " . DB_PREFIX . "customer_to_contest SET 
			status = '" . (int)$data['status'] . "',
			comment = '" . $this->db->escape($data['comment']) . "'
		WHERE customer_to_contest_id = '" . (int)$customer_to_contest_id . "'");

		$this->cache->delete('customer_to_contest');
	}
	//получить информацию  о заявке
	public function getInformationAboutRequest($request_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_to_contest WHERE customer_to_contest_id = '".(int)$request_id."'");


		return $query->row;
	}

	public function deleteRequest($customer_to_contest_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_to_contest WHERE customer_to_contest_id = '" . (int)$customer_to_contest_id . "'");

		$this->cache->delete('customer_to_contest');
	}

	public function getRequest($customer_to_contest_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_to_contest WHERE customer_to_contest_id = '" . (int)$customer_to_contest_id . "'");

		return $query->row;
	}

	public function getRequestsForAll(){
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest ";


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

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC ";
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

	public function getTotalRequestsForAll() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_to_contest");

		return $query->row['total'];
	}

	public function getRequests($data = array()) {

		 //filter_adaptive_status
			//если 2 - одобрена
			//если 1 - то не одобрена
			//если 0 то не оценена

	//	$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest WHERE status != 3 AND adaptive_status = 2";

		$sql = "SELECT c.customer_to_contest_id,c.contest_id,c.status,c.customer_id,c.date_added,c.adaptive_status,c.adaptive_id, c.value FROM " . DB_PREFIX . "customer_to_contest c LEFT JOIN " . DB_PREFIX . "contest cc ON (c.contest_id = cc.contest_id) WHERE (c.status != 3 AND c.adaptive_status = 2 AND cc.type = 3) OR (c.status != 3 AND c.adaptive_status = 0 AND cc.type != 3)";




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
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_to_contest c LEFT JOIN " . DB_PREFIX . "contest cc ON (c.contest_id = cc.contest_id) WHERE (c.status != 3 AND c.adaptive_status = 2 AND cc.type = 3) OR (c.status != 3 AND c.adaptive_status = 0 AND cc.type != 3)");

		return $query->row['total'];
	}

	public function getTotalRequestsByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_to_contest WHERE country_id = '" . (int)$country_id . "'");

		return $query->row['total'];
	}
	
	public function getEstimate($data){

		$_str =array();

		if (!empty($data['filter_customer_to_contest_id'])) {
			$_str[] =	" customer_to_contest_id = '" . (int)$data['filter_customer_to_contest_id'] . "'";
		}
		if (!empty($data['filter_customer_id'])) {
			$_str[] =	" customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}
		if (!empty($data['filter_contest_id'])) {
			//$_str[] =	" contest_id = '" . (int)$data['filter_contest_id'] . "'";
		}
		

		/*if (!empty($data['filter_array_project_customer_id'])) {

			if(count($data['filter_array_project_customer_id']) > 1){
				$_str[] .= " adaptive_id IN (" . implode(',', $data['filter_array_project_customer_id']) . ")";
			}else{
				//если один проект
				$contest_id = $data['filter_array_project_customer_id'][0];
				$_str[] .= " adaptive_id = '" . (int)$contest_id . "'";
			}
		} else{
			$_str[] .= " adaptive_id = '0'";
		}*/

		if (!empty($data['filter_status'])) {
			$_str[] = " status = '" . (int)$data['filter_status'] . "'";
		}
		

		
		$_sql = '' ;
		$i = 0;
		foreach ($_str as $vstr) {
			if($i > 0){
				$_sql .= ' AND'.$vstr;
			}else{
				$_sql .= $vstr;
			}
			$i++;
		}

		if(!$_sql){
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_estimate";
		}else{
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_estimate WHERE";
		}



		
		$sort_data = array(
			'team_title',
			'team_status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$_sql .= " ORDER BY " . $data['sort'];
		} else {
			$_sql .= " ORDER BY date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$_sql .= " DESC";
		} else {
			$_sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$_sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		
		$query = $this->db->query($sql.$_sql);

		return $query->rows;
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