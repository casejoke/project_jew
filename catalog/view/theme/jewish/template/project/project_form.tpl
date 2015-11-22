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
                 <input type="text" name="project_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($project_description[$language['language_id']]) ? html_entity_decode($project_description[$language['language_id']]['title'], ENT_QUOTES) : ''; ?>"  id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                  <?php if (isset($error_title[$language['language_id']])) { ?>
                    <small class="help-block"><?php echo $error_title[$language['language_id']]; ?></small>
                  <?php } ?>
                </div>

                <div class="form-group required <?php if (isset($error_target[$language['language_id']])) { ?> has-error <?php } ?>">
                  <label class="control-label" for="input-target<?php echo $language['language_id']; ?>"><?php echo $entry_target; ?></label>
                  <textarea data-editor="summernote" name="project_description[<?php echo $language['language_id']; ?>][target]" id="input-target<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($project_description[$language['language_id']]['target']) ? $project_description[$language['language_id']]['target'] : ''; ?></textarea>
                  <?php if (isset($error_target[$language['language_id']])) { ?>
                    <small class="help-block"><?php echo $error_target[$language['language_id']]; ?></small>
                  <?php } ?>
                </div>

                <div class="form-group required <?php if (isset($error_product[$language['language_id']])) { ?> has-error <?php } ?>">
                  <label class="control-label" for="input-product<?php echo $language['language_id']; ?>"><?php echo $entry_product; ?></label>
                  <textarea data-editor="summernote" name="project_description[<?php echo $language['language_id']; ?>][product]" id="input-product<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($project_description[$language['language_id']]['product']) ? $project_description[$language['language_id']]['product'] : ''; ?></textarea>
                  <?php if (isset($error_product[$language['language_id']])) { ?>
                    <small class="help-block"><?php echo $error_product[$language['language_id']]; ?></small>
                  <?php } ?>
                </div>

                <div class="form-group required <?php if (isset($error_description[$language['language_id']])) { ?> has-error <?php } ?>">
                  <label class="control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                  <textarea data-editor="summernote" name="project_description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($project_description[$language['language_id']]['description']) ? $project_description[$language['language_id']]['description'] : ''; ?></textarea>
                  <?php if (isset($error_description[$language['language_id']])) { ?>
                    <small class="help-block"><?php echo $error_description[$language['language_id']]; ?></small>
                  <?php } ?>
                </div>

                 <div class="form-group required <?php if (isset($error_result[$language['language_id']])) { ?> has-error <?php } ?>">
                  <label class="control-label" for="input-result<?php echo $language['language_id']; ?>"><?php echo $entry_result; ?></label>
                  <textarea data-editor="summernote" name="project_description[<?php echo $language['language_id']; ?>][result]" id="input-result<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($project_description[$language['language_id']]['result']) ? $project_description[$language['language_id']]['result'] : ''; ?></textarea>
                  <?php if (isset($error_result[$language['language_id']])) { ?>
                    <small class="help-block"><?php echo $error_result[$language['language_id']]; ?></small>
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
              <a href="" id="thumb-image-project" data-toggle="image" class="img-thumbnail">
                <img src="<?php echo $thumb; ?>" data-placeholder="<?php echo $placeholder; ?>" />
              </a>
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image-project" />
            </div>
          </div>


          <div class="col-sm-8">
            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="input-project_birthday"><?php echo $entry_project_birthday; ?></label>
                  <input type="text" name="project_birthday" value="<?php echo $project_birthday; ?>"  id="input-project_birthday" class="form-control date-picker" />
                </div><!--/.form-group-->
              </div>
                
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="input-project_birthday"><?php echo $entry_init_group; ?></label>
                  <select class="form-control" name="project_init_group_id">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php if (!empty($init_groups)) { ?>
                      <?php foreach ($init_groups as $ig) { ?>
                        <?php if ($ig['group_id'] == $project_init_group_id) { ?>
                          <option value="<?php echo $ig['group_id']; ?>" selected="selected"><?php echo $ig['group_title']; ?></option>
                        <?php } else { ?>
                          <option value="<?php echo $ig['group_id']; ?>"><?php echo $ig['group_title']; ?></option>
                        <?php } ?>
                        
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>


              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="input-project_birthday"><?php echo $entry_project_status; ?></label>
                  <select class="form-control" name="project_status_id">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php if (!empty($project_statuses)) { ?>
                      <?php foreach ($project_statuses as $ps) { ?>
                        <?php if ($ps['project_status_id'] == $project_status_id) { ?>
                          <option value="<?php echo $ps['project_status_id']; ?>" selected="selected"><?php echo $ps['project_status_title']; ?></option>
                        <?php } else { ?>
                          <option value="<?php echo $ps['project_status_id']; ?>"><?php echo $ps['project_status_title']; ?></option>
                        <?php } ?>
                        
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row">
                  <label class="control-label col-xs-12" for="input-project_budget"><?php echo $entry_project_budget; ?></label>
                  <div class="form-group col-xs-6">
                    <input type="text" name="project_budget" value="<?php echo $project_budget; ?>"  id="input-project_budget" class="form-control " />
                  </div><!--/.form-group-->
                  <div class="form-group col-xs-6">
                    <select class="form-control" name="project_currency_id">
                      <?php if (!empty($currencies)) { ?>
                        <?php foreach ($currencies as $pc) { ?>
                          <?php if ($pc['currency_id'] == $project_currency_id) { ?>
                            <option value="<?php echo $pc['currency_id']; ?>" selected="selected"><?php echo $pc['code']; ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $pc['currency_id']; ?>"><?php echo $pc['code']; ?></option>
                          <?php } ?>
                          
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div><!--/.form-group-->
                </div>
              </div>


              <div class="col-sm-6">
                <div class="row">
                <div class="col-xs-12">
                  <label class="control-label" for="input-sex_status"><?php echo $entry_sex_status; ?></label>
                  <?php foreach ($sex_statuses as $ssv) { ?>
                  <div class="checkbox ">
                    <label>
                      <?php if (in_array($ssv, $sex_status)) { ?>
                      <input type="checkbox" name="sex_status[]" value="<?php echo $ssv; ?>" checked="checked" />
                      <?php echo $sex_statuses_desc[$ssv]['title']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="sex_status[]" value="<?php echo $ssv; ?>" />
                      <?php echo $sex_statuses_desc[$ssv]['title']; ?>
                      <?php } ?>
                    </label>
                  </div>
                  <?php } ?>
                </div>
                </div>
              </div>
             </div><!-- /.row -->
              <div class="row">
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-xs-12">
                      <label class="control-label" for="input-age_status"><?php echo $entry_age_status; ?></label>
                      <?php foreach ($age_statuses as $asv) { ?>
                      <div class="checkbox ">
                        <label>
                          <?php if (in_array($asv, $age_status)) { ?>
                          <input type="checkbox" name="age_status[]" value="<?php echo $asv; ?>" checked="checked" />
                          <?php echo $age_statuses_desc[$asv]['title']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="age_status[]" value="<?php echo $asv; ?>" />
                          <?php echo $age_statuses_desc[$asv]['title']; ?>
                          <?php } ?>
                        </label>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-xs-12">
                      <label class="control-label" for="input-nationality_status"><?php echo $entry_nationality_status; ?></label>
                      <?php foreach ($nationality_statuses as $ssv) { ?>
                      <div class="checkbox ">
                        <label>
                          <?php if (in_array($ssv, $nationality_status)) { ?>
                          <input type="checkbox" name="nationality_status[]" value="<?php echo $ssv; ?>" checked="checked" />
                          <?php echo $nationality_statuses_desc[$ssv]['title']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="nationality_status[]" value="<?php echo $ssv; ?>" />
                          <?php echo $nationality_statuses_desc[$ssv]['title']; ?>
                          <?php } ?>
                        </label>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div><!-- /.row -->
              <div class="row">
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-xs-12">
                      <label class="control-label" for="input-professional_status"><?php echo $entry_professional_status; ?></label>
                      <?php foreach ($professional_statuses as $ssv) { ?>
                      <div class="checkbox ">
                        <label>
                          <?php if (in_array($ssv, $professional_status)) { ?>
                          <input type="checkbox" name="professional_status[]" value="<?php echo $ssv; ?>" checked="checked" />
                          <?php echo $professional_statuses_desc[$ssv]['title']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="professional_status[]" value="<?php echo $ssv; ?>" />
                          <?php echo $professional_statuses_desc[$ssv]['title']; ?>
                          <?php } ?>
                        </label>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-xs-12">
                      <label class="control-label" for="input-demographic_status"><?php echo $entry_demographic_status; ?></label>
                      <?php foreach ($demographic_statuses as $ssv) { ?>
                      <div class="checkbox ">
                        <label>
                          <?php if (in_array($ssv, $demographic_status)) { ?>
                          <input type="checkbox" name="demographic_status[]" value="<?php echo $ssv; ?>" checked="checked" />
                          <?php echo $demographic_statuses_desc[$ssv]['title']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="demographic_status[]" value="<?php echo $ssv; ?>" />
                          <?php echo $demographic_statuses_desc[$ssv]['title']; ?>
                          <?php } ?>
                        </label>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>


              </div><!-- /.row -->
            





            
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