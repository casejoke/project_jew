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
      <div id="users">
        <div class="col-sm-8 col-sm-offset-2 mb-20">
          <div class="widget">
            <form role="form">
              <div class="search-box">
                <input type="text" class="form-control search" placeholder="Поиск пользователя...">
                <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>

      <div class="col-sm-12 mb-20 customers-list">
        <ul class="list ">
        <?php foreach ($customers as $customer) { ?>
          <?php if($customer['customer_name']!=' ') { ?>
            <li class="font-alt col-xs-12 col-sm-4">
              <div class="alt-features-item">
								<div class="alt-features-icon alt-features-icon--image">
									<span class="">
                    <a href="<?php echo $customer['action']['info']; ?>"><img src="<?php echo $customer['customer_image']; ?>" alt=""></a>
                  </span>
								</div>
								<h3 class="alt-features-title font-alt name"><?php echo $customer['customer_name']; ?></h3>
                <a href="<?php echo $customer['action']['info']; ?>" class="btn btn-info btn-block  btn-round mt-20" autocomplete="off">Просмотр</a>
							</div>
            </li>
          <?php }?>
        <?php } ?>
        </ul>
      </div>

      </div>



    </div><!-- /.col-sm-10 -->
    <!-- Sidebar column start -->
    <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">

      <?php echo $column_right; ?>
    </div><!-- Sidebar column end -->
    </div><!-- /.row -->
  </div><!-- /.container -->
</div><!-- /.module -->
<?php echo $footer; ?>
