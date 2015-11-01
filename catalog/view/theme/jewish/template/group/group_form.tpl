<?php echo $header; ?>
<!-- Header section start -->
<div class="module  module--initnavbar"  data-navbar="navbar-dark">
  <div class="container">
    <div class="row module-heading module-heading--text-dark">
    <div class="col-sm-6 col-sm-offset-3">
      <h1 class="module-heading__module-title font-alt text-center"><?php echo $heading_title; ?></h1>
    </div>
  </div><!-- .row -->
  </div>
</div>
<!-- Header section end -->
<!-- MDULE -->

<div class="module module--small"><!-- module -->
  <div class="container">
   <?php echo $content_top; ?>

   <div class="row">
   <div class="col-sm-10 col-sm-offset-1">
    <?php if (!empty($error_warning)) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
    <?php } ?>
  
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" >
      <div class="row">   
      <div role="tabpanel">
        <ul class="nav nav-tabs font-alt" role="tablist" id="language">
          <?php foreach ($languages as $language) { ?>
              <li>
                <a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab">
                  <?php echo $language['name']; ?>
                </a>
              </li>
            <?php } ?>
        </ul>
        <div class="tab-content">
          
          <?php foreach ($languages as $language) { ?>
            <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
              
              <div class="col-sm-10 col-sm-offset-1">
                <div class="form-group required <?php if (isset($error_title[$language['language_id']])) { ?> has-error <?php } ?>">
                  <label class=" control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                 <input type="text" name="init_group_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($init_group_description[$language['language_id']]) ? html_entity_decode($init_group_description[$language['language_id']]['title'], ENT_QUOTES) : ''; ?>"  id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_title[$language['language_id']])) { ?>
                        <small class="help-block"><?php echo $error_title[$language['language_id']]; ?></small>
                      <?php } ?>
                </div>
                <div class="form-group required <?php if (isset($error_description[$language['language_id']])) { ?> has-error <?php } ?>">
                  <label class="control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                  <textarea data-editor="summernote" name="init_group_description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($init_group_description[$language['language_id']]['description']) ? $init_group_description[$language['language_id']]['description'] : ''; ?></textarea>
               
                  <?php if (isset($error_description[$language['language_id']])) { ?>
                    <small class="help-block"><?php echo $error_description[$language['language_id']]; ?></small>
                  <?php } ?>
                </div>
              </div>


            </div>
          <?php } ?>

        </div>
      </div><!-- /.tabpanel language -->
      </div>
      
        

        <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
        <hr class="divider-w mt-10 mb-20">
          <div class="form-group col-sm-4">
            <label class="control-label" for="input-image"><?php echo $entry_image; ?></label>
            <div class="">
              <a href="" id="thumb-image-group" data-toggle="image" class="img-thumbnail">
                <img src="<?php echo $thumb; ?>" data-placeholder="<?php echo $placeholder; ?>" />
              </a>
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image-group" />
            </div>
          </div>
          <div class="col-sm-8">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="input-group_birthday"><?php echo $entry_group_birthday; ?></label>
                  <input type="text" name="group_birthday" value="<?php echo $group_birthday; ?>"  id="input-group_birthday" class="form-control date-picker" />
                </div><!--/.form-group-->
              </div>
            </div>
          </div>
        </div>
        </div>
      <hr class="divider-w mt-10 mb-20">
        <div class="row">

          <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
              <input type="submit" value="<?php echo $text_submit;?>" class="btn btn-round btn-block btn-success" />
            </div>
          </div>  
        </div>
        </form>

    </div><!-- /.col-sm-10 -->
   <?php echo $content_bottom; ?>
    </div>
  </div>
</div>
<?php echo $column_left; ?>
<?php echo $column_right; ?>

<?php echo $footer; ?>