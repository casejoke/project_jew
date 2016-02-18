var timer;
var upload =  {
	init:function(){
		if (typeof timer != 'undefined') {
	      	clearInterval(timer);
	  	}
	},
	uploadImage:function(_image_id){
		var $img = $('#'+_image_id);
		timer = setInterval(function() {
		    if ($('#form-upload input[name=\'file\']').val() != '') {
		      clearInterval(timer);

		      $.ajax({
		        url: 'upload-file',
		        type: 'post',
		        dataType: 'json',
		        data: new FormData($('#form-upload')[0]),
		        cache: false,
		        contentType: false,
		        processData: false,
		        beforeSend: function() {
		           //старт загрузки
		        },
		        complete: function() {
		          //стоп загрузки
		        },
		        success: function(json) {
		          //$(node).parent().find('.text-danger').remove();

		          if (json['error']) {
		          	 console.log(json['error']);
		           // $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
		          }

		          if (json['success']) {
		            console.log(json);
		           $img.find('img').attr( 'src',json['thumb'] );
		           $img.next().attr('value', json['code']);
		          }
		        },
		        error: function(xhr, ajaxOptions, thrownError) {
		          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		        }
		      });
		    }
	  	}, 500);
	}
};


var promocode = {
	init:function(){
		$(document).on(mouse_down,'#send_promocode',function(e){
			e.preventDefault();
			var _b = $('#in-promocode').val();
			promocode.validatepromocode(_b);
			console.log($(this).attr('data-project'));
		});
	},
	validatepromocode:function(_b){
		var data = {};
		data  = {
			'b':_b
		};
		$.ajax({
	        url: 'validatepromocode',
	        type: 'post',
	        dataType: 'json',
	        data: data,
	        cache: false,
	   		beforeSend: function() {
	          
	        },
	        complete: function() {
	           
	        },
	        success: function(json) {
	        	$('#error-alert').addClass('hidden');
	        	$('#success-alert').addClass('hidden');
						if (json['error']) {
							console.log(json['error']);
							
							$('#error-alert').removeClass('hidden');
						}

						if (json['success']) {
							console.log(json);
							$('#success-alert').removeClass('hidden');
						}
					},
	        error: function(xhr, ajaxOptions, thrownError) {
	          console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
	      });


	}
};

$(document).ready(function() {
	$('#language a:first').tab('show');
	promocode.init();
	$('textarea').each(function() {
		if ($(this).attr('data-editor') == 'summernote') {
			$(this).summernote({
			    height: 300
			});
		}
		
	});
	$(document).delegate('a[data-toggle=\'image\']', 'click', function(e) {
		e.preventDefault();
		 $('#form-upload').remove();

		  $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

		  $('#form-upload input[name=\'file\']').trigger('click');	
		  _image_id = $(this).attr('id');
		  upload.init();
		  upload.uploadImage(_image_id);		
	});
});
