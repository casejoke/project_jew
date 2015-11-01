<?php echo $header; ?>
<!-- Header section start -->
<div class="module  module--initnavbar"  data-navbar="navbar-dark">
  <div class="container">
    <div class="row module-heading module-heading--text-dark">
    <div class="col-sm-6 col-sm-offset-3">
      <h1 class="module-heading__module-title font-alt text-center"><?php echo $heading_title; ?></h1>
    </div>
  </div><!-- .row -->
  </div>
</div>
<!-- Header section end -->
<div class="module module--content">
  <div class="container"><!-- .container -->
    
    <div class="row">

      <div class="col-sm-5 col-sm-offset-1 mb-sm-40">

            <h4 class="font-alt"><?php echo $text_login; ?></h4>

            <!-- Divider -->
            <hr class="divider-w mb-10">
            <!-- Divider -->
            <form class="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
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
                
              </div>

              <div class="form-group">
                <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-round btn-b" />
              </div>
              <div class="form-group">
                <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
              </div>
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>

            </form>

          </div>


      <div class="col-sm-5">

            <h4 class="font-alt"><?php echo $text_social_login; ?></h4>

            <!-- Divider -->
            <hr class="divider-w mb-10">
            <!-- Divider -->

            <?php echo $column_right; ?>

          </div>


      <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2 hidden">
        
        <div class="col-sm-6 ">
          
        </div>
        <div class="col-sm-6">
        
          
          <div class="alt-content-box m-t-0 m-t-sm-30">
            <div class="alt-content-box-icon">
              <i class="ion-android-share-alt"></i>
            </div>
            <h5 class="alt-content-box-title font-alt">
              Войти с помощью соцсетей
            </h5>
          </div>
          
         

        </div>
      </div>
    </div><!-- /.row -->
  </div><!-- /.container -->
</div>
<?php echo $content_top; ?>


<?php echo $column_left; ?>

<?php echo $content_bottom; ?>
<?php echo $footer; ?>
