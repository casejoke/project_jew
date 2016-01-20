<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2>Редактирование файла<?php //echo $heading_title; ?></h2>
        <ul class="actions">
            <li> <button type="submit" form="form-place"  class="btn btn-success"><?php echo $button_save; ?></button></li>
            <li>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>">
                    <i class="md md-replay"></i>
                </a>
            </li>
        </ul>
      </div>
      <div class="card-body card-padding table-responsive">
        <?php if ($error_warning) { ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $error_warning; ?>
          </div>
        <?php } ?>
        <div role="tabpanel">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-download" class="form-horizontal">
            <ul class="tab-nav" role="tablist">
                <li class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                <li><a href="#tab-data" aria-controls="tab-data" role="tab" data-toggle="tab"><?php echo $tab_data; ?></a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab-general">
                
                <div class="row">
                  <div class="col-sm-12">
                     <?php foreach ($languages as $language) { ?>   
                      <div class="form-group required <?php if (isset($error_name[$language['language_id']])) { ?> has-error <?php } ?>">
                        <div class="fg-line">
                            <label class="control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                            <input type="text" name="download_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($download_description[$language['language_id']]) ? $download_description[$language['language_id']]['name'] : ''; ?>"  id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                        </div>
                        <?php if (isset($error_name[$language['language_id']])) { ?>
                          <small class="help-block"><?php echo $error_name[$language['language_id']]; ?></small>
                        <?php } ?>
                      </div>
                      <?php } ?>
                  </div>
                </div>
               




                


                </div>
                <div role="tabpanel" class="tab-pane" id="tab-data">

                   <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-filename"><span data-toggle="tooltip" title="<?php echo $help_filename; ?>"><?php echo $entry_filename; ?></span></label>
                      <div class="col-sm-10">
                        <div class="input-group">
                          <input type="text" name="filename" value="<?php echo $filename; ?>" placeholder="<?php echo $entry_filename; ?>" id="input-filename" class="form-control" />
                          <span class="input-group-btn">
                          <button type="button" id="button-upload" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                          </span> </div>
                        <?php if ($error_filename) { ?>
                        <div class="text-danger"><?php echo $error_filename; ?></div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-mask"><span data-toggle="tooltip" title="<?php echo $help_mask; ?>"><?php echo $entry_mask; ?></span></label>
                      <div class="col-sm-10">
                        <input type="text" name="mask" value="<?php echo $mask; ?>" placeholder="<?php echo $entry_mask; ?>" id="input-mask" class="form-control" />
                        <?php if ($error_mask) { ?>
                        <div class="text-danger"><?php echo $error_mask; ?></div>
                        <?php } ?>
                      </div>
                    </div>


                </div>
            </div>
          </form>
        </div>
        
      </div><!--/.card -->
    </div> <!--/.container -->
</section>
<?php echo $footer; ?>
<script type="text/javascript"><!--
$('#button-upload').on('click', function() {
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
				url: 'index.php?route=catalog/download/upload&token=<?php echo $token; ?>',
				type: 'post',		
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,		
				beforeSend: function() {
					$('#button-upload').button('loading');
				},
				complete: function() {
					$('#button-upload').button('reset');
				},	
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}
								
					if (json['success']) {
						alert(json['success']);
						
						$('input[name=\'filename\']').attr('value', json['filename']);
						$('input[name=\'mask\']').attr('value', json['mask']);
					}
				},			
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script></div> 
<?php echo $footer; ?>