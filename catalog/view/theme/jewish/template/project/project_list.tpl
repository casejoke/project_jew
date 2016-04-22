<?php echo $header; ?>
<!-- Header section start -->
<div class="module  module--initnavbar"  data-navbar="navbar-dark">
  <div class="container">
    <div class="row module-heading module-heading--text-dark">
    <div class="col-sm-6 col-sm-offset-3">
      <h1 class="module-heading__module-title font-alt text-center"><?php echo $heading_title; ?></h1>
    </div>
  </div><!-- .row -->
  </div>
</div>
<!-- Header section end -->
<div class="module module--small"><!-- module -->
  <div class="container">
  <?php echo $content_top; ?>
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        <?php if (!empty($success)) { ?>
          <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?></div>
        <?php } ?>
      </div><!-- /.col-sm-10 -->
      <div class="col-sm-8">
        
        <div id="projects" class="row projects-list">
          
          <div class="col-sm-8 col-sm-offset-2 mb-20">
            <div class="widget">
              <form role="form">
                <div class="search-box">
                  <input type="text" class="form-control search" placeholder="Поиск по названию...">
                  <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                </div>
              </form>
            </div>
          </div>

          <ul class="col-xs-12 list">
            <?php if(!empty($projects)){ ?>
               <?php foreach ($projects as $p) { ?>
              <li class="font-alt col-xs-12">
                <a class="project" href="<?php echo $p['action']['view']; ?>">
                <img src="<?php echo  $p['project_image']; ?>" alt="<?php echo $p['project_title']; ?>" class="mb-20">
                <h4 class="name"><?php echo $p['project_title']; ?></h4>
                <div class="post-meta">
                  Автор проекта: <?php echo $p['project_customer']['customer_name']; ?>| <?php echo $p['project_birthday']; ?> 
                </div>
                </a>
              </li>
            <?php }?>
          <?php } ?>
          </ul>

        </div>
      </div><!-- /.col-sm-8 -->


      <!-- Content column end -->

      <!-- Sidebar column start -->
      <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
        <a href="<?php echo $add_project; ?>" class="btn btn-round btn-block btn-info mb-40 mt-20">Создать проект</a>
        <?php echo $column_right; ?>
        <?php echo $column_left; ?>
      </div>
      <!-- Sidebar column end -->
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div><!-- /.module -->



<?php echo $footer; ?>
