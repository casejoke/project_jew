<?php echo $header; ?>
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
    <section class="module">
      <div class="container">
        <?php echo $content_top; ?>
        <div class="row">
          <div class="col-sm-6 col-sm-offset-3">
            <h2 class="module-title font-alt"><?php echo $text_returning_customer; ?></h2>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2">
            <div class="col-sm-6 ">
              <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <?php if ($success) { ?>
                <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
                <?php } ?>
                <?php if ($error_warning) { ?>
                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
                <?php } ?>

                <div class="form-group">
                  <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                  <input type="text" name="email" value="<?php echo $email; ?>"  id="input-email" class="form-control" />
                </div>
                <div class="form-group">
                  <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
                  <input type="password" name="password" value="<?php echo $password; ?>" id="input-password" class="form-control" />
                  <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
                </div>

                <div class="form-group">
                    <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-block btn-info btn-round" />
                </div>
                
                <?php if ($redirect) { ?>
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <?php } ?>
              </form>
            </div>
            <div class="col-sm-6">
              <!-- ALT CONTENT BOX -->
              <div class="alt-content-box m-t-0 m-t-sm-30">
                <div class="alt-content-box-icon">
                  <i class="ion-android-share-alt"></i>
                </div>
                <h5 class="alt-content-box-title font-alt">
                  Войти с помощью соцсетей
                </h5>
              </div>
              <?php echo $column_right; ?>
              <!-- /ALT CONTENT BOX -->

            </div>
          </div>
        </div>
      </div>
    </section>
<?php echo $column_left; ?>

<?php echo $content_bottom; ?>
<?php echo $footer; ?>
