<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<script type="text/javascript">
    var route = '<?php echo $route; ?>';
</script>
<script type="text/javascript" src="assets/js/opencms_adm.js"></script>
<?php foreach ($scripts as $script) { ?>
  <script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<link href="assets/css/opencms_adm.css" type="text/css" rel="stylesheet" media="screen" />
<?php foreach ($styles as $style) { ?>
  <link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<?php foreach ($links as $link) { ?>
  <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
</head>

<?php if ($logged) { ?>
<body class="toggled sw-toggled">
<header id="header" >
    <ul class="header-inner">
        <li class="pull-left" id="menu-trigger" data-trigger="#sidebar">
            <div class="line-wrap">
                <div class="line top"></div>
                <div class="line center"></div>
                <div class="line bottom"></div>
            </div>
        </li>
            
        <li class="pull-left logo hidden-xs">
            <a href="<?php echo $home;?>">OpenCMS <?php echo $text_version; ?></a>
        </li>
        
        <li class="pull-right">
            <ul class="top-menu">
                <li id="toggle-width" class="hidden">
                    <div class="toggle-switch">
                        <input id="tw-switch" type="checkbox" hidden="hidden">
                        <label for="tw-switch" class="ts-helper"></label>
                    </div>
                </li>

                <li id="top-search" class="hidden">
                    <a class="tm-search" href=""></a>
                </li>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="tm-settings" href=""></a>
                    <ul class="dropdown-menu dm-icon pull-right">
                        <?php foreach ($stores as $store) { ?>
                        <li><a href="<?php echo $store['href']; ?>" target="_blank"><i class="md md-remove-red-eye"></i><?php echo $store['name']; ?></a></li>
                        <?php } ?>
                        
                        <li>
                            <a href="<?php echo $logout;?> "><i class="md md-exit-to-app"></i>&nbsp;<?php echo $text_logout; ?></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Top Search Content -->
    <div id="top-search-wrap">
        <input type="text">
        <i id="top-search-close">&times;</i>
    </div>
</header>
<section id="main">
<?php } else { ?>
<body class="login-content">
<?php } ?>