<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2><?php echo $heading_title; ?></h2>
        <ul class="actions">
            <li> <button type="submit" form="form-slideshow"  class="btn btn-success"><?php echo $button_save; ?></button></li>
            <li>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>">
                    <i class="md md-replay"></i>
                </a>
            </li>
        </ul>
      </div>
      <div class="card-body card-padding">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $error_warning; ?>
        </div>
        <?php } ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-slideshow" >
          
          <div class="form-group required  <?php if ($error_name) { ?>has-error <?php } ?>">
            <div class="fg-line">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="name" value="<?php echo $name; ?>"  id="input-name" class="form-control" />
            </div>
            <?php if ($error_name) { ?>
              <small class="help-block"><?php echo $error_name; ?></small>
            <?php } ?>
          </div>

          <div class="form-group">
            <div class="fg-line">
                <label class="control-label" for="input-banner"><?php echo $entry_banner; ?></label>
                <div class="select">
                    <select name="banner_id" id="input-banner"  class="form-control">
                      <?php foreach ($banners as $banner) { ?>
                      <?php if ($banner['banner_id'] == $banner_id) { ?>
                      <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                </div>
            </div>
          </div>

          <div class="form-group <?php if ($error_width) { ?>has-error <?php } ?>">
            <div class="fg-line">
                <label class="control-label" for="input-width"><?php echo $entry_width; ?></label>
                <input type="text" name="width" value="<?php echo $width; ?>"  id="input-width" class="form-control" />
            </div>
            <?php if ($error_width) { ?>
              <small class="help-block"><?php echo $error_width; ?></small>
            <?php } ?>
          </div>  

          <div class="form-group <?php if ($error_height) { ?>has-error <?php } ?>">
            <div class="fg-line">
                <label class="control-label" for="input-height"><?php echo $entry_height; ?></label>
                <input type="text" name="height" value="<?php echo $height; ?>" id="input-height" class="form-control" />
            </div>
            <?php if ($error_height) { ?>
              <small class="help-block"><?php echo $error_height; ?></small>
            <?php } ?>
          </div>   

          <div class="form-group">
            <div class="fg-line">
                <label class="control-label" for="input-full_heigth"><?php echo $entry_full_height; ?></label>
                <div class="select">
                    <select name="full_heigth" id="input-full_heigth"  class="form-control">
                      <?php if ($full_heigth) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                </div>
            </div>
          </div>

          <div class="form-group">
            <div class="fg-line">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="select">
                    <select name="status" id="input-status"  class="form-control">
                      <?php if ($status) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                </div>
            </div>
          </div>




        </form>
      </div>
    </div><!--/.card -->
  </div> <!--/.container -->
</section>
<?php echo $footer; ?>