<?php echo $header; ?>
<!-- HERO -->
<?php if ($image) { ?>
<section class="module bg-dark" data-background="<?php echo $image; ?>">
  <!-- HERO TEXT -->
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h1 class="mh-line-size-3 font-alt m-b-20"><?php echo $heading_title; ?></h1>
      </div>
    </div>
  </div>
  <!-- /HERO TEXT -->
</section>
<!-- /HERO -->
<?php } ?>
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
        <article class="post post-single">
         
          <div class="post-entry">
            <?php echo $description; ?>
          </div>
        </article>
      </div>
      <?php if ($column_right) { ?>
      <div class="col-sm-3 m-t-sm-60">
        <?php echo $column_right; ?>
      </div>
      <?php } ?>
    </div>
  </div>
</section>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>