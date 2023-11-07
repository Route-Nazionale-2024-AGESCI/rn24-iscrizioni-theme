<?php require_once('include/header-commons.php'); ?>
<body class="d-flex flex-column h-100 <?php body_class(); ?>">

<header>
  <nav class="navbar navbar-expand-lg main-navbar">
    <div class="container">
      <div class="navbar-left">
      <a class="navbar-brand smallest" target="_blank" href="https://www.agesci.it">
              <img src="<?php echo get_bloginfo('template_directory'); ?>/img/logo-Agesci-bianco.png" 
                class="agesci-link" alt="AGESCI">
            </a>
            <?php global $current_user;
                      wp_get_current_user();
                      if ( is_user_logged_in() ) { ?>
                      <div class="logged-user">
                        <ul class="navbar-nav">
                          <li class="nav-item logged-user-info">
                            <span class="logged-user-name"><?php echo $current_user->display_name; ?></span>
                            <span class="logged-user-email"><?php echo $current_user->user_email; ?></span>
                          </li>
                      </ul>
                      <a class="logout-btn" href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">Logout</a>
                    </div>
                      <?php } ?> 
      </div>
            
            <span class="navbar-follow-us-links d-none d-md-block">
            <a href="https://facebook.com/agesci.routenazionale2024" target="_blank">
              <img src="<?php echo get_bloginfo('template_directory'); ?>/img/facebook-f.svg" 
                class="social-link-header" alt="Facebook RN24">
            </a>
            <a href="https://instagram.com/agesci.routenazionale2024" target="_blank">
              <img src="<?php echo get_bloginfo('template_directory'); ?>/img/instagram.svg" 
                  class="social-link-header" alt="Instagram RN24">
            </a>
          </span>
    </div>

  </nav>
  <nav class="navbar navbar-expand-lg sub-navbar navbar-light">
    <div class="container">
      <a class="navbar-brand" href="<?php echo get_bloginfo( 'wpurl' ); ?>">
        <img src="<?php echo get_bloginfo('template_directory'); ?>/img/<?php echo isset($args['logo']) ? $args['logo'] : 'logo_rn24.png';?>" class="rn-logo" alt="Logo RN24">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <?php if (has_nav_menu('header-menu')) {
            wp_nav_menu( array(
                  'theme_location'    => 'header-menu',
                  'depth'             => 2,
                  'container'         => 'div',
                  //'container_class'   => 'collapse navbar-collapse',
                  'container_id'      => 'header-menu',
                  'menu_class'        => 'nav navbar-nav',
                  'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                  'walker'            => new WP_Bootstrap_Navwalker(),
              ) );
            } ?>
          <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home mt-3 mt-md-0">
            <a class="btn btn-primary text-center text-md-left btn-iscrizioni" href="<?php echo site_url('/inizia');?>">Iscrivi la tua Co.ca.</a>
          </li>
        </ul>
      </div>
    </div><!-- .container -->
  </nav>
  <!-- Breadcrumb -->
  <!--<div class="breadcrumb">
    <div class="container">
      <?php get_breadcrumb(); ?>
    </div>
  </div>-->
</header>