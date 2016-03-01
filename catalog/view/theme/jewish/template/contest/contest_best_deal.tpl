<?php echo $header; ?>
<div class="module module--initnavbar"  data-navbar="navbar-dark"><!-- module -->
  <div class="container">
  <?php echo $content_top; ?>
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        <?php if (!empty($success)) { ?>
          <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?></div>
        <?php } ?>
      </div><!-- /.col-sm-10 -->
     
      <!-- Content column start -->
      <div class="col-sm-8">
        <!-- Post start -->
        <div class="post">
          
          <div class="post-header font-alt">
            <h1 class="post-title">Оформление заявки на конкурс: <?php echo $contest_title; ?> </h1>
          </div>
          <div class="post-entry ">
            <?php if ($my_adaptive_projects_for_contest == 0) { ?>
              <h4 class="font-alt mb-0">ШАГ 1. Внесите свой проект-победитель указанных в&nbsp;правилах конкурсов в&nbsp;общий пул проектов. Только после этого вы&nbsp;сможете продолжить.</h4>
              <p>Если у&nbsp;вас есть проект-победитель, то&nbsp;вам должен был быть прислан соответствующий код с&nbsp;инструкцией. Если вы&nbsp;ее&nbsp;не&nbsp;получили пожалуйста, обратитесь к&nbsp;администраторам сайта <a href="mailto:info@jewish-grassroots.org">info@jewish-grassroots.org</a> и&nbsp;укажите в&nbsp;письме информацию о&nbsp;проекте (название проекта, в&nbsp;какой грантовой программе участвовал, в&nbsp;каком году, кто руководитель проекта).</p>
            
            
            
             <div class="row">
            <?php if(!empty($my_project) && $my_adaptive_projects_for_contest == 0) { ?>
                  <?php foreach ($my_project as $pfc) { ?>

                    <div class="col-sm-6 col-md-4 col-lg-4">
                      <div class="price-table font-alt">
                         <img src="<?php echo  $pfc['project_image']; ?>" alt="<?php echo $pfc['project_title']; ?>">
                        <div class="borderline"></div>
                        <h4><?php echo $pfc['project_title']; ?></h4>
                        <a href="#select-project" class="btn btn-success btn-round mt-20 select-project" data-project="<?php echo  $pfc['project_id']; ?>" id="select-project-<?php echo  $pfc['project_id']; ?>" data-complete-text="Отменить выбор" data-init-text="Выбрать">Выбрать</a>
                      </div>
                    </div>

                  <?php } ?>
                <?php } else { ?>
                <div class="col-sm-12">
                  <h5 class="font-alt">Вы не можете принять участие в Конкурсе, пока не внесете в общую базу для обмена опытом свой проект, реализованный в рамках программ, указанных в <a href="<?php echo $contest_href; ?>">положении о Конкурсе</a>.</h5>
                </div>
                  
                <?php }?>
                <div class="col-sm-6 col-sm-offset-3">
                  <a href="<?php echo $add_project; ?>" class="btn btn-round btn-block btn-info mb-40 mt-20">Создать проект</a>
                </div>
            </div>
            <script type="text/javascript">
              var selectProject = 0;
              </script>
            <?php } else{ ?>
              <script type="text/javascript">
              var selectProject = <?php echo $my_adaptive_projects_for_contest; ?>
              </script>
            <?php } ?>


            <h4 class="font-alt mb-0"><?php echo ($my_adaptive_projects_for_contest == 0)?'2. ':'';?>Укажите проект для адаптации </h4>
              <?php if(!empty($adaptive_projects)) { ?>
                <div class="row mt-30  mb-30">
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
             <div class="row">
            <?php if(!empty($adaptive_projects)) { ?>
                    

                  <?php foreach ($adaptive_projects as $apc) { ?>
                    
                    <div class="col-sm-6 col-md-4 col-lg-4">
                      <div class="price-table font-alt">
                         <a href="<?php echo $apc['project_action']['view']; ?>" target="_blank"><img src="<?php echo  $apc['project_image']; ?>" alt="<?php echo $apc['project_title']; ?>"></a>
                        <div class="borderline"></div>
                        <h4><a href="<?php echo $apc['project_action']['view']; ?>" target="_blank"><?php echo $apc['project_title']; ?></a></h4>
                        <a href="#select-adaptive" class="btn btn-success btn-round mt-20 select-adaptive" data-adaptive="<?php echo  $apc['project_id']; ?>" id="select-adaptive-<?php echo  $apc['project_id']; ?>" data-complete-text="Отменить выбор" data-init-text="Выбрать">Выбрать</a>
                      </div>
                    </div>

                  <?php } ?>
                <?php } ?>
            </div>
            <div class="row">
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
      <!-- Content column end -->
       <!-- Sidebar column start -->
      <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
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