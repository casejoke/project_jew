<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2><?php echo $form_header; ?></h2>
        <ul class="actions">
         
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
                            
                            <th>Участник</th>
                            <th>Заявка</th>
                            <th>Полученные очки от экпертов</th>
                            <th>Место</th>
                            <th>Действия</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if(!empty($list_request)){ ?>
                          <?php foreach ($list_request as $vlr) { ?>
                            <tr>
                              <td><?php echo $vlr['customer_name']; ?></td>
                              <td><a href="<?php echo $vlr['action']['view_request']; ?>">Подробно</a></td>
                              <td><?php echo $vlr['score']; ?></td>
                              <td><?php echo $vlr['place'];?></td>
                              <td>
                                
                                <a href="#" data-toggle="tooltip" data-request_id="<?php echo $vlr['customer_to_contest_id']; ?>" data-contest_id="<?php echo $vlr['contest_id']; ?>" title="" class="btn btn-primary choose-winner">Выбрать</a>
                                <select class="place_winner hidden" >
                                  <option value="0">Укажите место</option>
                                </select>

                                <a class="btn btn-success accept-winner hidden" 
                                  data-customer_id="<?php echo $vlr['customer_id']; ?>" 
                                  data-project_id="<?php echo $vlr['project_id']; ?>" 
                                  data-contest_id="<?php echo $vlr['contest_id']; ?>" 
                                  data-adaptive_id="<?php echo $vlr['adaptive_id']; ?>" 
                                  data-request_id="<?php echo $vlr['customer_to_contest_id']; ?>"
                                  href="#" data-toggle="tooltip"  title="" ><i class="fa fa-check"></i></a>

                                <a class="btn btn-danger delete-winner hidden" href="#" data-toggle="tooltip" data-request_id="<?php echo $vlr['customer_to_contest_id']; ?>" title="" ><i class="fa fa-times"></i></a>

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
//accept-winner - подтверждение победителя
//choose-winner - выбрать победителя
//place_winner - 
//delete-winner - 

  $('.choose-winner').on('click', function(e) {
    e.preventDefault();
    var _this = $(this);
    var contest_id = _this.attr('data-contest_id');
    var data = {
      'contest_id'  : contest_id
    };
    $.ajax({
      url: 'index.php?route=contest/estimate/getCountPlaceForContest&token=<?php echo $token; ?>',
      dataType: 'json',
      type: 'POST',
      data : data,
      success: function(json) {
        if(json.length){
          console.log(json.length);
          var options = '';
          options += '<option value="0">-- Укажите место -- </option>';
          $.each(json, function(key, value) {
            options += '<option value="' + value.place_id + '">' + value.place_title + '</option>';
          });
          _this.addClass('hidden');
          _this.next().removeClass('hidden').html(options);
        }
        
          
      }
    });
  });

  $('.place_winner').on('change', function(e) {
    e.preventDefault();
    $(this).next().removeClass('hidden');
  });

  $('.accept-winner').on('click', function(e){
    e.preventDefault();
    var _this = $(this);
    var place_winner  = _this.prev().val();
    var customer_id = _this.attr('data-customer_id');
    var request_id = _this.attr('data-request_id');
    var contest_id = _this.attr('data-contest_id');
    var adaptive_id = _this.attr('data-adaptive_id');
    var project_id = _this.attr('data-project_id');
    var data = {
      'customer_id' : customer_id,
      'place_id'    : place_winner,
      'request_id'  : request_id,
      'contest_id'  : contest_id,
      'adaptive_id' : adaptive_id,
      'project_id'  : project_id
    };
    console.log(place_winner);
    //отправляем запрос на установку победителя
    $.ajax({
      url: 'index.php?route=contest/estimate/addWinner&token=<?php echo $token; ?>',
      data : data,
      type: 'POST',
      dataType: 'json',
      success: function(json) {

        if(json.success){
          console.log(json);
          _this.addClass('hidden').next().removeClass('hidden');
          _this.prev().addClass('hidden');
        }
      }
    });

  });

  $('.delete-winner').on('click',function(e){
    e.preventDefault();
    var _this = $(this);
    var data = {
      'customer_id' : '5',
      'contest_id'  : '2'
    };
    $.ajax({
      url: 'index.php?route=contest/estimate/removeWinner&token=<?php echo $token; ?>',
      data : data,
      dataType: 'json',
      success: function(json) {

        if(json.success){
          console.log(json);
          _this.addClass('hidden').prev().addClass('hidden').prev().addClass('hidden').prev().removeClass('hidden');
        }
      }
    });
  });
</script>

<?php echo $footer; ?>