<?php
add_filter( 'show_admin_bar', '__return_false' );

// Registrazione header main menu
function register_my_menus() {
    register_nav_menus(array(
      'header-menu' => 'Header Menu',
      'footer-menu' => 'Footer Menu',
    ));
}
add_action( 'init', 'register_my_menus' );

function rn24_support() {

  // Add support for block styles.
  add_theme_support( 'wp-block-styles' );
  add_theme_support(
      'html5',
      array(
          'comment-form',
          'comment-list',
          'gallery',
          'caption',
          'style',
          'script',
          'navigation-widgets',
      )
  );
}
add_action( 'after_setup_theme', 'rn24_support' );

/**
* Abilita le zone dedicate ai widgets
*/
function rn24_widgets_init() {
register_sidebar(
  array(
    'name'          => esc_html__( 'Banner Evento', 'rn24' ),
    'id'            => 'banner_evento',
    'description'   => esc_html__( 'Aggiunti i widget da mostrare in testa agli eventi', 'rn24' ),
    'before_widget' => '<section id="%1$s" class="widget banner-widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  )
);
}
add_action( 'widgets_init', 'rn24_widgets_init' );