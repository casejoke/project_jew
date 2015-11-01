<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Favicons -->
<link href="favicon.ico" rel="icon" />
<link rel="shortcut icon" href="favicon.ico">
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">


<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>





  <?php foreach ($scripts as $script) { ?>
    <script src="<?php echo $script; ?>" type="text/javascript"></script>
  <?php } ?>

  
  
  <?php foreach ($styles as $style) { ?>
  <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
  <?php } ?>
  
  <?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">
  
  <div class="page-loader"><!-- preloader -->
    <div class="loader">Loading...</div>
  </div><!-- /.preloader -->

  <!-- OVERLAY MENU -->
  <div id="overlay-menu" class="overlay-menu">

    <a href="#" id="overlay-menu-hide" class="navigation-hide"><i class="ion-close-round"></i></a>
    
    <div class="overlay-menu-inner">
      <nav class="overlay-menu-nav">
        <ul id="nav">
          <li><a href="/statistics" title="Статистика">Статистика</a></li>
          <li><a href="/timetable" title="Расписание">Расписание</a></li>
          <li><a href="/reports" title="Отчеты">Отчеты</a></li>
          <li><a href="/about_us" title="О нас">О нас</a></li>
          <li><a href="/news" title="Новости">Новости</a></li>
          <?php if ($logged) { ?>
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
          <?php } else { ?>
          <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
          <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
          <?php } ?>
        </ul>
      </nav>
    </div>
    
    <div class="overlay-navigation-footer">
    
      <div class="container">
    
        <div class="row">
    
          <div class="col-sm-12 text-center">
            <p class="copyright font-alt m-b-0">&copy;&nbsp;2015 footbic.ru, Все права защищены.</p>
          </div>
    
        </div>
    
      </div>
    
    </div>

  </div>
  <!-- /OVERLAY MENU -->

  <!-- WRAPPER -->
  <div class="wrapper">

    <!-- NAVIGATION -->
    <nav class="navbar navbar-custom navbar-transparent navbar-fixed-top">

      <div class="container">
      
        <div class="navbar-header">
          <!-- YOU LOGO HERE -->
            <?php if ($logo) { ?>
              <a class="navbar-brand" href="<?php echo $home; ?>">
                <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" width="140"/>
              </a>
            <?php } ?>
        </div>
       
        <!-- ICONS NAVBAR -->
        <ul id="icons-navbar" class="nav navbar-nav navbar-right">
          <li>
            <a href="#" id="toggle-menu" class="show-overlay" title="Menu">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
          </li>
        </ul>
        <!-- /ICONS NAVBAR -->
      
        <ul class="extra-navbar nav navbar-nav navbar-right">
        
          <li><a href="/statistics" title="Статистика">Статистика</a></li>
          <li><a href="/timetable" title="Расписание">Расписание</a></li>
          <li><a href="/reports" title="Отчеты">Отчеты</a></li>
          <li><a href="/about_us" title="О нас">О нас</a></li>
          <li><a href="/news" title="Новости">Новости</a></li>
          <?php if ($logged) { ?>
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
          <?php } else { ?>
          <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
          <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
          <?php } ?>
        </ul>
      
      </div>

    </nav>
    <!-- /NAVIGATION -->


