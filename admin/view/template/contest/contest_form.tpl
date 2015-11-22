<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2><?php echo $form_header; ?></h2>
        <ul class="actions">
            <li> <button type="submit" form="form-information"  class="btn btn-success"><?php echo $button_save; ?></button></li>
            <li>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>">
                    <i class="md md-replay"></i>
                </a>
            </li>
        </ul>
      </div>
      <div class="card-body card-padding table-responsive">
      
         <div role="tabpanel">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" >
            
            <ul class="tab-nav" role="tablist">
                <li class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                <li><a href="#tab-timeline" aria-controls="tab-timeline" role="tab" data-toggle="tab"><?php echo $tab_timeline; ?></a></li>
				<li><a href="#tab-expert" aria-controls="tab-expert" role="tab" data-toggle="tab"><?php echo $tab_expert; ?></a></li>
				<li><a href="#tab-criteria" aria-controls="tab-criteria" role="tab" data-toggle="tab"><?php echo $tab_criteria; ?></a></li>
				<li><a href="#tab-direction" aria-controls="tab-direction" role="tab" data-toggle="tab"><?php echo $tab_direction; ?></a></li>
				<li ><a href="#tab-request" aria-controls="tab-request" role="tab" data-toggle="tab"><?php echo $tab_request; ?></a></li>
				<li class="hidden"><a href="#tab-files" aria-controls="tab-files" role="tab" data-toggle="tab"><?php echo $tab_files; ?></a></li>
                <li><a href="#tab-seo" aria-controls="tab-seo" role="tab" data-toggle="tab"><?php echo $tab_seo; ?></a></li>
                
                
            </ul>
          
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab-general">
                  <div role="tabpanel"> 
                  	<ul class="tab-nav language-tab" role="tablist" id="language" data-tab-color="amber">
                        <?php foreach ($languages as $language) { ?>
                          <li>
                            <a href="#general-language<?php echo $language['language_id']; ?>" data-toggle="tab">
                              <?php echo $language['name']; ?>
                            </a>
                          </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                      <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane" id="general-language<?php echo $language['language_id']; ?>">

                          <div class="card-body card-padding">
                          	
                          	<div class="row">
								<div class="col-sm-12">	
								  	<!-- название -->
									<div class="form-group required <?php if (isset($error_title[$language['language_id']])) { ?> has-error <?php } ?>">
									<div class="fg-line">
									    <label class="control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
									    <input type="text" name="contest_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['title'] : ''; ?>"  id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
									</div>
									<?php if (isset($error_title[$language['language_id']])) { ?>
									  <small class="help-block"><?php echo $error_title[$language['language_id']]; ?></small>
									<?php } ?>
									</div>
								</div>

								<div class="col-sm-12">
									<!-- организатор -->
									<div class="form-group required <?php if (isset($error_organizer[$language['language_id']])) { ?> has-error <?php } ?>">
										<div class="fg-line">
										    <label class="control-label" for="input-organizer<?php echo $language['language_id']; ?>"><?php echo $entry_organizer; ?></label>
										     <textarea name="contest_description[<?php echo $language['language_id']; ?>][organizer]" id="input-organizer<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['organizer'] : ''; ?></textarea>
										</div>
										<?php if (isset($error_organizer[$language['language_id']])) { ?>
										  <small class="help-block"><?php echo $error_organizer[$language['language_id']]; ?></small>
										<?php } ?>
									</div>
								</div>
								<div class="col-sm-12">
									 <!-- цель -->
			                          <div class="form-group">
			                            <div class="fg-line">
			                                <label class="control-label m-b-10" for="input-propose<?php echo $language['language_id']; ?>"><?php echo $entry_propose; ?></label>
			                                <textarea name="contest_description[<?php echo $language['language_id']; ?>][propose]" id="input-propose<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['propose'] : ''; ?></textarea>
			                            </div>
			                          </div>
		                        </div>

		                         <div class="col-sm-12">
	                          <!-- география -->
	                          <div class="form-group">
	                            <div class="fg-line">
	                                <label class="control-label m-b-10" for="input-location<?php echo $language['language_id']; ?>"><?php echo $entry_location; ?></label>
	                                <textarea name="contest_description[<?php echo $language['language_id']; ?>][location]" id="input-location<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['location'] : ''; ?></textarea>
	                            </div>
	                          </div>
	                          </div>
	                          <div class="col-sm-12">
	                          <!-- участники -->
	                          <div class="form-group">
	                            <div class="fg-line">
	                                <label class="control-label m-b-10" for="input-members<?php echo $language['language_id']; ?>"><?php echo $entry_members; ?></label>
	                                <textarea name="contest_description[<?php echo $language['language_id']; ?>][members]" id="input-members<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['members'] : ''; ?></textarea>
	                            </div>
	                          </div>
	                          </div>
	                          <div class="col-sm-12">
	                          <!-- Описание проекта  -->
		                      <div class="form-group required <?php if (isset($error_maxprice[$language['language_id']])) { ?> has-error <?php } ?>">
	                            <div class="fg-line">
	                                <label class="control-label m-b-10" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
	                                <textarea name="contest_description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['description'] : ''; ?></textarea>
	                            </div>	                            
	                            <?php if (isset($error_description[$language['language_id']])) { ?>
	                              <small class="help-block"><?php echo $error_description[$language['language_id']]; ?></small>
	                            <?php } ?>
	                          </div>
	                          </div>
	                          <div class="col-sm-12">
	                          <!-- Контакты  -->
		                      <div class="form-group">
	                            <div class="fg-line">
	                                <label class="control-label m-b-10" for="input-contacts<?php echo $language['language_id']; ?>"><?php echo $entry_contacts; ?></label>
	                                <textarea name="contest_description[<?php echo $language['language_id']; ?>][contacts]" id="input-contacts<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['contacts'] : ''; ?></textarea>
	                            </div>
	                          </div>
								</div>
	                          <div class="col-sm-12">
							  <!-- Дополнительный текст о графике -->
		                      <div class="form-group">
		                        <div class="fg-line">
		                            <label class="control-label m-b-10" for="input-timeline_text<?php echo $language['language_id']; ?>"><?php echo $entry_timeline_text; ?></label>
		                            <textarea name="contest_description[<?php echo $language['language_id']; ?>][timeline_text]" class="form-control auto-size" rows="4" id="input-timeline_text<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['timeline_text'] : ''; ?></textarea>
		                        </div>
		                      </div>
                          		</div>
	                          </div>
	                          
	                          
	                         
                          

                          </div><!--/.card-body -->
                        </div><!-- /tab-pane -->
                        <?php } ?>
                      </div><!-- /.tab-content -->
                  </div><!-- /.tabpanel -->
                </div><!-- /#tab-general -->

                <div role="tabpanel" class="tab-pane" id="tab-timeline">
                    <div class="card-body card-padding">
                    	  <div class="row">
		                          <div class="col-sm-6">
			                          <!-- тип -->
			                          <div class="form-group">
			                            <div class="fg-line">
			                              <label class="control-label" for="input-type"><?php echo $entry_type; ?></label>
			                              <div class="select">
		                              		<select name="type" id="input-type" class="form-control">
			                                  <?php if (!empty($contest_types)) { ?>
			                                    <?php foreach ($contest_types as $ct) { ?>
			                                    <?php if ($ct['contest_type_id'] == $type) { ?>
			                                      <option value="<?php echo $ct['contest_type_id']; ?>" selected="selected"><?php echo $ct['contest_type_title']; ?></option>
			                                    <?php } else { ?>
			                                      <option value="<?php echo $ct['contest_type_id']; ?>"><?php echo $ct['contest_type_title']; ?></option>
			                                    <?php } ?>
			                                    <?php } ?>
			                                  <?php } ?>
			                                </select>
			                              </div>
			                            </div>
			                          </div>
		                          </div>
		                          <div class="col-sm-6">
			                          <!-- тип -->
			                          <div class="form-group">
			                            <div class="fg-line">
			                              <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
			                              <div class="select">
		                              		<select name="status" id="input-status" class="form-control">
			                                  <?php if (!empty($contest_statuses)) { ?>
			                                    <?php foreach ($contest_statuses as $cs) { ?>
			                                    <?php if ($cs['contest_status_id'] == $status) { ?>
			                                      <option value="<?php echo $cs['contest_status_id']; ?>" selected="selected"><?php echo $cs['contest_status_title']; ?></option>
			                                    <?php } else { ?>
			                                      <option value="<?php echo $cs['contest_status_id']; ?>"><?php echo $cs['contest_status_title']; ?></option>
			                                    <?php } ?>
			                                    <?php } ?>
			                                  <?php } ?>
			                                </select>
			                              </div>
			                            </div>
			                          </div>
		                          </div>
		                      </div>
	                          
	                          <div class="row">
		                          <!-- максимальная сумма гранта -->
		                          <div class="col-sm-6 required <?php if (isset($error_maxprice[$language['language_id']])) { ?> has-error <?php } ?>">
			                          <div class="form-group">
			                            <div class="fg-line">
			                                <label class="control-label" for="input-maxprice"><?php echo $entry_maxprice; ?></label>
			                                <input type="text" name="maxprice" value="<?php echo (isset($maxprice)) ? $maxprice : ""; ?>"  id="input-maxprice" class="form-control" />
			                            </div>
			                            <?php if (isset($error_maxprice[$language['language_id']])) { ?>
			                              <small class="help-block"><?php echo $error_maxprice[$language['language_id']]; ?></small>
			                            <?php } ?>
			                          </div><!--/.form-group-->
			                      </div>
			                      
			                      <!-- Общий объем финансирования -->
		                          <div class="col-sm-6">
			                          <div class="form-group">
			                            <div class="fg-line">
			                                <label class="control-label" for="input-maxprice"><?php echo $entry_totalprice; ?></label>
			                                <input type="text" name="totalprice" value="<?php echo (isset($totalprice)) ? $totalprice : ""; ?>"  id="input-totalprice" class="form-control" />
			                            </div>
			                          </div><!--/.form-group-->
			                      </div>
			                  </div>
                        <div class="row">
	                        <div class="col-sm-4">
	                        	<!-- Начало приема заявок  -->
								<div class="form-group">
									<div class="fg-line">
									    <label class="control-label" for="date_start"><?php echo $entry_date_start; ?></label>
									     <input type="text" class="form-control date-picker" id="date_start" name="date_start" value="<?php echo $date_start; ?>">
									</div>
								</div>
	                        </div>
	                        <div class="col-sm-4">
	                        	<!-- Завершение приема заявок   -->
								<div class="form-group">
									<div class="fg-line">
									    <label class="control-label" for="datetime_end"><?php echo $entry_datetime_end; ?></label>
									     <input type="text" class="form-control date-picker datetime-picker" id="datetime_end" name="datetime_end" value="<?php echo (isset($datetime_end)) ? $datetime_end : date('Y-m-d'); ?>">
									</div>
								</div>
	                        </div>
	                        <div class="col-sm-4">
	                        	<!-- Завершение оценки заявок    -->
								<div class="form-group">
									<div class="fg-line">
									    <label class="control-label" for="date_rate"><?php echo $entry_date_rate; ?></label>
									     <input type="text" class="form-control date-picker" id="date_rate" name="date_rate" value="<?php echo (isset($date_rate)) ? $date_rate : date('Y-m-d'); ?>">
									</div>
								</div>
	                        </div>
	                        <div class="col-sm-4">
	                        	<!-- Объявление результатов    -->
								<div class="form-group">
									<div class="fg-line">
									    <label class="control-label" for="date_result"><?php echo $entry_date_result; ?></label>
									     <input type="text" class="form-control date-picker" id="date_result" name="date_result" value="<?php echo (isset($date_result)) ? $date_result : date('Y-m-d'); ?>">
									</div>
								</div>
	                        </div>
	                        <div class="col-sm-4">
	                        	<!-- Публикация списка финалистов     -->
								<div class="form-group">
									<div class="fg-line">
									    <label class="control-label" for="date_finalist"><?php echo $entry_date_finalist; ?></label>
									     <input type="text" class="form-control date-picker" id="date_finalist" name="date_finalist" value="<?php echo (isset($date_finalist)) ? $date_finalist : date('Y-m-d'); ?>">
									</div>
								</div>
	                        </div>
						</div>	
						<div class="row">
							<div class="col-sm-12">
							<label class=" control-label" for="input-image"><?php echo $entry_image; ?></label>
						  	<div class="form-group">
			                          <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
			                            <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
			                          </a>
			                          <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
		                        </div>  
		                    </div>
	                    </div>



                    </div>
                </div><!-- /#tab-timeline -->
				
				<div role="tabpanel " class="tab-pane" id="tab-expert">
                  	<div class="card-body card-padding">
                    <div class="row">
                    	<div class="col-sm-12">
                    		<!-- список экспертов -->
	                    	<table id="experts" class="table table-striped">

	                    		<tbody>                    			
		                    		<?php $expert_row = 0; ?>
			                        <?php foreach ($contest_experts as $contest_expert) { ?>
				                        <tr id="expert-row<?php echo $expert_row; ?>">
											<td>
												<div class="form-group <?php if(!empty($error_contest_experts[$expert_row])) { ?>has-error <?php } ?>">
					                              <div class="fg-line">
					                                <div class="select">
					                                  <select name="contest_experts[<?php echo $expert_row; ?>][customer_id]" id="input-expert_id" class="form-control">
					                                    <option value="0"><?php echo $text_none; ?></option>
					                                    <?php if (!empty($customers)) { ?>
					                                      <?php foreach ($customers as $customer) { ?>
					                                      <?php if ($customer['customer_id'] == $contest_expert['customer_id']) { ?>
					                                        <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['name']; ?></option>
					                                      <?php } else { ?>
					                                        <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['name']; ?></option>
					                                      <?php } ?>
					                                      <?php } ?>
					                                    <?php } ?>
					                                  </select>
					                                </div>
					                              </div>
					                            </div>
												<?php if(!empty($error_contest_experts[$expert_row])) { ?>
					                                <?php echo $error_contest_experts[$expert_row]; ?>
					                              <?php } ?>
											</td>
											<td>
											 	<button type="button" onclick="$('#expert-row<?php echo $expert_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger">
					                              <i class="fa fa-minus-circle"></i>
					                            </button>
											</td>
				                        </tr>
									<?php $expert_row++; ?>
									<?php } ?>
		                    	</tbody>
		                    	 <tfoot>
		                            <tr>
		                              <td colspan="2" class="text-center">
		                              	<div class="col-sm-offset-4 col-sm-4">
		                              		<button type="button" onclick="addExpert();" class="btn btn-primary btn-block"><i class="fa fa-plus-circle"> </i>  <?php echo $button_add; ?></button>
										</div>
		                              	</td>
		                            </tr>
		                          </tfoot>
	                    	</table>
                    	</div>
                	</div>
					</div>
                </div><!-- /#tab-expert -->
					
				<div role="tabpanel" class="tab-pane " id="tab-request">

					<div class="panel-group" role="tablist" aria-multiselectable="true">
						<?php $category_request_row = 0; ?>
		                    <?php foreach ($category_requestes as $cr) { ?>
								<?php if(!empty($contest_fields[$cr['category_request_id']])){ ?>
		                    	<div class="panel panel-collapse">
		                            <div class="panel-heading" role="tab" id="headingOne">
		                                <h4 class="panel-title">
		                                    <a data-toggle="collapse" data-parent="#accordion" href="#tab-category-request<?php echo $category_request_row; ?>" aria-expanded="true" aria-controls="tab-category-request<?php echo $category_request_row; ?>">
		                                        <?php echo $cr['name']; ?>
		                                    </a>
		                                </h4>
		                            </div>
		                            <div id="tab-category-request<?php echo $category_request_row; ?>" class="collapse <?php echo (!$category_request_row)?'in':'';?>" role="tabpanel" aria-labelledby="headingOne">
		                                <div class="panel-body">
			                                <table class="table table-striped">
				                                <thead>
				                                    <tr>
				                                        <th>Название поля</th>
				                                        <th>Порядок сортировки</th>
				                                        <th>Статус</th>
				                                    </tr>
				                                </thead>
				                                <tbody>
				                                	<?php $custom_field_row = 0; ?>
				                                	<?php foreach ($contest_fields[$cr['category_request_id']] as $cfvalue) { ?>
				                                		<tr>
					                                        <td>
					                                        	<?php echo $cfvalue['field_title']; ?>
																<input type="hidden" name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][contest_field_id]" value="<?php echo $cfvalue['field_id']; ?>"/>

					                                        </td>
					                                          <td style="width:30%">
					                                        	<div class="form-group">
												                    <div class="fg-line">
												                        <input type="text" name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][sort_order]" value="<?php echo $cfvalue['sort_order']; ?>"  id="input-sort_order" class="form-control" />
												                    </div>
											                  	</div><!--/.form-group-->
					                                        </td>
					                                        <td style="width:30%">
					                                        	<div class="form-group" >
												                    <div class="fg-line">
												                      <div class="select">
												                        <select name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][status]" id="input-status" class="form-control">
												                          <?php if ($cfvalue['status']) { ?>
												                          <option value="0"><?php echo $text_disabled; ?></option>
												                          <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												                          <?php } else { ?>
												                          <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												                          <option value="1"><?php echo $text_enabled; ?></option>
												                          <?php } ?>
												                        </select>
												                      </div>
												                    </div>
											                  	</div>
					                                        </td>
					                                    </tr>
														<?php $custom_field_row++; ?>
													<?php }	?>
				                               	</tbody>
				                            </table>
												
											
		                                </div>
		                            </div>
		                        </div>
		                        <?php $category_request_row++; ?>
								<?php }	?>
							
	                    <?php } ?>
                    </div>
                </div><!-- /#tab-request -->
				
				<div role="tabpanel" class="tab-pane " id="tab-criteria">
					<div class="card-body card-padding">
						<div class="row">
							<div class="col-sm-12">
							<!-- список критериев -->
							<table id="criterias" class="table table-striped">
			                    <thead>
			                      <tr>
			                        <th><?php echo $entry_criteria_title; ?></th>
			                        <th style="width: 30%;"><?php echo $entry_weight_criteria; ?></th>
			                        <th style="width: 20%;"><?php echo $entry_sort_order; ?></th>
			                        <th></th>
			                      </tr>
			                    </thead>
			                      <tbody>
			                        <?php $criteria_row = 0; ?>
			                        <?php foreach ($contest_criterias as $contest_criteria) { ?>
			                          <tr id="criteria-row<?php echo $criteria_row; ?>">
			                            <td>
			                              <?php foreach ($languages as $language) { ?>
			                              <div class="input-group <?php if (isset($error_contest_criteria[$criteria_row][$language['language_id']])) { ?>has-error <?php } ?>">
			                                  <span class="input-group-addon"><?php echo $language['name']; ?></span>
			                                  <div class="fg-line">
			                                    <input type="text" name="contest_criteria[<?php echo $criteria_row; ?>][contest_criteria_description][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($contest_criteria['contest_criteria_description'][$language['language_id']]) ? $contest_criteria['contest_criteria_description'][$language['language_id']]['title'] : ''; ?>"  class="form-control" />
			                                  </div>
			                                  <?php if (isset($error_contest_criteria[$criteria_row][$language['language_id']])) { ?>
			                                    <small class="help-block"><?php echo $error_contest_criteria[$criteria_row][$language['language_id']]; ?></small>
			                                  <?php } ?>
			                              </div>
			                              <?php } ?>
			                            </td>
			                            <td class="text-left" style="width: 30%;">
			                              <input type="text" name="contest_criteria[<?php echo $criteria_row; ?>][weight]" value="<?php echo $contest_criteria['weight']; ?>"  class="form-control" />
			                            </td>
			                            <td class="text-right">
			                              <input type="text" name="contest_criteria[<?php echo $criteria_row; ?>][sort_order]" value="<?php echo $contest_criteria['sort_order']; ?>" class="form-control" />
			                            </td>
			                            <td class="text-left">
			                              <button type="button" onclick="$('#criteria-row<?php echo $criteria_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger">
			                                <i class="fa fa-minus-circle"></i>
			                              </button>
			                            </td>
			                          </tr>
			                          <?php $criteria_row++; ?>
			                          <?php } ?>
			                          </tbody>
			                          <tfoot>
			                            <tr>
			                             <td colspan="4" class="text-center">
			                                <div class="col-sm-offset-4 col-sm-4">
			                                  <button type="button" onclick="addCriteria();" class="btn btn-primary btn-block"><i class="fa fa-plus-circle"> </i>  <?php echo $button_add; ?></button>
			                                </div>
			                              </td>
			                            </tr>
			                          </tfoot>
			                    </table>
							</div>
						</div>
					</div>
				</div><!-- /#tab-criteria -->

             	<div role="tabpanel" class="tab-pane" id="tab-direction">
		          <div class="card-body card-padding">
		            <div class="row">
		              <div class="col-sm-12">
		              <!-- список направлений -->
		              <table id="directions" class="table table-striped">
		                          <thead>
		                            <tr>
		                              <th><?php echo $entry_direction_title; ?></th>
		                              <th style="width: 20%;"><?php echo $entry_sort_order; ?></th>
		                              <th></th>
		                            </tr>
		                          </thead>
		                            <tbody>
		                              <?php $direction_row = 0; ?>
		                              <?php foreach ($contest_directions as $contest_direction) { ?>
		                                <tr id="direction-row<?php echo $direction_row; ?>">
		                                  <td>
		                                    <?php foreach ($languages as $language) { ?>
		                                    <div class="input-group <?php if (isset($error_contest_direction[$direction_row][$language['language_id']])) { ?>has-error <?php } ?>">
		                                        <span class="input-group-addon"><?php echo $language['name']; ?></span>
		                                        <div class="fg-line">
		                                          <input type="text" name="contest_direction[<?php echo $direction_row; ?>][contest_direction_description][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($contest_direction['contest_direction_description'][$language['language_id']]) ? $contest_direction['contest_direction_description'][$language['language_id']]['title'] : ''; ?>"  class="form-control" />
		                                        </div>
		                                        <?php if (isset($error_contest_direction[$direction_row][$language['language_id']])) { ?>
		                                          <small class="help-block"><?php echo $error_contest_direction[$direction_row][$language['language_id']]; ?></small>
		                                        <?php } ?>
		                                    </div>
		                                    <?php } ?>
		                                  </td>
		                                  <td class="text-right">
		                                    <input type="text" name="contest_direction[<?php echo $direction_row; ?>][sort_order]" value="<?php echo $contest_direction['sort_order']; ?>" class="form-control" />
		                                  </td>
		                                  <td class="text-left">
		                                    <button type="button" onclick="$('#direction-row<?php echo $direction_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger">
		                                      <i class="fa fa-minus-circle"></i>
		                                    </button>
		                                  </td>
		                                </tr>
		                                <?php $direction_row++; ?>
		                                <?php } ?>
		                                </tbody>
		                                <tfoot>
		                                  <tr>
		                                   <td colspan="4" class="text-center">
		                                      <div class="col-sm-offset-4 col-sm-4">
		                                        <button type="button" onclick="addDirection();" class="btn btn-primary btn-block"><i class="fa fa-plus-circle"> </i>  <?php echo $button_add; ?></button>
		                                      </div>
		                                    </td>
		                                  </tr>
		                                </tfoot>
		                          </table>
		              </div>
		            </div>
		          </div>
		        </div><!-- /#tab-direction -->
             	
                <div role="tabpanel" class="tab-pane" id="tab-files">
                  <div class="card-body card-padding">
                    	
                    	<!-- список файлов -->
                    	<table id="videos" class="table table-striped">
                    		<thead>
	                    		<th>Название файла</th>
	                    		<th></th>
                    		</thead>
                    		<tbody>                    			
		                    	<?php foreach($contest_file as $download_id){ ?>
									 <tr class="file-row">
										<td>
											<select name="contest_file[]" id="input-file" class="form-control input-file">
			                                	    <option value="">Выберите файл</option>		                    			
			                                	<?php foreach($files as $file){ ?>
			                                		<option <?php echo ($file['download_id'] == $download_id) ? "selected" : "";?> value="<? echo $file['download_id']; ?>"><?php echo $file['name']; ?></option>
			                                	<?php } ?>	                                 
			                                </select>
										</td>
										<td class="text-right">
			                    			<button onclick="deleteRow(this, 'file');" type="button" data-toggle="tooltip" title="<?php echo $button_file_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
		                    			</td>
									</tr>                    		
		                    	<?php } ?>
                    			<tr class="file-row" style="display: none;">
	                    			<td>
		                    			<select name="contest_file[]" id="input-file" class="form-control input-file">
		                                	    <option value="">Выберите файл</option>		                    			
		                                	<?php foreach($files as $file){ ?>
		                                		<option value="<? echo $file['download_id']; ?>"><?php echo $file['name']; ?></option>
		                                	<?php } ?>	                                 
		                                </select>
	                    			</td>
	                    			<td class="text-right">
		                    			<button onclick="deleteRow(this, 'file');" type="button" data-toggle="tooltip" title="<?php echo $button_file_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
	                    			</td>
                    			</tr>
		                    	<tr>
			                    	<td colspan="2" class="text-right">
			                    		<button type="button" onclick="addRow('file');" data-toggle="tooltip" title="<?php echo $button_file_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
			                    	</td>
		                    	</tr>
                    		</tbody>
                    	</table>
                    	
                  </div>
                </div><!-- /#tab-files -->
				
				<div role="tabpanel" class="tab-pane" id="tab-seo">
                	<ul class="tab-nav language-tab" role="tablist" id="language" data-tab-color="amber">
                        <?php foreach ($languages as $language) { ?>
                          <li>
                            <a href="#meta-language<?php echo $language['language_id']; ?>" data-toggle="tab">
                              <?php echo $language['name']; ?>
                            </a>
                          </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                      <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane" id="meta-language<?php echo $language['language_id']; ?>">

                          <div class="card-body card-padding">
                          
                          		 <!-- meta_title -->
			                      <div class="form-group <?php if (isset($error_meta_title[$language['language_id']])) { ?> has-error <?php } ?>">
			                        <div class="fg-line">
			                            <label class="control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
			                            <input type="text" name="contest_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['meta_title'] : ''; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
			                            <?php if (isset($error_meta_title[$language['language_id']])) { ?>
										  <small class="help-block"><?php echo $error_meta_title[$language['language_id']]; ?></small>
										<?php } ?>
			                        </div>
			                      </div>
			
			                      <!-- meta_description -->
			                      <div class="form-group">
			                        <div class="fg-line">
			                            <label class="control-label m-b-10" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
			                            <textarea name="contest_description[<?php echo $language['language_id']; ?>][meta_description]" class="form-control auto-size" rows="4" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
			                        </div>
			                      </div>
			                      
			                      <!-- meta_keywords -->
			                      <div class="form-group">
			                        <div class="fg-line">
			                            <label class="control-label m-b-10" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
			                            <textarea name="contest_description[<?php echo $language['language_id']; ?>][meta_keyword]" class="form-control auto-size" rows="4" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
			                        </div>
			                      </div>
                          
                          </div>
                         </div>
                      <?php } ?>
                    </div>
                </div><!-- /#tab-seo -->
                
               

            </div><!-- /.tab-content-->
          </form>
        </div><!-- /.tabpanel -->
      </div><!--/.card -->
    </div> <!--/.container -->
