var check = {
  init:function(){

    if($("#draft:checked" ).length) {
          $('#send_btn').val('Сохранить заявку');
      }else{
        $('#send_btn').val('Подать заявку');
      }


    $("#draft").change(function() {
      if(this.checked) {
          $('#send_btn').val('Сохранить заявку');
      }else{
        $('#send_btn').val('Подать заявку');
      }
  });
  },
  initUpload:function(){

   
    $(document).on('click','.button-custom-field', function() {   
      
      var node = this;

      $('#form-upload').remove();

      $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

      $('#form-upload input[name=\'file\']').trigger('click');

      if (typeof timer != 'undefined') {
          clearInterval(timer);
      }

      timer = setInterval(function() {
        if ($('#form-upload input[name=\'file\']').val() != '') {
          clearInterval(timer);

          $.ajax({
            url: 'index.php?route=tool/upload',
            type: 'post',
            dataType: 'json',
            data: new FormData($('#form-upload')[0]),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
              //$(node).button('loading');
            },
            complete: function() {
              //$(node).button('reset');
            },
            success: function(json) {
              $(node).parent().find('.text-danger').remove();

              if (json['error']) {
                $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
              }

              if (json['success']) {
                //alert(json['success']);

                $(node).next().next().attr('value', json['code']);
                $(node).addClass('hidden').addClass('disabled').next().removeClass('hidden').find('.file-name').html(json['file_name'])

              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
          });
        }
      }, 500);
    });

    
    $(document).on('click','.btn-delete-file-request', function() { 
      
      var node = this;
      $(node).parent().addClass('hidden').prev().removeClass('disabled').removeClass('hidden');
      $(node).parent().next().removeAttr('value');
    });

   
    $(document).on('click','.btn-add-file-request', function() { 
      console.log('asd');
      var node = this;
      var $module_upload = $(node).parents('.module-upload').clone(); 
      console.log($module_upload);

      $(node).parents('.module-upload').after($module_upload);
      $(node).parents('.module-upload').next().find('.btn-block').addClass('hidden').prev().removeClass('disabled').removeClass('hidden');
      $(node).remove();
    });


  }

};

$(document).ready(function() {

	check.init();
  $('textarea').each(function() {
    if ($(this).attr('data-editor') == 'summernote') {
      $(this).summernote({
          height: 300
      });
    }

  });
  check.initUpload();

});
