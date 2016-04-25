<?php
class ControllerContestRequest extends Controller {
  private $error = array();

  public function index() {
    $this->load->language('contest/contest_request');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('contest/contest_request');

    $this->getList();
  }

  public function add() {
    $this->load->language('contest/contest_request');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('contest/contest_request');

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      $this->model_contest_contest_request->addRequest($this->request->post);

      $this->session->data['success'] = $this->language->get('text_success');

      $url = '';

      if (isset($this->request->get['sort'])) {
        $url .= '&sort=' . $this->request->get['sort'];
      }

      if (isset($this->request->get['order'])) {
        $url .= '&order=' . $this->request->get['order'];
      }

      if (isset($this->request->get['page'])) {
        $url .= '&page=' . $this->request->get['page'];
      }

      $this->response->redirect($this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    $this->getForm();
  }

  public function edit() {
    $this->load->language('contest/contest_request');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('contest/contest_request');

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      $this->model_contest_contest_request->editRequest($this->request->get['customer_to_contest_id'], $this->request->post);

      $this->session->data['success'] = $this->language->get('text_success');

      $url = '';

      if (isset($this->request->get['sort'])) {
        $url .= '&sort=' . $this->request->get['sort'];
      }

      if (isset($this->request->get['order'])) {
        $url .= '&order=' . $this->request->get['order'];
      }

      if (isset($this->request->get['page'])) {
        $url .= '&page=' . $this->request->get['page'];
      }

      $this->response->redirect($this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    $this->getForm();
  }

  public function delete() {
    $this->load->language('contest/contest_request');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('contest/contest_request');

    if (isset($this->request->post['selected']) && $this->validateDelete()) {
      foreach ($this->request->post['selected'] as $zone_id) {
        $this->model_contest_contest_request->deleteRequest($zone_id);
      }

      $this->session->data['success'] = $this->language->get('text_success');

      $url = '';

      if (isset($this->request->get['sort'])) {
        $url .= '&sort=' . $this->request->get['sort'];
      }

      if (isset($this->request->get['order'])) {
        $url .= '&order=' . $this->request->get['order'];
      }

      if (isset($this->request->get['page'])) {
        $url .= '&page=' . $this->request->get['page'];
      }

      $this->response->redirect($this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    $this->getList();
  }

  protected function getList() {


    //статусы заявки:
    // 0 - не принята (есть комментарий)
    // 1 - принята  (видна экспертам и  ее можно оценивать)
    // 2 - не обработана ()
    //$_['text_status_not_accepted']      = 'Не одобрена';
    //$_['text_status_accepted']          = 'Одобрена';
    //$_['text_status_processed']         = 'В обработке';




    if (isset($this->request->get['sort'])) {
      $sort = $this->request->get['sort'];
    } else {
      $sort = 'date_added';
    }

    if (isset($this->request->get['order'])) {
      $order = $this->request->get['order'];
    } else {
      $order = 'DESC';
    }

    if (isset($this->request->get['page'])) {
      $page = $this->request->get['page'];
    } else {
      $page = 1;
    }

    $url = '';

    if (isset($this->request->get['sort'])) {
      $url .= '&sort=' . $this->request->get['sort'];
    }

    if (isset($this->request->get['order'])) {
      $url .= '&order=' . $this->request->get['order'];
    }

    if (isset($this->request->get['page'])) {
      $url .= '&page=' . $this->request->get['page'];
    }

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('heading_title'),
      'href' => $this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url, 'SSL')
    );

    $data['add'] = $this->url->link('contest/contest_request/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
    $data['delete'] = $this->url->link('contest/contest_request/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

    //подтянем список всех пользователей
    $this->load->model('sale/customer');
    $filter_data = array();
    $results = $this->model_sale_customer->getCustomers($filter_data);
    $customers = array();
    foreach ($results as $result) {

      $customers[$result['customer_id']] = array(
        'customer_id'    => $result['customer_id'],
        'name'           => $result['name']
      );
    }


    //подтянем полный список конкурсов
    $this->load->model('contest/contest');
    $contests_results = $this->model_contest_contest->getContests();

    if (!empty($contests_results)){
      $contests = array();
      foreach ($contests_results as $result) {
        $contests[$result['contest_id']] = array(
          'contest_id'  => $result['contest_id'],
          'title'         => $result['title'],
          'contest_type'  => $result['type'],
          'contest_date'  => rus_date($this->language->get('default_date_format'), strtotime($result['date_start'])),
          'edit'          => $this->url->link('contest/contest/edit', 'token=' . $this->session->data['token'] . '&contest_id=' . $result['contest_id'] . $url, 'SSL')
        );
      }
    }


    $results_projects = $this->model_contest_contest->getProjects();
    $projects = array();
    foreach ($results_projects as $result_p) {
      $projects[$result_p['project_id']] = array(
        'project_id'      => $result_p['project_id'],
        'project_title'     => $result_p['title']
      );
    }




    $data['contest_requests'] = array();

    $filter_data = array(
      'sort'  => $sort,
      'order' => $order,
      'start' => ($page - 1) * $this->config->get('config_limit_admin'),
      'limit' => $this->config->get('config_limit_admin')
    );

    $contest_request_total = $this->model_contest_contest_request->getTotalRequests();

    $results = $this->model_contest_contest_request->getRequests($filter_data);
      // 0 - не принята (есть комментарий)
    // 1 - принята  (видна экспертам и  ее можно оценивать)
    // 2 - не обработана ()
    //$_['text_status_not_accepted']      = 'Не одобрена';
    //$_['text_status_accepted']          = 'Одобрена';
    //$_['text_status_processed']         = 'В обработк
    $data['text_status_not_accepted']   = $this->language->get('text_status_not_accepted');
    $data['text_status_accepted']       = $this->language->get('text_status_accepted');
    $data['text_status_processed']      = $this->language->get('text_status_processed');
    foreach ($results as $result) {

      $status_text = '';

      switch ((int)$result['status']) {
        case '0':
          $status_text = $this->language->get('text_status_not_accepted');
          break;
        case '1':
          $status_text = $this->language->get('text_status_accepted');
          break;
        case '2':
          $status_text = $this->language->get('text_status_processed');
          break;
        default:
          $status_text = $this->language->get('text_status_processed');
          break;
      }


      $status_text = '';

      switch ((int)$result['status']) {
        case '0':
          $status_text = '';
          break;
        case '1':
          $status_text = $this->language->get('text_status_accepted');
          break;
        case '2':
          $status_text = $this->language->get('text_status_processed');
          break;
        default:
          $status_text = $this->language->get('text_status_processed');
          break;
      }


      $contest_type = (!empty($contests[$result['contest_id']]))?$contests[$result['contest_id']]['contest_type']:0;



      $adaptive_id_text = '';

      switch ((int)$contest_type) {
        case '1':
          $adaptive_id_text = '';;
          break;
        case '2':
          $adaptive_id_text = '';;
          break;
        case '3':
            //проект котрый адаптирует
            $adaptive_id = $result['adaptive_id'];
            $adaptive_id_text = $projects[$adaptive_id]['project_title'];
          break;
        default:
          $adaptive_id_text = '';;
          break;
      }

      $data['contest_requests'][] = array(
        'customer_to_contest_id'  => $result['customer_to_contest_id'],
        'customer_id'         => $customers[$result['customer_id']]['name'],
        'adaptive_title'      => $adaptive_id_text,
        'contest_id'          => (!empty($contests[$result['contest_id']]))?$contests[$result['contest_id']]['title']:'',
        'status'            => $status_text,
        'date_added'          => rus_date($this->language->get('datetime_format'), strtotime($result['date_added'])),
        'edit'              => $this->url->link('contest/contest_request/edit', 'token=' . $this->session->data['token'] . '&customer_to_contest_id=' . $result['customer_to_contest_id'] . $url, 'SSL')
      );
    }

    $data['heading_title']    = $this->language->get('heading_title');

    $data['text_list']      = $this->language->get('text_list');
    $data['text_no_results']  = $this->language->get('text_no_results');
    $data['text_confirm']     = $this->language->get('text_confirm');

    $data['column_customer']  = $this->language->get('column_customer');
    $data['column_contest']   = $this->language->get('column_contest');
    $data['column_status']    = $this->language->get('column_status');
    $data['column_action']    = $this->language->get('column_action');

    $data['button_add'] = $this->language->get('button_add');
    $data['button_edit'] = $this->language->get('button_edit');
    $data['button_delete'] = $this->language->get('button_delete');

    if (isset($this->error['warning'])) {
      $data['error_warning'] = $this->error['warning'];
    } else {
      $data['error_warning'] = '';
    }

    if (isset($this->session->data['success'])) {
      $data['success'] = $this->session->data['success'];

      unset($this->session->data['success']);
    } else {
      $data['success'] = '';
    }

    if (isset($this->request->post['selected'])) {
      $data['selected'] = (array)$this->request->post['selected'];
    } else {
      $data['selected'] = array();
    }

    $url = '';

    if ($order == 'ASC') {
      $url .= '&order=DESC';
    } else {
      $url .= '&order=ASC';
    }

    if (isset($this->request->get['page'])) {
      $url .= '&page=' . $this->request->get['page'];
    }


    $data['sort_contest_id'] = $this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . '&sort=contest_id' . $url, 'SSL');

    $url = '';

    if (isset($this->request->get['sort'])) {
      $url .= '&sort=' . $this->request->get['sort'];
    }

    if (isset($this->request->get['order'])) {
      $url .= '&order=' . $this->request->get['order'];
    }

    $pagination = new Pagination();
    $pagination->total = $contest_request_total;
    $pagination->page = $page;
    $pagination->limit = $this->config->get('config_limit_admin');
    $pagination->url = $this->url->link('contest/contest_request', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

    $data['pagination'] = $pagination->render();

    $data['results'] = sprintf($this->language->get('text_pagination'), ($contest_request_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($contest_request_total - $this->config->get('config_limit_admin'))) ? $contest_request_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $contest_request_total, ceil($contest_request_total / $this->config->get('config_limit_admin')));

    $data['sort'] = $sort;
    $data['order'] = $order;

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('contest/request_list.tpl', $data));
  }

 



  protected function validateDelete() {
    if (!$this->user->hasPermission('modify', 'contest/contest_request')) {
      $this->error['warning'] = $this->language->get('error_permission');
    }

    $this->load->model('setting/store');
    $this->load->model('sale/customer');
    $this->load->model('marketing/affiliate');
    $this->load->model('localisation/geo_zone');

    foreach ($this->request->post['selected'] as $zone_id) {
      if ($this->config->get('config_zone_id') == $zone_id) {
        $this->error['warning'] = $this->language->get('error_default');
      }

      $store_total = $this->model_setting_store->getTotalStoresByRequestId($zone_id);

      if ($store_total) {
        $this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
      }

      $address_total = $this->model_sale_customer->getTotalAddressesByRequestId($zone_id);

      if ($address_total) {
        $this->error['warning'] = sprintf($this->language->get('error_address'), $address_total);
      }

      $affiliate_total = $this->model_marketing_affiliate->getTotalAffiliatesByRequestId($zone_id);

      if ($affiliate_total) {
        $this->error['warning'] = sprintf($this->language->get('error_affiliate'), $affiliate_total);
      }

      $zone_to_geo_contest_request_total = $this->model_localisation_geo_zone->getTotalRequestToGeoRequestByRequestId($zone_id);

      if ($zone_to_geo_contest_request_total) {
        $this->error['warning'] = sprintf($this->language->get('error_zone_to_geo_zone'), $zone_to_geo_contest_request_total);
      }
    }

    return !$this->error;
  }
}
