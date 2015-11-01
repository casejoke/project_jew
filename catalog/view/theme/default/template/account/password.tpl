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
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
          <div class="col-sm-8">
              <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
          <div class="col-sm-8">
              <input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $entry_confirm; ?>" id="input-confirm" class="form-control" />
              <?php if ($error_confirm) { ?>
              <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php } ?>
            </div>
          </div>
              <div class="form-group">
                <div class="col-xs-offset-2 col-xs-8 col-sm-offset-2 col-sm-8  ">
                    <input type="submit" value="Изменить пароль" class="btn btn-block btn-round btn-d" />
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