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
            <h1 class="post-title">Оценка заявки на конкурс: <?php echo $contest_title; ?> </h1>
          </div>
          <div class="post-entry ">
            
            <div role="tabpanel">

              <!-- Nav tabs start-->
              <ul class="nav nav-tabs font-alt" role="tablist">
                <li><a href="#contest" data-toggle="tab">О конкурсе</a></li>
                <li class="active"><a href="#request" data-toggle="tab">Заявка</a></li>

                <li><a href="#estimate" data-toggle="tab">Оценить</a></li>
              </ul>
              <!-- Nav tabs end -->

              <!-- Tab panes start-->
              <div class="tab-content">

                <!-- Tab start -->
                <div class="tab-pane active" id="request">
                  
                </div>
                <!-- Tab end -->

                <!-- Tab start -->
                <div class="tab-pane" id="contest">
                  
                </div>
                <!-- Tab end -->

                <!-- Tab start -->
                <div class="tab-pane" id="estimate">

                  <?php if(!empty($contest_criteria)){ ?>
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" >
                    <?php foreach ($contest_criteria as $vcc) { ?>
                        <div class="row">
                         <div class="col-sm-5 col-md-3">
                            <p class="btn-list">
                              <button type="button" class="btn btn-default btn-round">1</button>
                              <button type="button" class="btn btn-default btn-round">2</button>
                              <button type="button" class="btn btn-default btn-round">3</button>
                            </p>
                             <input type="hidden" name="custom_fields[<?php echo $vcc['criteria_title']; ?>]" value=""  id="input-<?php echo $vcc['criteria_title']; ?>" class="form-control" />
                          </div>
                          <div class="col-sm-7 col-md-9">
                            <h5 class="font-alt mb-0 "><?php echo $vcc['criteria_title']; ?></h5>
                          </div>
                        </div>
                        
                        <div class="row hidden">
                          <label class="radio-inline">
                              <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> 1
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> 2
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3"> 3
                            </label>
                        </div>
                    <?php } ?>
                    <div class="row">
                      <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-3">
                          <input type="submit" value="<?php echo $text_submit;?>" class="btn btn-round btn-block btn-success" />
                        </div>
                      </div>  
                    </div> 
                    </form>
                  <?php  } ?>
                </div>
                <!-- Tab end -->

              </div>
              <!-- Tab panes end-->
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