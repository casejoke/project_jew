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


              <?php if(!empty($projects_for_customer)) { ?>
                <h4 class="font-alt mb-0">Вы можете выбрать свой проект для участия в конкурсе или создать новый:</h4>
                <div class="row">
                  <?php foreach ($projects_for_customer as $pfc) { ?>

                    <div class="col-sm-6 col-md-4 col-lg-4">
                      <div class="price-table font-alt">
                         <img src="<?php echo  $pfc['project_image']; ?>" alt="<?php echo $pfc['project_title']; ?>">
                        <div class="borderline"></div>
                        <h4><?php echo $pfc['project_title']; ?></h4>
                        <a href="#select-project" class="btn btn-success btn-round mt-20 select-project" data-project="<?php echo  $pfc['project_id']; ?>" id="select-project-<?php echo  $pfc['project_id']; ?>" data-complete-text="Отменить выбор" data-init-text="Выбрать">Выбрать</a>
                      </div>
                    </div>

                  <?php } ?>
                </div>
                <div class="row">
                  <div class="form-group">
                    <div class="col-sm-6">
                      <a href="<?php echo $action; ?>" class="btn btn-round btn-block btn-success mb-40 mt-20 disabled" id="send_request_to_contest" ><?php echo $text_im_deal;?></a>
                    </div>
                    <div class="col-sm-6">
                      <a href="<?php echo $action_n; ?>" class="btn btn-round btn-block btn-success mb-40 mt-20">Создать заявку и проект</a>
                    </div>
                  </div>
                </div>
              <?php } else{ ?>
                <div class="row">
                  <div class="form-group">
                    <div class="col-sm-12 text-center">
                      <p>Необходимо внести свой проект в&nbsp;общий пул проектов. Только после этого вы&nbsp;сможете продолжить.
                    </div>
                    <div class="col-sm-6 col-sm-offset-3">
                      <a href="<?php echo $action_n; ?>" class="btn btn-round btn-block btn-success mb-40 mt-20">Создать проект</a>
                    </div>
                  </div>
                </div>
              <?php } ?>




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

<?php echo $footer; ?>
