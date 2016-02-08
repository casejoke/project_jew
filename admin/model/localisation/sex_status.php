<?php
class ModelLocalisationSexStatus extends Model {
  public function addSexStatus($data) {
    foreach ($data['sex_status'] as $language_id => $value) {
      if (isset($sex_status_id)) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "sex_status SET sex_status_id = '" . (int)$sex_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . "sex_status SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

        $sex_status_id = $this->db->getLastId();
      }
    }

    $this->cache->delete('sex_status');
  }

  public function editSexStatus($sex_status_id, $data) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "sex_status WHERE sex_status_id = '" . (int)$sex_status_id . "'");

    foreach ($data['sex_status'] as $language_id => $value) {
      $this->db->query("INSERT INTO " . DB_PREFIX . "sex_status SET sex_status_id = '" . (int)$sex_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
    }

    $this->cache->delete('sex_status');
  }

  public function deleteSexStatus($sex_status_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "sex_status WHERE sex_status_id = '" . (int)$sex_status_id . "'");

    $this->cache->delete('sex_status');
  }

  public function getSexStatus($sex_status_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sex_status WHERE sex_status_id = '" . (int)$sex_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row;
  }

  public function getSexStatuses($data = array()) {
    if ($data) {
      $sql = "SELECT * FROM " . DB_PREFIX . "sex_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
      $sex_status_data = $this->cache->get('sex_status.' . (int)$this->config->get('config_language_id'));

      if (!$sex_status_data) {
        $query = $this->db->query("SELECT sex_status_id, name FROM " . DB_PREFIX . "sex_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

        $sex_status_data = $query->rows;

        $this->cache->set('sex_status.' . (int)$this->config->get('config_language_id'), $sex_status_data);
      }

      return $sex_status_data;
    }
  }

  public function getSexStatusDescriptions($sex_status_id) {
    $sex_status_data = array();

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sex_status WHERE sex_status_id = '" . (int)$sex_status_id . "'");

    foreach ($query->rows as $result) {
      $sex_status_data[$result['language_id']] = array('name' => $result['name']);
    }

    return $sex_status_data;
  }

  public function getTotalSexStatuses() {
    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sex_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row['total'];
  }
}