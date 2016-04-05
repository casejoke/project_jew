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

                  <h4 class="font-alt mb-20"><?php echo $cr['name']; ?></h4>

                  <?php $custom_field_row = 0; ?>
                  <?php foreach ($contest_fields[$cr['category_request_id']] as $cfvalue) { ?>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">

                        <input type="hidden" name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][field_id]" value="<?php echo $cfvalue['contest_field_id']; ?>"  id="input-<?php echo 'field_id_'.$cfvalue['contest_field_id']; ?>" class="form-control" />


                        <label class="control-label font-alt" for="input-<?php echo 'value_'.$cfvalue['contest_field_id']; ?>"><?php echo $cfvalue['contest_field_title']; ?></label>
                        <?php if(!empty($cfvalue['contest_field_description'])) {?> <p class="small"><?php echo $cfvalue['contest_field_description']; ?></p> <?php } ?>
                        <!-- select -->


                        <?php if ($cfvalue['contest_field_type'] == 'select') { ?>

                            <select name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][value]" id="input-<?php echo 'value_'.$cfvalue['contest_field_id']; ?>" class="form-control">

                              <option value=""><?php echo $text_select; ?></option>
                              <?php foreach ($cfvalue['contest_field_value'] as $custom_field_value) { ?>

                              <?php if ($cfvalue['contest_field_id'] == $cfvalue['value_r']) { ?>
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

                         <!-- /checkbox -->
                        <?php if ($cfvalue['contest_field_type'] == 'checkbox') { ?>
                          <div>
                                <?php foreach ($cfvalue['contest_field_value'] as $custom_field_value) { ?>

                                <div class="checkbox">
                                  <?php if (!empty($cfvalue['value_r']) && in_array($custom_field_value['contest_field_value_id'], $cfvalue['value_r'])) { ?>
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
                          <!-- /.checkbox -->

                        <!-- text -->
                        <?php if ($cfvalue['contest_field_type'] == 'text') { ?>

                            <input type="text" name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][value]" value="<?php echo $cfvalue['value_r']; ?>"  id="input-<?php echo 'value_'.$cfvalue['contest_field_id']; ?>" class="form-control" />

                            <?php if (isset($error_custom_field[$cfvalue['contest_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$cfvalue['contest_field_id']]; ?></div>
                            <?php } ?>

                        <?php } ?>
                        <!-- /.text -->

                        <!-- /textarea -->
                        <?php if ($cfvalue['contest_field_type'] == 'textarea') { ?>



                          <textarea data-editor="summernote" name="custom_fields[<?php echo $cr['category_request_id']?>][<?php echo $custom_field_row; ?>][value]" rows="5"  id="input-<?php echo 'value_'.$cfvalue['contest_field_id']; ?>" class="form-control summer-text"><?php echo $cfvalue['value_r']; ?></textarea>
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
              <?php if(isset($draft) && $draft) {?>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label font-alt">Видимость заявки</label>
                     <p class="small">При установке статуса "черновик", заявка будет видна только вам, или по ссылке. Вы сможете в любой момент отредактировать ее и подать заявку.</p>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="draft" id="draft"   value="1" <?php if($draft_check == 3) echo 'checked'; ?> /> черновик
                        </label>
                      </div>
                    </div>
                </div>
              </div>
            <?php } ?>
             <div class="row hidden">
              <div class="col-sm-12">
                <h5 class="text-center">Подав данную заявку, я подтверждаю, что:</h5>

              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                  <input type="submit" value="<?php echo $text_submit;?>"  id="send_btn"  class="btn btn-round btn-block btn-success" />
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
        <?php echo $column_left; ?>
        <?php echo $column_right; ?>

      </div>
      <!-- Sidebar column end -->
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div><!-- /.module -->



<?php echo $footer; ?>
