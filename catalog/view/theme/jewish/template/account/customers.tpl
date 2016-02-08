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
    <div class="row">
    <?php echo $content_top; ?>
    <!-- Content column start -->
    <div class="col-sm-8">
      <div class="row multi-columns-row">
      <?php if (!empty($error_warning)) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
      <?php } ?>
        <?php if (!empty($customers)) { ?>
          <?php foreach ($customers as $customer) { ?>
            <div class="col-sm-6 col-md-4 col-lg-4">
              <div class="price-table font-alt">
                <a href="<?php echo $customer['action']['info']; ?>"><img src="<?php echo $customer['customer_image']; ?>" alt=""></a>
                <div class="borderline"></div>
                <h4><?php echo $customer['customer_name']; ?></h4>
                <a href="<?php echo $customer['action']['info']; ?>" class="btn btn-info btn-block  btn-round mt-20" autocomplete="off">Просмотр</a>
              </div>
            </div>
          <?php } ?>
        <?php  } else { ?>
          <div class="col-sm-8 col-sm-offset-2 text-center mb-20">
            <h3 class="font-alt text-center">Список пользователей пуст</h3>
          </div>
        <?php  } ?>
        <?php echo $content_bottom; ?>
      </div>
    </div><!-- /.col-sm-10 -->
    <!-- Sidebar column start -->
    <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
      <!-- Widget start -->
      <div class="widget ">
        <h5 class="widget-title font-alt">Анонсы</h5>
        <ul class="widget-posts">
    
          <li class="clearfix">
            <div class="widget-posts-image">
              <a href="#"><img src="image/noimage.png" alt=""></a>
            </div>
            <div class="widget-posts-body">
              <div class="widget-posts-title">
                <a href="#">Designer Desk Essentials</a>
              </div>
              <div class="widget-posts-meta">
                23 November
              </div>
            </div>
          </li>
    
          <li class="clearfix">
            <div class="widget-posts-image">
              <a href="#"><img src="image/noimage.png" alt=""></a>
            </div>
            <div class="widget-posts-body">
              <div class="widget-posts-title">
                <a href="#">Realistic Business Card Mockup</a>
              </div>
              <div class="widget-posts-meta">
                15 November
              </div>
            </div>
          </li>
        </ul>
      </div>
      <!-- Widget end -->
      <?php echo $column_right; ?>
    </div><!-- Sidebar column end -->
    </div><!-- /.row -->
  </div><!-- /.container -->
</div><!-- /.module -->
<?php echo $footer; ?>