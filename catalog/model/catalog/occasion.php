<?php
class ModelCatalogOccasion extends Model {
	
	public function getOccasion($occasion_id) {
		$query = $this->db->query("SELECT DISTINCT  *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'occasion_id=" . (int)$occasion_id . "') AS keyword FROM " . DB_PREFIX . "occasion d LEFT JOIN " . DB_PREFIX . "occasion_description dd ON (d.occasion_id = dd.occasion_id) WHERE d.occasion_id = '" . (int)$occasion_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function addPlayerToOccasion($data=array(),$customer_id){
		///$this->event->trigger('pre.recordtooccasion.add', $data);


		$this->db->query("INSERT INTO " . DB_PREFIX . "occasion_record SET 
			occasion_id = '" . (int)$data['occasion_id'] . "', 
			firstname = '" . $this->db->escape($data['firstname']) . "', 
			lastname = '" . $this->db->escape($data['lastname']) . "', 
			email = '" . $this->db->escape($data['email']) . "', 
			telephone = '" . $this->db->escape($data['telephone']) . "',
			customer_id = '" . (int)$customer_id . "', 
			ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', 
			status = '1',
		    date_added = NOW()");
		$occasion_record_id = $this->db->getLastId();
		
		$this->load->language('mail/recordtooccasion');

		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

		$message = sprintf($this->language->get('text_welcome'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
		//$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			
		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject($subject);
		$mail->setText($message);
		$mail->send();

		// Send to main admin email if new account email is enabled
		if ($this->config->get('config_account_mail')) {
			$message  = $this->language->get('text_signup') . "\n\n";
			//$message .= $this->language->get('text_website') . ' ' . html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8') . "\n";
			$message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
			$message .= $this->language->get('text_lastname') . ' ' . $data['lastname'] . "\n";
			//$message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";
			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			
			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'));
			$mail->setText($message);
			$mail->send();

			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_mail_alert'));

			foreach ($emails as $email) {
				if (utf8_strlen($email) > 0 && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}
		
		return $occasion_record_id;
		//$this->event->trigger('post.recordtooccasion.add', $customer_id);
	}
	public function getOccasions($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "occasion 
			d LEFT JOIN " . DB_PREFIX . "occasion_description dd ON (d.occasion_id = dd.occasion_id) WHERE 
			dd.language_id = '" . (int)$this->config->get('config_language_id') . "'
		";

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND d.status = '" . (int)$data['filter_status'] . "'";
		}
		if (!empty($data['filter_occasion_date'])) {
			$sql .= " AND DATE(d.occasion_date) >= '" . $this->db->escape($data['filter_occasion_date']) . "' ";
			//$sql .= " AND DATE(d.occasion_added) >= NOW()";
		}

		if (!empty($data['filter_begin_date']) && !empty($data['filter_end_date']) ) {
			$sql .= " AND d.occasion_date BETWEEN 
			STR_TO_DATE('" . $this->db->escape($data['filter_begin_date']) . "', '%Y-%m-%d %H:%i:%s') AND 
			STR_TO_DATE('" . $this->db->escape($data['filter_end_date']) . "', '%Y-%m-%d %H:%i:%s') ";
			//$sql .= " AND DATE(d.occasion_added) >= NOW()";
		}


		$sort_data = array(
			'dd.title',
			'd.date_added',
			'd.occasion_date',
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

	public function getOccasionDescriptions($occasion_id) {
		$occasion_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "occasion_description WHERE occasion_id = '" . (int)$occasion_id . "'");

		foreach ($query->rows as $result) {
			$occasion_description_data[$result['language_id']] = array(
				'title' => $result['title']
			);
		}

		return $occasion_description_data;
	}

	public function getTotalOccasions() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "occasion");

		return $query->row['total'];
	}
	public function getOccasionsToOccasionGroups(){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "occasion_to_occasion_group");

		return $query->rows;
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