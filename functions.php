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

/**
 * Custom login page
 */
function rn24_redirect_login_page() {
  $login_url  = home_url( '/login' );
  $url = basename($_SERVER['REQUEST_URI']); // get requested URL
  isset( $_REQUEST['redirect_to'] ) ? ( $url   = "wp-login.php" ): 0; // if users ssend request to wp-admin
  if( $url  == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET' && !(isset($_GET['action']) && isset($_GET['action']) == 'logout'))  {
      wp_redirect( $login_url );
      exit;
  }
}
add_action('init', 'rn24_redirect_login_page');

/**
 * Custom login page form
 * 
 */
function rn24_wp_login_form($args = array()) {
  $defaults = array(
		'echo'           => true,
		// Default 'redirect' value takes the user back to the request URI.
		'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
		'form_id'        => 'loginform',
		'label_username' => __( 'Username or Email Address' ),
		'label_password' => __( 'Password' ),
		'label_remember' => __( 'Remember Me' ),
		'label_log_in'   => __( 'Log In' ),
		'id_username'    => 'user_login',
		'id_password'    => 'user_pass',
		'id_remember'    => 'rememberme',
		'id_submit'      => 'wp-submit',
		'remember'       => true,
		'value_username' => '',
		// Set 'value_remember' to true to default the "Remember me" checkbox to checked.
		'value_remember' => false,
	);
	$args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );
  $form =
		sprintf(
			'<form name="%1$s" id="%1$s" action="%2$s" method="post">',
			esc_attr( $args['form_id'] ),
			esc_url( site_url( 'wp-login.php', 'login_post' ) )
		)
		.
		sprintf(
			'<div class="form-group login-username">
				<label for="%1$s">%2$s</label>
				<input type="text" name="log" id="%1$s" autocomplete="username" class="form-control w-100" value="%3$s" />
			</div>',
			esc_attr( $args['id_username'] ),
			esc_html( $args['label_username'] ),
			esc_attr( $args['value_username'] )
		) .
		sprintf(
			'<div class="form-group login-password">
				<label for="%1$s">%2$s</label>
				<input type="password" name="pwd" id="%1$s" autocomplete="current-password" spellcheck="false" class="form-control w-100" value=""/>
			</div>',
			esc_attr( $args['id_password'] ),
			esc_html( $args['label_password'] )
		)
		.
		sprintf(
			'<input type="hidden" name="redirect_to" value="%3$s" />
       <button type="submit" name="wp-submit" id="%1$s" class="btn btn-primary" $disabled>%2$s</button>',
			esc_attr( $args['id_submit'] ),
			esc_attr( $args['label_log_in'] ),
			esc_url( $args['redirect'] )
		)
		.
		'<a href="'.wp_lostpassword_url().'" class="lost-password-url">Hai dimenticato la password?</a>'.
		'</form>';
    if ( $args['echo'] ) {
      echo $form;
    } else {
      return $form;
    }
}

/**
 * 
 */
add_shortcode('rn24_signup_btn', 'rn24_show_signup_btn');
function rn24_show_signup_btn($atts, $content = null, $tag = '') {
	$_atts = shortcode_atts(
		array(
			'page_iscrizioni' => '/iscriviti',
      		'page_evento' => '/eventi/rn24'
		), $atts, $tag
	);
  if (is_user_logged_in()) {
	return sprintf(
		'<a class="btn-link" href="%1$s"><button class="btn btn-primary">Iscrivi la tua Comunità Capi</button></a>',
		esc_attr( $_atts['page_evento'] )
	);
  } else {
	return sprintf(
		'<a class="btn-link" href="%1$s"><button class="btn btn-primary">Iscrivi la tua Comunità Capi</button></a>',
		esc_attr( $_atts['page_iscrizioni'] )
	  );
  }
}

/**
 * Redicrect automatica alla homepage dopo il logout
 */
add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
  wp_safe_redirect( home_url() );
  exit;
}

/**
 * Pagina personalizzata per recupera password
 */
add_action( 'login_form_lostpassword', 'rn24_lost_password_page' );
function rn24_lost_password_page() {
	wp_safe_redirect(site_url( 'recupera-password' ));
	exit();
}

/**
 * Prepare RN24 registration email
 */
function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );

function prepare_email_base($template) {
	ob_start();
	include(get_template_directory().'/email/'.$template.'.email.php');
	$output = ob_get_contents();
	ob_end_clean();
	$output = str_replace("[RN24_BASE_URL]", site_url(), $output);
	$output = str_replace("[RN24_THEME_URL]", get_bloginfo('template_directory'), $output);
	return $output;
}

/**
 * Build template email for registration purpose
 */
function prepare_registration_email($username, $groupName, $password) {
	$output = prepare_email_base('registration');
	$output = str_replace("[RN24_GRUPPO]", $groupName, $output);
	$output = str_replace("[RN24_EMAIL]", $username, $output);
	$output = str_replace("[RN24_PASSWORD]", $password, $output);
	return $output;
}