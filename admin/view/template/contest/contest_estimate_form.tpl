<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2><?php echo $form_header; ?></h2>
        <ul class="actions">
          <li> <button type="submit" form="form-information"  class="btn btn-success"><?php echo $button_save; ?></button></li>
          <li>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>">
                  <i class="md md-replay"></i>
              </a>
          </li>
        </ul>
      </div>
      <div class="card-body card-padding table-responsive">
        <div role="tabpanel">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" >
            
            <ul class="tab-nav" role="tablist">
                <li class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                
           
            </ul>
          
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="tab-general">
                  <div class="card-body card-padding">
                    <table class="table">
                      <thead>
                          <tr>
                            
                            <th>Пользователь</th>
                            <th>Заявка</th>
                            <th>Полученные очки от экпертов</th>
                            <th>Место</th>
                            <th>Действия</th>
                            <th>Действия</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if(!empty($list_request)){ ?>
                          <?php foreach ($list_request as $vlr) { ?>
                            <tr>
                              <td><?php echo $vlr['customer_id']; ?></td>
                              <td><a href="<?php echo $vlr['action']['view_request']; ?>">Подробно</a></td>
                              <td><?php echo $vlr['score']; ?></td>
                              <td><?php echo $count_winner_place;?></td>
                              <td>
                               
                              </td>
                              <td>
                                <select class="place_winner">
                                  <option value="0">Укажите место</option>
                                  <option value="1">Укажите место</option>
                                </select>
                                <a href="#" data-toggle="tooltip" data-request_id="<?php echo $vlr['customer_to_contest_id']; ?>" title="" class="btn btn-primary disabled"><i class="fa fa-check "></i></a> 
                              </td>
                            </tr>  
                          <?php } ?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div><!-- /#tab-general -->

                <div role="tabpanel" class="tab-pane" id="tab-timeline">
                  <div class="card-body card-padding">
                    
                  </div>
                </div><!-- /#tab-timeline -->
        
                
            
            </div><!-- /.tab-content-->
          </form>
        </div><!-- /.tabpanel -->
      </div><!--/.card -->
    </div> <!--/.container -->
</section>
<script type="text/javascript">
  $('.place_winner').on('change', function() {
    console.log( this.value ); // or $(this).val()

  });
</script>

<?php echo $footer; ?>