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
  <!-- Styles -->
  <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Volkhov:400italic' rel='stylesheet' type='text/css'>
  <link href="catalog/view/theme/jewish/assets/css/jewish.css" rel="stylesheet">
  <?php foreach ($styles as $style) { ?>
    <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
  <?php } ?>
<?php echo $google_analytics; ?>
  <script type="text/javascript">
    var mobile = false;
  </script>
</head>
<body class="<?php echo $class; ?>">
  <div class="page-loader"><!-- preloader -->
    <div class="loader">Loading...</div>
  </div><!-- /.preloader -->
  <!-- Navigation start -->
  <nav class="navbar navbar-custom navbar-transparent navbar-fixed-top" role="navigation">
    <div class="container">
  
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#custom-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <?php if ($logo) { ?>
          <a class="navbar-brand" href="<?php echo $home; ?>">
            <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"/>
          </a>
        <?php } ?>
      </div>
  
      <div class="collapse navbar-collapse" id="custom-collapse">
  
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/"><?php echo $text_announcement; ?></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $text_about_us; ?></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="<?php echo $about_us;?>"><?php echo $text_about; ?></a></li>
              <li><a href="partners-list"><?php echo $text_partners; ?></a></li>
              <li><a href="<?php echo $news;?>"><?php echo $text_news; ?></a></li>
              <li><a href="/"><?php echo $text_faq; ?></a></li>
              <li class="hidden"><a href="#"><?php echo $text_materials; ?></a></li>
              
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $text_people; ?></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="<?php echo $init_groups; ?>"><?php echo $text_init_groups; ?></a></li>
              <li><a href="<?php echo $customers; ?>"><?php echo $text_customers; ?></a></li>
            </ul>
          </li>
          <li><a href="<?php echo $projects; ?>"><?php echo $text_projects; ?></a></li>
          <li><a href="<?php echo $contests; ?>"><?php echo $text_contest; ?></a></li>
         
          

          
    
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-search"></i>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li>
                <div class="dropdown-search">
                  <form role="form" action="/">
                    <input type="text" class="form-control" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                  </form>
                </div>
              </li>
            </ul>
          </li>
  
          <li class="dropdown hidden">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">English</a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">English</a></li>
              <li><a href="#">Germany</a></li>
            </ul>
          </li>

          <?php if ($logged) { ?>
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
          <?php } else { ?>
          <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
          <li><a  href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
          <?php } ?>
  
        </ul>
      </div>
  
    </div>

  </nav>
  <!-- Navigation end -->
  <!-- Wrapper start -->
  <div class="main">