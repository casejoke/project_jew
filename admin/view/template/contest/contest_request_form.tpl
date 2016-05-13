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
                <li class="active"><a href="#tab-request" aria-controls="tab-request" role="tab" data-toggle="tab"><?php echo $tab_request; ?></a></li>
                <li><a href="#tab-customer" aria-controls="tab-customer" role="tab" data-toggle="tab"><?php echo $tab_customer; ?></a></li>
                <li><a href="#tab-status" aria-controls="tab-status" role="tab" data-toggle="tab"><?php echo $tab_status; ?></a></li>
                <li><a href="#tab-mark" aria-controls="tab-mark" role="tab" data-toggle="tab">Оценки и рекомендации</a></li>
            </ul>
          
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane activec" id="tab-request">
                  <div class="card-body card-padding">
                    <?php foreach ($category_requestes as $cr) { ?>
                    <?php if ( !empty( $cr['category_request_id']) && !empty( $cr['category_fields']) ) { ?>

                    <h4 class="font-alt mb-20"><?php echo $cr['name']; ?></h4>

                      <?php foreach ($cr['category_fields'] as $vcri) { ?>
                    
                          

                          <div class="pmb-block">
                            <?php if($vcri['field_type'] == 'text'){ ?>
                              <div class="pmbb-header">
                                  <h5><?php echo $vcri['field_title']; ?></h5>
                              </div>
                              <div class="pmbb-body p-l-30">
                                  <div class="pmbb-view">
                                       <?php echo (!empty($vcri['field_value']))?html_entity_decode($vcri['field_value']):'Не указано.'; ?> 
                                  </div>
                              </div>
                            <?php }?>

                            <?php if($vcri['field_type'] == 'list'){ ?>
                              <div class="pmbb-header">
                                  <h5><?php echo $vcri['field_title']; ?></h5>
                              </div>
                              <div class="pmbb-body p-l-30">
                                  <div class="pmbb-view">
                                    <ul> 
                                      <?php foreach ($vcri['field_value'] as $vfv) { ?>
                                        <li><?php echo $vfv['title']; ?></li>
                                      <?php } ?>
                                    </ul>
                                  </div>
                              </div>
                            <?php } ?>
  
                            <?php if($vcri['field_type'] == 'textarea'){ ?>
                              <div class="pmbb-header">
                                  <h5><?php echo $vcri['field_title']; ?></h5>
                              </div>
                              <div class="pmbb-body p-l-30">
                                  <div class="pmbb-view">
                                      <?php echo (!empty($vcri['field_value']) || $vcri['field_value'] == '<p><br></p>')?html_entity_decode($vcri['field_value']):'Не указано.'; ?> 
                                  </div>
                              </div>
                            <?php }?>

                          </div>

                          


                          
      
                       
                        
                        
                        <?php } ?>
                      <?php } ?>
                    <?php } ?>
                  </div>
                </div><!-- /#tab-general -->
                <div role="tabpanel" class="tab-pane " id="tab-customer">
                  <div class="card-body card-padding">

                      <div class="pmb-block">
                                
                                <div class="pmbb-body p-l-30">
                                    <div class="pmbb-view">
                                        <dl class="dl-horizontal">
                                            <dt>Фамилия Имя</dt>
                                            <dd><?php echo $lastname; ?> <?php echo $firstname; ?></dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>E-mail</dt>
                                            <dd><?php echo $email; ?></dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Телефон</dt>
                                            <dd><?php echo $telephone; ?></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>



                    
                  </div>
                </div><!-- /#tab-general -->
                <div role="tabpanel" class="tab-pane" id="tab-status">
                  <div class="card-body card-padding">
                	 <div class="row">

                    <div class="col-sm-6">
                        <!-- тип -->
                        <div class="form-group">
                          <div class="fg-line">
                            <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                            <div class="select">
                              <select name="status" id="input-status" class="form-control">
                                <?php if (!empty($request_status)) { ?>
                                  <?php foreach ($request_status as $rs) { ?>
                                  <?php if ($rs['request_status_type_id'] == $status) { ?>
                                    <option value="<?php echo $rs['request_status_type_id']; ?>" selected="selected"><?php echo $rs['request_status_type_title']; ?></option>
                                  <?php } else { ?>
                                    <option value="<?php echo $rs['request_status_type_id']; ?>"><?php echo $rs['request_status_type_title']; ?></option>
                                  <?php } ?>
                                  <?php } ?>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div> 

                      <div class="col-sm-6">
                          <!-- организатор -->
                          <div class="form-group required">
                            <div class="fg-line">
                                <label class="control-label" for="input-organizer">Комментарий</label>
                                 <textarea name="comment" row='10' id="input-comment" class="form-control"><?php echo isset($comment) ? $comment : ''; ?></textarea>
                            </div>
                           
                          </div>
                        </div>



                   </div>
                  </div>
                </div><!-- /#tab-timeline -->
				        
                <div role="tabpanel" class="tab-pane active" id="tab-mark">
                  <div class="card-body card-padding">
                    <table class="table">
                      <thead>
                          <tr>
                            <th class="text-center">Эксперт</th>
                            <th class="text-center">Оценка</th>
                            <th class="text-center">Рекомендация</th>
                            <th class="text-center">Комментарий</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php if (!empty($estimate_list)) { ?>
                      
                          <?php foreach ($estimate_list as $vel) { ?>
                            <tr>
                              <td class="text-center"><?php echo $vel['customer_expert_name']; ?></td>
                              <td class="text-center"><?php echo $vel['customer_score']; ?></td>
                              <td class="text-center"><?php echo $vel['customer_recommendation']; ?></td>
                              <td class="text-center"><?php echo $vel['customer_comment']; ?></td>
                        </tr>
                          <?php } ?>
                      <?php } else {?>
                        
                        <tr>
                          <td colspan="4" class="text-center">Нет оценок</td>
                          
                        </tr>
                       <?php } ?>
                        
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

<?php echo $footer; ?>