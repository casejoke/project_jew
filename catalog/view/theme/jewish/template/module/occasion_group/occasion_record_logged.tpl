<!-- COMMENT FORM -->
<div class="comment-form m-b-30">
  <h4 class="comment-form-title font-alt"><?php echo $heading_title; ?></h4>
  <div class="row">
    <div class="contact-form-succes-block hidden" id="registration-succes-block">
      <div class="alert alert-success" role="alert"><?php echo $text_registration_logged_success; ?></div>
    </div>
    <form id="form-player-registration">
      <input type="hidden" class="form-control" id="occasion_id" name="occasion_id" value="<?php echo $occasion_id;?>">
      <div class="col-sm-12">
        <button class="btn btn-round btn-block btn-info" id="send-form-player-registration"><?php echo $text_btn_play; ?></button>
      </div>
    </form>
  </div>
</div>
  <!-- /COMMENT FORM -->
<script type="text/javascript">
var record = {
    init:function(){
      $(document).on('click touchstart','#send-form-player-registration',function(e){
        e.preventDefault();
        var data = $('#form-player-registration').serializeArray();  
        var url = '/iwantplay'
            $.ajax({
              url: url,
              type: 'POST',
              data: data,
              dataType: 'json',
              beforeSend: function() {
                
              },  
              complete: function() {
                  
              },
              success: function(obj) {
                console.log(obj);
                //очишаем все help-block
                $('#form-player-registration').find('.form-group').removeClass('has-error').find('.help-block').empty();
                if(obj['success']){
                  $('#form-player-registration').addClass('hidden');
                  $('#registration-succes-block').removeClass('hidden');
                }else{
                  //обкат ошибок
                  $.each(obj['error'],function(key,val){
                    console.log(obj['error'][key]);
                    if(obj['error'][key]){
                      $('#form-player-registration').find('#'+key).parents('.form-group').addClass('has-error');
                      $('#form-player-registration').find('#'+key).next().removeClass('hidden').html(val);
                    }
                  });
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText  + "\r\n" +xhr);
              } 
            });
      })
    }
  }
  $(document).ready(function() {
    record.init();
  });
</script>