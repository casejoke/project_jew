<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2><?php echo $heading_title; ?></h2>
        <ul class="actions">
            <li> <button type="submit" form="form-information"  class="btn btn-success"><?php echo $button_save; ?></button></li>
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
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-custom-field" class="">
            
            <ul class="tab-nav language-tab" role="tablist" id="language" data-tab-color="amber">
                <?php foreach ($languages as $language) { ?>
                  <li>
                    <a href="#general-language<?php echo $language['language_id']; ?>" data-toggle="tab">
                      <?php echo $language['name']; ?>
                    </a>
                  </li>
                <?php } ?>
            </ul>
            <div class="tab-content">
              <div class="row">
                <div class="col-sm-12">
                <?php foreach ($languages as $language) { ?>
                  <div class="tab-pane" id="general-language<?php echo $language['language_id']; ?>">
                    <div class="card-body card-padding">
                        
                        <!-- название -->
                        <div class="form-group required <?php if (isset($error_name[$language['language_id']])) { ?> has-error <?php } ?>">
                          <div class="fg-line">
                              <label class="control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                              <input type="text" name="contest_field_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($contest_field_description[$language['language_id']]) ? $contest_field_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
                          </div>
                          <?php if (isset($error_name[$language['language_id']])) { ?>
                            <small class="help-block"><?php echo $error_name[$language['language_id']]; ?></small>
                          <?php } ?>
                        </div>
                    </div><!--/.card-body -->
                  </div><!-- /tab-pane -->
                <?php } ?>
                </div>
              </div>
                

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <div class="fg-line">
                      <label class="control-label" for="input-location"><?php echo $entry_field_system; ?></label>
                      <div class="select">
                      <select name="field_system" id="input-field_system" class="form-control">
                          <option value="custom" data-source="custom" ><?php echo $text_none; ?></option>
                          <optgroup label="<?php echo $text_customer; ?>">
                            <?php if (!empty($contest_field_system['customer'])) { ?>
                              <?php foreach ($contest_field_system['customer'] as $cfs) { ?>
                                <?php if ($cfs['field_value'] == $field_system) { ?>
                                  <option value="<?php echo $cfs['field_value']; ?>" data-source="<?php echo $cfs['field_source']; ?>" selected="selected"><?php echo $cfs['field_title']; ?></option>
                                <?php } else { ?>
                                  <option value="<?php echo $cfs['field_value']; ?>" data-source="<?php echo $cfs['field_source']; ?>"><?php echo $cfs['field_title']; ?></option>
                                <?php } ?>
                              <?php } ?>
                            <?php } ?>
                          </optgroup>
                        </select>
                        <input type="hidden" name="field_system_table" value="<?php echo $field_system_table; ?>" />
                        
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="col-sm-6">
                  <div class="form-group <?php if (!empty($error_location)) { ?> has-error <?php } ?>">
                    <div class="fg-line">
                      <label class="control-label" for="input-location"><?php echo $entry_location; ?></label>
                      <div class="select">
                        <select name="location" id="input-location" class="form-control">
                          <option value="0"><?php echo $text_none; ?></option>
                          <?php if (!empty($category_requestes)) { ?>
                            <?php foreach ($category_requestes as $cr) { ?>
                            <?php if ($cr['category_request_id'] == $location) { ?>
                              <option value="<?php echo $cr['category_request_id']; ?>" selected="selected"><?php echo $cr['title']; ?></option>
                            <?php } else { ?>
                              <option value="<?php echo $cr['category_request_id']; ?>"><?php echo $cr['title']; ?></option>
                            <?php } ?>
                            <?php } ?>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <?php if (!empty($error_location)) { ?>
                      <small class="help-block"><?php echo $error_location; ?></small>
                    <?php } ?>
                  </div>
                </div>
              </div>




              <div class="row custom_fields">
               
                <div class="col-sm-6">
                  <div class="form-group">
                    <div class="fg-line">
                      <label class="control-label" for="input-status"><?php echo $entry_required; ?></label>
                      <div class="required">
                        <select name="required" id="input-status" class="form-control">
                          <?php if ($required) { ?>
                          <option value="0"><?php echo $text_disabled; ?></option>
                          <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                          <?php } else { ?>
                          <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                          <option value="1"><?php echo $text_enabled; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!--/.row -->

              <div class="row custom_fields">
                <div class="col-sm-6">
                  <div class="form-group">
                    <div class="fg-line">
                      <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                      <div class="select">
                        <select name="status" id="input-status" class="form-control">
                          <?php if ($status) { ?>
                          <option value="0"><?php echo $text_disabled; ?></option>
                          <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                          <?php } else { ?>
                          <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                          <option value="1"><?php echo $text_enabled; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <div class="fg-line">
                        <label class="control-label" for="input-sort_order"><?php echo $entry_sort_order; ?></label>
                        <input type="text" name="sort_order" value="<?php echo $sort_order; ?>"  id="input-sort_order" class="form-control" />
                    </div>
                  </div><!--/.form-group-->
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                      <div class="fg-line">
                        <label class="control-label" for="input-type"><?php echo $entry_type; ?></label>
                        <div class="select">
                          <select name="type" id="input-type" class="form-control">
                            <optgroup label="<?php echo $text_date; ?>">
                            <?php if ($type == 'date') { ?>
                            <option value="date" selected="selected"><?php echo $text_date; ?></option>
                            <?php } else { ?>
                            <option value="date"><?php echo $text_date; ?></option>
                            <?php } ?>
                            <?php if ($type == 'time') { ?>
                            <option value="time" selected="selected"><?php echo $text_time; ?></option>
                            <?php } else { ?>
                            <option value="time"><?php echo $text_time; ?></option>
                            <?php } ?>
                            <?php if ($type == 'datetime') { ?>
                            <option value="datetime" selected="selected"><?php echo $text_datetime; ?></option>
                            <?php } else { ?>
                            <option value="datetime"><?php echo $text_datetime; ?></option>
                            <?php } ?>
                            </optgroup>
                            <optgroup label="<?php echo $text_choose; ?>">
                            <?php if ($type == 'select') { ?>
                            <option value="select" selected="selected"><?php echo $text_select; ?></option>
                            <?php } else { ?>
                            <option value="select"><?php echo $text_select; ?></option>
                            <?php } ?>
                            <?php if ($type == 'radio') { ?>
                            <option value="radio" selected="selected"><?php echo $text_radio; ?></option>
                            <?php } else { ?>
                            <option value="radio"><?php echo $text_radio; ?></option>
                            <?php } ?>
                            <?php if ($type == 'checkbox') { ?>
                            <option value="checkbox" selected="selected"><?php echo $text_checkbox; ?></option>
                            <?php } else { ?>
                            <option value="checkbox"><?php echo $text_checkbox; ?></option>
                            <?php } ?>
                            </optgroup>
                            <optgroup label="<?php echo $text_input; ?>">
                            <?php if ($type == 'text') { ?>
                            <option value="text" selected="selected"><?php echo $text_text; ?></option>
                            <?php } else { ?>
                            <option value="text"><?php echo $text_text; ?></option>
                            <?php } ?>
                            <?php if ($type == 'textarea') { ?>
                            <option value="textarea" selected="selected"><?php echo $text_textarea; ?></option>
                            <?php } else { ?>
                            <option value="textarea"><?php echo $text_textarea; ?></option>
                            <?php } ?>
                            </optgroup>

                            <optgroup label="<?php echo $text_file; ?>">
                            <?php if ($type == 'file') { ?>
                            <option value="file" selected="selected"><?php echo $text_file; ?></option>
                            <?php } else { ?>
                            <option value="file"><?php echo $text_file; ?></option>
                            <?php } ?>
                            </optgroup>

                            
                          </select>
                        </div>
                      </div>
                    </div>
                </div>
                 <div class="col-sm-6">
                  <div class="form-group">
                    <div class="fg-line" id="display-value">
                        <label class="control-label" for="input-value"><?php echo $entry_value; ?></label>
                        <input type="text" name="value" value="<?php echo $value; ?>"  id="input-value" class="form-control" />
                    </div>
                  </div><!--/.form-group-->
                </div>
                <div class="col-sm-12">
                  <table id="custom-field-value" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <td class="text-left required"><?php echo $entry_custom_value; ?></td>
                          <td class="text-right"><?php echo $entry_sort_order; ?></td>
                          <td></td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $contest_field_value_row = 0; ?>
                        <?php foreach ($contest_field_values as $contest_field_value) { ?>
                        <tr id="custom-field-value-row<?php echo $contest_field_value_row; ?>">
                          <td class="text-left" style="width: 70%;"><input type="hidden" name="contest_field_value[<?php echo $contest_field_value_row; ?>][contest_field_value_id]" value="<?php echo $contest_field_value['contest_field_value_id']; ?>" />
                            <?php foreach ($languages as $language) { ?>
                            <div class="input-group"> <span class="input-group-addon"><?php echo $language['name']; ?></span>
                              <input type="text" name="contest_field_value[<?php echo $contest_field_value_row; ?>][contest_field_value_description][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($contest_field_value['contest_field_value_description'][$language['language_id']]) ? $contest_field_value['contest_field_value_description'][$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_custom_value; ?>" class="form-control" />
                            </div>
                            <?php if (isset($error_contest_field_value[$contest_field_value_row][$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_contest_field_value[$contest_field_value_row][$language['language_id']]; ?></div>
                            <?php } ?>
                            <?php } ?></td>
                          <td class="text-right"><input type="text" name="contest_field_value[<?php echo $contest_field_value_row; ?>][sort_order]" value="<?php echo $contest_field_value['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                          <td class="text-left"><button onclick="$('#custom-field-value-row<?php echo $contest_field_value_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>
                        <?php $contest_field_value_row++; ?>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2"></td>
                          <td class="text-left"><button type="button" onclick="addContestFieldValue();" data-toggle="tooltip" title="<?php echo $button_contest_field_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                      </tfoot>
                    </table>
                </div>
              </div><!-- /.row -->
        </form>
        </div>
      </div><!--/.card -->
    </div> <!--/.container -->
</section>

<script type="text/javascript"><!--
$('.language-tab').each(function(){
    
    $('a:first', $(this)).tab('show');
  }) 

$('select[name=\'field_system\']').on('change', function() {
  if ( this.value == 'custom') {
     $('.custom_fields').show();
  }else{
     $('.custom_fields').hide();
  }
  var option = $('option:selected', this).attr('data-source');
  $('input[name=\'field_system_table\']').val(option);
}); 
$('select[name=\'type\']').on('change', function() {
	if ( this.value == 'select' || this.value == 'radio' || this.value == 'checkbox') {
		$('#custom-field-value').show();
		$('#display-value').hide();
	} else {
		$('#custom-field-value').hide();
		$('#display-value').show();
	}
	
	if (this.value == 'date') {
		$('#display-value > div').html('<div class="input-group date"><input type="text" name="value" value="' + $('#input-value').val() + '" placeholder="<?php echo $entry_value; ?>" data-date-format="YYYY-MM-DD" id="input-value" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div>');
	} else if (this.value == 'time') {
		$('#display-value > div').html('<div class="input-group time"><input type="text" name="value" value="' + $('#input-value').val() + '" placeholder="<?php echo $entry_value; ?>" data-date-format="HH:mm" id="input-value" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div>');
	} else if (this.value == 'datetime') {
		$('#display-value > div').html('<div class="input-group datetime"><input type="text" name="value" value="' + $('#input-value').val() + '" placeholder="<?php echo $entry_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div>');
	} else if (this.value == 'textarea') {

      var html = '<label class="control-label" for="input-value"><?php echo $entry_value; ?></label><textarea name="value" id="input-value" class="form-control">' + $('#input-value').val() + '</textarea>'
		  $('#display-value').html(html);
	} else {
     var html = '<label class="control-label" for="input-value"><?php echo $entry_value; ?></label><input type="text" name="value" value="' + $('#input-value').val() + '" id="input-value" class="form-control" />';

		$('#display-value').html(html);
	}
	/*
	$('.date').datetimepicker({
		pickTime: false
	});
	
	$('.time').datetimepicker({
		pickDate: false
	});	
		
	$('.datetime').datetimepicker({
		pickDate: true,
		pickTime: true
	});*/

});

$('select[name=\'type\']').trigger('change');
$('select[name=\'field_system\']').trigger('change');

var contest_field_value_row = <?php echo $contest_field_value_row; ?>;

function addContestFieldValue() {
	html  = '<tr id="custom-field-value-row' + contest_field_value_row + '">';	
    html += '  <td class="text-left" style="width: 70%;"><input type="hidden" name="contest_field_value[' + contest_field_value_row + '][contest_field_value_id]" value="" />';
	<?php foreach ($languages as $language) { ?>
	html += '    <div class="input-group">';
	html += '      <span class="input-group-addon"><?php echo $language['name']; ?></span><input type="text" name="contest_field_value[' + contest_field_value_row + '][contest_field_value_description][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_custom_value; ?>" class="form-control" />';
    html += '    </div>';
	<?php } ?>
	html += '  </td>';
	html += '  <td class="text-right"><input type="text" name="contest_field_value[' + contest_field_value_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#custom-field-value-row' + contest_field_value_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';	
	
	$('#custom-field-value tbody').append(html);
	
	contest_field_value_row++;
}
//--></script></div>
<?php echo $footer; ?>