</section>

<script type="text/javascript"><!--
 <?php foreach ($languages as $language) { ?>
  $('#input-description<?php echo $language['language_id']; ?>').summernote({
    height: 300
  });
  $('#input-organizer<?php echo $language['language_id']; ?>').summernote({
    height: 300
  });
  $('#input-propose<?php echo $language['language_id']; ?>').summernote({
    height: 300
  });
  $('#input-location<?php echo $language['language_id']; ?>').summernote({
    height: 300
  });
  $('#input-members<?php echo $language['language_id']; ?>').summernote({
    height: 300
  });
  $('#input-contacts<?php echo $language['language_id']; ?>').summernote({
    height: 300
  });
  $('#input-timeline_text<?php echo $language['language_id']; ?>').summernote({
    height: 300
  });

  <?php } ?>
  $('.language-tab').each(function(){
	  
	  $('a:first', $(this)).tab('show');
  }) 
//--></script>

<script type="text/javascript"><!--
var expert_row = <?php echo $expert_row; ?>;

function addExpert() {
  html  = '<tr id="expert-row' + expert_row + '">';
  

  html += '<td>';
  html += '<div class="form-group"><div class="fg-line"><div class="select">';
  html += '<select name="contest_experts[' + expert_row + '][customer_id]" id="input-customer_id" class="form-control">'
  html += '<option value="0"><?php echo $text_none; ?></option>'
  <?php if (!empty($customers)) { ?>
    <?php foreach ($customers as $customer) { ?>
    html += '<option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['name']; ?></option>';
    <?php } ?>
  <?php } ?>
  html += '</select></div></div></div></td>';

 
  html += '<td class="text-left"><button type="button" onclick="$(\'#expert-row' + expert_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#experts tbody').append(html);
  
  expert_row++;
}
//--></script>

