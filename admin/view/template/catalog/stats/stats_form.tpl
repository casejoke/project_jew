<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2>Редактирование статситики</h2>
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
            </ul>
          
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab-general">
                  <div role="tabpanel">
                    <table id="stats" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Дата игрового дня</th>
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
                            <div class="form-group">
                              <div class="fg-line">
                                <div class="select">
                                  <select name="stats[<?php echo $stat_row; ?>][occasion_id]" id="input-occasion_id" class="form-control">
                                    <option value="0"><?php echo $text_none; ?></option>
                                    <?php if (!empty($occasions)) { ?>
                                      <?php foreach ($occasions as $occasion) { ?>
                                      <?php if ($occasion['occasion_id'] == $stat['occasion_id']) { ?>
                                        <option value="<?php echo $occasion['occasion_id']; ?>" selected="selected"><?php echo $occasion['occasion_date']; ?></option>
                                      <?php } else { ?>
                                        <option value="<?php echo $occasion['occasion_id']; ?>"><?php echo $occasion['occasion_date']; ?></option>
                                      <?php } ?>
                                      <?php } ?>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                              <?php if(!empty($error_occasion[$stat_row])) { ?>
                                <?php echo $error_occasion[$stat_row]; ?>
                              <?php } ?>
                          </td>
                          <td style="width:200px;">
                            <div class="form-group">
                              <div class="fg-line">
                                <div class="select">
                                  <select name="stats[<?php echo $stat_row; ?>][season_id]" id="input-season_id" class="form-control">
                                    <option value="0"><?php echo $text_none; ?></option>
                                    <?php if (!empty($seasons)) { ?>
                                      <?php foreach ($seasons as $season) { ?>
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

                <div role="tabpanel" class="tab-pane" id="tab-data">
                  <div class="card-body card-padding">
                    
                  </div>
                </div>

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
  html += '<select name="stats[' + stat_row + '][occasion_id]" id="input-occasion_id" class="form-control">';
  html += '<option value="0"><?php echo $text_none; ?></option>';
  <?php if (!empty($occasions)) { ?>
  <?php foreach ($occasions as $occasion) { ?>
  html += '<option value="<?php echo $occasion['occasion_id']; ?>"><?php echo $occasion['occasion_date']; ?></option>';
  <?php } ?>
  <?php } ?>
  html += '</select></div></div></div></td>';

  html += '<td>';
  html += '<div class="form-group"><div class="fg-line"><div class="select">';
  html += '<select name="stats[' + stat_row + '][season_id]" id="input-season_id" class="form-control">'
  html += '<option value="0"><?php echo $text_none; ?></option>'
  <?php if (!empty($seasons)) { ?>
    <?php foreach ($seasons as $season) { ?>
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
<?php echo $footer; ?>