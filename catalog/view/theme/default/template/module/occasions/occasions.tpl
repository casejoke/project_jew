<?php if (!empty($occasions)) { ?>
<div class="">
	<h5 class="widget-title font-alt"><?php echo $heading_title; ?></h5>
	<!-- TABS -->
<div role="tabpanel">
	<?php if ($occasion_groups) { ?>
	<?php $first = true; ?>
	<?php $isset_tab = false; ?>
	<ul class="nav nav-tabs font-alt" role="tablist">
		<?php foreach ($occasion_groups as $occasion_group) { ?>
			<?php if (!empty($occasions)) { ?>
				<?php foreach ($occasions as $occasion) { ?>
					<?php if($occasion['occasion_group_id'] == $occasion_group['occasion_group_id']) { ?>
						<?php $isset_tab = true; ?>
						<?php break; ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<?php if ($isset_tab) { ?>
				<li class="<?php if ( $first ) { echo 'active'; };?>"><a href="#occasion_group_<?php echo $occasion_group['occasion_group_id'];?>" data-toggle="tab"><?php echo $occasion_group['occasion_title'];?></a></li>
				<?php $isset_tab = false; ?>	
			<?php } ?>
			<?php $first = false; ?>
		<?php } ?>
		
	</ul>
	<div class="tab-content">
		<?php $first = true; ?>
		<?php foreach ($occasion_groups as $occasion_group) { ?>
			<div class="tab-pane <?php if ( $first ) { echo 'active'; };?> " id="occasion_group_<?php echo $occasion_group['occasion_group_id'];?>">
				<div class="row multi-columns-row">
				<?php if (!empty($occasions)) { ?>
					<?php $i = 1; ?>
					<?php foreach ($occasions as $occasion) { ?>
						<?php if($occasion['occasion_group_id'] == $occasion_group['occasion_group_id']) { ?>
						<!-- OCCASION-TABLE -->
							<?php if ($i == 4) { ?>
							<div class="col-sm-6 hidden-md col-lg-3">
							<?php } else { ?>
							<div class="col-sm-6 col-md-4 col-lg-3">
							<?php } ?>
								<div class="price-table font-alt <?php if($occasion['isset_best_price']){ ?>best<?php } ?>">
									<p class="small"><?php echo $occasion['occasion_date']; ?></p>
									<h4><?php echo $occasion['occasion_date_day']; ?></h4>
									<p class="small"><?php echo $occasion['occasion_time']; ?></p>
									<?php if($occasion['isset_best_price']){ ?><p class="small text-danger"><?php echo $text_best_price; ?></p><?php } ?>
									<div class="borderline"></div>
									<?php if($occasion['isset_best_price']){ ?>
										<p class="price "><?php echo $occasion['best_price']; ?></p>
									<?php } else { ?>
										<p class="price"><?php echo $occasion['price']; ?></p>
									<?php }?>
									
									<ul class="price-details">
										<?php if($occasion['isset_best_price']){ ?>
											<li class="text-danger"><span class="text-danger"><?php echo $occasion['price']; ?></span></li>
										<?php } ?>
										<li class="metro"><small><?php echo $text_metro; ?>:</small> <?php echo $metro_results[$places[$occasion['occasion_place_id']]['place_metro_id']]['metro_title'] ?></li>
										<li class="place"><small><?php echo $text_place; ?>:</small>&nbsp;<a href="<?php echo $places[$occasion['occasion_place_id']]['place_href']; ?>"><span><?php echo $places[$occasion['occasion_place_id']]['place_title']; ?></span></a></li>
									</ul>
									<a href="<?php echo $occasion['href']; ?>" class="btn btn-info btn-round"><?php echo $button_play; ?></a>
								</div>
							</div>
							<!-- /OCCASION-TABLE -->
							<?php if ($i == 4) { break;} ?>
							<?php $i++; ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				
				</div>	
			</div>
		<?php $first = false; ?>
		<?php } ?>

	</div>
	<?php } ?>
</div>
<h5 class="text-right widget-title font-alt"><a href="<?php echo $href_list_occasions; ?>"><span><?php echo $text_list_occasions; ?></span></a></h5>
<!-- /TABS -->
</div>
<?php } ?>