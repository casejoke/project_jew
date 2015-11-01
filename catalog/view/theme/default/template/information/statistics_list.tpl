
<?php echo $header; ?>

<!-- HERO -->
<section class="module bg-dark" data-background="<?php echo $main_image; ?>">
  <!-- HERO TEXT -->
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h1 class="mh-line-size-3 font-alt m-b-20"><?php echo $heading_title; ?></h1>
      </div>
    </div>
  </div>
  <!-- /HERO TEXT -->
</section>
<!-- /HERO -->
<?php echo $content_top; ?>
<!-- SINGLE POST -->
<section class="module">
  <div class="container">
    <div class="row">
      <!-- CONTENT -->
      <?php echo $column_left; ?>
      <?php if ($column_left && $column_right) { ?>
      <?php $class = 'col-sm-6'; ?>
      <?php } elseif ($column_left || $column_right) { ?>
      <?php $class = 'col-sm-9'; ?>
      <?php } else { ?>
      <?php $class = 'col-sm-12'; ?>
      <?php } ?>
      <div class="<?php echo $class; ?>">
       <h5 class="widget-title font-alt"><?php echo $heading_title; ?></h5>
            <!-- TABS -->
          <div role="tabpanel">
            <?php if ($list_statistics) { ?>
            <?php $first = true; ?>
            <?php $isset_tab = false; ?>
            <ul class="nav nav-tabs font-alt" role="tablist">

              <?php foreach ($occasion_groups as $occasion_group) { ?>
                <?php if (!empty($list_statistics_score[$occasion_group['occasion_group_id']])) { ?>
                  <?php foreach ($list_statistics as $key => $stat) { ?>
                    <?php if($key == $occasion_group['occasion_group_id']) { ?>
                      <?php $isset_tab = true; ?>
                      <?php break; ?>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
                <?php if ($isset_tab) { ?>
                  <li class="<?php if ( $first ) { echo 'active'; };?>"><a href="#occasion_group_<?php echo $occasion_group['occasion_group_id'];?>" data-toggle="tab"><?php echo $occasion_group['occasion_title'];?></a></li>
                  <?php $isset_tab = false; ?>  
                <?php } ?>
                <?php $first = false; ?>
              <?php } ?>
              
            </ul>
              <div class="tab-content">
                <?php $first = true; ?>
                <?php foreach ($occasion_groups as $occasion_group) { ?>
                   <?php if (!empty($list_statistics_score[$occasion_group['occasion_group_id']])) { ?>
                  <div class="tab-pane <?php if ( $first ) { echo 'active'; };?> " id="occasion_group_<?php echo $occasion_group['occasion_group_id'];?>">
                  
                          <table class="table table-striped " id="table_occasion_group_<?php echo $occasion_group['occasion_group_id'];?>">
                              <thead>
                                  <tr>
                                      <th data-sort="int">Место</th>
                                      <th data-sort="string">Игрок</th>
                                      <th data-sort="int">И/дни</th>
                                      <th data-sort="int">Голы</th>
                                      <th data-sort="int">Пасы</th>
                                      <th data-sort="int">Очки<span class="arrow">&darr;</span></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($list_statistics_score[$occasion_group['occasion_group_id']] as $key => $value) { ?>
                                  <tr>
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $list_statistics[$occasion_group['occasion_group_id']][$key]['customer_name']; ?></td>
                                      <td><?php echo $list_statistics[$occasion_group['occasion_group_id']][$key]['day']; ?></td>
                                      <td><?php echo $list_statistics[$occasion_group['occasion_group_id']][$key]['goal']; ?></td>
                                      <td><?php echo $list_statistics[$occasion_group['occasion_group_id']][$key]['pass']; ?></td>
                                      <td><?php echo $list_statistics[$occasion_group['occasion_group_id']][$key]['score']; ?></td>
                                  </tr>
                                <?php $i++;} ?>
                              </tbody>
                          </table>
                          <script type="text/javascript">
                              $(document).ready(function(){
                                  //Basic Example
                                  if($("#table_occasion_group_<?php echo $occasion_group['occasion_group_id'];?>").length > 0 ){
                                   /* $("#table_occasion_group_<?php echo $occasion_group['occasion_group_id'];?>").bootgrid({
                                      navigation:2,
                                      padding:0
                                     });*/

                                     var table_<?php echo $occasion_group['occasion_group_id'];?> = $("#table_occasion_group_<?php echo $occasion_group['occasion_group_id'];?>").stupidtable();
                                     table_<?php echo $occasion_group['occasion_group_id'];?>.on("beforetablesort", function (event, data) {
                                        
                                      });

                                      table_<?php echo $occasion_group['occasion_group_id'];?>.on("aftertablesort", function (event, data) {
                                        // Reset loading message.

                                        var th = $(this).find("th");
                                        th.find(".arrow").remove();
                                        var dir = $.fn.stupidtable.dir;

                                        var arrow = data.direction === dir.ASC ? "&uarr;" : "&darr;";
                                        th.eq(data.column).append('<span class="arrow">' + arrow +'</span>');
                                      });
                                  }
                                  
                              });
                          </script>
                      
                    </div>  
                  <?php } ?>
                <?php $first = false; ?>
                <?php } ?>

              </div>
            <?php } ?>
          
          <!-- /TABS -->
          </div>



        
      </div>
      <?php if ($column_right) { ?>
      <div class="col-sm-3 m-t-sm-60">
        <?php echo $column_right; ?>
      </div>
      <?php } ?>
      
    </div>
  </div>
</section>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>