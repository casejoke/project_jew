var timer;
var upload =  {
	init:function(){
		if (typeof timer != 'undefined') {
	      	clearInterval(timer);
	  	}
	},
	uploadImage:function(_image_id){
		var $img = $('#i-'+_image_id);
		timer = setInterval(function() {
		    if ($('#form-upload input[name=\'file\']').val() != '') {
		      clearInterval(timer);

		      $.ajax({
		        //url: 'upload-avatar',
		        url:'?route=account/account/upload',
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
		           $img.attr( 'src',json['thumb'] );
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
		$(document).on(mouse_down,'#addpromocode',function(e){
			e.preventDefault();
			var _a = $(this).attr('data-a');
			var _b = $('#in-promocode').val();
			promocode.addpromocode(_a,_b);
		});
		
	},
	addpromocode:function(_a,_b){
		var data = {};
		data  = {
			'a':_a,
			'b':_b
		};
		$.ajax({
	        //url: 'activatepromocode',
	        url:'?route=account/promocode',
	        type: 'post',
	        dataType: 'json',
	        data: data,
	        cache: false,
	   		beforeSend: function() {
	          
	        },
	        complete: function() {
	           
	        },
	        success: function(json) {

				if (json['error']) {
					console.log(json['error']);
					alert(json['error']['promocode']);
				}

				if (json['success']) {
					console.log(json);
					window.location.href = json['redirect'];
				}
			},
	        error: function(xhr, ajaxOptions, thrownError) {
	          console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
	      });
	},
};

$(document).ready(function() {
	promocode.init();
	$(document).delegate('a[data-toggle=\'image\']', mouse_down, function(e) {
		e.preventDefault();
		 $('#form-upload').remove();

		  $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

		  $('#form-upload input[name=\'file\']').trigger('click');	
		  _image_id = $(this).attr('id');
		  upload.init();
		  upload.uploadImage(_image_id);		
	});
});
