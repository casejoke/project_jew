<?php
class ModelCatalogNews extends Model {	
	public function getNews($news_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON n.news_id = nd.news_id WHERE n.news_id = '" . (int)$news_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
 	
	public function getAllNews($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON n.news_id = nd.news_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' ORDER BY date_added DESC";
		
		if (isset($data['start']) && isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			
			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getTotalNews() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news");
	
		return $query->row['total'];
	}



	public function getListAnons($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON n.news_id = nd.news_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND customer_id !=0 ORDER BY date_added DESC";
		
		if (isset($data['start']) && isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			
			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	public function addNews($data) {



		$this->db->query("INSERT INTO " . DB_PREFIX . "news SET 
			customer_id  = '" .(int)$data['customer_id'] . "',
			country  = '" .$this->db->escape($data['country']) . "',
			city  = '" .$this->db->escape($data['city']) . "',
			init_group_id  = '" .(int)$data['init_group_id'] . "',
			image = '" . $this->db->escape($data['image']) . "', 
			date_added = '" . $this->db->escape($data['date_added']) . "', 
			status = '" . (int)$data['status'] . "'
		");
		
		$news_id = $this->db->getLastId();
		
		foreach ($data['news_description'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX ."news_description SET 
				news_id = '" . (int)$news_id . "', 
				language_id = '" . (int)$key . "', 
				title = '" . $this->db->escape($value['title']) . "', 
				description = '" . $this->db->escape($value['description']) . "', 
				short_description = '" . $this->db->escape($value['short_description']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		return $news_id;
	}
}