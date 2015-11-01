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
<!-- MDULE -->
<div class="module module--small"><!-- module -->
  <div class="container">
  <?php echo $content_top; ?>
    <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2">
        <div class="post-entry m-b-30">
          <?php echo $text_message; ?>
        </div>
        <div class="col-xs-offset-3 col-xs-6 col-sm-4 col-sm-offset-4 ">
            <a href="<?php echo $continue; ?>" class="btn btn-round btn-b"><?php echo $button_continue; ?></a>
        </div>
    </div>
  </div>
</div><!-- /MODULE -->
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<?php echo $content_bottom; ?>

<?php echo $footer; ?>