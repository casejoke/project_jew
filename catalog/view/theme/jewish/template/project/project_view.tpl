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
            <h1 class="post-title"><?php echo $project_title; ?></h1>
            <div class="post-meta">
              <?php echo $text_create; ?> <a href="<?php echo $link_admin; ?>"><?php echo $admin_info['lastname'].' '.$admin_info['firstname']?></a> | <?php echo $project_birthday; ?> 
            </div>
          </div>
          <div class="post-thumbnail">
            <img src="<?php echo $image; ?>" alt="<?php echo $project_title; ?>">
          </div>
          <div class="post-entry">
           <?php echo $project_description; ?>
          </div>
          
          <?php if(!empty($project_target)){ ?>
            <div class="post-entry">
            <h4 class="font-alt mb-20">Цель проекта</h4>
             <?php echo $project_target; ?>
            </div>
          <?php } ?>
          <?php if(!empty($project_product)){ ?>

            <div class="post-entry">
              <h4 class="font-alt mb-20">Продукт проекта</h4>
             <?php echo $project_product; ?>
            </div>
          <?php } ?>
          <?php if(!empty($project_result)){ ?>
            
            <div class="post-entry">
            <h4 class="font-alt mb-20">Результат проекта</h4>
             <?php echo $project_result; ?>
            </div>
          <?php } ?>

          

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