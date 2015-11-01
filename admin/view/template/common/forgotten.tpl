<?php echo $header; ?>
    <div class="container">
        <div class="block-header">
            
            <div class="row">
              <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
                <div class="card">
                  <div class="card-header ch-alt bgm-blue text-center">
                      <h2><?php echo $heading_title; ?></h2>
                  </div>

                  <div class="card-body card-padding">
                      <form role="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                       <?php if ($error_warning) { ?>
                        <div class="alert alert-danger alert-dismissible w-100" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <?php echo $error_warning; ?>
                        </div>
                        <?php } ?>
                          <div class="form-group fg-line">
                              <label for="input-username"><?php echo $entry_email; ?></label>
                              <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control input-sm" />
                          </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary m-t-20"><?php echo $button_reset; ?></button>

                            <a href="<?php echo $cancel; ?>" title="<?php echo $button_cancel; ?>" class="btn btn-default m-t-20"><i class="md md-replay"></i></a>
                          </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
<?php echo $footer; ?>