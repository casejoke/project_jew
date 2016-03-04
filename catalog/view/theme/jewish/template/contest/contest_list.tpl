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
           <?php if(!empty($contests)){ ?> 
              <?php foreach ($contests as $contest) { ?>
                
                <div class="col-sm-6 col-md-4 col-lg-4">
                  <?php //echo $contest['contest_status'];?>
                  <span aria-hidden="true" class="icon-clock"></span>
                  <div class="price-table font-alt">
                    <a href="<?php echo $contest['action']['view']; ?>"> <img src="<?php echo  $contest['contest_image']; ?>" alt="<?php echo $contest['contest_title']; ?>"></a>
                    <div class="borderline"></div>
                    <h4><a href="<?php echo $contest['action']['view']; ?>" ><?php echo $contest['contest_title']; ?></a></h4>
                    <a href="<?php echo $contest['action']['view']; ?>" class="btn btn-info btn-block btn-round mt-20">Подробнее</a>
                  </div>
                </div>

              <?php } ?>
          <?php } else{ ?>
            <div class="col-sm-8 col-sm-offset-2 text-center mb-20">
              <h3 class="font-alt text-center">Список конкурсов пуст</h3>
            </div>

          <?php  }?>
        </div>
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