<?php
class ModelContestContest extends Model {

	public function getContest($contest_id) {
		$query = $this->db->query("SELECT DISTINCT  *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'contest_id=" . (int)$contest_id . "') AS keyword FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.contest_id = dd.contest_id) WHERE d.contest_id = '" . (int)$contest_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getContestDescriptions($contest_id) {
		$contest_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_description WHERE contest_id = '" . (int)$contest_id . "'");

		foreach ($query->rows as $result) {
			$contest_description_data[$result['language_id']] = array(
				'title' 		   => $result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $contest_description_data;
	}

	public function getContestsForAdmin($customer_id) {
		$query = $this->db->query("SELECT   * FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.contest_id = dd.contest_id) WHERE d.customer_id = '" . (int)$customer_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->rows;
	}

	public function getContestForExpertCustomer($customer_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_expert WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->rows;
	}

	public function getContests($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "contest d LEFT JOIN " . DB_PREFIX . "contest_description dd ON (d.contest_id = dd.contest_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		if (!empty($data['filter_status'])) {


			if(count($data['filter_status']) > 1){
				$sql .= " AND d.status IN (" . implode(',', $data['filter_status']) . ")";
			}else{
				$sql .= " AND d.status = '" . (int)$data['filter_status'][0] . "'";
			}


		}




		$sort_data = array(
			'dd.title',
			'd.date_start'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY d.date_start";
		}

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
	}

	public function getTotalContests() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "contest");

		return $query->row['total'];
	}

	//для bestpractice
	public function addRequest($data=array(),$customer_id,$contest_id,$adaptive_id,$project_id){
		$status =2;
		if(isset($data['draft'])){
			$status = 3;
		}
		if(isset($data['notice_draft'])){

			//$adaptive_id проект
			 $this->load->model('project/project');
			 $this->load->model('account/customer');
			 $project_info = $this->model_project_project->getProject($adaptive_id);
			 $customer_info = $this->model_account_customer->getCustomer($customer_id);
			 $adaptor_info = $this->model_account_customer->getCustomer($project_info['customer_id']);
			 $this->load->language('mail/contest');
			 $message = sprintf($this->language->get('text_mail_for_adaptor'),$project_info['title'],$customer_info['lastname'].''.$customer_info['firstname'],$customer_info['city'],$customer_info['email']);
			 $subject = 'Конкурс Best Practices - уведомление';

			//отправляем письмо адаптору ()

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($adaptor_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($subject);
			$mail->setText($message);
			$mail->send();


		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_to_contest SET
				contest_id = '" . (int)$contest_id . "',
				customer_id = '" . (int)$customer_id . "',
				project_id = '" . (int)$project_id . "',
				adaptive_id = '" . (int)$adaptive_id . "',
				status = '". (int)$status ."',
				value  = '" . $this->db->escape(  serialize($data) ) . "',
				date_added = NOW()"
			);
			$customer_to_contest_id = $this->db->getLastId();

		return $customer_to_contest_id;
	}



	//для bestpractice
	public function editRequest($data=array(),$customer_to_contest_id){
		$status =2;
		//статус заявки 
		if(isset($data['draft'])){
			$status = 3;
		}
		$request_info = $this->getInformationAboutRequest($customer_to_contest_id);
		if(isset($data['notice_draft'])){

			 
			//$adaptive_id проект
			 $this->load->model('project/project');
			 $this->load->model('account/customer');
			 $project_info = $this->model_project_project->getProject($request_info['adaptive_id']);
			 $customer_info = $this->model_account_customer->getCustomer($request_info['customer_id']);
			 $adaptor_info = $this->model_account_customer->getCustomer($project_info['customer_id']);
			 
			 $this->load->language('mail/contest');
			 $message = sprintf($this->language->get('text_mail_for_adaptor'),$project_info['title'],$customer_info['lastname'].''.$customer_info['firstname'],$customer_info['city'],$customer_info['email']);
			 $subject = 'Конкурс Best Practices - уведомление';

			//отправляем письмо адаптору ()

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($adaptor_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($subject);
			$mail->setHtml($message);
			$mail->send();


		}
		if($request_info['adaptive_status']){

		}
		$this->db->query("UPDATE " . DB_PREFIX . "customer_to_contest SET
			value  = '" . $this->db->escape(  serialize($data) ) . "',
			adaptive_status = '".(int)$request_info['adaptive_status']."',
			status = '". (int)$status ."'
			WHERE customer_to_contest_id = '" . (int)$customer_to_contest_id . "'
		");


		return $customer_to_contest_id;
	}

	public function addAdaptive($customer_id,$contest_id,$project_id){

		//$isset_project = $this->getPersonalAdaptive($customer_id,$contest_id);

		//if(!$isset_project){
			$this->db->query("INSERT INTO " . DB_PREFIX . "contest_adaptor SET
				contest_id = '" . (int)$contest_id . "',
				customer_id = '" . (int)$customer_id . "',
				project_id = '" . (int)$project_id . "',
				date_added = NOW()"
			);
			$contest_adaptor_id = $this->db->getLastId();
		//}else{
		//	$contest_adaptor_id = $isset_project['contest_adaptor_id'];
		//}


		return $contest_adaptor_id;
	}

	//заявка на конкурс
	public function addRequestToContest($data=array(),$customer_id,$contest_id){
		$filter_data = array();
		$filter_data = array(
			'filter_customer_id' 	=> 	$customer_id,
			'filter_contest_id'		=>	$contest_id
		);
		$is_isset_request = $this->getRequestForCustomer($filter_data);

		if(!empty($is_isset_request)){
			//статус = 2 значит отправляем на модерацию
			$this->db->query("UPDATE " . DB_PREFIX . "customer_to_contest SET
				value  = '" . $this->db->escape(  serialize($data) ) . "',
				status = '2',
				adaptive_status = '0',
				date_added = NOW()
				WHERE contest_id = '" . (int)$contest_id . "' AND customer_id = '" . (int)$customer_id . "'
			");
			$customer_to_contest_id = $is_isset_request[0]['customer_to_contest_id'];
		}else{
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_to_contest SET
				contest_id = '" . (int)$contest_id . "',
				customer_id = '" . (int)$customer_id . "',
				status = '2',
				adaptive_status = '0',
				value  = '" . $this->db->escape(  serialize($data) ) . "',
				date_added = NOW()"
			);
			$customer_to_contest_id = $this->db->getLastId();
		}


		return $customer_to_contest_id;
	}

	public function getPersonalAdaptive($customer_id,$contest_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_adaptor WHERE contest_id = '" . (int)$contest_id . "' AND customer_id = '" . (int)$customer_id . "'");
		return $query->rows;
	}


	public function getInfoRequest($customer_to_contest_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest WHERE customer_to_contest_id ='". (int)$customer_to_contest_id ."'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	//получение заявок
	public function getRequestForCustomer($data=array()){

		if(empty($data)){
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest";
		}else{
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest WHERE";
		}

		$_str =array();


		if (!empty($data['filter_customer_id'])) {
			$_str[] =	" customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (!empty($data['filter_contest_id'])) {

			if(count($data['filter_contest_id']) > 1){
				$_str[] .= " contest_id IN (" . implode(',', $data['filter_contest_id']) . ")";
			}else{
				//если один конкурс
				$contest_id = $data['filter_contest_id'][0];
				$_str[] .= " contest_id = '" . (int)$contest_id . "'";
			}
		} else{
			//$_str[] .= " contest_id = '0'";
		}

		//statss = 1 значит модератор разрешил оценивать
		if (!empty($data['filter_status'])) {
			$_str[] = " status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_no_acepted'])) {
			$_str[] = " status != '0'";
		}

		$_sql = '' ;
		$i = 0;
		foreach ($_str as $vstr) {
			if($i > 0){
				$_sql .= ' AND'.$vstr;
			}else{
				$_sql .= $vstr;
			}
			$i++;
		}
	//	print_r($sql.$_sql);
		$query = $this->db->query($sql.$_sql);



		return $query->rows;
	}

	public function getRequestForApproved($data=array()){
		if(empty($data)){
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest";
		}else{
			$sql = "SELECT * FROM " . DB_PREFIX . "customer_to_contest WHERE";
		}

		$_str =array();


		if (!empty($data['filter_customer_id'])) {
			$_str[] =	" customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}



		if (!empty($data['filter_array_contest_id'])) {

			if(count($data['filter_array_contest_id']) > 1){
				$_str[] .= " contest_id IN (" . implode(',', $data['filter_array_contest_id']) . ")";
			}else{
				//если один конкурс
				$contest_id = $data['filter_array_contest_id'][0];
				$_str[] .= " contest_id = '" . (int)$contest_id . "'";
			}
		} else{
			//$_str[] .= " contest_id = '0'";
		}

		

		if (!empty($data['filter_array_project_customer_id'])) {

			if(count($data['filter_array_project_customer_id']) > 1){
				$_str[] .= " adaptive_id IN (" . implode(',', $data['filter_array_project_customer_id']) . ")";
			}else{
				//если один проект
				$contest_id = $data['filter_array_project_customer_id'][0];
				$_str[] .= " adaptive_id = '" . (int)$contest_id . "'";
			}
		} else{
			$_str[] .= " adaptive_id = '0'";
		}

		//statss = 1 значит модератор разрешил оценивать
		if (!empty($data['filter_status'])) {
			$_str[] = " status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_no_acepted'])) {
			$_str[] = " status != '0'";
		}

		$_sql = '' ;
		$i = 0;
		foreach ($_str as $vstr) {
			if($i > 0){
				$_sql .= ' AND'.$vstr;
			}else{
				$_sql .= $vstr;
			}
			$i++;
		}
	//	print_r($sql.$_sql);
		$query = $this->db->query($sql.$_sql);



		return $query->rows;
	}

	public function getCustomerForWinner($data){

		$_str =array();

		if (!empty($data['filter_customer_id'])) {
			$_str[] =	" customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}
		if (!empty($data['filter_contest_id'])) {
			$_str[] =	" contest_id = '" . (int)$data['filter_contest_id'] . "'";
		}
		if (!empty($data['filter_contest_type_id'])) {
			$_str[] =	" contest_type_id = '" . (int)$data['filter_contest_type_id'] . "'";
		}

		/*if (!empty($data['filter_array_project_customer_id'])) {

			if(count($data['filter_array_project_customer_id']) > 1){
				$_str[] .= " adaptive_id IN (" . implode(',', $data['filter_array_project_customer_id']) . ")";
			}else{
				//если один проект
				$contest_id = $data['filter_array_project_customer_id'][0];
				$_str[] .= " adaptive_id = '" . (int)$contest_id . "'";
			}
		} else{
			$_str[] .= " adaptive_id = '0'";
		}*/

		if (!empty($data['filter_status'])) {
			$_str[] = " status = '" . (int)$data['filter_status'] . "'";
		}
		

		
		$_sql = '' ;
		$i = 0;
		foreach ($_str as $vstr) {
			if($i > 0){
				$_sql .= ' AND'.$vstr;
			}else{
				$_sql .= $vstr;
			}
			$i++;
		}

		if(!$_sql){
			$sql = "SELECT * FROM " . DB_PREFIX . "contest_winner";
		}else{
			$sql = "SELECT * FROM " . DB_PREFIX . "contest_winner WHERE";
		}



		
		$sort_data = array(
			'team_title',
			'team_status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$_sql .= " ORDER BY " . $data['sort'];
		} else {
			$_sql .= " ORDER BY date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$_sql .= " DESC";
		} else {
			$_sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$_sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		
		$query = $this->db->query($sql.$_sql);

		return $query->rows;
	}










	public function getInfoAboutEstimate($customer_id,$customer_to_contest_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_estimate WHERE 
			customer_id = '".(int)$customer_id."' AND customer_to_contest_id = '".(int)$customer_to_contest_id."' ";
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getEstimateForCustomer($customer_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_estimate WHERE customer_id = '".(int)$customer_id."'";
		$query = $this->db->query($sql);
		return $query->rows;
	}



	//получить информацию  о заявке
	public function getInformationAboutRequest($request_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_to_contest WHERE customer_to_contest_id = '".(int)$request_id."'");


		return $query->row;
	}

	//оценка заявки на конкурс
	public function addEstimateToContest($data=array(),$customer_id,$contest_id,$request_id){
		//записываем оценку эксперта
		//customer_id - id экперта
		//value - оценка
		//customer_to_contest_id - id заявки
		//статус заявки 
		$recommendation = 0;
		if(isset($data['recommendation'])){
			$recommendation = 1;
		}


		$estimate_request = $this->getInfoAboutEstimate($customer_id,$request_id);
		
		if(!empty($estimate_request)){
			$this->db->query("UPDATE " . DB_PREFIX . "customer_estimate SET
				value  = '" . $this->db->escape( serialize($data) ) . "',
				comment  = '" . $this->db->escape( $data['estimate_comment'] ) . "',
				recommendation = '". (int)$recommendation . "'
			WHERE customer_estimate_id = '" . (int)$estimate_request['customer_estimate_id'] . "'");
		}else{
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_estimate SET
				contest_id = '" . (int)$contest_id . "',
				customer_id = '" . (int)$customer_id . "',
				customer_to_contest_id = '".(int)$request_id."',
				value  = '" . $this->db->escape(  serialize($data) ) . "',
				comment  = '" . $this->db->escape( $data['estimate_comment'] ) . "',
				recommendation = '". (int)$recommendation . "',
				date_added = NOW()"
			);
		}
		

	}
	//оценка заявки на конкурс
	public function updateAEstimateToContest($data=array(),$customer_id,$contest_id,$request_id){

		//записываем утверждение пользователя на использование проекта другим пользователем и отправляем мыло
		//adaptive_status - оценка
		$this->db->query("UPDATE " . DB_PREFIX . "customer_to_contest SET
			adaptive_status = '" . (int)$data['adaptive_status'] . "',
			adaptor_comment = '" . $this->db->escape($data['comment']) . "'
		WHERE customer_to_contest_id = '" . (int)$request_id . "'");


	}





	// получение связанных с конкурсом экспертов
	public function getContestExpert($contest_id) {

		$contest_expert = array();
		$contest_expert_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_expert WHERE contest_id = '" . (int)$contest_id . "'");
		if (!empty($contest_expert_query->rows)) {
			$sql = "SELECT * , CONCAT(lastname, ' ', firstname) AS name FROM " . DB_PREFIX . "customer";
			$implode = array();

			foreach ($contest_expert_query->rows as $customer_id) {
				$implode[] = (int)$customer_id['customer_id'];
			}

			$sql .= " WHERE customer_id IN (" . implode(',', $implode) . ")";
			$query = $this->db->query($sql);
			$contest_expert = $query->rows;
		}

		return $contest_expert;
	}

		// получение связанных с конкурсом критериев

	public function getContestCriteria($contest_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_criteria c LEFT JOIN " . DB_PREFIX . "contest_criteria_description cd
				ON (c.contest_criteria_id = cd.contest_criteria_id)
				WHERE c.contest_id = '" . (int)$contest_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
				ORDER BY c.sort_order ASC");

		return $query->rows;
	}

	// получение связанных с конкурсом направлений
	public function getContestDirection($contest_id) {
	    $contest_direction_data = array();

	    $contest_direction_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_direction WHERE contest_id = '" . (int)$contest_id . "' ORDER BY sort_order ASC");

	    foreach ($contest_direction_query->rows as $contest_direction) {
	      $contest_direction_description_data = array();

	      $contest_direction_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_direction_description WHERE contest_direction_id = '" . (int)$contest_direction['contest_direction_id'] . "' AND contest_id = '" . (int)$contest_id . "'");

	      foreach ($contest_direction_description_query->rows as $contest_direction_description) {
	        $contest_direction_description_data[$contest_direction_description['language_id']] = array(
	          'title' => $contest_direction_description['title']
	        );
	      }

	      $contest_direction_data[] = array(
	        'contest_direction_description'    => $contest_direction_description_data,
	        'sort_order'          => $contest_direction['sort_order']
	      );
	    }

	    return $contest_direction_data;
	}


	// получение связанных с конкурсом файлов
	public function getContestDownloads($contest_id){
	 	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_download WHERE contest_id = '". (int)$contest_id ."'");
		return $query->rows;
	}

	public function getContestTypes(){
		$data_contest_types = array();
		$data_contest_types[] = array(
			'contest_type_id' => 1,
			'contest_type_title' => 'Открытый'
		);
		$data_contest_types[] = array(
			'contest_type_id' => 2,
			'contest_type_title' => 'По приглашению'
		);
		$data_contest_types[] = array(
			'contest_type_id' => 3,
			'contest_type_title' => 'Best Practice'
		);
		return $data_contest_types;
	}

	public function getContestStatuses(){
		$data_contest_status = array();
		$data_contest_status[] = array(
			'contest_status_id' => 0,
			'contest_status_title' => 'В работе'
		);
		$data_contest_status[] = array(
			'contest_status_id' => 1,
			'contest_status_title' => 'Активный'
		);
		$data_contest_status[] = array(
			'contest_status_id' => 2,
			'contest_status_title' => 'Архив'
		);
		return $data_contest_status;
	}

	public function getDownload($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id = '" . (int)$download_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getWinnerContest($customer_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contest_winner WHERE customer_id = '".(int)$customer_id."'");

		return $query->rows;
	}



}
