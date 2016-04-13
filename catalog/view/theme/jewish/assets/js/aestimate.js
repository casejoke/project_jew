var estimate ={
	init:function(){
		console.log('btn-list');
		estimate.initButton();


		$(document).on(mouse_down,'.btn-estimate',function(e){
			e.preventDefault();
			//console.log($(this).attr('data-mark'));

			if( $(this).hasClass('btn-success')) {

			}else{
				$(this).parents('.btn-list').find('.btn-estimate').removeClass('btn-success');
				$(this).addClass('btn-success').blur();
				//console.log($(this).attr('data-mark'));
				$(this).parents('.btn-list').next().val($(this).attr('data-mark'));
				estimate.enableSend();
			}
		});
	},
	enableSend:function(){
		var enableSendButton = false;
		$('.btn-list').each(function(index) {
			//активируем кнопки
            var valInput = $(this).next().val();
            console.log(valInput);
            if(valInput){
            	enableSendButton = true;
            }else{
            	enableSendButton = false;
            }
        });

        if(enableSendButton){
 			$(".btn-send-estimate").removeAttr('disabled');
        }
	},
	initButton:function(){
		$('.btn-list').each(function(index) {
			//активируем кнопки
            $(this).find('.btn').removeClass('disabled');
        });

        $(".btn-send-estimate").attr('disabled','disabled');
	}

};
$(document).ready(function() {
	estimate.init();
});
