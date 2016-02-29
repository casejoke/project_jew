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
            <h1 class="post-title"><?php echo $contest_title; ?></h1>
          </div>
          <?php if($image){ ?>
            <div class="post-thumbnail">
              <img src="<?php echo $image; ?>" alt="<?php echo $contest_title; ?>">
            </div>
          <?php } ?>
         

          <div class="post-entry ">
          <?php if(!empty($contest_propose)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_propose; ?></h4>
            <?php echo $contest_propose; ?>
          <?php } ?>
          
          <?php if (!$is_expert) { ?>
            <div class="row">
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                  <a href="<?php echo $im_deal; ?>" class="btn btn-round btn-block btn-success mb-40 mt-20"><?php echo $text_im_deal; ?></a>
                </div>
              </div>  
            </div>
          <?php } ?>

          
          <?php if(!empty($contest_description)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_description; ?></h4>
            <?php echo $contest_description; ?>
          <?php } ?>
            <h4 class="font-alt mb-10"><?php echo $entry_contest_dates; ?></h4>
            <table class="table table-striped table-border checkout-table">
                <tbody>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_date_start; ?> :</th>
                    <td><?php echo $contest_date_start; ?></td>
                  </tr>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_datetime_end; ?> :</th>
                    <td><?php echo $contest_datetime_end; ?></td>
                  </tr>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_date_rate; ?> :</th>
                    <td><?php echo $contest_date_rate; ?></td>
                  </tr>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_date_result; ?> :</th>
                    <td><?php echo $contest_date_result; ?></td>
                  </tr>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_date_finalist; ?> :</th>
                    <td><?php echo $contest_date_finalist; ?></td>
                  </tr>

                </tbody>
              </table>
            

          
          <?php if(!empty($contest_location)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_location; ?></h4>
            <?php echo $contest_location; ?>
          <?php } ?>
          <?php if(!empty($contest_organizer)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_organizer; ?></h4>
            <?php echo $contest_organizer; ?>
          <?php } ?>
          <?php if(!empty($contest_members)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_members; ?></h4>
            <?php echo $contest_members; ?>
          <?php } ?>
          <?php if(!empty($contest_contacts)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_contacts; ?></h4>
            <?php echo $contest_contacts; ?>
          <?php } ?>
          <?php if(!empty($contest_timeline_text)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_timeline_text; ?></h4>
            <?php echo $contest_timeline_text; ?>
          <?php } ?>

          <?php if(!empty($contest_downloads)) { ?>
            <h4 class="font-alt mb-10"><?php echo $entry_contest_downloads; ?></h4>
            <table class="table table-striped table-border checkout-table">
              <tbody>
                <?php foreach ($contest_downloads as $vcd) { ?>
                  <tr>
                    <th class="hidden"></th>
                    <th><h5 class="product-title font-alt"><?php echo $vcd['name']; ?></h5></th>
                    <td><a class="btn btn-round btn-g pull-right" target="_blank" title="" href="<?php echo $vcd['href']; ?>">Скачать <?php echo $vcd['size']; ?></a></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
          
          <?php if (!$is_expert) { ?>
            <div class="row">
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                  <a href="<?php echo $im_deal; ?>" class="btn btn-round btn-block btn-success mb-40 mt-20"><?php echo $text_im_deal; ?></a>
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