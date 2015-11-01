<?php echo $header; ?>
    <div class="container">
        <div class="block-header">
            
            <div class="row">
              <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
                <div class="card">
                  <div class="card-header ch-alt bgm-blue text-center">
                      <h2><?php echo $text_login; ?></h2></h2>
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
                              <label for="input-username"><?php echo $entry_username; ?></label>
                              <input type="text" name="username" value="<?php echo $username; ?>" id="input-username" class="form-control input-sm" />
                          </div>
                          <div class="form-group fg-line">
                              <label for="input-password"><?php echo $entry_password; ?></label>
                              <input type="password" name="password" value="<?php echo $password; ?>" id="input-password" class="form-control input-sm" />
                          </div>
                          <?php if ($forgotten) { ?>
                          <span class="help-block"><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></span>
                          <?php } ?>
                          <?php if ($redirect) { ?>
                            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                          <?php } ?>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary m-t-20"><?php echo $button_login; ?></button>
                          </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
<?php echo $footer; ?>