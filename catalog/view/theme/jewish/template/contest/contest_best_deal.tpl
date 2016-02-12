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
              <h4 class="font-alt mb-0">1.Укажите свой проект для участия в конкурсе</h4>
            
            
            
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
                <?php } ?>
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
        <!-- Widget start -->
        <div class="widget ">
          <h5 class="widget-title font-alt">Новости проекта</h5>
          <ul class="widget-posts">
      
            <li class="clearfix">
              <div class="widget-posts-image">
                <a href="#"><img src="image/noimage.png" alt=""></a>
              </div>
              <div class="widget-posts-body">
                <div class="widget-posts-title">
                  <a href="#">Designer Desk Essentials</a>
                </div>
                <div class="widget-posts-meta">
                  23 November
                </div>
              </div>
            </li>
      
            <li class="clearfix">
              <div class="widget-posts-image">
                <a href="#"><img src="image/noimage.png" alt=""></a>
              </div>
              <div class="widget-posts-body">
                <div class="widget-posts-title">
                  <a href="#">Realistic Business Card Mockup</a>
                </div>
                <div class="widget-posts-meta">
                  15 November
                </div>
              </div>
            </li>
          </ul>
        </div>
        <!-- Widget end -->

   


        <?php echo $column_left; ?>
      </div>
      <!-- Sidebar column end -->
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div><!-- /.module -->

<?php echo $column_right; ?>

<?php echo $footer; ?>