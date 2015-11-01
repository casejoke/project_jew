<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2>Редактирование статьи</h2>
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
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" >
            <ul class="tab-nav" role="tablist">
                <li class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                <li><a href="#tab-data" aria-controls="profile11" role="tab" data-toggle="tab"><?php echo $tab_data; ?></a></li>
                <li><a href="#tab-design" aria-controls="tab-design" role="tab" data-toggle="tab"><?php echo $tab_design; ?></a></li>
            </ul>
          
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab-general">
                  <div role="tabpanel">

                    <ul class="tab-nav" role="tablist" id="language" data-tab-color="amber">
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

                          <div class="card-body card-padding">

                            <div class="form-group required <?php if (isset($error_title[$language['language_id']])) { ?> has-error <?php } ?>">
                              <div class="fg-line">
                                  <label class="control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                                  <input type="text" name="information_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['title'] : ''; ?>"  id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                              </div>
                              <?php if (isset($error_title[$language['language_id']])) { ?>
                                <small class="help-block"><?php echo $error_title[$language['language_id']]; ?></small>
                              <?php } ?>
                            </div>

                            <div class="form-group required <?php if (isset($error_description[$language['language_id']])) { ?> has-error <?php } ?>">
                              <div class="fg-line">
                                  <label class="control-label m-b-10" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                                  <textarea name="information_description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['description'] : ''; ?></textarea>
                              </div>
                              <?php if (isset($error_description[$language['language_id']])) { ?>
                                <small class="help-block"><?php echo $error_description[$language['language_id']]; ?></small>
                              <?php } ?>
                            </div>

                            <div class="form-group required <?php if (isset($error_title[$language['language_id']])) { ?> has-error <?php } ?>">
                              <div class="fg-line">
                                  <label class="control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                                  <input type="text" name="information_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_title'] : ''; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                              </div>
                              <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                                <small class="help-block"><?php echo $error_meta_title[$language['language_id']]; ?></small>
                              <?php } ?>
                            </div>

                            <div class="form-group">
                              <div class="fg-line">
                                  <label class="control-label m-b-10" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                                  <textarea name="information_description[<?php echo $language['language_id']; ?>][meta_description]" class="form-control auto-size" rows="4" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="fg-line">
                                  <label class="control-label m-b-10" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                                  <textarea name="information_description[<?php echo $language['language_id']; ?>][meta_keyword]" class="form-control auto-size" rows="4" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                              </div>
                            </div>
                          </div><!--/.card-body -->
                        </div><!-- /tab-pane -->
                        <?php } ?>
                    </div><!-- /.tab-content -->
                  </div><!-- /.tabpanel -->

                </div><!-- /#tab-general -->
                <div role="tabpanel" class="tab-pane" id="tab-data">
                  <div class="card-body card-padding">
                    <div class="form-group hidden">
                      <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                      <div class="col-sm-10">
                        <div class="well well-sm" style="height: 150px; overflow: auto;">
                          <div class="checkbox">
                            <label>
                              <?php if (in_array(0, $information_store)) { ?>
                              <input type="checkbox" name="information_store[]" value="0" checked="checked" />
                              <?php echo $text_default; ?>
                              <?php } else { ?>
                              <input type="checkbox" name="information_store[]" value="0" />
                              <?php echo $text_default; ?>
                              <?php } ?>
                            </label>
                          </div>
                          <?php foreach ($stores as $store) { ?>
                          <div class="checkbox">
                            <label>
                              <?php if (in_array($store['store_id'], $information_store)) { ?>
                              <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                              <?php echo $store['name']; ?>
                              <?php } else { ?>
                              <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" />
                              <?php echo $store['name']; ?>
                              <?php } ?>
                            </label>
                          </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>

                    <div class="form-group <?php if ($error_keyword) { ?> has-error <?php } ?>">
                      <div class="fg-line">
                          <label class="control-label" for="input-keyword"><?php echo $entry_keyword; ?></label>
                          <input type="text" name="keyword" value="<?php echo $keyword; ?>"  id="input-keyword" class="form-control" />
                      </div>
                      <?php if ($error_keyword) { ?>
                        <small class="help-block"><?php echo $error_keyword; ?></small>
                      <?php } ?>
                    </div><!--/.form-group-->

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
                    
                    <div class="checkbox m-b-15 hidden">
                        <label>
                            <?php if ($bottom) { ?>
                            <input type="checkbox" name="bottom" value="1" checked="checked" id="input-bottom" />
                            <?php } else { ?>
                            <input type="checkbox" name="bottom" value="0" id="input-bottom" />
                            <?php } ?>
                            <i class="input-helper"></i>
                            <?php echo $entry_bottom; ?>
                        </label>
                    </div>


                    <div class="form-group ">
                      <div class="fg-line">
                        <label class="control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                        <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                      </div>
                    </div><!--/.form-group-->

                    <div class="form-group">
                      <label class="control-label" for="input-image"><?php echo $text_image; ?></label>
                        <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                          <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" />
                        </a>
                        <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                    </div><!--/.form-group--> 


                  </div><!--/.card-body -->
                </div><!-- /.tab-pane #tab-data -->

                <div role="tabpanel" class="tab-pane" id="tab-design">
                  <div class="card-body card-padding">
                    <div class="form-group">
                      <div class="fg-line">
                          <label class="control-label" for="input-sort-order"><?php echo $entry_layout; ?></label>
                          <div class="select">
                              <select name="information_layout[0]" class="form-control">
                                  <?php foreach ($layouts as $layout) { ?>
                                  <?php if (isset($information_layout[0]) && $information_layout[0] == $layout['layout_id']) { ?>
                                  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                  <?php } else { ?>
                                  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                  <?php } ?>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                    </div>
                  </div>


                  <div class="hidden">
                      

                          <?php foreach ($stores as $store) { ?>
                          <?php echo $store['name']; ?>
                           <select name="information_layout[<?php echo $store['store_id']; ?>]" class="form-control">
                                <option value=""></option>
                                <?php foreach ($layouts as $layout) { ?>
                                <?php if (isset($information_layout[$store['store_id']]) && $information_layout[$store['store_id']] == $layout['layout_id']) { ?>
                                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                              </select>
                          <?php } ?>
                    </div>
                </div><!-- /#tab-design -->
            </div>
          </form>
        </div><!-- /.tabpanel -->
      </div><!--/.card -->
    </div> <!--/.container -->
</section>
<script type="text/javascript"><!--
  <?php foreach ($languages as $language) { ?>
  $('#input-description<?php echo $language['language_id']; ?>').summernote({
  	height: 300
  });
  <?php } ?>
  $('#language a:first').tab('show');
//--></script>
<?php echo $footer; ?>