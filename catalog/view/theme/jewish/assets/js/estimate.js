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
		var enableSendButton = 0;
		$('.btn-list').each(function(index) {
			//активируем кнопки
            var valInput = $(this).next().val();
            if(valInput){
            	enableSendButton++;
            }
        });
       

        if($('.btn-list').length === enableSendButton){
 			$(".btn-send-estimate").removeAttr('disabled');	
        }
	},

	initButton:function(){
		$('.btn-list').each(function(index) {
			//активируем кнопки
            $(this).find('.btn').removeClass('disabled');
        });

		//activate send button
        $(".btn-send-estimate").attr('disabled','disabled');

        if(estimate_mark){
        	$('.btn-list').each(function(index) {
        		
				//активируем кнопки
	            var mark = $(this).next().val();
	            console.log('index ->>'+mark);
	            $(this).find('.btn').each(function(index) {
	            	if($(this).attr('data-mark') === mark){
	            		$(this).addClass('btn-success').blur();
	            	}

	            });
	            estimate.enableSend();
	        });
        }




	}

};
$(document).ready(function() {
	estimate.init();
});