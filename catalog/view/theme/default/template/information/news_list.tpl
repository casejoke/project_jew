<?php echo $header; ?>
<!-- HERO -->
<section class="module bg-dark" data-background="image/temp/section-13.jpg">
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
			<?php if(!empty($all_news)) { ?>
				<?php foreach ($all_news as $news) { ?>
      			<!-- POST -->
				<div class="col-sm-6 col-md-6 col-lg-6 m-b-60">
					<div class="post">
						<div class="post-media">
							<a href="<?php echo $news['view']; ?>">
								<img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">
							</a>
						</div>
						<div class="post-meta font-alt">
							<?php echo $news['date_added']; ?>
						</div>
						<div class="post-header">
							<h4 class="post-title font-alt">
								<a href="<?php echo $news['view']; ?>"><?php echo $news['title']; ?></a>
							</h4>
						</div>
						<div class="post-entry hidden">
							<p><?php echo $news['description']; ?></p>
						</div>
						<div class="post-more-link font-alt">
							<a href="<?php echo $news['view']; ?>"><?php echo $text_view; ?></a>
						</div>
					</div>
				</div>
				<!-- /POST -->
				<?php } ?>
			<?php } ?>
      	</div>
          <!-- PAGINATION -->
          <div class="row">
            <div class="col-sm-12 text-center m-t-60">
              <?php echo $pagination; ?>
            </div>
          </div>
        <!-- /PAGINATION -->
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

