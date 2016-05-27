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
                            <th>#</th>
                            <th>Участник</th>
                            <th>Полученные очки от экпертов</th>
                            <th>Полученные рекомендации<br> от экпертов</th>
                            <th></th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if(!empty($list_request)){ ?>
                          <?php foreach ($list_request as $vlr) { ?>
                            <tr>
                              <td><?php echo $vlr['customer_to_contest_id']; ?></td>
                              <td><?php echo $vlr['customer_name']; ?></td>
                              <td><?php echo $vlr['score']; ?></td>
                              <td><?php echo $vlr['recommendation_score']; ?></td>
                              <td>
                                  <table class="table">
                                    <thead>
                                        <tr>
                                          <th class="text-center">Эксперт</th>
                                          <th class="text-center">Оценка</th>
                                          <th class="text-center">Рекомендация</th>
                                          <th class="text-center">Комментарий</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($vlr['estimate_list'])) { ?>
                                    
                                        <?php foreach ($vlr['estimate_list'] as $vel) { ?>
                                          <tr>
                                            <td class="text-center"><?php echo $vel['customer_expert_name']; ?></td>
                                            <td class="text-center"><?php echo $vel['customer_score']; ?></td>
                                            <td class="text-center"><?php echo $vel['customer_recommendation']; ?></td>
                                            <td class="text-center"><?php echo $vel['customer_comment']; ?></td>
                                      </tr>
                                        <?php } ?>
                                    <?php } else {?>
                                      
                                      <tr>
                                        <td colspan="4" class="text-center">Нет оценок</td>
                                        
                                      </tr>
                                     <?php } ?>
                                      
                                    </tbody>   
                                  </table>

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
          $('#request_id_'+request_id).html(place_winner);
        }
      }
    });

  });

  $('.delete-winner').on('click',function(e){
    e.preventDefault();
    var _this = $(this);
    var request_id = _this.attr('data-request_id');
    var data = {
      'request_id'  : request_id,
    };
    $.ajax({
      url: 'index.php?route=contest/estimate/removeWinner&token=<?php echo $token; ?>',
      data : data,
      type: 'POST',
      dataType: 'json',
      success: function(json) {

        if(json.success){
          console.log(json);
          _this.addClass('hidden').prev().addClass('hidden').prev().addClass('hidden').prev().removeClass('hidden');
          $('#request_id_'+request_id).html('Не выбрано');
        }
      }
    });
  });
</script>

<?php echo $footer; ?>