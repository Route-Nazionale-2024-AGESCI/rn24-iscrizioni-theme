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
</header>