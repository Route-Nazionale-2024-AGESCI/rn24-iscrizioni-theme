<!DOCTYPE html>
<html lang="it" class="h-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo get_bloginfo('name'); ?></title>
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/style.css">
  <?php wp_head(); ?>
</head>
<body class="d-flex flex-column h-100">

<header>
  <nav class="navbar navbar-expand-lg main-navbar">
    <div class="container">
    <a class="navbar-brand smallest" target="_blank" href="https://www.agesci.it">
              <img src="<?php echo get_bloginfo('template_directory'); ?>/img/logo-Agesci-bianco.png" 
                class="agesci-link" alt="AGESCI">
            </a>
    </div>

  </nav>
  <nav class="navbar navbar-expand-lg sub-navbar navbar-light">
    <div class="container">
      <a class="navbar-brand" href="<?php echo get_bloginfo( 'wpurl' ); ?>">
        <img src="<?php echo get_bloginfo('template_directory'); ?>/img/logo_rn24.png" class="rn-logo" alt="Logo RN24">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <?php if (has_nav_menu('header-menu')) {
              wp_nav_menu(array('theme_location' => 'header-menu'));
            } ?>
        </ul>
      </div>
    </div><!-- .container -->
  </nav>
</header>