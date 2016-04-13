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
                  <div class="row">
                  <div class="col-sm-12">
                  <hr class="divider-w mt-10 mb-20">
                  <h4 class="font-alt mb-20">Оценка заявки</h4>
                  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" >
                    <div class="form-group">
                      <label class="control-label font-alt" for="comment">Укажите статус заявки</label>
                      <p class="btn-list">
                        <button type="button" class="btn btn-default btn-round btn-estimate disabled" data-mark="2">Одобрено</button>
                        <button type="button" class="btn btn-default btn-round btn-estimate disabled" data-mark="1">Не одобрено</button>
                      </p>
                       <input type="hidden" name="adaptive_status" value=""  id="input-aestimate_request" class="form-control" />

                    </div>


                      <div class="form-group">
                          <label class="control-label font-alt" for="comment">Комментарий</label>
                          <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
                      </div>



                    <div class="form-group">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="submit" value="<?php echo $text_submit;?>" class="btn btn-round btn-block btn-success btn-send-estimate" disabled/>
                      </div>
                    </div>

                  </form>
                    </div>
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
