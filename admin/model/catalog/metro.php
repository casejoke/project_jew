<?php
class ModelCatalogMetro extends Model {
	public function getList($city_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "metro WHERE 
			city_id = '" . (int)$city_id . "' 
		");
		return $query->rows;
	}
}