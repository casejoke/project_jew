<?php echo $header; ?>
<?php echo $content_top; ?>
<section class="module-small bg-dark" data-background="<?php echo $main_image; ?>">
  <div class="container">
    <!-- MODULE TITLE -->
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        <h1 class="mh-line-size-3 font-alt m-b-20 text-center"><?php echo $heading_title; ?></h1>
       </div>
    </div>
    <!-- /MODULE TITLE -->
  </div>
</section>
<!-- MDULE -->
<section class="module">
  <div class="container">
    <div class="row ">
      <div class="col-sm-6 col-sm-offset-3">
        <h4 class="module-subtitle"><?php echo $text_email; ?></h4>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <?php if ($error_warning) { ?>
              <div class="col-sm-offset-2 col-sm-8">
                <div class="alert alert-danger"><?php echo $error_warning; ?></div>
              </div>
              <div class="clearfix"></div>
            <?php } ?>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-8">
              <input type="text" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
            </div>
          </div>
              <div class="form-group">
                <div class="col-xs-offset-2 col-xs-8 col-sm-offset-2 col-sm-8  ">
                    <input type="submit" value="Восстановить пароль" class="btn btn-block btn-info btn-round" />
                </div>
              </div>
          </form>
       
      </div>
    </div>
  </div>
</section>

<!-- /MODULE -->
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<?php echo $content_bottom; ?>

<?php echo $footer; ?>