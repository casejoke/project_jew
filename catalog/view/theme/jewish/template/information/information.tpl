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
            <h1 class="post-title"><?php echo $heading_title; ?></h1>
          </div>
          <div class="post-thumbnail">
            <img src="<?php echo $hero_image; ?>" alt="<?php echo $heading_title; ?>">
          </div>
          <div class="post-entry">
           <?php echo $description; ?>
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
