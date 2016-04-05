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

});
