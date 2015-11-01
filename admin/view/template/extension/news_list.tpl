<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    
    <div class="card">
      <div class="card-header">
        <h2><?php echo $heading_title; ?><small></small></h2>
        <ul class="actions">
            <li>
                <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>">
                    <i class="md  md-note-add"></i>
                </a>
            </li>
            <li><button class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-information').submit() : false;"> <?php echo $button_delete; ?></button></li>
        </ul>
      </div>
      <div class="card-body card-padding table-responsive">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $error_warning; ?>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
          <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $success; ?>
          </div>
        <?php } ?>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-information">
          <table class="table">
              <thead>
                  <tr>
                      <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                      <td class="text-left"><?php echo $entry_title; ?></td>
                      <td class="text-left"><?php echo $entry_short_description; ?></td>
                      <td class="text-left"><?php echo $entry_date; ?></td>
                      <td class="text-right"><?php echo $entry_action; ?></td>
                  </tr>
              </thead>
              <tbody>
                  <?php if ($all_news) { ?>
                  <?php foreach ($all_news as $news) { ?>
                  <tr>
                  <td width="1" style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $news['news_id']; ?>" /></td>
                  <td class="text-left"><?php echo $news['title']; ?></td>
                  <td class="text-left"><?php echo $news['short_description']; ?></td>
                  <td class="text-left"><?php echo $news['date_added']; ?></td>
                  <td class="text-right">
                     <a href="<?php echo $news['edit']; ?>" title="<?php echo $button_edit; ?>" class="btn btn-primary"><?php echo $button_edit; ?></a>
                  </td>
                  </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                  <td colspan="5" class="text-center"><?php echo $text_no_results; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
          </table>
        </form>
          <div class="hidden"><?php echo $results; ?></div>
          <?php echo $pagination; ?>
        </div>
      </div>
    </div> 
</section>
<?php echo $footer; ?>