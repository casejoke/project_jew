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
