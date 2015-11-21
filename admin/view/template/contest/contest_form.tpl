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
                <li ><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo $tab_general; ?></a></li>
				<li><a href="#tab-expert" aria-controls="tab-expert" role="tab" data-toggle="tab"><?php echo $tab_expert; ?></a></li>
				<li class="active"><a href="#tab-request" aria-controls="tab-request" role="tab" data-toggle="tab"><?php echo $tab_request; ?></a></li>
				
                <li><a href="#tab-direction" aria-controls="tab-direction" role="tab" data-toggle="tab"><?php echo $tab_direction; ?></a></li>
                <li><a href="#tab-timeline" aria-controls="tab-timeline" role="tab" data-toggle="tab"><?php echo $tab_timeline; ?></a></li>
                <li><a href="#tab-files" aria-controls="tab-files" role="tab" data-toggle="tab"><?php echo $tab_files; ?></a></li>
                
                <li><a href="#tab-seo" aria-controls="tab-seo" role="tab" data-toggle="tab"><?php echo $tab_seo; ?></a></li>
                <li><a href="#tab-criteria" aria-controls="tab-criteria" role="tab" data-toggle="tab"><?php echo $tab_criteria; ?></a></li>
                
            </ul>
          
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane " id="tab-general">
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
	                          	 <div class="col-sm-6">	
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
		                          
		                          <div class="col-sm-6">
			                          <!-- организатор -->
			                          <div class="form-group required <?php if (isset($error_organizer[$language['language_id']])) { ?> has-error <?php } ?>">
			                            <div class="fg-line">
			                                <label class="control-label" for="input-organizer<?php echo $language['language_id']; ?>"><?php echo $entry_organizer; ?></label>
			                                <input type="text" name="contest_description[<?php echo $language['language_id']; ?>][organizer]" value="<?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['organizer'] : ''; ?>"  id="input-organizer<?php echo $language['language_id']; ?>" class="form-control" />
			                            </div>
			                            <?php if (isset($error_organizer[$language['language_id']])) { ?>
			                              <small class="help-block"><?php echo $error_organizer[$language['language_id']]; ?></small>
			                            <?php } ?>
			                          </div>
		                          </div>
	                          </div>
	                          
	                          <!-- цель -->
	                          <div class="form-group">
	                            <div class="fg-line">
	                                <label class="control-label m-b-10" for="input-propose<?php echo $language['language_id']; ?>"><?php echo $entry_propose; ?></label>
	                                <textarea name="contest_description[<?php echo $language['language_id']; ?>][propose]" id="input-propose<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['propose'] : ''; ?></textarea>
	                            </div>
	                          </div>
	                          
	                          <!-- география -->
	                          <div class="form-group">
	                            <div class="fg-line">
	                                <label class="control-label m-b-10" for="input-location<?php echo $language['language_id']; ?>"><?php echo $entry_location; ?></label>
	                                <textarea name="contest_description[<?php echo $language['language_id']; ?>][location]" id="input-location<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['location'] : ''; ?></textarea>
	                            </div>
	                          </div>
	                          
	                          <!-- участники -->
	                          <div class="form-group">
	                            <div class="fg-line">
	                                <label class="control-label m-b-10" for="input-members<?php echo $language['language_id']; ?>"><?php echo $entry_members; ?></label>
	                                <textarea name="contest_description[<?php echo $language['language_id']; ?>][members]" id="input-members<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['members'] : ''; ?></textarea>
	                            </div>
	                          </div>
	                          
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
	                          
	                          <!-- Контакты  -->
		                      <div class="form-group">
	                            <div class="fg-line">
	                                <label class="control-label m-b-10" for="input-contacts<?php echo $language['language_id']; ?>"><?php echo $entry_contacts; ?></label>
	                                <textarea name="contest_description[<?php echo $language['language_id']; ?>][contacts]" id="input-contacts<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['contacts'] : ''; ?></textarea>
	                            </div>
	                          </div>
						
							  <!-- Дополнительный текст о графике -->
		                      <div class="form-group">
		                        <div class="fg-line">
		                            <label class="control-label m-b-10" for="input-timeline_text<?php echo $language['language_id']; ?>"><?php echo $entry_timeline_text; ?></label>
		                            <textarea name="contest_description[<?php echo $language['language_id']; ?>][timeline_text]" class="form-control auto-size" rows="4" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['timeline_text'] : ''; ?></textarea>
		                        </div>
		                      </div>
                          
                          

                          </div><!--/.card-body -->
                        </div><!-- /tab-pane -->
                        <?php } ?>
                        
                        
                        
	                          
	                          <div class="row">
		                          <div class="col-sm-6">
			                          <!-- тип -->
			                          <div class="form-group">
			                            <div class="fg-line">
			                              <label class="control-label" for="input-type"><?php echo $entry_type; ?></label>
			                              <div class="select">
			                                <select name="type" id="input-type" class="form-control">
			                                	<?php foreach($contest_types as $k => $one_type){ ?>
			                                		<option <?php echo (isset($type) && $type == $k) ? "selected" : ""?> value="<? echo $k; ?>"><?php echo $one_type; ?></option>
			                                	<?php } ?>	                                 
			                                </select>
			                              </div>
			                            </div>
			                          </div>
		                          </div>
		                          
		                          <div class="col-sm-6">
			                          <!-- статус -->
			                          <div class="form-group">
			                            <div class="fg-line">
			                              <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
			                              <div class="select">
			                                <select name="status" id="input-status" class="form-control">
			                                  <?php foreach($contest_statuses as $k => $one_status){ ?>
			                                		<option <?php echo (isset($type) && $status == $k) ? "selected" : ""?> value="<? echo $k; ?>"><?php echo $one_status; ?></option>
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
                        
                        
                    </div><!-- /.tab-content -->
                  </div><!-- /.tabpanel -->
                </div><!-- /#tab-general -->
				
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
					
				<div role="tabpanel" class="tab-pane active" id="tab-request">

					<div class="panel-group" role="tablist" aria-multiselectable="true">
						<?php $category_request_row = 0; ?>
		                    <?php foreach ($category_requestes as $cr) { ?>
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
		                                    <?php echo $cr['name']; ?>
		                                    <?php echo $cr['category_request_id']; ?>
		                                </div>
		                            </div>
		                        </div>
		                    <?php $category_request_row++; ?>
	                    <?php } ?>
                    </div>
                </div><!-- /#tab-request -->


             	<div role="tabpanel" class="tab-pane" id="tab-direction">
                  <div class="card-body card-padding">
                    	
                    	<!-- Направления конкурса  -->
	                      <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label m-b-10" for="input-direction<?php echo $language['language_id']; ?>"><?php echo $entry_directions; ?></label>
                                <?php 
                                	if (isset($contest_direction)){
                                		
                                		foreach($contest_direction as $direction){
                                		?> 
                                			<div class="row direction-row" style="position: relative;">
                                			
                                		<?php	foreach($languages as $language){
                                				?>
                                					<?php echo $language['name']; ?> <input type="text" name="contest_direction[<?php echo $language['language_id']; ?>][]" value="<?php echo isset($direction[$language['language_id']]['title'])? $direction[$language['language_id']]['title'] : ""; ?>"  id="input-direction<?php echo $language['language_id']; ?>" class="form-control input-direction" />			
                                				<?php
                                			} ?>
                                			<button style="position: absolute; right: 0px; bottom: 0px;" onclick="deleteRow(this, 'direction');" type="button" data-toggle="tooltip" title="<?php echo $button_direction_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                			</div>
                                			<br/>
                                		<?php
                                		}
                                	}
                                ?>
                                
                                <div class="row direction-row" style="position: relative; display: none;">
                                	<?php foreach ($languages as $language) { ?>
			                        	<?php echo $language['name']; ?><input type="text" name="contest_direction[<?php echo $language['language_id']; ?>][]" value=""  id="input-direction<?php echo $language['language_id']; ?>" class="form-control input-direction" />
			                        <?php } ?>
	                            	<button style="position: absolute; right: 0px; bottom: 0px;" onclick="deleteRow(this, 'direction');" type="button" data-toggle="tooltip" title="<?php echo $button_direction_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
	                            	<br/>
	                            </div>
	                            <div class="row text-right">
	                            	<br/>
		                            <button type="button" onclick="addRow('direction');" data-toggle="tooltip" title="<?php echo $button_direction_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
	                            </div>
                            </div>
                          </div>
						
                  </div>
                </div><!-- /#tab-direction -->
                
             	<div role="tabpanel" class="tab-pane" id="tab-timeline">
                  <div class="card-body card-padding">
                    	
                    	<!-- Начало приема заявок  -->
						<div class="form-group">
							<div class="fg-line">
							    <label class="control-label" for="date_start"><?php echo $entry_date_start; ?></label>
							     <input type="text" class="form-control date-picker" id="date_start" name="date_start" value="<?php echo (isset($date_start)) ? $date_start : date('Y-m-d'); ?>">
							</div>
						</div>
						
						<!-- Завершение приема заявок   -->
						<div class="form-group">
							<div class="fg-line">
							    <label class="control-label" for="datetime_end"><?php echo $entry_datetime_end; ?></label>
							     <input type="text" class="form-control date-picker datetime-picker" id="datetime_end" name="datetime_end" value="<?php echo (isset($datetime_end)) ? $datetime_end : date('Y-m-d'); ?>">
							</div>
						</div>
						
						<!-- Завершение оценки заявок    -->
						<div class="form-group">
							<div class="fg-line">
							    <label class="control-label" for="date_rate"><?php echo $entry_date_rate; ?></label>
							     <input type="text" class="form-control date-picker" id="date_rate" name="date_rate" value="<?php echo (isset($date_rate)) ? $date_rate : date('Y-m-d'); ?>">
							</div>
						</div>
						
						<!-- Объявление результатов    -->
						<div class="form-group">
							<div class="fg-line">
							    <label class="control-label" for="date_result"><?php echo $entry_date_result; ?></label>
							     <input type="text" class="form-control date-picker" id="date_result" name="date_result" value="<?php echo (isset($date_result)) ? $date_result : date('Y-m-d'); ?>">
							</div>
						</div>
						
						<!-- Публикация списка финалистов     -->
						<div class="form-group">
							<div class="fg-line">
							    <label class="control-label" for="date_finalist"><?php echo $entry_date_finalist; ?></label>
							     <input type="text" class="form-control date-picker" id="date_finalist" name="date_finalist" value="<?php echo (isset($date_finalist)) ? $date_finalist : date('Y-m-d'); ?>">
							</div>
						</div>
						
                  </div>
                </div><!-- /#tab-timeline -->
                
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
			                      <div class="form-group">
			                        <div class="fg-line">
			                            <label class="control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
			                            <input type="text" name="contest_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($contest_description[$language['language_id']]) ? $contest_description[$language['language_id']]['meta_title'] : ''; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
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
                
               	<div role="tabpanel" class="tab-pane" id="tab-criteria">
                  <div class="card-body card-padding">
                    	
                    	<!-- список критериев -->
                    	<table id="videos" class="table table-striped">
                    		<thead>
	                    		<th>Критерий</th>
	                    		<th>Вес</th>
	                    		<th></th>
                    		</thead>
                    		<tbody>     
                    			<?php 
                                	if (isset($contest_criteria)){
                                		foreach($contest_criteria as $k => $criteria){
                                		?> 
                                			<tr class="criteria-row">
	                                			<td>
	                                				<?php	foreach($languages as $language){
	                                					?>
	                                					
		                                					<?php echo $language['name']; ?> <input type="text" name="contest_criteria[<?php echo $language['language_id']; ?>][title][]" value="<?php echo isset($criteria[$language['language_id']]['title'])? $criteria[$language['language_id']]['title'] : ""; ?>"  id="input-criteria<?php echo $language['language_id']; ?>" class="form-control input-criteria" />			
	                                					
	                                				<?php } ?>
	                                			</td>
	                                			<td>
	                                				<br/>
	                                				<input type="text" name="contest_criteria[weight][]" value="<?php echo isset($criteria[$language['language_id']]['weight'])? $criteria[$language['language_id']]['weight'] : ""; ?>"  id="input-criteria<?php echo $language['language_id']; ?>" class="form-control input-criteria" />
	                                			</td>
	                                			<td>
		                                			<button onclick="deleteRow(this, 'criteria');" type="button" data-toggle="tooltip" title="<?php echo $button_criteria_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
	                                			</td>
                                			</tr>
                                		<?php
                                		}
                                	}
                                ?>  
                    			<tr class="criteria-row" style="display: none;">
	                    			<td>
	                    				<?php foreach($languages as $language){ ?>
	                    					<?php echo $language['name']; ?><input type="text" name="contest_criteria[<?php echo $language['language_id']; ?>][title][]" value=""  id="input-criteria<?php echo $language['language_id']; ?>" class="form-control input-expert" />
	                    				<?php } ?>
	                    			</td>
	                    			<td>
	                    				<br/>
	                    				<input type="text" name="contest_criteria[weight][]" value=""  id="input-criteria<?php echo $language['language_id']; ?>" class="form-control input-expert" />
	                    			</td>
	                    			<td class="text-right">
		                    			<button onclick="deleteRow(this, 'criteria');" type="button" data-toggle="tooltip" title="<?php echo $button_criteria_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
	                    			</td>
                    			</tr>
		                    	<tr>
			                    	<td colspan="3" class="text-right">
			                    		<button type="button" onclick="addRow('criteria');" data-toggle="tooltip" title="<?php echo $button_criteria_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
			                    	</td>
		                    	</tr>
                    		</tbody>
                    	</table>
                    	
                  </div>
                </div>

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