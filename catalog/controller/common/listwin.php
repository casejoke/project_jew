<?php
class ControllerCommonListwin extends Controller {
  public function index(){
    
    $this->load->model('account/customer');
    $this->load->model('group/group');
    $this->load->model('project/project');


    //получим список проектов 
    $results_projects = $this->model_project_project->getProjects();
   

    //получим список групп
    $results_groups = $this->model_group_group->getGroups();
    
    print_r('<table>');

    foreach ($results_groups as $result_g){
      foreach ($results_projects as $result_p) {
        if($result_p['project_init_group_id'] == $result_g['init_group_id']){
          print_r('<tr>');
            print_r('<td>');
            print_r($result_g['init_group_id']);
            print_r('</td>');
            print_r('<td>');
            print_r($result_g['title']);
            print_r('</td>');
            print_r('<td>');
            print_r($result_p['project_id']);
            print_r('</td>');
            print_r('<td>');
            print_r($result_p['project_birthday']);
            print_r('</td>');
            print_r('<td>');
            print_r($result_p['title']);
            print_r('</td>');
            print_r('<td>');
            $customer = $this->model_account_customer->getCustomer($result_p['customer_id']);
            print_r($customer['firstname'].' '.$customer['lastname']);
            print_r('</td>');
          print_r('</tr>');
        }
      }
      
    }

    print_r('</table>');
  }
}