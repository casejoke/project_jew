<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    
    <div class="card">
      <div class="card-header">
        <h2><?php echo $heading_title; ?><small></small></h2>
        <ul class="actions hidden">
            <li class="hidden">
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
                  <td>#</td>
                   <td style="width: 1px;" class="text-center hidden"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left">Конкурс</td>
                  <td class="text-left">Участник (Адаптор проекта)</td>
                  <td class="text-left">Автор проекта (только для BP)</td>
                  <td class="text-left">Проект</td>
                  <td class="text-center">Оценка автора проекта(только для BP)</td>
                  <td class="text-center">Статус</td>
                  <td class="text-right">Дата подачи заявки</td>
                  </tr>
              </thead>
              <tbody>
                 <?php if ($contest_requests) { ?>
                 <?php $i = 1; ?>
                <?php foreach ($contest_requests as $cr) { ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td class="text-center hidden"><?php if (in_array($cr['customer_to_contest_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $cr['customer_to_contest_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $cr['customer_to_contest_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $cr['contest_id']; ?></td>
                  <td class="text-left"><?php echo $cr['customer_name']; ?></td>
                   <td class="text-left"><?php echo $cr['adaptive_name']; ?></td>
                 <td class="text-left"><a href="<?php echo $cr['project_link']; ?>" target="_blank"><?php echo $cr['adaptive_title']; ?></a></td>
                  <td class="text-center"><?php echo $cr['adaptive_status']; ?></td>
                  <td class="text-center"><?php echo $cr['status']; ?></td>
                  <td class="text-right"><?php echo $cr['date_added']; ?></td>
                  
                </tr>
                <?php $i++;} ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
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