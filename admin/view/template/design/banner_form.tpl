<?php echo $header; ?>
<ol class="breadcrumb" style="margin-bottom: 5px;">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
</ol>
<?php echo $column_left; ?>

<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2>Редактирование баннера</h2>
        <ul class="actions">
            <li><button type="submit" form="form-information"  class="btn btn-success"><?php echo $button_save; ?></button></li>
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
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" >
           <ul class="tab-nav" role="tablist">
                <li class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                <li><a href="#tab-image" aria-controls="tab-image" role="tab" data-toggle="tab"><?php echo $tab_image; ?></a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="tab-general">
                <div class="row">
                  <div class="col-sm-8">
                    <div class="form-group <?php if ($error_name) { ?> has-error <?php } ?>">
                      <div class="fg-line">
                          <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                          <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
                      </div>
                      <?php if ($error_name) { ?>
                        <small class="help-block"><?php echo $error_name; ?></small>
                      <?php } ?>
                    </div><!--/.form-group-->
                  </div>
                  <div class="col-sm-4">
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
                </div><!--/.row -->
              </div>
              <div role="tabpanel" class="tab-pane" id="tab-image">
                <table id="images" class="table table-striped">
                  <thead>
                    <tr>
                      <th><?php echo $entry_title; ?></th>
                      <th><?php echo $entry_link; ?></th>
                      <th><?php echo $entry_image; ?></th>
                      <th><?php echo $entry_sort_order; ?></th>
                      <th></th>
                    </tr>
                  </thead>
                <tbody>
              <?php $image_row = 0; ?>
              <?php foreach ($banner_images as $banner_image) { ?>
                <tr id="image-row<?php echo $image_row; ?>">
                  <td>
                    <?php foreach ($languages as $language) { ?>
                    <div class="input-group <?php if (isset($error_banner_image[$image_row][$language['language_id']])) { ?>has-error <?php } ?>">
                        <span class="input-group-addon"><?php echo $language['name']; ?></span>
                        <div class="fg-line">
                          <input type="text" name="banner_image[<?php echo $image_row; ?>][banner_image_description][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($banner_image['banner_image_description'][$language['language_id']]) ? $banner_image['banner_image_description'][$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" class="form-control" />
                        </div>
                        <?php if (isset($error_banner_image[$image_row][$language['language_id']])) { ?>
                          <small class="help-block"><?php echo $error_banner_image[$image_row][$language['language_id']]; ?></small>
                        <?php } ?>
                    </div>
                    <?php } ?>
                  </td>
                  <td class="text-left" style="width: 30%;">
                    <input type="text" name="banner_image[<?php echo $image_row; ?>][link]" value="<?php echo $banner_image['link']; ?>" placeholder="<?php echo $entry_link; ?>" class="form-control" />
                  </td>
                  <td class="text-left">
                    <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                      <img src="<?php echo $banner_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                    </a>
                    <input type="hidden" name="banner_image[<?php echo $image_row; ?>][image]" value="<?php echo $banner_image['image']; ?>" id="input-image<?php echo $image_row; ?>" />
                  </td>
                  <td class="text-right">
                    <input type="text" name="banner_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $banner_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" />
                  </td>
                  <td class="text-left">
                    <button type="button" onclick="$('#image-row<?php echo $image_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger">
                      <i class="fa fa-minus-circle"></i>
                    </button>
                  </td>
                </tr>
                <?php $image_row++; ?>
                <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4"></td>
                    <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_banner_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                  </tr>
                </tfoot>
              </table>
              </div>
            </div><!--/.tab-content-->

          </form>
        </div><!-- /.tabpanel -->
      </div><!--/.card -->
    </div> <!--/.container -->
</section>

<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
  html  = '<tr id="image-row' + image_row + '">';
    html += '  <td>';
  <?php foreach ($languages as $language) { ?>
  html += '    <div class="input-group">';
  html += '      <span class="input-group-addon"><?php echo $language['name']; ?></span><div class="fg-line"><input type="text" name="banner_image[' + image_row + '][banner_image_description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="<?php echo $entry_title; ?>" class="form-control" /></div>';
    html += '    </div>';
  <?php } ?>
  html += '  </td>';  
  html += '  <td class="text-left"><input type="text" name="banner_image[' + image_row + '][link]" value="" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>'; 
  html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="banner_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
  html += '  <td class="text-right"><input type="text" name="banner_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#images tbody').append(html);
  
  image_row++;
}
//--></script>
<?php echo $footer; ?>