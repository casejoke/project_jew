<?php echo $header; ?>
<div class="module module--initnavbar"  data-navbar="navbar-dark"><!-- module -->
  <div class="container">
  <?php echo $content_top; ?>
    <div class="row">


      <!-- Content column start -->
      <div class="col-sm-8">
        <?php if (!empty($success)) { ?>
          <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?></div>
        <?php } ?>
        <!-- Post start -->
        <div class="post">

          <div class="post-header font-alt">
            <h1 class="post-title">Оформление заявки на конкурс: <?php echo $contest_title; ?> </h1>
          </div>
          <div class="post-entry ">

              <h4 class="font-alt mb-0">ШАГ 1. Внесите свой проект-победитель указанных в&nbsp;правилах конкурсов в&nbsp;общий пул проектов. Только после этого вы&nbsp;сможете продолжить.</h4>
              <p>Если у&nbsp;вас есть проект-победитель, то&nbsp;вам должен был быть прислан соответствующий код с&nbsp;инструкцией. Если вы&nbsp;ее&nbsp;не&nbsp;получили пожалуйста, обратитесь к&nbsp;администраторам сайта <a href="mailto:info@jewish-grassroots.org">info@jewish-grassroots.org</a> и&nbsp;укажите в&nbsp;письме информацию о&nbsp;проекте (название проекта, в&nbsp;какой грантовой программе участвовал, в&nbsp;каком году, кто руководитель проекта).</p>
            <script type="text/javascript">
              var selectProject = 0;
            </script>


             <div class="row">
              <?php $isset_adaptive = false; ?> 
              <?php if(!empty($my_project)) { ?>
                  <?php foreach ($my_project as $pfc) { ?>

                    <div class="col-sm-6 col-md-4 col-lg-4">
                      <div class="price-table font-alt">
                         <img src="<?php echo  $pfc['project_image']; ?>" alt="<?php echo $pfc['project_title']; ?>">
                        <div class="borderline"></div>
                        <h4><?php echo $pfc['project_title']; ?></h4>
                        <?php if($pfc['project_status']){ ?>
                          <p>Проект в базе конкурса</p>
                        <?php }else{ $isset_adaptive = true;?>
                          <a href="#select-project" class="btn btn-success btn-round mt-20 select-project" data-project="<?php echo  $pfc['project_id']; ?>" id="select-project-<?php echo  $pfc['project_id']; ?>" data-complete-text="Отменить выбор" data-init-text="Выбрать">Выбрать</a>
                        <?php } ?>



                      </div>
                    </div>
                    <?php if($pfc['project_status']){ ?>
                    <script type="text/javascript">
                     var selectProject = <?php echo $pfc['project_id']; ?>
                    </script>
                    <?php } ?>
                  <?php } ?>

              <?php } else { ?>
                <div class="col-sm-12">
                  <h5 class="font-alt">Вы не можете принять участие в Конкурсе, пока не внесете в общую базу для обмена опытом свой проект, реализованный в рамках программ, указанных в <a href="<?php echo $contest_href; ?>">положении о Конкурсе</a>.</h5>
                </div>

              <?php }?>

            </div>
            <?php if ($isset_adaptive) { ?>
              <script type="text/javascript">
              // var selectProject = 0;
              </script>
            <?php } else{ ?>
              <script type="text/javascript">
              var selectProject = <?php echo $my_adaptive; ?>
              </script>
            <?php } ?>
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <a href="<?php echo $add_project; ?>" class="btn btn-round btn-block btn-info mb-40 mt-20">Создать проект</a>
              </div>
            </div>
            <h4 class="font-alt mb-0">ШАГ 2. Просмотрите другие проекты-победители и&nbsp;выберите&nbsp;те, которые&nbsp;бы вы&nbsp;хотели&nbsp;бы адаптировать и&nbsp;повторить.</h4>
              <?php if(!empty($adaptive_projects)) { ?>
                <div class="row mt-30  mb-30 hidden">
                  <div class="col-sm-8 col-sm-offset-2">
                    <form role="form">
                      <div class="search-box">
                        <input type="text" class="form-control" placeholder="Укажите название проекта">
                        <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                      </div>
                    </form>
                  </div>
                </div>
              <?php } ?>


             <div class="row" >
            <?php if(!empty($adaptive_projects)) { ?>
              <div class="col-md-12">
                <div class="panel-group" id="accordion">

                    <!-- Accordion item start -->
                    <div class="panel panel-default mt-20">
                      <div class="panel-heading">
                        <h4 class="panel-title font-alt">
                          <a data-toggle="collapse" data-parent="#accordion" href="#support1" class="collapsed">
                            Фильтр проектов
                          </a>
                        </h4>
                      </div>
                      <div id="support1" class="panel-collapse collapse ">

                        <div class="panel-body">


                           <div class="widget " id="filters">

                            <h6 class="font-alt">Возраст группы проекта</h6>
                            <div class="tags font-alt">
                              <?php foreach ($age_statuses as  $vas) { ?>
                               <btn  class="tag btn btn-d btn-xs mb-10 filter" data-filter=".filter-age-<?php echo $vas['filtet_id'];?>"><?php echo $vas['filter_title'];?></btn>
                              <?php } ?>
                            </div>

                            <h6 class="font-alt hidden">Религия / национальность</h6>
                            <div class="tags font-alt hidden">
                              <?php foreach ($nationality_statuses as  $vns) { ?>
                               <btn class="tag btn btn-d btn-xs mb-10 filter" data-filter=".filter-nationality-<?php echo $vns['filtet_id'];?>"><?php echo $vns['filter_title'];?></btn>
                              <?php } ?>
                            </div>

                            <h6 class="font-alt">Профессиональный статус</h6>
                            <div class="tags font-alt">
                              <?php foreach ($professional_statuses as  $vps) { ?>
                               <btn class="tag btn btn-d btn-xs mb-10 filter" data-filter=".filter-professional-<?php echo $vps['filtet_id'];?>"><?php echo $vps['filter_title'];?></btn>
                              <?php } ?>
                            </div>

                            <h6 class="font-alt hidden">Демографический статус</h6>
                            <div class="tags font-alt hidden">
                              <?php foreach ($demographic_statuses as  $vds) { ?>
                               <btn class="tag btn btn-d btn-xs mb-10 filter" data-filter=".filter-demographic-<?php echo $vds['filtet_id'];?>"><?php echo $vds['filter_title'];?></btn>
                              <?php } ?>
                            </div>

                          </div>



                        </div>
                      </div>
                    </div>
                    <!-- Accordion item end -->


                  </div>






              </div>
              <div id="ad_projects">
              <?php foreach ($adaptive_projects as $apc) { ?>
                <div class="col-sm-6 col-md-4 col-lg-4 mix <?php echo $apc['project_age']. $apc['project_nationality']. $apc['project_professional']. $apc['project_demographic']; ?> " >
                  <div class="price-table font-alt">
                     <a href="<?php echo $apc['project_action']['view']; ?>" target="_blank"><img src="<?php echo  $apc['project_image']; ?>" alt="<?php echo $apc['project_title']; ?>"></a>
                    <div class="borderline"></div>
                    <h4><a href="<?php echo $apc['project_action']['view']; ?>" target="_blank"><?php echo $apc['project_title']; ?></a></h4>

                    <a href="<?php echo $apc['project_action']['view']; ?>" target="_blank" class="btn btn-info btn-round mt-20" >Просмотреть</a>


                    <a href="#select-adaptive" class="btn btn-success btn-round mt-20 select-adaptive" data-adaptive="<?php echo  $apc['project_id']; ?>" id="select-adaptive-<?php echo  $apc['project_id']; ?>" data-complete-text="Отменить выбор" data-init-text="Выбрать">Выбрать</a>

                  </div>
                </div>
              <?php } ?>
              </div>
            <?php } ?>
            </div>


            <div id="send_to_modal" class="hidden">
              <div class="row " >
                <div class="form-group">
                  <div class="col-sm-6 col-sm-offset-3">
                    <a href="<?php echo $action; ?>" class="btn btn-round btn-block btn-success mb-40 mt-20 disabled" id="send_request_to_contest" ><?php echo $text_im_deal;?></a>
                  </div>
                </div>
              </div>
            </div>


        </div>
        <!-- Post end -->
      </div>
      </div>
      <!-- Content column end -->
       <!-- Sidebar column start -->
      <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar" role="complementary">


        <?php echo $column_left; ?>
        <?php echo $column_right; ?>


      </div>
      <!-- Sidebar column end -->
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div><!-- /.module -->

<?php echo $column_right; ?>

<?php echo $footer; ?>
