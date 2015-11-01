
<?php echo $header; ?>
<!-- HERO -->
<section class="module module-parallax bg-dark" data-background="<?php echo $hero_image; ?>"></section>
<!-- /HERO -->

<!-- SINGLE POST -->
<section class="module">
  <div class="container">
    <div class="row">
      <!-- CONTENT -->
      <?php if ($column_left) { ?>
        <div class="col-xs-12 col-sm-4 col-md-3">
          <?php echo $column_left; ?>
        </div>
      <?php } ?>
      <?php if ($column_left) { ?>
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
              <h4 class="font-alt"><?php echo $text_price; ?></h4>
            </div>
            <div class="col-sm-4">
              <h4 class="font-alt"><?php echo $text_format_group; ?><?php echo $current_occasion_group; ?></h4>
            </div>
            
          </div>
          <hr class="divider m-b-30">
          <h4 class="font-alt"><?php echo $text_description_heading; ?></h4>
            <?php echo $description; ?>
            
           </div>
            <!-- /POST CONTENT -->
           
           <!-- MEDIA -->
          <div class="post-media">
            <h4 class="font-alt"><?php echo $text_address_place; ?></h4>
            <h6 class="font-alt"><?php echo $occasion_place_address; ?></h6>
            <div class="map-wrap">
              <div class="map" id="map"></div>
            </div>
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaRnViczXcD1ZBzwxCLH-yHMRuWzJR-54&sensor=false"></script>
            <script type="text/javascript">
              var map = {
                  init:function(){
                    $('.map-wrap').height($(window).height() * 0.35);
                    /* ---------------------------------------------- /*
                     * Google Map
                    /* ---------------------------------------------- */
                    var mapOptions = {
                        zoom: 14,
                        center: new google.maps.LatLng(<?php echo $occasion_place['latitude_longitude']; ?>), 
                        streetViewControl : false,
                        overviewMapControl: false,
                        mapTypeControl: false,
                        zoomControl : false,
                        panControl : false,
                        scrollwheel: false,
                        styles: [{"stylers":[{"visibility":"simplified"},{"saturation":20},{"weight":3.2},{"lightness":25}]}]
                    };

                    // Get the HTML DOM element that will contain your map 
                    // We are using a div with id="map" seen below in the <body>
                    var mapElement = document.getElementById('map');

                    // Create the Google Map using our element and options defined above
                    var _map = new google.maps.Map(mapElement, mapOptions);
                    var image = new google.maps.MarkerImage('catalog/view/theme/default/assets/images/apple-touch-icon.png',
                      new google.maps.Size(57, 57),
                      new google.maps.Point(0, 0),
                      new google.maps.Point(57, 57)
                    );
                    // Let's also add a marker while we're at it
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(<?php echo $occasion_place['latitude_longitude']; ?>),
                        icon: image,
                        map: _map,
                        title: 'D1GITABLE'
                    });
                  }
                };
                $(document).ready(function() {
                  map.init();
                });
            </script>
          </div>
          <!-- /MEDIA --> 
          <?php if (!empty($occasion_place['images'])) { ?>
          <!-- MEDIA -->
          <div class="post-media">
          <h4 class="font-alt"><?php echo $text_photo_place; ?></h4>
            <div class="owl-carousel slider-images">  
              <?php foreach ($occasion_place['images'] as $occasion_place_image) { ?>
                <div class="item">    
                  <img alt="" src="<?php echo $occasion_place_image['image']; ?>"> 
                </div>
              <?php } ?>
            </div>
          </div>
          <!-- /MEDIA -->
          <?php } ?>
          <div class="post-entry">
            <h4 class="font-alt"><?php echo $text_description_place; ?></h4>
            <?php echo $occasion_place_description; ?>
          </div>
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
    </div>
  </div>
</section>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>