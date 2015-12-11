<?php
/**
 * Оценка  
 */
class ControllerContestEstimate extends Controller {
  private $error = array();
  //создаем группу
  public function index(){
    if ( !isset($this->request->get['request_id']) ) {
      $this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
      $this->response->redirect($this->url->link('account/account', '', 'SSL'));
      
    }
    
    $this->getView();
  }
  
  private function getView(){
    //подгрузим язык
    $this->load->language('contest/send');
    //SEO
    $this->document->setTitle($this->language->get('entry_title'));
    //$this->document->setDescription(substr(strip_tags(html_entity_decode($contest_info['meta_description'], ENT_QUOTES)), 0, 150) . '...');
    //$this->document->setKeywords($contest_info['meta_keyword']);

    

    
    //подгрузим модели
    $this->load->model('account/customer');
    $this->load->model('contest/contest');
    $this->load->model('contest/contest_field');
    $this->load->model('project/project');
    $this->load->model('group/group');
    $this->load->model('tool/upload');
    $this->load->model('tool/image');
    $this->load->model('localisation/category_request');
    
//*************************** проверки ********************************//
   

    //проверка на сушествование пользователя и логина в системе
    if (!$this->customer->isLogged()) {
      $this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
      $this->response->redirect($this->url->link('account/account', '', 'SSL'));
    }
    //id эксперта 
    $customer_id = $this->customer->getId();
     //номер заявки в системе
    $request_id = $this->request->get['request_id'];

    //получим инфу о заявке
    $result_request_information = $this->model_contest_contest->getInformationAboutRequest($request_id);
    if (empty($result_request_information)) {
      $this->session->data['warning'] = 'Извините. Заявка уже обработана';
      $this->response->redirect($this->url->link('account/account', '', 'SSL'));
    }
    //проверка на сушествование конкурса
    $contest_info = array();
    $contest_id = $result_request_information['contest_id'];
    $contest_info = $this->model_contest_contest->getContest($contest_id);
    if ( empty($contest_info) ){
      //редиректим на список конкурсов
      $this->session->data['redirect'] = $this->url->link('contest/contest', '', 'SSL');
      $this->response->redirect($this->url->link('contest/contest', '', 'SSL'));
    }
    //если конкурс в статусе работа - редирект
    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


    //проверяем стату конкурса и даты 
    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//*************************** проверки ********************************//   

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

      $this->model_contest_contest->addRequestToContest($this->request->post,$customer_id,$contest_id);
      $this->session->data['success'] = $this->language->get('text_contest_success');
      // Add to activity log
      $this->load->model('account/activity');

      $activity_data = array(
        'customer_id' => $customer_id,
        'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
      );

      $this->model_account_activity->addActivity('add request to contest', $activity_data);

      $this->response->redirect($this->url->link('account/account', '', 'SSL'));
    }

    if (isset($this->error['warning'])) {
      $data['error_warning'] = $this->error['warning'];
    } else {
      $data['error_warning'] = '';
    }

