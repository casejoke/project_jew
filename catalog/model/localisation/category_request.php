<?php
class ModelLocalisationCategoryRequest extends Model {
  public function addCategoryRequest($data) {
    foreach ($data['category_request'] as $language_id => $value) {
      if (isset($category_request_id)) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "category_request SET 
          category_request_id = '" . (int)$category_request_id . "', 
          language_id = '" . (int)$language_id . "', 
          name = '" . $this->db->escape($value['name']) . "',
          sort_order = '" . (int)$value['sort_order'] . "'
        ");
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . "category_request SET 
          language_id = '" . (int)$language_id . "', 
          name = '" . $this->db->escape($value['name']) . "',
          sort_order = '" . (int)$value['sort_order'] . "'
        ");

        $category_request_id = $this->db->getLastId();
      }
    }

    $this->cache->delete('category_request');
  }

  public function editCategoryRequest($category_request_id, $data) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "category_request WHERE category_request_id = '" . (int)$category_request_id . "'");

    foreach ($data['category_request'] as $language_id => $value) {
      $this->db->query("INSERT INTO " . DB_PREFIX . "category_request SET 
          category_request_id = '" . (int)$category_request_id . "', 
          language_id = '" . (int)$language_id . "', 
          name = '" . $this->db->escape($value['name']) . "',
          sort_order = '" . (int)$value['sort_order'] . "'
        ");
       }

    $this->cache->delete('category_request');
  }

  public function deleteCategoryRequest($category_request_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "category_request WHERE category_request_id = '" . (int)$category_request_id . "'");

    $this->cache->delete('category_request');
  }

  public function getCategoryRequest($category_request_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_request WHERE category_request_id = '" . (int)$category_request_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row;
  }

  public function getCategoryRequestes($data = array()) {
    if ($data) {
      $sql = "SELECT * FROM " . DB_PREFIX . "category_request WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

      $sql .= " ORDER BY sort_order";

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
    } else {
      $category_request_data = $this->cache->get('category_request.' . (int)$this->config->get('config_language_id'));

      if (!$category_request_data) {
        $query = $this->db->query("SELECT category_request_id, name FROM " . DB_PREFIX . "category_request WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

        $category_request_data = $query->rows;

        $this->cache->set('category_request.' . (int)$this->config->get('config_language_id'), $category_request_data);
      }

      return $category_request_data;
    }
  }

  public function getCategoryRequestDescriptions($category_request_id) {
    $category_request_data = array();

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_request WHERE category_request_id = '" . (int)$category_request_id . "'");

    foreach ($query->rows as $result) {
      $category_request_data[$result['language_id']] = array(
          'name' => $result['name'],
          'sort_order' => $result['sort_order']
      );
    }

    return $category_request_data;
  }

  public function getTotalCategoryRequestes() {
    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_request WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row['total'];
  }
}