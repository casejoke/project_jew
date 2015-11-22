<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2>Редактирование события</h2>
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
                <li><a href="#tab-data" aria-controls="tab-data" role="tab" data-toggle="tab"><?php echo $tab_data; ?></a></li>
                <li><a href="#tab-image" aria-controls="tab-image" role="tab" data-toggle="tab"><?php echo $tab_image; ?></a></li>
                <li><a href="#tab-video" aria-controls="tab-video" role="tab" data-toggle="tab"><?php echo $tab_video; ?></a></li>
                <li><a href="#tab-customers" aria-controls="tab-customers" role="tab" data-toggle="tab"><?php echo $tab_occasion_record; ?></a></li>
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
                                <input type="text" name="occasion_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($occasion_description[$language['language_id']]) ? $occasion_description[$language['language_id']]['title'] : ''; ?>"  id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                            </div>
                            <?php if (isset($error_title[$language['language_id']])) { ?>
                              <small class="help-block"><?php echo $error_title[$language['language_id']]; ?></small>
                            <?php } ?>
                          </div>
                          <div class="form-group required <?php if (isset($error_description[$language['language_id']])) { ?> has-error <?php } ?>">
                            <div class="fg-line">
                                <label class="control-label m-b-10" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                                <textarea name="occasion_description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($occasion_description[$language['language_id']]) ? $occasion_description[$language['language_id']]['description'] : ''; ?></textarea>
                            </div>
                            <?php if (isset($error_description[$language['language_id']])) { ?>
                              <small class="help-block"><?php echo $error_description[$language['language_id']]; ?></small>
                            <?php } ?>
                          </div>

                          <div class="form-group required <?php if (isset($error_meta_title[$language['language_id']])) { ?> has-error <?php } ?>">
                            <div class="fg-line">
                                <label class="control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                                <input type="text" name="occasion_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($occasion_description[$language['language_id']]) ? $occasion_description[$language['language_id']]['meta_title'] : ''; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                            </div>
                            <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                              <small class="help-block"><?php echo $error_meta_title[$language['language_id']]; ?></small>
                            <?php } ?>
                          </div>

                          <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label m-b-10" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                                <textarea name="occasion_description[<?php echo $language['language_id']; ?>][meta_description]" class="form-control auto-size" rows="4" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($occasion_description[$language['language_id']]) ? $occasion_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label m-b-10" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                                <textarea name="occasion_description[<?php echo $language['language_id']; ?>][meta_keyword]" class="form-control auto-size" rows="4" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($occasion_description[$language['language_id']]) ? $occasion_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
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
                    <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group <?php if ($error_keyword) { ?> has-error <?php } ?>">
                          <div class="fg-line">
                              <label class="control-label" for="input-keyword"><?php echo $entry_keyword; ?></label>
                              <input type="text" name="keyword" value="<?php echo $keyword; ?>"  id="input-keyword" class="form-control" />
                          </div>
                          <?php if ($error_keyword) { ?>
                            <small class="help-block"><?php echo $error_keyword; ?></small>
                          <?php } ?>
                        </div><!--/.form-group-->
                      </div>
                    </div>
                    <div class="row">

                      
                      <div class="col-sm-6">

                         <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="occasion_date"><?php echo $entry_occasion_date; ?></label>
                                 <input type="text" class="form-control date-picker" id="occasion_date" name="occasion_date" value="<?php echo $occasion_date; ?>">
                            </div>
                          </div><!--/.form-group-->

                          <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="input-occasion_time"><?php echo $entry_occasion_time; ?></label>
                                <input type="text" name="occasion_time" value="<?php echo $occasion_time; ?>"  id="input-occasion_time" class="form-control" />
                            </div>
                          </div><!--/.form-group-->

                        </div>



                      <div class="col-sm-6">
                        <div class="form-group">
                            <div class="fg-line">
                              <label class="control-label" for="input-occasion_season_id"><?php echo $entry_occasion_season_id; ?></label>
                              <div class="select">
                                <select name="occasion_season_id" id="input-occasion_season_id" class="form-control">
                                  <option value="0"><?php echo $text_none; ?></option>
                                  <?php if (!empty($occasion_seasons)) { ?>
                                    <?php foreach ($occasion_seasons as $occasion_season) { ?>
                                    <?php if ($occasion_season['season_id'] == $occasion_season_id) { ?>
                                      <option value="<?php echo $occasion_season['season_id']; ?>" selected="selected"><?php echo $occasion_season['title']; ?></option>
                                    <?php } else { ?>
                                      <option value="<?php echo $occasion_season['season_id']; ?>"><?php echo $occasion_season['title']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                  <?php } ?>
                                 
                                </select>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group <?php if ($error_place_id) { ?> has-error <?php } ?>">

                          <div class="fg-line">
                            <label class="control-label" for="input-place_id"><?php echo $entry_place; ?></label>
                            <div class="select">
                              <select name="occasion_place_id" id="input-place_id" class="form-control">
                              <option value="0"><?php echo $text_none; ?></option>
                                <?php if (!empty($place_results)) { ?>
                                  <?php foreach ($place_results as $place_result) { ?>
                                    <?php if ($place_result['place_id'] == $occasion_place_id) { ?>
                                      <option value="<?php echo $place_result['place_id']; ?>" selected="selected"><?php echo $place_result['place_title']; ?></option>
                                    <?php } else { ?>
                                      <option value="<?php echo $place_result['place_id']; ?>"><?php echo $place_result['place_title']; ?></option>
                                    <?php } ?>
                                  <?php } ?>
                                <?php } ?>
                               
                              </select>
                            </div>
                          </div>
                          <?php if ($error_place_id) { ?>
                            <small class="help-block"><?php echo $error_place_id; ?></small>
                          <?php } ?>
                        </div>
                      </div>
                       <div class="col-sm-6">

                          <div class="form-group">
                            <div class="fg-line">
                              <label class="control-label" for="occasion_to_occasion_group"><?php echo $entry_occasion_group_id; ?></label>
                              <div class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php if (!empty($occasion_groups)) { ?>
                                  <?php foreach ($occasion_groups as $occasion_group) { ?>
                                  <div class="checkbox  m-b-15">
                                    <label>
                                      <?php if (in_array($occasion_group['occasion_group_id'], $occasion_to_occasion_group)) { ?>
                                      <input type="checkbox" name="occasion_to_occasion_group[]" value="<?php echo $occasion_group['occasion_group_id']; ?>" checked="checked" />
                                      <i class="input-helper"></i>
                                      <?php echo $occasion_group['title']; ?>
                                      <?php } else { ?>
                                      <input type="checkbox" name="occasion_to_occasion_group[]" value="<?php echo $occasion_group['occasion_group_id']; ?>" />
                                      <i class="input-helper"></i>
                                      <?php echo $occasion_group['title']; ?>
                                      <?php } ?>
                                    </label>
                                  </div>
                                  <?php } ?>
                                <?php } ?>
                              </div>


                              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
                            </div>
                          </div>
                        </div>  

                        <div class="col-sm-6">
                          <div class="form-group <?php if ($error_price) { ?> has-error <?php } ?>">
                            <div class="fg-line">
                                <label class="control-label" for="input-price"><?php echo $entry_price; ?></label>
                                <input type="text" name="price" value="<?php echo $price; ?>"  id="input-price" class="form-control" />
                            </div>
                            <?php if ($error_price) { ?>
                              <small class="help-block"><?php echo $error_price; ?></small>
                            <?php } ?>
                          </div><!--/.form-group-->
                          <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="input-best_price"><?php echo $entry_best_price; ?></label>
                                <input type="text" name="best_price" value="<?php echo $best_price; ?>"  id="input-best_price" class="form-control" />
                            </div>
                          </div><!--/.form-group-->
                        </div>

                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <div class="fg-line">
                            <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                            <div class="select">
                              <select name="status" id="input-status" class="form-control">
                                <?php if (!empty($ar_status)) { ?>
                                  <?php foreach ($ar_status as $value) { ?>
                                  <?php if ($value['status_id'] == $status) { ?>
                                    <option value="<?php echo $value['status_id']; ?>" selected="selected"><?php echo $value['title']; ?></option>
                                  <?php } else { ?>
                                    <option value="<?php echo $value['status_id']; ?>"><?php echo $value['title']; ?></option>
                                  <?php } ?>
                                  <?php } ?>
                                <?php } ?>
                               
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                            <div class="fg-line">
                              <label class="control-label" for="input-status"><?php echo $entry_visibility; ?></label>
                              <div class="select">
                                <select name="visibility" id="input-visibility" class="form-control">
                                  <?php if ($visibility) { ?>
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
                    </div>
                  </div>
                </div>

               <div role="tabpanel" class="tab-pane " id="tab-image">
                  <table id="images" class="table table-striped">
                    <thead>
                      <tr>
                        <th><?php echo $entry_image_title; ?></th>
                        <th><?php echo $entry_link; ?></th>
                        <th><?php echo $entry_image; ?></th>
                        <th><?php echo $entry_sort_order; ?></th>
                        <th></th>
                      </tr>
                    </thead>
                      <tbody>
                        <?php $image_row = 0; ?>
                        <?php foreach ($occasion_images as $occasion_image) { ?>
                          <tr id="image-row<?php echo $image_row; ?>">
                            <td>
                              <?php foreach ($languages as $language) { ?>
                              <div class="input-group <?php if (isset($error_occasion_image[$image_row][$language['language_id']])) { ?>has-error <?php } ?>">
                                  <span class="input-group-addon"><?php echo $language['name']; ?></span>
                                  <div class="fg-line">
                                    <input type="text" name="occasion_image[<?php echo $image_row; ?>][occasion_image_description][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($occasion_image['occasion_image_description'][$language['language_id']]) ? $occasion_image['occasion_image_description'][$language['language_id']]['title'] : ''; ?>" occasionholder="<?php echo $entry_image_title; ?>" class="form-control" />
                                  </div>
                                  <?php if (isset($error_occasion_image[$image_row][$language['language_id']])) { ?>
                                    <small class="help-block"><?php echo $error_occasion_image[$image_row][$language['language_id']]; ?></small>
                                  <?php } ?>
                              </div>
                              <?php } ?>
                            </td>
                            <td class="text-left" style="width: 30%;">
                              <input type="text" name="occasion_image[<?php echo $image_row; ?>][link]" value="<?php echo $occasion_image['link']; ?>" occasionholder="<?php echo $entry_link; ?>" class="form-control" />
                            </td>
                            <td class="text-left">
                              <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                <img src="<?php echo $occasion_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                              </a>
                              <input type="hidden" name="occasion_image[<?php echo $image_row; ?>][image]" value="<?php echo $occasion_image['image']; ?>" id="input-image<?php echo $image_row; ?>" />
                            </td>
                            <td class="text-right">
                              <input type="text" name="occasion_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $occasion_image['sort_order']; ?>" occasionholder="<?php echo $entry_sort_order; ?>" class="form-control" />
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
                              <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                            </tr>
                          </tfoot>
                    </table>
                </div>

                <div role="tabpanel" class="tab-pane " id="tab-video">
                  <table id="videos" class="table table-striped">
                    <thead>
                      <tr>
                        <th><?php echo $entry_video_title; ?></th>
                        <th><?php echo $entry_link_video; ?></th>
                        <th><?php echo $entry_image; ?></th>
                        <th><?php echo $entry_sort_order; ?></th>
                        <th></th>
                      </tr>
                    </thead>
                      <tbody>
                        <?php $video_row = 0; ?>
                        <?php foreach ($occasion_videos as $occasion_video) { ?>
                          <tr id="video-row<?php echo $video_row; ?>">
                            <td>
                              <?php foreach ($languages as $language) { ?>
                              <div class="input-group <?php if (isset($error_occasion_video[$video_row][$language['language_id']])) { ?>has-error <?php } ?>">
                                  <span class="input-group-addon"><?php echo $language['name']; ?></span>
                                  <div class="fg-line">
                                    <input type="text" name="occasion_video[<?php echo $video_row; ?>][occasion_video_description][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($occasion_video['occasion_video_description'][$language['language_id']]) ? $occasion_video['occasion_video_description'][$language['language_id']]['title'] : ''; ?>" occasionholder="<?php echo $entry_image_title; ?>" class="form-control" />
                                  </div>
                                  <?php if (isset($error_occasion_video[$video_row][$language['language_id']])) { ?>
                                    <small class="help-block"><?php echo $error_occasion_video[$video_row][$language['language_id']]; ?></small>
                                  <?php } ?>
                              </div>
                              <?php } ?>
                            </td>
                            <td class="text-left" style="width: 30%;">
                              <input type="text" name="occasion_video[<?php echo $video_row; ?>][link]" value="<?php echo $occasion_video['link']; ?>" occasionholder="<?php echo $entry_link; ?>" class="form-control" />
                            </td>
                            <td class="text-left">
                              <a href="" id="thumb-video<?php echo $video_row; ?>" data-toggle="image" class="img-thumbnail">
                                <img src="<?php echo $occasion_video['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                              </a>
                              <input type="hidden" name="occasion_video[<?php echo $video_row; ?>][image]" value="<?php echo $occasion_video['image']; ?>" id="input-video<?php echo $video_row; ?>" />
                            </td>
                            <td class="text-right">
                              <input type="text" name="occasion_video[<?php echo $video_row; ?>][sort_order]" value="<?php echo $occasion_video['sort_order']; ?>" occasionholder="<?php echo $entry_sort_order; ?>" class="form-control" />
                            </td>
                            <td class="text-left">
                              <button type="button" onclick="$('#video-row<?php echo $video_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger">
                                <i class="fa fa-minus-circle"></i>
                              </button>
                            </td>
                          </tr>
                          <?php $video_row++; ?>
                          <?php } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="4"></td>
                              <td class="text-left"><button type="button" onclick="addVideo();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                            </tr>
                          </tfoot>
                    </table>
                </div>

                <div role="tabpanel" class="tab-pane " id="tab-customers">
                  <div role="tabpanel">
                    <table id="stats" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Имя игрока</th>
                          <th>Сезон</th>
                          <th>Формат</th>
                          <th>Количество голов</th>
                          <th>Количество пасов</th>
                          <th>MVP</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $stat_row = 0; ?>
                      <?php if (!empty($stats)) { ?>
                        <?php foreach ($stats as $stat) { ?>
                        <tr id="stat-row<?php echo $stat_row; ?>">
                          <td>
                            <div class="form-group <?php if(!empty($error_customer[$stat_row])) { ?>has-error <?php } ?>">
                              <div class="fg-line">
                                <div class="select">
                                  <select name="stats[<?php echo $stat_row; ?>][customer_id]" id="input-customer_id" class="form-control">
                                    <option value="0"><?php echo $text_none; ?></option>
                                    <?php if (!empty($customers)) { ?>
                                      <?php foreach ($customers as $customer) { ?>
                                      <?php if ($customer['customer_id'] == $stat['customer_id']) { ?>
                                        <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['name']; ?></option>
                                      <?php } else { ?>
                                        <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['name']; ?></option>
                                      <?php } ?>
                                      <?php } ?>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                              <?php if(!empty($error_customer[$stat_row])) { ?>
                                <?php echo $error_customer[$stat_row]; ?>
                              <?php } ?>
                          </td>
                          <td style="width:200px;">
                            <div class="form-group <?php if(!empty($error_season[$stat_row])) { ?>has-error <?php } ?>">
                              <div class="fg-line">
                                <div class="select">
                                  <select name="stats[<?php echo $stat_row; ?>][season_id]" id="input-season_id" class="form-control">
                                    <option value="0"><?php echo $text_none; ?></option>
                                    <?php if (!empty($occasion_seasons)) { ?>
                                      <?php foreach ($occasion_seasons as $season) { ?>
                                      <?php if ($season['season_id'] == $stat['season_id']) { ?>
                                        <option value="<?php echo $season['season_id']; ?>" selected="selected"><?php echo $season['title']; ?></option>
                                      <?php } else { ?>
                                        <option value="<?php echo $season['season_id']; ?>"><?php echo $season['title']; ?></option>
                                      <?php } ?>
                                      <?php } ?>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                               <?php if(!empty($error_season[$stat_row])) { ?>
                                <?php echo $error_season[$stat_row]; ?>
                              <?php } ?>
                          </td>
                          <td>
                            <div class="form-group <?php if(!empty($error_occasion_group[$stat_row])) { ?>has-error <?php } ?>">
                              <div class="fg-line">
                                <div class="select">
                                  <select name="stats[<?php echo $stat_row; ?>][occasion_group_id]" id="input-occasion_group_id" class="form-control">
                                    <option value="0"><?php echo $text_none; ?></option>
                                    <?php if (!empty($occasion_groups)) { ?>
                                      <?php foreach ($occasion_groups as $occasion_group) { ?>
                                      <?php if ($occasion_group['occasion_group_id'] == $stat['occasion_group_id']) { ?>
                                        <option value="<?php echo $occasion_group['occasion_group_id']; ?>" selected="selected"><?php echo $occasion_group['title']; ?></option>
                                      <?php } else { ?>
                                        <option value="<?php echo $occasion_group['occasion_group_id']; ?>"><?php echo $occasion_group['title']; ?></option>
                                      <?php } ?>
                                      <?php } ?>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                              <?php if(!empty($error_occasion_group[$stat_row])) { ?>
                                <?php echo $error_occasion_group[$stat_row]; ?>
                              <?php } ?>
                          </td>
                          <td><input type="text" name="stats[<?php echo $stat_row; ?>][goal]" value="<?php echo $stat['goal']; ?>"  class="form-control" /></td>
                          <td><input type="text" name="stats[<?php echo $stat_row; ?>][pass]" value="<?php echo $stat['pass']; ?>"  class="form-control" /></td>
                          <td><input type="text" name="stats[<?php echo $stat_row; ?>][mvp]" value="<?php echo $stat['mvp']; ?>"  class="form-control" /></td>
                          <td class="text-left">
                            <button type="button" onclick="$('#stat-row<?php echo $stat_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger">
                              <i class="fa fa-minus-circle"></i>
                            </button>
                          </td>
                        <?php $stat_row++;} ?>
                      <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="6"></td>
                          <td class="text-left"><button type="button" onclick="addStat();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                      </tfoot>
                  </table>
                  </div><!-- /.tabpanel -->
                </div><!-- /#tab-general -->

            </div><!-- /.tab-content-->
          </form>
        </div><!-- /.tabpanel -->
      </div><!--/.card -->
    </div> <!--/.container -->
</section>
<script type="text/javascript"><!--
var stat_row = <?php echo $stat_row; ?>;

function addStat() {
  html  = '<tr id="stat-row' + stat_row + '">';
  html += '<td>';
  html += '<div class="form-group"><div class="fg-line"><div class="select">';
  html += '<select name="stats[' + stat_row + '][customer_id]" id="input-customer_id" class="form-control">';
  html += '<option value="0"><?php echo $text_none; ?></option>';
  <?php if (!empty($customers)) { ?>
  <?php foreach ($customers as $customer) { ?>
  html += '<option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['name']; ?></option>';
  <?php } ?>
  <?php } ?>
  html += '</select></div></div></div></td>';

  html += '<td>';
  html += '<div class="form-group"><div class="fg-line"><div class="select">';
  html += '<select name="stats[' + stat_row + '][season_id]" id="input-season_id" class="form-control">'
  html += '<option value="0"><?php echo $text_none; ?></option>'
  <?php if (!empty($occasion_seasons)) { ?>
    <?php foreach ($occasion_seasons as $season) { ?>
    html += '<option value="<?php echo $season['season_id']; ?>"><?php echo $season['title']; ?></option>';
    <?php } ?>
  <?php } ?>
  html += '</select></div></div></div></td>';

  html += '<td>'
  html += '<div class="form-group"><div class="fg-line"><div class="select">';
  html += '<select name="stats[' + stat_row + '][occasion_group_id]" id="input-occasion_group_id" class="form-control">';
  html += '<option value="0"><?php echo $text_none; ?></option>';
  <?php if (!empty($occasion_groups)) { ?>
    <?php foreach ($occasion_groups as $occasion_group) { ?>
  html += '<option value="<?php echo $occasion_group['occasion_group_id']; ?>"><?php echo $occasion_group['title']; ?></option>';
    <?php } ?>
  <?php } ?>
  html += '</select></div></div></div></td>';
  html += '<td><input type="text" name="stats[' + stat_row + '][goal]" value=""  class="form-control" /></td>';
  html += '<td><input type="text" name="stats[' + stat_row + '][pass]" value=""  class="form-control" /></td>';
  html += '<td><input type="text" name="stats[' + stat_row + '][mvp]" value=""  class="form-control" /></td>';
  html += '<td class="text-left"><button type="button" onclick="$(\'#stat-row' + stat_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#stats tbody').append(html);
  
  stat_row++;
}
//--></script>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
  html  = '<tr id="image-row' + image_row + '">';
    html += '  <td>';
  <?php foreach ($languages as $language) { ?>
  html += '    <div class="input-group">';
  html += '      <span class="input-group-addon"><?php echo $language['name']; ?></span><div class="fg-line"><input type="text" name="occasion_image[' + image_row + '][occasion_image_description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="<?php echo $entry_image_title; ?>" class="form-control" /></div>';
    html += '    </div>';
  <?php } ?>
  html += '  </td>';  
  html += '  <td class="text-left" style="width: 30%;"><input type="text" name="occasion_image[' + image_row + '][link]" value="" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>'; 
  html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="occasion_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
  html += '  <td class="text-right"><input type="text" name="occasion_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#images tbody').append(html);
  
  image_row++;
}
//--></script>
<script type="text/javascript"><!--
var video_row = <?php echo $video_row; ?>;

function addVideo() {
  html  = '<tr id="video-row' + video_row + '">';
    html += '  <td style="width: 30%;">';
  <?php foreach ($languages as $language) { ?>
  html += '    <div class="input-group">';
  html += '      <span class="input-group-addon"><?php echo $language['name']; ?></span><div class="fg-line"><input type="text" name="occasion_video[' + video_row + '][occasion_video_description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="<?php echo $entry_image_title; ?>" class="form-control" /></div>';
    html += '    </div>';
  <?php } ?>
  html += '  </td>';  
  html += '  <td class="text-left" style="width: 30%;"><input type="text" name="occasion_video[' + video_row + '][link]" value="" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>'; 
  html += '  <td class="text-left"><a href="" id="thumb-video' + video_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="occasion_video[' + video_row + '][image]" value="" id="input-video' + video_row + '" /></td>';
  html += '  <td class="text-right"><input type="text" name="occasion_video[' + video_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#video-row' + video_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#videos tbody').append(html);
  
  video_row++;
}
//--></script>
<script type="text/javascript"><!--
 <?php foreach ($languages as $language) { ?>
  $('#input-description<?php echo $language['language_id']; ?>').summernote({
    height: 300
  });
  <?php } ?>
  $('#language a:first').tab('show');
//--></script>
<?php echo $footer; ?>