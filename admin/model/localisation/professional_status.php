<?php
class ModelLocalisationProfessionalStatus extends Model {
  public function addProfessionalStatus($data) {
    foreach ($data['professional_status'] as $language_id => $value) {
      if (isset($professional_status_id)) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "professional_status SET professional_status_id = '" . (int)$professional_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . "professional_status SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

        $professional_status_id = $this->db->getLastId();
      }
    }

    $this->cache->delete('professional_status');
  }

  public function editProfessionalStatus($professional_status_id, $data) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "professional_status WHERE professional_status_id = '" . (int)$professional_status_id . "'");

    foreach ($data['professional_status'] as $language_id => $value) {
      $this->db->query("INSERT INTO " . DB_PREFIX . "professional_status SET professional_status_id = '" . (int)$professional_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
    }

    $this->cache->delete('professional_status');
  }

  public function deleteProfessionalStatus($professional_status_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "professional_status WHERE professional_status_id = '" . (int)$professional_status_id . "'");

    $this->cache->delete('professional_status');
  }

  public function getProfessionalStatus($professional_status_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "professional_status WHERE professional_status_id = '" . (int)$professional_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row;
  }

  public function getProfessionalStatuses($data = array()) {
    if ($data) {
      $sql = "SELECT * FROM " . DB_PREFIX . "professional_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
      $professional_status_data = $this->cache->get('professional_status.' . (int)$this->config->get('config_language_id'));

      if (!$professional_status_data) {
        $query = $this->db->query("SELECT professional_status_id, name FROM " . DB_PREFIX . "professional_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

        $professional_status_data = $query->rows;

        $this->cache->set('professional_status.' . (int)$this->config->get('config_language_id'), $professional_status_data);
      }

      return $professional_status_data;
    }
  }

  public function getProfessionalStatusDescriptions($professional_status_id) {
    $professional_status_data = array();

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "professional_status WHERE professional_status_id = '" . (int)$professional_status_id . "'");

    foreach ($query->rows as $result) {
      $professional_status_data[$result['language_id']] = array('name' => $result['name']);
    }

    return $professional_status_data;
  }

  public function getTotalProfessionalStatuses() {
    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "professional_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row['total'];
  }
}