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
            <h1 class="post-title">Оформление заявки на конкурс: <?php echo $contest_title; ?> </h1>
          </div>
          <div class="post-entry ">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" >
            <?php foreach ($category_requestes as $cr) { ?>
              <?php if(!empty($contest_fields[$cr['category_request_id']])){ ?>

                <h4 class="font-alt mb-0"><?php echo $cr['name']; ?></h4>

                <?php $custom_field_row = 0; ?>
                <?php foreach ($contest_fields[$cr['category_request_id']] as $cfvalue) { ?>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <input type="hidden" name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][field_id]" value="<?php echo $cfvalue['contest_field_id']; ?>"  id="input-<?php echo 'field_id_'.$cfvalue['contest_field_id']; ?>" class="form-control" />
                      <label class="control-label" for="input-<?php echo 'value_'.$cfvalue['contest_field_id']; ?>"><?php echo $cfvalue['contest_field_title']; ?></label>
                      
                      <!-- select -->
                      <?php if ($cfvalue['contest_field_type'] == 'select') { ?>
            
                          <select name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][value]" id="input-<?php echo 'value_'.$cfvalue['contest_field_id']; ?>" class="form-control">

                            <option value=""><?php echo $text_select; ?></option>
                            <?php foreach ($cfvalue['contest_field_value'] as $custom_field_value) { ?>

                            <?php if (isset($register_custom_field[$cfvalue['contest_field_id']]) && $cfvalue['contest_field_id'] == $register_custom_field[$custom_field['contest_field_id']]) { ?>
                              <option value="<?php echo $custom_field_value['contest_field_value_id']; ?>" selected="selected"><?php echo $custom_field_value['name']; ?></option>
                            <?php } else { ?>
                              <option value="<?php echo $custom_field_value['contest_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
                            <?php } ?>

                            <?php } ?>


                          </select>
                         <?php if (isset($error_custom_field[$cfvalue['contest_field_id']])) { ?>
                          <div class="text-danger"><?php echo $error_custom_field[$cfvalue['contest_field_id']]; ?></div>
                          <?php } ?>
                      <?php } ?>
                       <!-- /.select -->

                      <?php if ($cfvalue['contest_field_type'] == 'checkbox') { ?>
                        <div>
                              <?php foreach ($cfvalue['contest_field_value'] as $custom_field_value) { ?>
                              <div class="checkbox">
                                <?php if (isset($register_custom_field[$cfvalue['contest_field_id']]) && in_array($custom_field_value['contest_field_value_id'], $register_custom_field[$cfvalue['contest_field_id']])) { ?>
                                <label>
                                  <input type="checkbox" name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][value][]" value="<?php echo $custom_field_value['contest_field_value_id']; ?>" checked="checked" />
                                  <?php echo $custom_field_value['name']; ?></label>
                                <?php } else { ?>
                                <label>
                                  <input type="checkbox" name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][value][]" value="<?php echo $custom_field_value['contest_field_value_id']; ?>" />
                                  <?php echo $custom_field_value['name']; ?></label>
                                <?php } ?>
                              </div>
                              <?php } ?>
                            </div>
                            <?php if (isset($error_custom_field[$cfvalue['contest_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['contest_field_id']]; ?></div>
                            <?php } ?>
                        <?php } ?>


                      <!-- text -->
                      <?php if ($cfvalue['contest_field_type'] == 'text') { ?>
                      
                          <input type="text" name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][value]" value="<?php echo $cfvalue['contest_field_value']; ?>"  id="input-<?php echo 'value_'.$cfvalue['contest_field_id']; ?>" class="form-control" />

                          <?php if (isset($error_custom_field[$cfvalue['contest_field_id']])) { ?>
                          <div class="text-danger"><?php echo $error_custom_field[$cfvalue['contest_field_id']]; ?></div>
                          <?php } ?>
                      
                      <?php } ?>
                      <!-- /.text -->
                      <!-- /textarea -->
                      <?php if ($cfvalue['contest_field_type'] == 'textarea') { ?>

                        
                          
                        <textarea name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][value]" rows="5"  id="input-<?php echo 'value_'.$cfvalue['contest_field_id']; ?>" class="form-control summer-text"><?php echo $cfvalue['contest_field_value']; ?></textarea>
                          <?php if (isset($error_custom_field[$cfvalue['contest_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$cfvalue['custom_field_id']]; ?></div>
                          <?php } ?>
                        

                      <?php } ?><!-- /.textarea -->


                      







                    </div><!--/.form-group-->
                  </div><!--/.col-sm-12-->
                </div><!--/.row-->
                

                <?php $custom_field_row++; ?>
                <?php } ?>
                
              <?php } ?>
            <?php } ?>
            <hr class="divider-w mt-10 mb-20">
            <div class="row">
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                  <input type="submit" value="<?php echo $text_submit;?>" class="btn btn-round btn-block btn-success" />
                </div>
              </div>  
            </div> 
            </form>
          </div>
        </div>
        <!-- Post end -->
      </div>
      <!-- Content column end -->
       <!-- Sidebar column start -->
      <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
        <!-- Widget start -->
        <div class="widget ">
          <h5 class="widget-title font-alt">Новости проекта</h5>
          <ul class="widget-posts">
      
            <li class="clearfix">
              <div class="widget-posts-image">
                <a href="#"><img src="image/noimage.png" alt=""></a>
              </div>
              <div class="widget-posts-body">
                <div class="widget-posts-title">
                  <a href="#">Designer Desk Essentials</a>
                </div>
                <div class="widget-posts-meta">
                  23 November
                </div>
              </div>
            </li>
      
            <li class="clearfix">
              <div class="widget-posts-image">
                <a href="#"><img src="image/noimage.png" alt=""></a>
              </div>
              <div class="widget-posts-body">
                <div class="widget-posts-title">
                  <a href="#">Realistic Business Card Mockup</a>
                </div>
                <div class="widget-posts-meta">
                  15 November
                </div>
              </div>
            </li>
          </ul>
        </div>
        <!-- Widget end -->

   


        <?php echo $column_left; ?>
      </div>
      <!-- Sidebar column end -->
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div><!-- /.module -->

<?php echo $column_right; ?>

<?php echo $footer; ?>