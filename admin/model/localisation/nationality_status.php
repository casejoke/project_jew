<?php
class ModelLocalisationNationalityStatus extends Model {
  public function addNationalityStatus($data) {
    foreach ($data['nationality_status'] as $language_id => $value) {
      if (isset($nationality_status_id)) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "nationality_status SET nationality_status_id = '" . (int)$nationality_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . "nationality_status SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

        $nationality_status_id = $this->db->getLastId();
      }
    }

    $this->cache->delete('nationality_status');
  }

  public function editNationalityStatus($nationality_status_id, $data) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "nationality_status WHERE nationality_status_id = '" . (int)$nationality_status_id . "'");

    foreach ($data['nationality_status'] as $language_id => $value) {
      $this->db->query("INSERT INTO " . DB_PREFIX . "nationality_status SET nationality_status_id = '" . (int)$nationality_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
    }

    $this->cache->delete('nationality_status');
  }

  public function deleteNationalityStatus($nationality_status_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "nationality_status WHERE nationality_status_id = '" . (int)$nationality_status_id . "'");

    $this->cache->delete('nationality_status');
  }

  public function getNationalityStatus($nationality_status_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nationality_status WHERE nationality_status_id = '" . (int)$nationality_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row;
  }

  public function getNationalityStatuses($data = array()) {
    if ($data) {
      $sql = "SELECT * FROM " . DB_PREFIX . "nationality_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
      $nationality_status_data = $this->cache->get('nationality_status.' . (int)$this->config->get('config_language_id'));

      if (!$nationality_status_data) {
        $query = $this->db->query("SELECT nationality_status_id, name FROM " . DB_PREFIX . "nationality_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

        $nationality_status_data = $query->rows;

        $this->cache->set('nationality_status.' . (int)$this->config->get('config_language_id'), $nationality_status_data);
      }

      return $nationality_status_data;
    }
  }

  public function getNationalityStatusDescriptions($nationality_status_id) {
    $nationality_status_data = array();

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nationality_status WHERE nationality_status_id = '" . (int)$nationality_status_id . "'");

    foreach ($query->rows as $result) {
      $nationality_status_data[$result['language_id']] = array('name' => $result['name']);
    }

    return $nationality_status_data;
  }

  public function getTotalNationalityStatuses() {
    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "nationality_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row['total'];
  }
}