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
<div class="module module--small"><!-- module -->
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
        <div class="row multi-columns-row">
           <?php if(!empty($projects)){ ?> 
              <?php foreach ($projects as $p) { ?>
                
                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="price-table font-alt">
                    <a href="<?php echo $p['action']['view']; ?>"> <img src="<?php echo  $p['project_image']; ?>" alt="<?php echo $p['project_title']; ?>"></a>
                    <div class="borderline"></div>
                    <h4><a href="<?php echo $p['action']['view']; ?>" ><?php echo $p['project_title']; ?></a></h4>
                    <a href="<?php echo $p['action']['view']; ?>" class="btn btn-info btn-block btn-round mt-20">Подробнее</a>
                  </div>
                </div>

              <?php } ?>
          <?php } ?>
        </div>
      </div>
      <!-- Content column end -->

      <!-- Sidebar column start -->
      <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
        <?php echo $column_right; ?>
        <?php echo $column_left; ?>
      </div>
      <!-- Sidebar column end -->
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div><!-- /.module -->



<?php echo $footer; ?>