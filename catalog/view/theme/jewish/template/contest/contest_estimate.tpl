<?php echo $header; ?>
<div class="module module--initnavbar"  data-navbar="navbar-dark"><!-- module -->
  <div class="container">
  <?php echo $content_top; ?>
    <div class="row">
       <div class="col-sm-10 col-sm-offset-1">
        <?php if (!empty($success)) { ?>
          <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?></div>
        <?php } ?>
      </div><!-- /.col-sm-10 -->
     
      <!-- Content column start -->
      <div class="col-sm-12">
        <!-- Post start -->
        <div class="post">
          <div class="post-header font-alt">
            <h1 class="post-title">Оценка заявки на конкурс: <?php echo $contest_title; ?> </h1>
          </div>
          <div class="post-entry ">
            
            <div role="tabpanel">

              <!-- Nav tabs start-->
              <ul class="nav nav-tabs font-alt" role="tablist">
                <li class="hidden"><a href="#contest" data-toggle="tab">О конкурсе</a></li>
                <li class="active" ><a href="#request" data-toggle="tab">Заявка</a></li>

                <li><a href="#estimate" data-toggle="tab">Оценить</a></li>
              </ul>
              <!-- Nav tabs end -->

              <!-- Tab panes start-->
              <div class="tab-content">

                <!-- Tab start -->
                <div class="tab-pane active" id="request">
                    
                     <div class="col-md-6 post">
                  <div class="post-header font-alt">
                        <h2 class="post-title">Заявка</h2>
                      </div>
                  <?php foreach ($category_requestes as $cr) { ?>
                    <?php if ( !empty( $cr['category_request_id']) && !empty($cr['category_fields']) )  { ?>

                    <h4 class="font-alt mb-20"><?php echo $cr['name']; ?></h4>

                      <?php foreach ($cr['category_fields'] as $vcri) { ?>
                  
                      <?php if($vcri['field_type'] == 'list'){ ?>
                        <div class="col-sm-12"> 
                          <div class="form-group">
                            <label class="control-label font-alt" ><?php echo $vcri['field_title']; ?> </label>
                          </div> 
                          <ul> 
                            <?php foreach ($vcri['field_value'] as $vfv) { ?>
                              <li><?php echo $vfv['title']; ?></li>
                            <?php } ?>
                          </ul>
                        </div>
                      <?php } ?>



                      <?php if($vcri['field_type'] == 'text'){ ?>
                        <div class="col-sm-12">  
                          <div class="form-group">
                            <label class="control-label font-alt" ><?php echo $vcri['field_title']; ?> </label>
                          </div> 
                          <div class="form-group">
                            
                            <?php echo html_entity_decode($vcri['field_value']); ?> 
                          </div>
                        </div>
                      <?php }?>


                      <?php if($vcri['field_type'] == 'textarea'){ ?>
                        <div class="col-sm-12">   
                          <div class="form-group">
                            <label class="control-label font-alt" ><?php echo $vcri['field_title']; ?> </label>
                          </div>
                          <div class="form-group">
                            <?php echo html_entity_decode($vcri['field_value']); ?> 
                          </div>
                        </div>
                      <?php }?>

                       
                        
                        
                      <?php } ?>


                    <?php } ?>
                  <?php } ?>
                  </div>


                  <div class="hidden-xs hidden-sm col-md-6 sidebar">


                  <?php if(!empty($adaptive_info)) { ?>

                
                    <!-- Post start -->
                    <div class="post">
                      <div class="post-header font-alt">
                        <h2 class="post-title">Описание проекта который выбрали для адаптации</h2>
                      </div>
                      <div class="post-entry ">
                            <h4 class="font-alt mb-20">Контакная информация</h4>  
                              <h5 class="font-alt mb-20"><a href="mailto:<?php echo $admin_info['email']; ?>"><?php echo $admin_info['email']; ?></a></h5>
                              <h5 class="font-alt mb-20"><a href="<?php echo $link_admin; ?>"><?php echo $admin_info['lastname'].' '.$admin_info['firstname']?></a></h5>
                               
                            <h4 class="font-alt mb-20">Описание проекта: <?php echo $project_title; ?></h4> 
                             
                              <div class="post-thumbnail">
                                <img src="<?php echo $image; ?>" alt="<?php echo $project_title; ?>">
                              </div>
                              <div class="post-entry">
                               <?php echo $project_description; ?>
                              </div>
                              
                              <?php if(!empty($project_target)){ ?>
                                <div class="post-entry">
                                <h4 class="font-alt mb-20">Цель проекта</h4>
                                 <?php echo $project_target; ?>
                                </div>
                              <?php } ?>
                              <?php if(!empty($project_product)){ ?>

                                <div class="post-entry">
                                  <h4 class="font-alt mb-20">Продукт проекта</h4>
                                 <?php echo $project_product; ?>
                                </div>
                              <?php } ?>
                              <?php if(!empty($project_result)){ ?>
                                
                                <div class="post-entry">
                                <h4 class="font-alt mb-20">Результат проекта</h4>
                                 <?php echo $project_result; ?>
                                </div>
                              <?php } ?>

                              <div class="post-entry">
                              <h4 class="font-alt mb-20">Вид сотрудничества</h4>
                              <ul>
                                  <li>Консультация</li>
                              </ul>
                              </div>

                              <?php if(!empty($sex_statuses)){ ?>
                                <div class="post-entry">
                                <h4 class="font-alt mb-20">Пол</h4>
                                <ul>
                                  <?php foreach ($sex_statuses as  $vss) { ?>
                                    <li><?php echo $vss['title']; ?></li>
                                  <?php } ?>
                                </ul>
                                </div>
                              <?php } ?>
                              
                              <?php if(!empty($age_statuses)){ ?>
                                <div class="post-entry">
                                <h4 class="font-alt mb-20">Возраст группы проекта</h4>
                                <ul>
                                  <?php foreach ($age_statuses as  $vas) { ?>
                                    <li><?php echo $vas['title']; ?></li>
                                  <?php } ?>
                                </ul>
                                </div>
                              <?php } ?>

                              <?php if(!empty($project_nationality)){ ?>
                                <div class="post-entry">
                                  <h4 class="font-alt mb-20">Религия / национальность</h4>
                                  <ul>
                                    <?php foreach ($project_nationality as  $vpn) { ?>
                                      <li><?php echo $vpn['title']; ?></li>
                                    <?php } ?>
                                  </ul>
                                </div>
                              <?php } ?>

                              <?php if(!empty($project_professional)){ ?>
                                <div class="post-entry">
                                  <h4 class="font-alt mb-20">Профессии</h4>
                                  <ul>
                                    <?php foreach ($project_professional as  $vpp) { ?>
                                      <li><?php echo $vpp['title']; ?></li>
                                    <?php } ?>
                                  </ul>
                                </div>
                              <?php } ?>

                              <?php if(!empty($project_demographic)){ ?>
                                <div class="post-entry">
                                  <h4 class="font-alt mb-20">Демография проекта</h4>
                                  <ul>
                                    <?php foreach ($project_demographic as  $vpp) { ?>
                                      <li><?php echo $vpp['title']; ?></li>
                                    <?php } ?>
                                  </ul>
                                </div>
                              <?php } ?>
                              
                              
              

                      </div>
                    </div>
                      <?php } ?>
                  </div>





                </div>
                <!-- Tab end -->

                <!-- Tab start -->
                <div class="tab-pane" id="contest">
                  
                </div>
                <!-- Tab end -->

                <!-- Tab start -->
                <div class="tab-pane " id="estimate">
                  
                  <?php if(!empty($contest_criteria)){ ?>
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" >
                    <?php foreach ($contest_criteria as $vcc) { ?>
                        <div class="row">
                         <div class="col-sm-5 col-md-3">
                            <p class="btn-list">
                              <button type="button" class="btn btn-default btn-round btn-estimate disabled" data-mark="1">1</button>
                              <button type="button" class="btn btn-default btn-round btn-estimate disabled" data-mark="2">2</button>
                              <button type="button" class="btn btn-default btn-round btn-estimate disabled" data-mark="3">3</button>
                            </p>
                             <input type="hidden" name="estimate_request[<?php echo $vcc['contest_criteria_id']; ?>]" value=""  id="input-<?php echo $vcc['contest_criteria_id']; ?>" class="form-control" />
                          </div>
                          <div class="col-sm-7 col-md-9">
                            <h5 class="font-alt mb-0 "><?php echo $vcc['criteria_title']; ?></h5>
                          </div>
                        </div>

                    <?php } ?>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label class="control-label font-alt">Отметка о пользе заявки</label>
                          <div class="checkbox">
                              <label>
                                <input type="checkbox" name="recommendation" id="recommendation"   value="1" /> Я рекомендую проект
                              </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-3">
                          <input type="submit" value="<?php echo $text_submit;?>" class="btn btn-round btn-block btn-success btn-send-estimate" disabled/>
                        </div>
                      </div>  
                    </div> 
                    </form>
                  <?php  } ?>
                </div>
                <!-- Tab end -->

              </div>
              <!-- Tab panes end-->
            </div>


          </div>
        </div>
        <!-- Post end -->
      </div>
      <!-- Content column end -->
      
       <?php echo $column_left; ?>
        <?php echo $column_right; ?>
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div><!-- /.module -->

<?php echo $column_right; ?>

<?php echo $footer; ?>