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
            <h1 class="post-title"><?php echo $group_title; ?></h1>
            <div class="post-meta">
              <?php echo $text_create; ?> <a href="<?php echo $link_admin; ?>"><?php echo $admin_info['lastname'].' '.$admin_info['firstname']?></a> | <?php echo $group_birthday; ?> | <?php echo $count_customers; ?> <?php echo $text_member; ?> 
            </div>
          </div>
          <div class="post-thumbnail">
            <img src="<?php echo $image; ?>" alt="<?php echo $group_title; ?>">
          </div>

            <div role="tabpanel">
                <!-- Nav tabs start-->
                <ul class="nav nav-tabs font-alt" role="tablist">
                  <li class="active"><a href="#group_description" data-toggle="tab">Описание</a></li>
                  <li><a href="#group_customers" data-toggle="tab">Участники</a></li>
                </ul>
                <!-- Nav tabs end -->

                <!-- Tab panes start-->
                <div class="tab-content">
                  <!-- Tab start -->
                  <div class="tab-pane active" id="group_description">
                      <?php echo $group_description; ?>
                  </div>
                  <!-- Tab end -->

                  <!-- Tab start -->
                  <div class="tab-pane" id="group_customers">
                    <div class="row">
                    <?php if (!empty($customers)) { ?>
                      <?php foreach ($customers as $customer) { ?>
                        <div class="col-sm-6 col-md-4 col-lg-4">
                          <div class="price-table font-alt">
                            <a href="<?php echo $customer['action']['info']; ?>"><img src="<?php echo $customer['customer_image']; ?>" alt=""></a>
                            <div class="borderline"></div>
                            <h4><a href="<?php echo $customer['action']['info']; ?>"><?php echo $customer['customer_name']; ?></a></h4>
                          </div>
                        </div>
                      <?php } ?>
                    <?php  } else { ?>
                      <h3 class="font-alt text-center">Список пользователей пуст</h3>
                    <?php  } ?>
                      <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="price-table font-alt">
                          <a href="#" class="btn btn-success btn-block  btn-round  join"  autocomplete="off">Присоединиться к группе</a>
                        </div>
                      </div>
                    </div> 
                  </div>
                  <!-- Tab end -->

                </div>
                <!-- Tab panes end-->
              </div>

          

        </div>
        <!-- Post end -->
      </div>
      <!-- Content column end -->
       <!-- Sidebar column start -->
      <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
        <!-- Widget start -->
        <div class="widget ">
          <h5 class="widget-title font-alt">Проекты группы</h5>
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

        <!-- Widget start -->
        <div class="widget ">
          <h5 class="widget-title font-alt">Новости группы</h5>
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