<?php echo $header; ?>
<!-- Header section start -->
<div class="module  module--initnavbar"  data-navbar="navbar-dark">
  <div class="container">
    <div class="row module-heading module-heading--text-dark">
    <div class="col-sm-6 col-sm-offset-3">
      <h1 class="module-heading__module-title font-alt text-center"><?php echo $text_my_account; ?></h1>
    </div>
  </div><!-- .row -->
  </div>
</div>
<!-- Header section end -->
<!-- MDULE -->

<div class="module module--small"><!-- module -->
  <div class="container">
   <?php echo $content_top; ?>
    <div class="row">

      <?php if ($success) { ?>
        <div class="col-xs-12 col-sm-12 m-b-30">
          <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        </div>
      <?php } ?>
      
      <div class="col-xs-12 col-sm-12 m-b-30">
        <div role="tabpanel">

          <ul class="nav nav-tabs font-alt" role="tablist">

            <li  <?php if (empty($customer_invite_group)) { ?>class="active"<?php } ?>><a href="#contact_information" data-toggle="tab" aria-expanded="true">Мой профиль</a></li>
            <li><a href="#projects"       data-toggle="tab" aria-expanded="true">Мои проекты</a></li>
            <li><a href="#customer_group" data-toggle="tab" aria-expanded="true">Мои инициативные группы</a></li> 
            <?php if (!empty($customer_invite_group)) { ?><li class="active"><a href="#invite_me"  data-toggle="tab" aria-expanded="true" >Приглашения</a></li> <?php } ?>
            <li class="hidden"><a href="#blog"           data-toggle="tab" aria-expanded="true">Мой блог</a></li> 
            
             
            
          </ul>

          <div class="tab-content">
            <div class="tab-pane <?php if (empty($customer_invite_group)) { ?>active<?php } ?>" id="contact_information">
              <div class="row">
                <div class="col-sm-4 col-md-3 mb-sm-20 wow fadeInUp animated">
                  <div class="team-item">
                    <div class="team-image">
                      <img src="<?php echo $avatar; ?>" alt="" id="i-account_image">
                       <input type="hidden" name="image" value="<?php echo $image; ?>" />
                    </div>
                    <div class="team-descr font-alt">
                      <div class="team-name"><a href="#" class="btn btn-g btn-round " data-toggle="image" id="account_image">Сменить аватар</a></div>
                      <div class="team-role"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 col-md-6 mb-sm-20 wow fadeInUp animated">
                  <div class="work-details">
                    <h5 class="work-details-title font-alt">Контакная информация</h5>
                    <ul>
                      <li><strong>Имя Отчество:</strong><span class="font-serif"> <?php echo $firstname?></span></li>
                      <li><strong>Фамилия:</strong><span class="font-serif"> <?php echo $lastname?></span></li>
                      <li><strong>Email:</strong><span class="font-serif"> <?php echo $email?></span></li>
                      <li><strong>Телефон:</strong><span class="font-serif"> <?php echo $telephone?></span></li>
                      <!-- до вывести кастомные поля -->
                    </ul>
                  </div>
                  
                </div>
                <div class="col-sm-4 col-md-3 mb-sm-20 wow fadeInUp animated">
                  <div class="work-details text-center">
                    <h5 class="work-details-title font-alt">Редактирование профиля</h5>
                    <a class="btn btn-g btn-round  m-b-20" href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a>
                  </div>
                  <div class="work-details text-center">
                    <a class="btn btn-g btn-round  m-b-20 " href="<?php echo $password; ?>"><?php echo $text_password; ?></a>
                  </div>
                                    
                </div>
              </div>
            </div><!-- /.contact_information -->
            <div class="tab-pane " id="projects">
              <div class="row multi-columns-row">
                <div class="col-sm-6 col-md-3 col-lg-3">
                  <div class="price-table font-alt price-table--empty">
                     <a href="<?php echo $add_project; ?>" class="btn btn-success btn-round"><?php echo $text_add_project; ?></a>
                  </div>
                </div>

                <?php if(!empty($projects_for_customer)) { ?>
                  <?php foreach ($projects_for_customer as $pfc) { ?>

                    <div class="col-sm-6 col-md-3 col-lg-3">
                      <div class="price-table font-alt">
                         <img src="<?php echo  $pfc['project_image']; ?>" alt="<?php echo $pfc['project_title']; ?>">
                        <div class="borderline"></div>
                        <h4><?php echo $pfc['project_title']; ?></h4>
                        <a href="<?php echo $pfc['prject_action']['edit']; ?>" class="btn btn-success btn-round mt-20 ">Редактировать</a>
                      </div>
                    </div>

                  <?php } ?>
                <?php } ?>
              </div>
            </div><!-- /.projects -->

            <div class="tab-pane " id="customer_group">
              
              <div class="row multi-columns-row">
                <div class="col-sm-6 col-md-3 col-lg-3">
                  <div class="price-table font-alt price-table--empty">
                    <a href="<?php echo $add_group; ?>" class="btn btn-success btn-round"><?php echo $text_add_group; ?></a>
                  </div>
                </div>
                <?php if(!empty($admin_init_groups)){ ?> 
                    <?php foreach ($admin_init_groups as $aig) { ?>
                      <div class="col-sm-6 col-md-3 col-lg-3">
                        <div class="price-table font-alt">
                          <img src="<?php echo  $init_groups[$aig['group_id']]['group_image']; ?>" alt="<?php echo $init_groups[$aig['group_id']]['group_title']; ?>">
                          <div class="borderline"></div>
                          <h4><?php echo $init_groups[$aig['group_id']]['group_title']; ?></h4>
                          <ul class="price-details">
                            <li>Участников: <?php echo $init_groups[$aig['group_id']]['group_customer_count']; ?></li>
                            <li>Проектов: 0</li>
                          </ul>
                          <a href="<?php echo $init_groups[$aig['group_id']]['action']['edit']; ?>" class="btn btn-info btn-block btn-round mt-20">Редактирование</a>
                          <a href="<?php echo $init_groups[$aig['group_id']]['action']['invite']; ?>" class="btn btn-warning btn-block  btn-round mt-20">Пригласить участников</a>
                        </div>
                      </div>
                    <?php } ?>
                <?php } ?>
                
                 <?php if(!empty($customer_agree_groups)){ ?> 
                    <?php foreach ($customer_agree_groups as $cag) { ?>


                      <div class="col-sm-6 col-md-3 col-lg-3">
                        <div class="price-table font-alt">
                          <img src="<?php echo  $init_groups[$cag['group_id']]['group_image']; ?>" alt="<?php echo $init_groups[$cag['group_id']]['group_title']; ?>">
                          <div class="borderline"></div>
                          <h4><?php echo $init_groups[$cag['group_id']]['group_title']; ?></h4>
                          <ul class="price-details">
                            <li>Участников: <?php echo $init_groups[$cag['group_id']]['group_customer_count']; ?></li>
                            <li>Проектов: 0</li>
                          </ul>
                          <a href="<?php echo $init_groups[$cag['group_id']]['action']['view']; ?>" class="btn btn-info btn-block btn-round mt-20">Просмотр</a>
                        </div>
                      </div>


                    <?php } ?>
                <?php } ?>

                

                


              </div>
            </div><!-- /.customer_group -->
            <?php if (!empty($customer_invite_group)) { ?>
              <div class="tab-pane active" id="invite_me">
                <h3 class="font-alt text-center">Вас пригласили</h3>
                <?php foreach ($customer_invite_group as $cig) { ?>
                  <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="price-table font-alt">
                      <img src="<?php echo  $init_groups[$cig['group_id']]['group_image']; ?>" alt="<?php echo $init_groups[$cig['group_id']]['group_title']; ?>">
                      <div class="borderline"></div>
                      <h4><?php echo $init_groups[$cig['group_id']]['group_title']; ?></h4>
                      <a href="<?php echo $init_groups[$cig['group_id']]['action']['agree']; ?>" class="btn btn-success btn-block  btn-round mt-20 i_agree">Принять приглашение</a>
                    </div>
                  </div>
                <?php } ?>
              </div><!-- /.invite_me -->
            <?php } ?>

            <div class="tab-pane"id="blog">
              Мой блог
            </div><!-- /.blog -->

            
            

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>