    $data['breadcrumbs'] = array();
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/home')
    );
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_contests'),
      'href' => $this->url->link('contest/contest', '', 'SSL')
    );
    $data['breadcrumbs'][] = array(
      'text' => $contest_info['title'],
      'href' => $this->url->link('contest/estimate', 'request_id=' . $this->request->get['request_id'], 'SSL')
    );

    $data['entry_title']              = $this->language->get('entry_title');
    $data['entry_description']        = $this->language->get('entry_description');
    $data['entry_image']              = $this->language->get('entry_image');
    $data['entry_contest_birthday']   = $this->language->get('entry_contest_birthday');
    $data['entry_contest_email']      = $this->language->get('entry_contest_email'); 
    
    $data['entry_contest_dates']          = $this->language->get('entry_contest_dates'); 
    $data['entry_contest_date_start']     = $this->language->get('entry_contest_date_start'); 
    $data['entry_contest_datetime_end']   = $this->language->get('entry_contest_datetime_end'); 
    $data['entry_contest_date_rate']      = $this->language->get('entry_contest_date_rate'); 
    $data['entry_contest_date_result']    = $this->language->get('entry_contest_date_result'); 
    $data['entry_contest_date_finalist']  = $this->language->get('entry_contest_date_finalist'); 

    $data['entry_contest_organizer']    = $this->language->get('entry_contest_organizer'); 
    $data['entry_contest_budget']       = $this->language->get('entry_contest_budget');
    $data['entry_contest_propose']      = $this->language->get('entry_contest_propose'); 
    $data['entry_contest_location']     = $this->language->get('entry_contest_location'); 
    $data['entry_contest_members']      = $this->language->get('entry_contest_members'); 
    $data['entry_contest_contacts']     = $this->language->get('entry_contest_contacts'); 
    $data['entry_contest_timeline_text']  = $this->language->get('entry_contest_timeline_text'); 
    $data['entry_contest_budget']       = $this->language->get('entry_contest_budget'); 
    $data['entry_contest_maxprice']     = $this->language->get('entry_contest_maxprice'); 
    $data['entry_contest_totalprice']   = $this->language->get('entry_contest_totalprice'); 
    
    $data['text_create']          = $this->language->get('text_create');
    $data['text_member']          = $this->language->get('text_member');
    $data['text_submit']          = $this->language->get('text_submit');
    $data['text_select']          = $this->language->get('text_select');


    $data['contest_title']            = html_entity_decode($contest_info['title'], ENT_QUOTES, 'UTF-8');
    $data['contest_description']      = html_entity_decode($contest_info['description'], ENT_QUOTES, 'UTF-8');
    $data['contest_organizer']        = html_entity_decode($contest_info['organizer'], ENT_QUOTES, 'UTF-8');
    $data['contest_propose']          = html_entity_decode($contest_info['propose'], ENT_QUOTES, 'UTF-8');
    $data['contest_location']         = html_entity_decode($contest_info['location'], ENT_QUOTES, 'UTF-8');
    $data['contest_members']          = html_entity_decode($contest_info['members'], ENT_QUOTES, 'UTF-8');
    $data['contest_contacts']         = html_entity_decode($contest_info['contacts'], ENT_QUOTES, 'UTF-8');
    $data['contest_timeline_text']    = html_entity_decode($contest_info['timeline_text'], ENT_QUOTES, 'UTF-8');

    $data['contest_date_start']       = rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_start']));
    $data['contest_datetime_end']     = rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['datetime_end']));
    $data['contest_date_rate']        = rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_rate']));
    $data['contest_date_result']      = rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_result']));
    $data['contest_date_finalist']    = rus_date($this->language->get('date_day_date_format'), strtotime($contest_info['date_finalist']));

   
    //**************** сформируем данные заявки ******************//
    //подтянем данные заявки
    $request_value = unserialize($result_request_information['value']);
    //конкурс на который подали заявку
    //$contest_id и $contest_info
    //пользователь который подал заявку
    $request_customer_id = $result_request_information['customer_id'];

    //подтянем список каетгорий для заявки на  конкурса
    $data['category_requestes'] = array();
    $filter_data = array(
      'order' => 'ASC'
    );
    $category_request_results = $this->model_localisation_category_request->getCategoryRequestes($filter_data);
    


    //подтянем поля для заполнения
    $results_contest_fields = $this->model_contest_contest_field->getContestFields();
    $contest_fields = array();
    foreach ($results_contest_fields as  $vccf) {
      $contest_fields[$vccf['contest_field_id']] = array(
        'contest_field_title'         => $vccf['name'],
        'contest_field_type'          => $vccf['type'],
        'contest_field_system'        => $vccf['field_system'],
        'contest_field_system_table'  => $vccf['field_system_table'],
      );
    }
    //ракрутим заявку
    $data['customer_field'] = array();
    foreach ($category_request_results as $crr) {
        $data_for_category = array();
        foreach ($request_value['custom_fields'] as $kr => $vr) {
          if($crr['category_request_id'] == $kr){
            foreach ($vr as $vvr) {
              $data_for_category[] = array(
                'field_id'    => $vvr['field_id'],
                'field_value' => $vvr['value'],
                'field_title' => $contest_fields[$vvr['field_id']]['contest_field_title']
              );
            }
          }
        }

        $data['category_requestes'][] = array(
          'category_request_id'   => $crr['category_request_id'],
          'name'                => $crr['name'],
          'category_fields'     =>$data_for_category
        );
    }
    
    print_r('<pre>');
    print_r($data['category_requestes']);
    print_r('</pre>');
    die();
    

   
  





    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_estimate.tpl')) {
      $this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/contest.js');
    } else {
      $this->document->addScript('catalog/view/theme/default/assets/js/contest.js');
    }

    $data['column_left'] = $this->load->controller('common/column_left');
    $data['column_right'] = $this->load->controller('common/column_right');
    $data['content_top'] = $this->load->controller('common/content_top');
    $data['content_bottom'] = $this->load->controller('common/content_bottom');
    $data['footer'] = $this->load->controller('common/footer');
    $data['header'] = $this->load->controller('common/header');


    

    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_estimate.tpl')) {
      
      $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/contest/contest_estimate.tpl', $data));
    } else {
      $this->response->setOutput($this->load->view('default/template/contest/contest_estimate.tpl', $data));
    }


  }
  protected function validate() {
    //подтянем все сушествующие поля и правила для них
    //подтянуть список всех полей заявки для каждой категории
      $this->load->model('contest/contest_field');
      $filter_data = array(
        'order' => 'ASC'
      );
      $contest_fields_results = $this->model_contest_contest_field->getContestFields($filter_data); 
      /*
            [contest_field_id] => 6
            [type] => textarea
            [field_system] => custom
            [field_system_table] => custom
            [value] => 
            [location] => 14 // id группы в заявке
            [required] => 0
            [status] => 1
            [sort_order] => 0
            [language_id] => 2
            [name] => Дополнителное образование

          */
       

      //подтянем список каетгорий для заявки на  конкурса
      $filter_data = array(
        'order' => 'ASC'
      );
      $category_request_results = $this->model_localisation_category_request->getCategoryRequestes($filter_data);
      foreach ($category_request_results as $crr) {
        if(!empty($this->request->post['custom_fields'][$crr['category_request_id']])){
          foreach ($this->request->post['custom_fields'][$crr['category_request_id']] as $category_key => $vcf) {
            
            //проверяем на обязательность заполнения
            foreach ($contest_fields_results as $value_cfr) {
              if ($value_cfr['contest_field_id'] == $vcf['field_id']) {
                //
                
                //$this->error['custom_fields'][$vcf['field_id']] = $this->language->get('error_email');

              }
            }
          }
        }
        
        } 

      


    /*






    foreach ($this->request->post['project_description'] as $language_id => $value) {
      if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
    //    $this->error['title'][$language_id] = $this->language->get('error_title');
      }

      if (utf8_strlen($value['description']) < 3) {
    //    $this->error['description'][$language_id] = $this->language->get('error_description');
      }

      if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
        $this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
      }

    }

    if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
      $this->error['lastname'] = $this->language->get('error_lastname');
    }

    if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
      $this->error['email'] = $this->language->get('error_email');
    }

    if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
      $this->error['warning'] = $this->language->get('error_exists');
    }

    if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
      $this->error['telephone'] = $this->language->get('error_telephone');
    }
    */

    return !$this->error;
  }

}