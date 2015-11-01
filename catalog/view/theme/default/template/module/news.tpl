<!-- WIDGET -->
<div class="widget">
	<h5 class="widget-title font-alt"><?php echo $heading_title; ?></h5>
	<ul class="widget-posts">
		<?php foreach ($all_news as $news) { ?>
			<li class="clearfix">
				<div class="widget-posts-image">
					<a href="<?php echo $news['view']; ?>">
						<img src="<?php echo $news['image']; ?>" alt="">
					</a>
				</div>
				<div class="widget-posts-body">
					<h6 class="widget-posts-title font-alt">
						<a href="<?php echo $news['view']; ?>"><?php echo $news['title']; ?></a>
					</h6>
					<div class="widget-posts-meta">
						<?php echo $news['date_added']; ?>
					</div>
				</div>
			</li>
		  <?php } ?>
	</ul>
	<ul class="social-icon-links socicon-round m-t-20 hidden">
										<li><a href="#" target="_blank"><i class="fa fa-vk"></i></a></li>
										<li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
										<li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
									</ul>
</div>
<!-- /WIDGET -->