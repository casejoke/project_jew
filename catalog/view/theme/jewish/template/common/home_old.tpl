<?php echo $header; ?>
<?php echo $content_top; ?>
<!-- SINGLE POST -->
<section class="module">
  <div class="container">
    <div class="row">
      <!-- CONTENT -->
      <?php echo $column_left; ?>
      <?php if ($column_left && $column_right) { ?>
      <?php $class = 'col-sm-6'; ?>
      <?php } elseif ($column_left || $column_right) { ?>
      <?php $class = 'col-sm-9'; ?>
      <?php } else { ?>
      <?php $class = 'col-sm-12'; ?>
      <?php } ?>
      <div class="<?php echo $class; ?>">
        <?php echo $content_bottom; ?>
      </div>
      <?php if ($column_right) { ?>
      <div class="col-sm-3 m-t-sm-60">
        <?php echo $column_right; ?>
      </div>
      <?php } ?>
    </div>
  </div>
</section>

<?php echo $footer; ?>