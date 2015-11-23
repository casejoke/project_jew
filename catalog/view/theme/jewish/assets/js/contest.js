var _href_temp = '';
var contest = {
	init:function() {
		_href_temp = $('#send_request_to_contest').attr('href');
		$(document).on(mouse_down,'.select-project',function(e){
			e.preventDefault();
			console.log($(this).attr('data-project'));
			contest.chooseProject($(this).attr('data-project'));
		});
	},
	chooseProject:function(_project_id){
		var _project_btn  = '#select-project-'+_project_id;
		if( $(_project_btn).hasClass('btn-success')) {
		  	contest.disabledAllProject();
		 	 var _text_complete = $(_project_btn).attr('data-complete-text');
          	$(_project_btn).html(_text_complete).removeClass('btn-success').addClass('btn-warning').removeClass('disabled');
          	contest.initLinkSend(_project_id);

		}else{
			contest.undisabledAllProject();
			var _text_init = $(_project_btn).attr('data-init-text');
	        $(_project_btn).html(_text_init).addClass('btn-success').removeClass('btn-warning');
	        contest.initLinkSend(0);
		}
		
	},
	disabledAllProject:function(){
		$('.select-project').addClass('disabled');
	},
	undisabledAllProject:function(){
		$('.select-project').removeClass('disabled');
	},
	initLinkSend:function(ch_project_id){

		if (ch_project_id != 0) {
			$('#send_request_to_contest').removeClass('disabled')
			console.log(_href_temp + '&project_id='+ch_project_id);
			$('#send_request_to_contest').attr('href',_href_temp+ '&project_id='+ch_project_id);
		}else{
			$('#send_request_to_contest').addClass('disabled');
			
		};

	}
};

$(document).ready(function() {
	contest.init();
});
