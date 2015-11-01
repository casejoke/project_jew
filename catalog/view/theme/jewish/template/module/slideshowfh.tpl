<!-- HERO -->
<?php if(count($banners)>1) { ?>
<section id="hero" class="module-hero module-half-full-height">
  <div id="slideshow<?php echo $module; ?>" class="slides">
    <ul class="slides-container">
       <?php foreach ($banners as $banner) { ?>
        <li class="bg-dark">
          <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" >
          <?php if ($banner['link']) { ?>
          <!-- HERO TEXT -->
          <div class="hero-caption">
            <div class="hero-text">
              <h1 class="font-alt m-b-50 wow fadeInDown"><?php echo $banner['title']; ?></h1>
              <h5 class="mh-line-size-5 font-alt wow fadeInDown" data-wow-delay="0.7s">Любительский футбол в Москве</h5>
            </div>
          </div>
          <!-- /HERO TEXT -->
          <?php } else{?>
          <!-- HERO TEXT -->
          <div class="hero-caption">
            <div class="hero-text">
              <h1 class="font-alt m-b-50 wow fadeInDown"><?php echo $banner['title']; ?></h1>
              <h5 class="mh-line-size-5 font-alt wow fadeInDown" data-wow-delay="0.7s">Любительский футбол в Москве </h5>
            </div>
          </div>
          <!-- /HERO TEXT -->
          <?php } ?>
        </li>
        <?php } ?>
    </ul>
    <nav class="slides-navigation">
      <a href="#" class="next"><i class="fa fa-angle-right"></i></a>
      <a href="#" class="prev"><i class="fa fa-angle-left"></i></a>
    </nav>
  </div>
</section>

<script type="text/javascript"><!--
    $('#slideshow<?php echo $module; ?>').superslides({
      play: 5000,
      animation: 'fade',
      animation_speed: 400,
      pagination: true,
      inherit_height_from: $('#hero')
    });
--></script>
<?php }else { ?>
    <!-- HERO -->
     <?php foreach ($banners as $banner) { ?>
    <section id="hero" class="module-hero module-parallax" data-background="image/catalog/default/home_banner/section-1.jpg">
      <!-- HERO TEXT -->
      <?php if ($banner['link']) { ?>
          <!-- HERO TEXT -->
          <div class="hero-caption">
            <div class="hero-text">
              <h1 class="font-alt m-b-50 wow fadeInDown"><?php echo $banner['title']; ?></h1>
              <h5 class="mh-line-size-5 font-alt wow fadeInDown" data-wow-delay="0.7s">Любительский футбол в Москве</h5>
            </div>
          </div>
          <!-- /HERO TEXT -->
          <?php } else{?>
          <!-- HERO TEXT -->
          <div class="hero-caption">
            <div class="hero-text">
              <h1 class="font-alt m-b-50 wow fadeInDown"><?php echo $banner['title']; ?></h1>
              <h5 class="mh-line-size-5 font-alt wow fadeInDown" data-wow-delay="0.7s">Любительский футбол в Москве </h5>
            </div>
          </div>
          <!-- /HERO TEXT -->
          <?php } ?>
      <!-- /HERO TEXT -->

    </section>
   <?php } ?>
    <!-- /HERO -->
<?php } ?>
<!-- /HERO -->