<?php
class ModelLocalisationProjectStatus extends Model {
  public function addProjectStatus($data) {
    foreach ($data['project_status'] as $language_id => $value) {
      if (isset($project_status_id)) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "project_status SET project_status_id = '" . (int)$project_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . "project_status SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

        $project_status_id = $this->db->getLastId();
      }
    }

    $this->cache->delete('project_status');
  }

  public function editProjectStatus($project_status_id, $data) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "project_status WHERE project_status_id = '" . (int)$project_status_id . "'");

    foreach ($data['project_status'] as $language_id => $value) {
      $this->db->query("INSERT INTO " . DB_PREFIX . "project_status SET project_status_id = '" . (int)$project_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
    }

    $this->cache->delete('project_status');
  }

  public function deleteProjectStatus($project_status_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "project_status WHERE project_status_id = '" . (int)$project_status_id . "'");

    $this->cache->delete('project_status');
  }

  public function getProjectStatus($project_status_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "project_status WHERE project_status_id = '" . (int)$project_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row;
  }

  public function getProjectStatuses($data = array()) {
    if ($data) {
      $sql = "SELECT * FROM " . DB_PREFIX . "project_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
      $project_status_data = $this->cache->get('project_status.' . (int)$this->config->get('config_language_id'));

      if (!$project_status_data) {
        $query = $this->db->query("SELECT project_status_id, name FROM " . DB_PREFIX . "project_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

        $project_status_data = $query->rows;

        $this->cache->set('project_status.' . (int)$this->config->get('config_language_id'), $project_status_data);
      }

      return $project_status_data;
    }
  } 

  public function getProjectStatusDescriptions($project_status_id) {
    $project_status_data = array();

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "project_status WHERE project_status_id = '" . (int)$project_status_id . "'");

    foreach ($query->rows as $result) {
      $project_status_data[$result['language_id']] = array('name' => $result['name']);
    }

    return $project_status_data;
  }

  public function getTotalProjectStatuses() {
    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "project_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row['total'];
  }
}