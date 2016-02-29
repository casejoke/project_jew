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
      <div class="col-sm-8">
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
                <li ><a href="#request" data-toggle="tab">Заявка</a></li>

                <li class="active"><a href="#estimate" data-toggle="tab">Оценить</a></li>
              </ul>
              <!-- Nav tabs end -->

              <!-- Tab panes start-->
              <div class="tab-content">

                <!-- Tab start -->
                <div class="tab-pane " id="request">
                  <?php foreach ($category_requestes as $cr) { ?>
                    <?php if ( !empty( $cr['category_request_id'] ) ) { ?>

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
                <!-- Tab end -->

                <!-- Tab start -->
                <div class="tab-pane" id="contest">
                  
                </div>
                <!-- Tab end -->

                <!-- Tab start -->
                <div class="tab-pane active" id="estimate">
                  
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
       <!-- Sidebar column start -->
      <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
        <?php echo $column_left; ?>
        <?php echo $column_right; ?>
      </div>
      <!-- Sidebar column end -->
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div><!-- /.module -->

<?php echo $column_right; ?>

<?php echo $footer; ?>