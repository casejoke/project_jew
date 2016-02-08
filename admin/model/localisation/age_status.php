<?php
class ModelLocalisationAgeStatus extends Model {
  public function addAgeStatus($data) {
    foreach ($data['age_status'] as $language_id => $value) {
      if (isset($age_status_id)) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "age_status SET age_status_id = '" . (int)$age_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . "age_status SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

        $age_status_id = $this->db->getLastId();
      }
    }

    $this->cache->delete('age_status');
  }

  public function editAgeStatus($age_status_id, $data) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "age_status WHERE age_status_id = '" . (int)$age_status_id . "'");

    foreach ($data['age_status'] as $language_id => $value) {
      $this->db->query("INSERT INTO " . DB_PREFIX . "age_status SET age_status_id = '" . (int)$age_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
    }

    $this->cache->delete('age_status');
  }

  public function deleteAgeStatus($age_status_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "age_status WHERE age_status_id = '" . (int)$age_status_id . "'");

    $this->cache->delete('age_status');
  }

  public function getAgeStatus($age_status_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "age_status WHERE age_status_id = '" . (int)$age_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row;
  }

  public function getAgeStatuses($data = array()) {
    if ($data) {
      $sql = "SELECT * FROM " . DB_PREFIX . "age_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

      $sql .= " ORDER BY name";

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
      $age_status_data = $this->cache->get('age_status.' . (int)$this->config->get('config_language_id'));

      if (!$age_status_data) {
        $query = $this->db->query("SELECT age_status_id, name FROM " . DB_PREFIX . "age_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

        $age_status_data = $query->rows;

        $this->cache->set('age_status.' . (int)$this->config->get('config_language_id'), $age_status_data);
      }

      return $age_status_data;
    }
  }

  public function getAgeStatusDescriptions($age_status_id) {
    $age_status_data = array();

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "age_status WHERE age_status_id = '" . (int)$age_status_id . "'");

    foreach ($query->rows as $result) {
      $age_status_data[$result['language_id']] = array('name' => $result['name']);
    }

    return $age_status_data;
  }

  public function getTotalAgeStatuses() {
    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "age_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row['total'];
  }
}