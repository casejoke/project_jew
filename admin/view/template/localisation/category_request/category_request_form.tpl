<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2><?php echo $heading_title; ?></h2>
        <ul class="actions">
            <li> <button type="submit" form="form-age-status"  class="btn btn-success"><?php echo $button_save; ?></button></li>
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

         <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-age-status" class="form-horizontal">
         
              <div class="card-body card-padding">
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
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group <?php if (isset($error_name[$language['language_id']])) { ?> has-error <?php } ?>">
                                <div class="fg-line">
                                    <label class="control-label" for="input-category_request"><?php echo $entry_name; ?></label>
                                    <input type="text" name="category_request[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_request[$language['language_id']]) ? $category_request[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_name[$language['language_id']])) { ?>
                                  <small class="help-block"><?php echo $error_name[$language['language_id']]; ?></small>
                                <?php } ?>
                              </div><!--/.form-group-->
                            </div>
                          </div>
                          <div class="form-group ">
                          <div class="fg-line">
                            <label class="control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                            <input type="text" name="category_request[<?php echo $language['language_id']; ?>][sort_order]" value="<?php echo isset($category_request[$language['language_id']]) ? $category_request[$language['language_id']]['sort_order'] : ''; ?>"  id="input-sort-order" class="form-control" />
                          </div>
                        </div><!--/.form-group-->
                        </div>
                      </div>

                      
                    <?php } ?>
                  </div>
              </div>
          

          </form>
        </div><!--/.card -->
    </div> <!--/.container -->
</section>
<script type="text/javascript"><!--
 $('#language a:first').tab('show');
//--></script>
<?php echo $footer; ?>