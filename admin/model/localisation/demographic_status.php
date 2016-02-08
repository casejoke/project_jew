<?php
class ModelLocalisationDemographicStatus extends Model {
  public function addDemographicStatus($data) {
    foreach ($data['demographic_status'] as $language_id => $value) {
      if (isset($demographic_status_id)) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "demographic_status SET demographic_status_id = '" . (int)$demographic_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . "demographic_status SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

        $demographic_status_id = $this->db->getLastId();
      }
    }

    $this->cache->delete('demographic_status');
  }

  public function editDemographicStatus($demographic_status_id, $data) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "demographic_status WHERE demographic_status_id = '" . (int)$demographic_status_id . "'");

    foreach ($data['demographic_status'] as $language_id => $value) {
      $this->db->query("INSERT INTO " . DB_PREFIX . "demographic_status SET demographic_status_id = '" . (int)$demographic_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
    }

    $this->cache->delete('demographic_status');
  }

  public function deleteDemographicStatus($demographic_status_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "demographic_status WHERE demographic_status_id = '" . (int)$demographic_status_id . "'");

    $this->cache->delete('demographic_status');
  }

  public function getDemographicStatus($demographic_status_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "demographic_status WHERE demographic_status_id = '" . (int)$demographic_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row;
  }

  public function getDemographicStatuses($data = array()) {
    if ($data) {
      $sql = "SELECT * FROM " . DB_PREFIX . "demographic_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
      $demographic_status_data = $this->cache->get('demographic_status.' . (int)$this->config->get('config_language_id'));

      if (!$demographic_status_data) {
        $query = $this->db->query("SELECT demographic_status_id, name FROM " . DB_PREFIX . "demographic_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

        $demographic_status_data = $query->rows;

        $this->cache->set('demographic_status.' . (int)$this->config->get('config_language_id'), $demographic_status_data);
      }

      return $demographic_status_data;
    }
  }

  public function getDemographicStatusDescriptions($demographic_status_id) {
    $demographic_status_data = array();

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "demographic_status WHERE demographic_status_id = '" . (int)$demographic_status_id . "'");

    foreach ($query->rows as $result) {
      $demographic_status_data[$result['language_id']] = array('name' => $result['name']);
    }

    return $demographic_status_data;
  }

  public function getTotalDemographicStatuses() {
    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "demographic_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row['total'];
  }
}