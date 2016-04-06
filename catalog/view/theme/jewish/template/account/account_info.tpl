<?php echo $header; ?>
<!-- Header section start -->
<div class="module  module--initnavbar"  data-navbar="navbar-dark">
  <div class="container">
    <div class="row module-heading module-heading--text-dark">
      <div class="col-sm-6 col-sm-offset-3">
        <h1 class="module-heading__module-title font-alt text-center">Информация о пользователе</h1>
      </div>
    </div>
    <div class="row mt-20">
      <div class="col-sm-4 col-md-3 mb-sm-20 ">
        <div class="team-item">
          <div class="team-image">
            <img src="<?php echo $avatar; ?>" alt="">
          </div>
        </div>
      </div>
      <div class="col-sm-4 col-md-6 mb-sm-20 ">
        <div class="work-details">
          <h5 class="work-details-title font-alt">Контакная информация</h5>
          <ul>
            <li><strong>Имя Отчество:</strong><span class="font-serif"> <?php echo $firstname?></span></li>
            <li><strong>Фамилия:</strong><span class="font-serif"> <?php echo $lastname?></span></li>
            <!-- до вывести кастомные поля -->
          </ul>
        </div>

      </div>

  </div><!-- .row -->
  </div>
</div>
<!-- Header section end -->
<!-- MDULE -->

<div class="module module--small"><!-- module -->
  <div class="container">
    <div class="row">

    </div>
    <?php echo $content_top; ?>
    <?php echo $column_left; ?>
    <?php echo $column_right; ?>
    <?php echo $content_bottom; ?>
  </div>
</div>

<?php echo $footer; ?>
