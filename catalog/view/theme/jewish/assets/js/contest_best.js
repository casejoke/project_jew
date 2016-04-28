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

    $(document).on(mouse_down,'#send_project_to_pull',function(e){
      e.preventDefault();
      console.log('ajax отправка проекта в пулл');
      contest.addProjectToPull();
    });
    $(document).on(mouse_down,'#close_send_project_to_pull',function(e){
      e.preventDefault();
      console.log('---'+project_id);
      var _project_btn  = '#select-project-'+project_id;
      $(_project_btn).removeClass('disabled');
      if(selectProject != 0){
        project_id = selectProject;
      }else{
        project_id = 0;
      }
    });
     $(document).on(mouse_down,'#cancel_choose',function(e){
      e.preventDefault();
      console.log('---'+project_id);
      var _project_btn  = '#select-adaptive-'+ adaptive_id;
         contest.undisabledAllAdaptive();
          var _text_init = $(_project_btn).attr('data-init-text');
              $(_project_btn).html(_text_init).addClass('btn-success').removeClass('btn-warning');

          adaptive_id =  0;
    });


    //

  },
  chooseProject:function(_project_id){
    //выбор проекта для пулла
    project_id = _project_id;
    var _project_btn  = '#select-project-'+_project_id;
    //показываем окно с подтверждением
    $('#first_step_deal_bp').modal({
      backdrop: 'static'
    })
    //отключаем кнопку
    $(_project_btn).addClass('disabled');
    
/*
    if( $(_project_btn).hasClass('btn-success')) {
   //   contest.disabledAllProject();
      //показываем всплывашку для подтверждения

      var _text_complete = $(_project_btn).attr('data-complete-text');
            $(_project_btn).html(_text_complete).removeClass('btn-success').addClass('btn-warning').removeClass('disabled');
       project_id = _project_id;
      
       
       //отправляем ajax 





    }else{
     // contest.undisabledAllProject();
      var _text_init = $(_project_btn).attr('data-init-text');
          $(_project_btn).html(_text_init).addClass('btn-success').removeClass('btn-warning');

        // project_id = 0;

    }
    //- подтверждение подачи заявки на конкурс
    // contest.initLinkSend(); 
*/

  },
  chooseAdaptive:function(_adaptive_id){
    //выбор проекта для адаптации
     if (adaptive_id == 0 && project_id == 0) {
        $('#alert-send-best').modal({
          backdrop: 'static'
        });
      }


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
  addProjectToPull:function(){
    console.log(project_id);
    //добавляем запрос
    var data = {};
    data  = {
      'a':contest_id,
      'b':project_id
    };
    $.ajax({
         // url: 'invite-user',
          url: '/?route=contest/sendbest/addproject',
          type: 'post',
          dataType: 'json',
          data: data,
          cache: false,
          beforeSend: function() {},
          complete: function() {},
          success: function(json) {

                if (json['error']) {
                  console.log(json['error']);
                 }

                if (json['success']) {
                  console.log(json);
                  $('#first_step_deal_bp').modal('hide');
                  //замену текста
                  var _project_btn  = '#select-project-'+project_id;
                  $(_project_btn).after('<p>Проект в базе конкурса</p>').remove();
                  if (adaptive_id != 0) {
                     contest.initLinkSend(); 
                  }
                }

          },
          error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
    


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
      var body_modal =  $('#send_to_modal').html();
       $('#myModal').find('#body_modal').html(body_modal);

      $('#myModal').modal({
          backdrop: 'static'
        });

      console.log('ff');
      }else{
        $('#send_request_to_contest').addClass('disabled');
        
      };



  }
};



// On document ready, initialise our code.

$(document).ready(function() {
  contest.init();
  $('.tag').on(mouse_down,function(e){
    e.preventDefault();
  });


 // Initialize buttonFilter code

  //buttonFilter.init();

  // Instantiate MixItUp

  $('#ad_projects').mixItUp({
    load: {
      filter: 'all'
    },
    controls: {
      toggleFilterButtons: true,
      toggleLogic: 'and'
    },
    callbacks: {
      onMixEnd: function(state){
        console.log(state.activeFilter)
      }
    }
  });

  $('textarea').each(function() {
    if ($(this).attr('data-editor') == 'summernote') {
      $(this).summernote({
          height: 300
      });
    }

  });
});
