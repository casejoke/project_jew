<?php
/**
 * Утверждение заявки пользователем в конкурсе BP
 */
class ControllerContestAestimate extends Controller {
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
    $this->load->language('contest/estimate');
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


    //проверяем статус конкурса и даты
    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//*************************** проверки ********************************//

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

      $this->model_contest_contest->updateAEstimateToContest($this->request->post,$customer_id,$contest_id,$request_id);
      $this->session->data['success'] = 'Ваша оценка принята.';//$this->language->get('text_expert_request_contest_success');
      // Add to activity log
      $this->load->model('account/activity');

      $activity_data = array(
        'customer_id' => $customer_id,
        'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
      );

      $this->model_account_activity->addActivity('aestimate request to contest', $activity_data);

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
    //раcкрутим заявку
    $data['customer_field'] = array();
    foreach ($category_request_results as $crr) {
        $data_for_category = array();


        foreach ($request_value['custom_fields'] as $kr => $vr) {
          if($crr['category_request_id'] == $kr){
            foreach ($vr as $vvr) {

              $type = $contest_fields[$vvr['field_id']]['contest_field_type'];
              $value_field = '';
              if(!empty($vvr['value'])){
                 $value_field = $vvr['value'];
              }


              if( $contest_fields[$vvr['field_id']]['contest_field_system'] == 'project_age' && ( !empty($vvr['value']) && is_array($vvr['value']) == true) ){
                $type = 'list';
                $val_project_age = array();
                $result_project_age = $this->model_contest_contest_field->getProjectAges();
                foreach ($result_project_age  as $vpa) {
          foreach ($vvr['value'] as $vvvr) {
                      if($vpa['contest_field_value_id'] == $vvvr){
                        $val_project_age[] = array(
                          'title' =>  $vpa['name']
                        );
                      }
                    }
                }
                $value_field = $val_project_age;


              }

              if( $contest_fields[$vvr['field_id']]['contest_field_system'] == 'project_sex' && ( !empty($vvr['value']) && is_array($vvr['value']) == true) ){
                $type = 'list';
                $val_project_sex = array();
                $result_project_sex = $this->model_contest_contest_field->getProjectSexs();
                foreach ($result_project_age  as $vpa) {
                  foreach ($vvr['value'] as $vvvr) {
                              if($vpa['contest_field_value_id'] == $vvvr){
                                $val_project_sex[] = array(
                                  'title' =>  $vpa['name']
                                );
                              }
                            }
                        }
                        $value_field = $val_project_sex;


                      }

                      if( $contest_fields[$vvr['field_id']]['contest_field_system'] == 'project_nationality' && ( !empty($vvr['value']) && is_array($vvr['value']) == true) ){
                        $type = 'list';
                        $val_project_nationality = array();
                        $result_project_nationality = $this->model_contest_contest_field->getProjectNationalitys();
                        foreach ($result_project_nationality  as $vpa) {
                  foreach ($vvr['value'] as $vvvr) {
                              if($vpa['contest_field_value_id'] == $vvvr){
                                $val_project_nationality[] = array(
                                  'title' =>  $vpa['name']
                                );
                              }
                            }
                        }
                        $value_field = $val_project_nationality;


                      }

                      if( $contest_fields[$vvr['field_id']]['contest_field_system'] == 'project_professional' && ( !empty($vvr['value']) && is_array($vvr['value']) == true) ){
                        $type = 'list';
                        $val_project_professional = array();
                        $result_project_professional = $this->model_contest_contest_field->getProjectProfessionals();
                        foreach ($result_project_professional  as $vpa) {
                  foreach ($vvr['value'] as $vvvr) {
                              if($vpa['contest_field_value_id'] == $vvvr){
                                $val_project_professional[] = array(
                                  'title' =>  $vpa['name']
                                );
                              }
                            }
                        }
                        $value_field = $val_project_professional;


                      }

                      if( $contest_fields[$vvr['field_id']]['contest_field_system'] == 'project_demographic' && ( !empty($vvr['value']) && is_array($vvr['value']) == true) ){
                        $type = 'list';
                        $val_project_demographic = array();
                        $result_project_demographic = $this->model_contest_contest_field->getProjectDemographics();
                        foreach ($result_project_demographic  as $vpa) {
                  foreach ($vvr['value'] as $vvvr) {
                              if($vpa['contest_field_value_id'] == $vvvr){
                                $val_project_demographic[] = array(
                                  'title' =>  $vpa['name']
                                );
                              }
                            }
                        }
                        $value_field = $val_project_demographic;


                      }




              $data_for_category[] = array(
                'field_id'    => $vvr['field_id'],
                'field_value' => $value_field,
                'field_title' => $contest_fields[$vvr['field_id']]['contest_field_title'],
                'field_type' => $type,
                'field_contest_system_table' => $contest_fields[$vvr['field_id']]['contest_field_system_table']
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
/*
    print_r('<pre>');
    print_r($data['category_requestes'] );
    print_r('</pre>');
    die();*/
//целевая группа








    //информация о пользователе подавщти заявку



    //информация о конкурсе для эксперта



    //информация о критерияя оценки
    $request_contest_id = $result_request_information['contest_id'];
    $contest_criteria = $this->model_contest_contest->getContestCriteria($contest_id);

    $data['contest_criteria'] = array();
    foreach ($contest_criteria as $vcc) {
      $data['contest_criteria'][] = array(
        'contest_criteria_id' => $vcc['contest_criteria_id'],
        'criteria_title'      => $vcc['title']
      );
    }




/*

      //подтянем поля для заполнения
      //СИСТЕМНЫЕ ПОЛЯ
      $data['contest_field_system']['customer'] = array();
      //поля пользователя
      $data['contest_field_system']['customer']['firstname'] = array(
        'field_value'         => $customer_info['firstname'],
        'field_type'          => 'text'
      );
      $data['contest_field_system']['customer']['lastname'] = array(
        'field_value'         => $customer_info['lastname'],
        'field_type'          => 'text'
      );
      $data['contest_field_system']['customer']['email'] = array(
        'field_value'         => $customer_info['email'],
        'field_type'          => 'text'
      );
      $data['contest_field_system']['customer']['telephone'] = array(
        'field_value'         => $customer_info['telephone'],
        'field_type'          => 'text'
      );



    $data['contest_field_system']['init_group'] = array();
    //поля для группы
    $data['contest_field_system']['init_group']['title'] = array(
      'field_value'         => $init_group_information['group_title'],
      'field_type'          => 'text'
    );
    $data['contest_field_system']['init_group']['group_description'] = array(
      'field_value'         => $init_group_information['group_description'],
      'field_type'          => 'textarea'
    );

    //поля для проекта
    $data['contest_field_system']['project'] = array();
    $data['contest_field_system']['project']['title'] = array(
      'field_value'         => html_entity_decode($project_info['title'], ENT_QUOTES, 'UTF-8'),
      'field_type'          => 'text'
    );

    $data['contest_field_system']['project']['project_budget'] = array(
      'field_value'         => $project_info['project_budget'],
      'field_type'          => 'text'
    );
    $data['contest_field_system']['project']['description'] = array(
      'field_value'         => $project_info['description'],
      'field_type'          => 'textarea'
    );
    $data['contest_field_system']['project']['target'] = array(
      'field_value'         => $project_info['target'],
      'field_type'       => 'target'
    );
    $data['contest_field_system']['project']['product'] = array(
      'field_value'         => $project_info['product'],
      'field_type'       => 'textarea'
    );
    $data['contest_field_system']['project']['result'] = array(
      'field_value'         => $project_info['result'],
      'field_type'       => 'textarea'
    );
    $data['contest_field_system']['project']['project_birthday'] = array(
      'field_value'         => $project_info['project_birthday'],
      'field_type'       => 'textarea'
    );
    $data['contest_field_system']['project']['project_age'] = array(
      'field_value'         => $project_info['project_age'],
      'field_type'       => 'textarea'
    );
*/






/*

    print_r('<pre>');
    print_r($data['category_requestes']);
    print_r('</pre>');
    die();


   */




    $data['action'] = $this->url->link('contest/aestimate', 'request_id='.$request_id, 'SSL');

    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_aestimate.tpl')) {
      $this->document->addScript('catalog/view/theme/'.$this->config->get('config_template') . '/assets/js/aestimate.js');
    } else {
      $this->document->addScript('catalog/view/theme/default/assets/js/aestimate.js');
    }

    $data['column_left'] = $this->load->controller('common/column_left');
    $data['column_right'] = $this->load->controller('common/column_right');
    $data['content_top'] = $this->load->controller('common/content_top');
    $data['content_bottom'] = $this->load->controller('common/content_bottom');
    $data['footer'] = $this->load->controller('common/footer');
    $data['header'] = $this->load->controller('common/header');




    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contest/contest_aestimate.tpl')) {

      $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/contest/contest_aestimate.tpl', $data));
    } else {
      $this->response->setOutput($this->load->view('default/template/contest/contest_aestimate.tpl', $data));
    }


  }
  protected function validate() {
    //$this->error['fake'] = 1;
    return !$this->error;
  }

}
