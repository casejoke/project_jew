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


   <div class="col-sm-10 col-sm-offset-1">
    <?php if (!empty($error_warning)) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
    <?php } ?>



    <?php if (!empty($customers)) { ?>
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
                <?php if( $customer['customer_status_invite'] == 2 ){ ?>
                <a href="#" class="btn btn-success btn-block  btn-round disabled">Оправлено приглашение</a>
                <?php } else { ?>
                  <a href="#" class="btn btn-success btn-block  btn-round invite" data-loading-text="Отправляем ..." id="invite_<?php echo $customer['customer_id_hash']; ?>" data-a="<?php echo $customer['customer_id_hash']; ?>" data-b="<?php echo $group_id_hash; ?>" data-complete-text="Отправлено" autocomplete="off">Отправить приглашение</a>
                <?php } ?>
							</div>

            </li>
          <?php }?>



        <?php } ?>
        </ul>
      </div>

    <?php  } else { ?>
      <div class="col-sm-8 col-sm-offset-2 text-center mb-20">
        <h3 class="font-alt text-center">Список пользователей пуст</h3>
      </div>
    <?php  } ?>



    </div><!-- /.col-sm-10 -->
   <?php echo $content_bottom; ?>
    </div>
  </div>
</div>
<?php echo $column_left; ?>
<?php echo $column_right; ?>

<?php echo $footer; ?>
