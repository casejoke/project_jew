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
        <div id="projects">
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

        <div class="col-sm-12 mb-20 projects-list">
          <ul class="list ">

            <?php if(!empty($projects)){ ?>
               <?php foreach ($projects as $p) { ?>
              <li class="font-alt col-xs-12">
                <div class="hidden">
                  <div class="price-table font-alt">
                    <a href="<?php echo $p['action']['view']; ?>"> <img src="<?php echo  $p['project_image']; ?>" alt="<?php echo $p['project_title']; ?>"></a>
                    <div class="borderline"></div>
                    <h4><a href="<?php echo $p['action']['view']; ?>" class="name"><?php echo $p['project_title']; ?></a></h4>
                    <a href="<?php echo $p['action']['view']; ?>" class="btn btn-info btn-block btn-round mt-20">Подробнее</a>
                  </div>
                </div>
              </li>
            <?php }?>
          <?php } ?>
          </ul>
        </div>

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
