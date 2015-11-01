<?php foreach ($customers as $customer) { ?>
        <div class="col-sm-6 col-md-3 col-lg-3">
          <div class="price-table font-alt">
            <a href="<?php echo $customer['action']['info']; ?>"><img src="<?php echo $customer['customer_image']; ?>" alt=""></a>
            <div class="borderline"></div>
            <h4><?php echo $customer['customer_name']; ?></h4>
            <?php if( $customer['customer_status_invite'] == 2 ){ ?>
              <a href="#" class="btn btn-success btn-block  btn-round mt-20 disabled" data-loading-text="Отправляем ..." id="uninvite_<?php echo $customer['customer_id_hash']; ?>" data-a="<?php echo $customer['customer_id_hash']; ?>" data-b="<?php echo $group_id_hash; ?>" data-complete-text="Отправлено" autocomplete="off">Оправлено приглашение</a>
            <?php } else { ?>
              <a href="#" class="btn btn-success btn-block  btn-round mt-20 invite" data-loading-text="Отправляем ..." id="invite_<?php echo $customer['customer_id_hash']; ?>" data-a="<?php echo $customer['customer_id_hash']; ?>" data-b="<?php echo $group_id_hash; ?>" data-complete-text="Отправлено" autocomplete="off">Отправить приглашение</a>
            <?php } ?>
            
          </div>
        </div>
      <?php } ?>