<?php echo $header; ?>
<?php echo $column_left; ?>
<section id="content">
  <div class="container">
    
    <div class="card">
      <div class="card-header">
        <h2><?php echo $heading_title; ?><small></small></h2>
        <ul class="actions">
          
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-contest">
          <table class="table">
              <thead>
                  <tr>
                     
                      <th class="text-left"><?php if ($sort == 'dd.title') { ?>
                        <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
                        <?php } ?>
                      </th>
                       
                      <th class="text-center"><?php echo $column_contest_date; ?></th>
                      
                      <th class="text-right"><?php echo $column_action; ?></th>
                  </tr>
              </thead>
              <tbody>
                  <?php if ($contests) { ?>
                  <?php foreach ($contests as $contest) { ?>
                  <tr>
                    
                    <td class="text-left"><?php echo $contest['title']; ?></td>
                    <td class="text-center"><?php echo $contest['contest_date']; ?></td>
                    <td class="text-right"><a href="<?php echo $contest['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                  </tr>
                  <?php } ?>
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