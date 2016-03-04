var _href_temp = '';

//проект который я выберу
var adaptive_id = 0;
//мой проект котрый я выставил на конкурс
var project_id = 0;

var contest = {
  init:function() {
    _href_temp = $('#send_request_to_contest').attr('href');

    if(selectProject != 0){
      project_id = selectProject;
    }

    $(document).on(mouse_down,'.select-project',function(e){
      e.preventDefault();
      console.log($(this).attr('data-project'));
      contest.chooseProject($(this).attr('data-project'));
    });

     $(document).on(mouse_down,'.select-adaptive',function(e){
      e.preventDefault();
      console.log($(this).attr('data-adaptive'));
      contest.chooseAdaptive($(this).attr('data-adaptive'));
    });


  },
  chooseAdaptive:function(_adaptive_id){
    
    var _project_btn  = '#select-adaptive-'+_adaptive_id;
    if( $(_project_btn).hasClass('btn-success')) {
        contest.disabledAllAdaptive();
       var _text_complete = $(_project_btn).attr('data-complete-text');
            $(_project_btn).html(_text_complete).removeClass('btn-success').addClass('btn-warning').removeClass('disabled');
       adaptive_id = _adaptive_id;
    }else{
      contest.undisabledAllAdaptive();
      var _text_init = $(_project_btn).attr('data-init-text');
          $(_project_btn).html(_text_init).addClass('btn-success').removeClass('btn-warning');
      
      adaptive_id =  0;
    }

    contest.initLinkSend();

    
  },

  chooseProject:function(_project_id){
    
    var _project_btn  = '#select-project-'+_project_id;
    if( $(_project_btn).hasClass('btn-success')) {
        contest.disabledAllProject();
       var _text_complete = $(_project_btn).attr('data-complete-text');
            $(_project_btn).html(_text_complete).removeClass('btn-success').addClass('btn-warning').removeClass('disabled');
       project_id = _project_id;  
       

    }else{
      contest.undisabledAllProject();
      var _text_init = $(_project_btn).attr('data-init-text');
          $(_project_btn).html(_text_init).addClass('btn-success').removeClass('btn-warning');
       
         project_id = 0;  
   
    }

    contest.initLinkSend();

    
  },
  disabledAllProject:function(){
    $('.select-project').addClass('disabled');
  },
  undisabledAllProject:function(){
    $('.select-project').removeClass('disabled');
  },
  disabledAllAdaptive:function(){
    $('.select-adaptive').addClass('disabled');
  },
  undisabledAllAdaptive:function(){
    $('.select-adaptive').removeClass('disabled');
  },
  initLinkSend:function(){


    console.log('project_id - '+project_id);
    console.log('adaptive_id - '+adaptive_id);



    if (project_id != 0 && adaptive_id != 0) {
      console.log('hello');
     /* $('html,body').animate({
          scrollTop: $('#send_request_to_contest').offset().top
        }, 1000);*/
     

      $('#send_request_to_contest').removeClass('disabled')
      console.log(_href_temp + '&project_id='+project_id);
      //cсделать рефактор и добавить шифрование
      $('#send_request_to_contest').attr('href',_href_temp+ '&project_id='+project_id+'&adaptive_id='+adaptive_id);
      }else{
        $('#send_request_to_contest').addClass('disabled');
        
      };


       var body_modal =  $('#send_to_modal').html();  
       $('#myModal').find('#body_modal').html(body_modal);

      $('#myModal').modal({
        keyboard: false
      });

  }
};

$(document).ready(function() {
  contest.init();
  $('textarea').each(function() {
    if ($(this).attr('data-editor') == 'summernote') {
      $(this).summernote({
          height: 300
      });
    }
    
  });
});
