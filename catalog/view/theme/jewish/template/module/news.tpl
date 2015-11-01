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
	                <div class="widget-posts-title">
	                 <a href="<?php echo $news['view']; ?>"><?php echo $news['title']; ?></a>
	                </div>
	                <div class="widget-posts-meta">
	                  <?php echo $news['date_added']; ?>
	                </div>
	              </div>
	            </li>
		  <?php } ?>
	</ul>
</div>
<!-- /WIDGET -->