<script type="text/javascript"><!--
var criteria_row = <?php echo $criteria_row; ?>;

function addCriteria() {
  html  = '<tr id="criteria-row' + criteria_row + '">';
    html += '  <td>';
  <?php foreach ($languages as $language) { ?>
  html += '    <div class="input-group">';
  html += '      <span class="input-group-addon"><?php echo $language['name']; ?></span><div class="fg-line"><input type="text" name="contest_criteria[' + criteria_row + '][contest_criteria_description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="<?php echo $entry_criteria_title; ?>"  class="form-control" /></div>';
    html += '    </div>';
  <?php } ?>
  html += '  </td>'; 

  html += '  <td class="text-left" style="width: 30%;"><input type="text" name="contest_criteria[' + criteria_row + '][weight]" value="1" class="form-control" /></td>'; 
  
  html += '  <td class="text-right" style="width: 20%;"><input type="text" name="contest_criteria[' + criteria_row + '][sort_order]" value="10" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#criteria-row' + criteria_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#criterias tbody').append(html);
  
  criteria_row++;
}
//--></script>

<script type="text/javascript"><!--
var direction_row = <?php echo $direction_row; ?>;

function addDirection() {
  html  = '<tr id="direction-row' + direction_row + '">';
    html += '  <td>';
  <?php foreach ($languages as $language) { ?>
  html += '    <div class="input-group">';
  html += '      <span class="input-group-addon"><?php echo $language['name']; ?></span><div class="fg-line"><input type="text" name="contest_direction[' + direction_row + '][contest_direction_description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="<?php echo $entry_direction_title; ?>"  class="form-control" /></div>';
    html += '    </div>';
  <?php } ?>
  html += '  </td>'; 
 
  html += '  <td class="text-right" style="width: 20%;"><input type="text" name="contest_direction[' + direction_row + '][sort_order]" value="10" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#direction-row' + direction_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#directions tbody').append(html);
  
  direction_row++;
}
//--></script>

<script type="text/javascript"><!--
	/*
	function deleteRow(sender, type){
	
		if ($('.' + type + '-row').length > 1){
 	 
		 	$(sender).parents('.' + type + '-row').remove();
		 }
		 else{
		 	$(sender).parents('.' + type + '-row').find('.input-' + type + '').val('');
		 }
	}
	
	function addRow(type){
		
		$('.' + type + '-row')
 		.last()
 		.clone()
 		.insertBefore($('.' + type + '-row').last())
 		.show()
 		.find('.input-' + type + '').val('');
	}*/
//--></script>
<?php echo $footer; ?>