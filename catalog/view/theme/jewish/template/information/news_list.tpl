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
     
      <!-- Content column start -->
      <div class="col-sm-8">
        <div class="row multi-columns-row">
           <?php if(!empty($all_news)) { ?>
            <?php foreach ($all_news as $news) { ?>
              <!-- Post item start -->
              <div class="col-md-6 col-lg-6">

                <div class="post">

                  <div class="post-thumbnail">
                    <a href="<?php echo $news['view']; ?>">
                      <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">
                    </a>
                  </div>

                  <div class="post-header font-alt">
                    <h2 class="post-title"><a href="<?php echo $news['view']; ?>"><?php echo $news['title']; ?></a></h2>
                    <div class="post-meta">
                      <?php echo $news['date_added']; ?>
                    </div>
                  </div>

                  <div class="post-entry">
                    <p><?php echo $news['description']; ?></p>
                  </div>

                  <div class="post-more">
                    <a href="<?php echo $news['view']; ?>" class="more-link"><?php echo $text_view; ?></a>
                  </div>

                </div>

              </div>
              <!-- Post item end -->  

              <?php } ?>
          <?php } ?>
        </div>
        <!-- PAGINATION -->
          <div class="row">
            <div class="col-sm-12 text-center m-t-60">
              <?php echo $pagination; ?>
            </div>
          </div>
        <!-- /PAGINATION -->
      </div>
      <!-- Content column end -->

      <!-- Sidebar column start -->
      <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
        <!-- Widget start -->
        <div class="widget ">
          <h5 class="widget-title font-alt">Новые проекты</h5>
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