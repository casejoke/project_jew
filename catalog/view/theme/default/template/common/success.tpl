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
  <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2">
          <div class="post-entry m-b-30">
          <?php echo $text_message; ?>
          </div>
          <div class="col-xs-offset-3 col-xs-6 col-sm-4 col-sm-offset-4 ">
              <a href="<?php echo $continue; ?>" class="btn btn-block btn-info btn-round"><?php echo $button_continue; ?></a>
          </div>

        </div>
  </div>
</section>
<!-- /MODULE -->
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<?php echo $content_bottom; ?>

<?php echo $footer; ?>