var invite = {
	init:function(){
		$(document).on(mouse_down,'.invite',function(e){
			e.preventDefault();
			var _a = $(this).attr('data-a');
			var _b = $(this).attr('data-b');
			invite.inviteUser(_a,_b);
		});
		$(document).on(mouse_down,'.uninvite',function(e){
			e.preventDefault();
			var _a = $(this).attr('data-a');
			var _b = $(this).attr('data-b');
			invite.uninviteUser(_a,_b);
		});
		
	},
	inviteUser:function(_a,_b){
		var data = {};
		data  = {
			'a':_a,
			'b':_b
		};
		var _change_btn  = '#invite_'+_a;
		$.ajax({
	        url: 'invite-user',
	        type: 'post',
	        dataType: 'json',
	        data: data,
	        cache: false,
	   		beforeSend: function() {
	           //старт 
	           var _text_loading = $(_change_btn).attr('data-loading-text');
	           $(_change_btn).html(_text_loading).addClass('disabled');
	        },
	        complete: function() {
	          //стоп 
	           //$(_change_btn).addClass('disabled').button('complete');
	           
	        },
	        success: function(json) {

				if (json['error']) {
					console.log(json['error']);
					var _text_error = $(_change_btn).attr('data-error-text');
	           		$(_change_btn).html(_text_error).removeClass('disabled');
				}

				if (json['success']) {
					console.log(json);
					var _text_complete = $(_change_btn).attr('data-complete-text');
	           		$(_change_btn).html(_text_complete).addClass('disabled');
				}




	        },
	        error: function(xhr, ajaxOptions, thrownError) {
	          console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
	      });
	},
	uninviteUser:function(_a,_b){
		var data = {};
		data  = {
			'a':_a,
			'b':_b
		};
		var _change_btn  = '#uninvite_'+_a;
		$.ajax({
	        url: 'uninvite-user',
	        type: 'post',
	        dataType: 'json',
	        data: data,
	        cache: false,
	   		beforeSend: function() {
	           //старт 
	           var _text_loading = $(_change_btn).attr('data-loading-text');
	           $(_change_btn).html(_text_loading).addClass('disabled');
	        },
	        complete: function() {
	          //стоп 
	           //$(_change_btn).addClass('disabled').button('complete');
	           
	        },
	        success: function(json) {

				if (json['error']) {
					console.log(json['error']);
					var _text_error = $(_change_btn).attr('data-error-text');
	           		$(_change_btn).html(_text_error).removeClass('disabled');
				}

				if (json['success']) {
					console.log(json);
					var _text_complete = $(_change_btn).attr('data-complete-text');
	           		$(_change_btn).html(_text_complete).addClass('disabled');
				}




	        },
	        error: function(xhr, ajaxOptions, thrownError) {
	          console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
	      });
	}
};
$(document).ready(function() {
	invite.init();
});