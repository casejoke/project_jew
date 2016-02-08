<?php
class ModelAccountPromocode extends Model {
	public function getPromocodes($data=array()) {
		
		if(empty($data)){
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_promocode";
		}else{
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_promocode WHERE";
		}

		$_str =array();
		if (!empty($data['filter_customer_id'])) {
			$_str[] =	" customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}
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
		$query = $this->db->query($sql.$_sql);
		return $query->rows;
	}
	public function getPromocodeDescription($promocode_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_to_promocode WHERE promocode_id = '" . $this->db->escape($promocode_id)  . "'");

		return $query->row;
	}
	public function addPromocode($promocode_id){
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_to_promocode SET 
			promocode_id = '" . $this->db->escape($promocode_id) . "',
			status = '1',
			date_added = NOW()");
		$customer_promocode_id = $this->db->getLastId();
		return $customer_promocode_id;
	}
	public function activatePromocode($promocode_id,$customer_id){
		 $this->db->query("UPDATE " . DB_PREFIX . "customer_to_promocode SET 
		  customer_id = '" . (int)$customer_id . "',	
	      status = '0'
	      WHERE promocode_id = '" . $this->db->escape($promocode_id) . "'");

	}
}