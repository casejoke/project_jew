
<?php echo $header; ?>
<!-- HERO -->
<section class="module module-parallax bg-dark" data-background="<?php echo $hero_image; ?>"></section>
<!-- /HERO -->

<!-- SINGLE POST -->
<section class="module">
  <div class="container">
    <div class="row">
      <!-- CONTENT -->
     <?php if ($column_right) { ?>
      <?php $class = 'col-sm-8 col-md-9'; ?>
      <?php } else { ?>
      <?php $class = 'col-sm-12'; ?>
      <?php } ?>
      <div class="<?php echo $class; ?>">
        
        <article class="post post-single">
          <?php echo $content_top; ?>
          <!-- HEADER -->
              <div class="post-header">
                <h1 class="post-title font-alt">
                  <?php echo $heading_title; ?>
                </h1>
              </div>
              <!-- /HEADER -->
           <!-- POST CONTENT -->
          <div class="post-entry">
            <div class="row">
              <div class="col-sm-4">
                <h4 class="font-alt"><?php echo $text_season; ?><?php echo $occasion_season['title']; ?></h4>
              </div>
              <div class="col-sm-4">
                <h4 class="font-alt"><?php echo $text_date; ?></h4>
              </div>
              <div class="col-sm-4">
                <h4 class="font-alt"><?php echo $text_metro; ?><?php echo $occasion_place['metro_title']; ?></h4>
              </div>
              <div class="col-sm-4">
                <h4 class="font-alt"><?php echo $text_format_group; ?><?php echo $current_occasion_group; ?></h4>
              </div>
              
            </div>
            <hr class="divider m-b-30">
          </div>
            <!-- /POST CONTENT -->
          <?php if (!empty($occasion['videos'])) { ?>
          <!-- MEDIA -->
          <div class="post-media">
          <h4 class="font-alt">Видеоотчет</h4>
            <div class="video-images">  
              <?php foreach ($occasion['videos'] as $occasion_place_video) { ?>
                
              <iframe width="950" height="480" src="<?php echo $occasion_place_video['link'].'?rel=0'; ?>" frameborder="0" allowfullscreen></iframe>
              <?php } ?>
            </div>
          </div>
          <!-- /MEDIA -->
          <?php } ?>
          <?php if (!empty($occasion['images'])) { ?>
          <!-- MEDIA -->
          <div class="post-media">
          <h4 class="font-alt">Фотоотчет</h4>
            <div class="owl-carousel slider-images">  
              <?php foreach ($occasion['images'] as $occasion_place_image) { ?>
                <div class="item">    
                  <img alt="" src="<?php echo $occasion_place_image['image']; ?>"> 
                </div>
              <?php } ?>
            </div>
          </div>
          <!-- /MEDIA -->
          <?php } ?>
          <div class="post-media">
            <h4 class="font-alt">Комментарии</h4>
            <!-- Put this script tag to the <head> of your page -->
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>

            <script type="text/javascript">
              VK.init({apiId: 5042571, onlyWidgets: true});
            </script>

            <!-- Put this div tag to the place, where the Comments block will be -->
            <div id="vk_comments"></div>
            <script type="text/javascript">
            VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*"});
            </script>
          </div>
        </article>

        </div>
      <?php if ($column_right) { ?>
      <div class="col-xs-12 col-sm-4 col-md-3 m-t-sm-60">
        <?php echo $column_right; ?>
      </div>
      <?php } ?>
    </div>
  </div>
</section>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>