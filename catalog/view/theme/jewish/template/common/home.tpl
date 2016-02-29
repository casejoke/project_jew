<?php echo $header; ?>
  <!-- Header section start -->
  <div class="module module--hero module--parallax" data-background="image/catalog/default/home_banner/banner_1.jpg">
    <div class="container">
      <div class="row module-heading module-heading--text-light">
        <div class="col-sm-6 col-sm-offset-3 mt-60">
          <h1 class="module-heading__module-title font-alt text-center">Jewish Grassroots</h1>
          <h3 class="module-heading__module-subtitle font-serif text-center mb-0">
            Платформа поддержки развития еврейских сообществ
          </h3>
        </div>
      </div><!-- .row -->
    </div>
  </div>
  <!-- Header section end -->
  
  <!-- About start -->
    <section class="module hidden">
      <div class="container">

        <div class="row">

          <div class="col-sm-6">

            <h5 class="font-alt">We’re a digital creative agency</h5>
            <br>
            <p>The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words.</p>
            <p>The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary.</p>

          </div>

          <div class="col-sm-6">

            <h6 class="font-alt"><span class="icon-tools-2"></span> Development</h6>
            <div class="progress">
              <div class="progress-bar pb-dark" aria-valuenow="60" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <span class="font-alt"></span>
              </div>
            </div>

            <h6 class="font-alt"><span class="icon-strategy"></span> Branding</h6>
            <div class="progress">
              <div class="progress-bar pb-dark" aria-valuenow="80" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <span class="font-alt"></span>
              </div>
            </div>

            <h6 class="font-alt"><span class="icon-target"></span> Marketing</h6>
            <div class="progress">
              <div class="progress-bar pb-dark" aria-valuenow="50" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <span class="font-alt"></span>
              </div>
            </div>

            <h6 class="font-alt"><span class="icon-camera"></span> Photography</h6>
            <div class="progress">
              <div class="progress-bar pb-dark" aria-valuenow="90" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <span class="font-alt"></span>
              </div>
            </div>

          </div>

        </div><!-- .row -->

      </div>
    </section>
    <!-- About end -->
    <!-- Divider -->
    <hr class="divider-w">
    <!-- Divider -->
    
    <section id="news" class="module module--small">
      <div class="container">

        <div class="row">

          <div class="col-sm-6 col-sm-offset-3">

            <h2 class="module-title font-alt">Последние новости</h2>
            <div class="module-subtitle font-serif hidden"></div>

          </div>

        </div><!-- .row -->

        <div class="row multi-columns-row post-columns">
          
          <?php foreach ($all_news as $news) { ?>
            <!-- Post item start -->
            <div class="col-sm-6 col-md-4 col-lg-4">

              <div class="post">
                <div class="post-thumbnail">
                  <a href="<?php echo $news['view']; ?>"><img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>"></a>
                </div>
                <div class="post-header font-alt">
                  <h2 class="post-title" style="min-height: 60px;"><a href="<?php echo $news['view']; ?>"><?php echo $news['title']; ?></a></h2>
                  <div class="post-meta">
                    <?php echo $news['date_added']; ?>
                  </div>
                </div>
                <div class="post-entry">
                  <p><?php echo $news['short_description']; ?></p>
                </div>
                <div class="post-more">
                  <a href="<?php echo $news['view']; ?>" class="more-link">Подробнее</a>
                </div>
              </div>

            </div>
            <!-- Post item end -->
          <?php } ?>


        </div><!-- .row -->

      </div>
    </section>

    <section class="module bg-light module--small">
      <div class="container">

        <div class="row">
          <div class="col-sm-6 col-sm-offset-3">
            <h2 class="module-title font-alt">ОРГАНИЗАТОРЫ</h2>
            <div class="module-subtitle font-serif"></div>
          </div>
        </div>
        <div class="row mb-60">
          <div class="col-sm-3">
            <img src="image/catalog/default/partners/partner_1.jpg">
          </div>
          <div class="col-sm-3">
            <img src="image/catalog/default/partners/partner_2.jpg">
          </div>
          <div class="col-sm-3">
            <img src="image/catalog/default/partners/partner_3.jpg">
          </div>
          <div class="col-sm-3">
            <img src="image/catalog/default/partners/partner_4.jpg">
          </div>
        </div><!-- .row -->

      </div>
    </section>



<?php echo $footer; ?>