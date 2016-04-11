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
      <div class="col-sm-8 col-md-6 mb-sm-20 ">
        <div class="work-details">
          <h5 class="work-details-title font-alt">Контакная информация</h5>
          <ul>
            <li><strong>Имя Отчество:</strong><span class="font-serif"> <?php echo $firstname?></span></li>
            <li><strong>Фамилия:</strong><span class="font-serif"> <?php echo $lastname?></span></li>
            <!-- до вывести кастомные поля -->
          </ul>
        </div>
        <div role="tabpanel">

          <ul class="nav nav-tabs font-alt" role="tablist">
            <li class="active"><a href="#projects"       data-toggle="tab" aria-expanded="true">Проекты пользователя</a></li>
            <li><a href="#customer_group" data-toggle="tab" aria-expanded="true">Группы пользователя</a></li>
          </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="projects">
            <div class="row multi-columns-row">


              <?php if(!empty($projects_for_customer)) { ?>
                <?php foreach ($projects_for_customer as $pfc) { ?>

                  <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="price-table font-alt">

                       <img src="<?php echo  $pfc['project_image']; ?>" alt="<?php echo $pfc['project_title']; ?>">
                      <div class="borderline"></div>
                      <h4><?php echo $pfc['project_title']; ?></h4>
                      <a href="<?php echo $pfc['project_action']['edit']; ?>" class="btn btn-success btn-round mt-20 ">Редактировать</a>
                      <?php if(!$pfc['project_winner'] && $isset_promocode){?>
                          <a href="<?php echo $pfc['promocode_action']; ?>" class="btn btn-warning btn-round mt-20 ">Активировать промокод</a>
                      <?php }?>

                    </div>
                  </div>

                <?php } ?>
              <?php } else{ ?>
                <div class="col-sm-12 text-center">
                  <p class="font-alt">Проектов нет</p>
                </div>
              <?php }?>
            </div>
          </div><!-- /.projects -->
          <div class="tab-pane " id="customer_group">
            <div class="row multi-columns-row">

              <?php if(!empty($admin_init_groups)){ ?>
                  <?php foreach ($admin_init_groups as $aig) { ?>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                      <div class="price-table font-alt">
                        <img src="<?php echo  $init_groups[$aig['group_id']]['group_image']; ?>" alt="<?php echo $init_groups[$aig['group_id']]['group_title']; ?>">
                        <div class="borderline"></div>
                        <h4><?php echo $init_groups[$aig['group_id']]['group_title']; ?></h4>
                        <ul class="price-details">
                          <li>Участников: <?php echo $init_groups[$aig['group_id']]['group_customer_count']; ?></li>
                          <li>Проектов: 0</li>
                        </ul>
                      </div>
                    </div>
                  <?php } ?>
              <?php } ?>
              </div>
            </div>
          </div>
        </div><!--/.tabpanel -->
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
