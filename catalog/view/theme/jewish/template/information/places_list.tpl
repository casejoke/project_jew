<?php echo $header; ?>
<!-- HERO -->
<section class="module bg-dark" data-background="<?php echo $main_image; ?>">
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
      <!-- POSTS COLUMN -->
		<div class="<?php echo $class; ?>">
			<div class="row multi-columns-row">
			<?php if(!empty($places)) { ?>
				<?php foreach ($places as $place) { ?>
      			<!-- POST -->
				<div class="col-sm-6 col-md-4 col-lg-4 m-b-60">
					<div class="post">
						<div class="post-media">
							<a href="<?php echo $place['place_href']; ?>">
								<img src="<?php echo $place['image']; ?>" alt="<?php echo $place['place_title']; ?>">
							</a>
						</div>
						<div class="post-meta font-alt">
							<?php //echo $place['date_added']; ?>
						</div>
						<div class="post-header">
							<h4 class="post-title font-alt">
								<a href="<?php echo $place['place_href']; ?>"><?php echo $place['place_title']; ?></a>
							</h4>
						</div>
						<div class="post-more-link font-alt">
							<a href="<?php echo $place['place_href']; ?>"><?php echo $text_view; ?></a>
						</div>
					</div>
				</div>
				<!-- /POST -->
				<?php } ?>
			<?php } ?>
      	</div>
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

