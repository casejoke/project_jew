<?php echo $header; ?>
<?php echo $content_top; ?>
<!-- CONTACT -->
    <section class="module">

      <div class="container">

        <div class="row">
          <div class="col-sm-6 col-sm-offset-3">
            <h2 class="module-title font-alt"><?php echo $text_my_account; ?></h2>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2">
            <div class="col-sm-6 col-sm-offset-1">
              <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <?php if ($success) { ?>
                <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
                <?php } ?>

                <ul class="list-unstyled">
                  <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
                  <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
                  <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
                  <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
                </ul>
                <h2><?php echo $text_my_orders; ?></h2>
                <ul class="list-unstyled">
                  <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
                  <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
                  <?php if ($reward) { ?>
                  <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
                  <?php } ?>
                  <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
                  <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
                  <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
                </ul>
                <h2><?php echo $text_my_newsletter; ?></h2>
                <ul class="list-unstyled">
                  <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
                </ul>
            </div>
            <div class="col-sm-4">
              <!-- ALT CONTENT BOX -->
              <div class="alt-content-box m-t-0 m-t-sm-30">
                <div class="alt-content-box-icon">
                  <i class="ion-android-share-alt"></i>
                </div>
                <h5 class="alt-content-box-title font-alt">
                  Авторизоваться с помощью соцсетей
                </h5>
                <?php echo $column_right; ?>
               
              </div>
              <!-- /ALT CONTENT BOX -->

            </div>
          </div>
        </div>
      </div>
    </section>
<?php echo $column_left; ?>

<?php echo $content_bottom; ?>
<?php echo $footer; ?>
