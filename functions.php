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


function load_jquery() {
    if ( ! wp_script_is( 'jquery', 'enqueued' )) {
        wp_enqueue_script( 'jquery' );
    }
}
add_action( 'wp_enqueue_scripts', 'load_jquery' );

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
	  if (isset($_GET['redirect_to'])) {
		$login_url = esc_url( add_query_arg( 'on_success', $_GET['redirect_to'], home_url( '/login' ) ) );
	  }
	  wp_redirect($login_url);
      exit;
  }
}
add_action('init', 'rn24_redirect_login_page');

/**
 * Custom login page form
 * 
 */
function rn24_wp_login_form($args = array()) {
	$redirect_url = isset($_GET['on_success']) ? $_GET['on_success'] : site_url();
 	$defaults = array(
		'echo'           => true,
		'redirect'       => $redirect_url,
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
			esc_url( $redirect_url )
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
 * Handle login failed login
 */
add_action( 'wp_login_failed', 'rn24_front_end_login_fail' );
function rn24_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];
   if ( !empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin') ) {
		if (str_contains($referrer, '?')) {
			wp_redirect( $referrer . '&error-login=true' );
			exit;
		} else {
			wp_redirect( $referrer . '?error-login=true' );
			exit;
		}
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
		'<a class="btn-link" href="%1$s"><button class="btn btn-primary">Iscrivi la tua Comunità capi</button></a>',
		esc_attr( $_atts['page_evento'] )
	);
  } else {
	return sprintf(
		'<a class="btn-link" href="%1$s"><button class="btn btn-primary">Iscrivi la tua Comunità capi</button></a>',
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
	$output = str_replace("[RN24_TITLE]", 'Registrazione', $output);
	$output = str_replace("[RN24_GRUPPO]", $groupName, $output);
	$output = str_replace("[RN24_EMAIL]", $username, $output);
	$output = str_replace("[RN24_PASSWORD]", $password, $output);
	return $output;
}

/**
 * Build template email for recover password purpose
 */
function prepare_recover_password_email($username, $groupName, $key) {
	$output = prepare_email_base('recover-password');
	$output = str_replace("[RN24_TITLE]", 'Recupera password', $output);
	$output = str_replace("[RN24_GRUPPO]", $groupName, $output);
	$output = str_replace("[RN24_EMAIL]", $username, $output);
	$output = str_replace("[RN24_RESET_KEY]", $key, $output);
	return $output;
}


/**
 * Disable WordPress sends email for password update
 */
add_filter( 'send_password_change_email', '__return_false' );
add_filter( 'send_email_change_email', '__return_false' );
add_filter( 'wp_send_new_user_notification_to_user', '__return_false' );
add_filter( 'wp_send_new_user_notification_to_admin', '__return_false' );

// Our custom post type function
function create_rn24_timeline_post_type() {
    register_post_type( 'timeline',
        array(
            'labels' => array(
                'name' => __( 'Eventi percorso' ),
                'singular_name' => __( 'Evento percorso' )
            ),
            'public' => true,
            'has_archive' => true,
			'menu_icon' => 'dashicons-calendar',
            'rewrite' => array('slug' => 'timeline'),
            'show_in_rest' => true,
			'menu_position' => 6,
			'supports' => array( 
				'title', 
				'editor', 
				'thumbnail', 
				'custom-fields', 
				'revisions',
				'excerpt'
			  )
        )
    );

}
add_action( 'init', 'create_rn24_timeline_post_type' );
add_theme_support('post-thumbnails');
add_theme_support( 'title-tag' );


function create_rn24_box_post_type() {
    register_post_type( 'box',
        array(
            'labels' => array(
                'name' => __( 'Scatole' ),
                'singular_name' => __( 'Scatola' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'box'),
            'show_in_rest' => true,
			'menu_position' => 5,
			'menu_icon' => 'dashicons-archive',
			'supports' => array( 
				'title', 
				'editor', 
				'thumbnail', 
				'custom-fields', 
				'revisions',
				'excerpt'
			  )
        )
    );

}
add_action( 'init', 'create_rn24_box_post_type' );

flush_rewrite_rules( false );

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_template_directory() . '/include/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );

/**
 * Generate breadcrumbs
 * @author CodexWorld
 * @authorURL www.codexworld.com
 */
function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;&gt;&nbsp;&nbsp;";
        the_category(' &bull; ');
            if (is_single()) {
                echo " &nbsp;&nbsp;&gt;&nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;&gt;&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;&gt;&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}


function get_italy_map() {
	return  file_get_contents(get_template_directory()."/img/italy.svg");
}

function rn24_get_zones($region) {
    $zones = array();
    foreach (rn24_get_groups() as $data) {
        if (strtoupper($data['Regione']) === strtoupper($region) && !in_array($data['zona'], $zones)) {
            array_push($zones, $data['zona']);
        }
    }
    return $zones;
}

function rn24_select_zones() {
    $region = stripslashes(isset($_POST['region']) ? strtoupper($_POST['region']) : '');
    $zones = rn24_get_zones($region);
	sort($zones);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($zones);
    wp_die();
}

add_action( 'wp_ajax_nopriv_rn24_select_zones', 'rn24_select_zones' );
add_action( 'wp_ajax_rn24_select_zones', 'rn24_select_zones' );

/**
 * FAQ
 */
function create_rn24_faq_post_type() {
    register_post_type( 'faq',
        array(
            'labels' => array(
                'name' => __( 'FAQ' ),
                'singular_name' => __( 'FAQ' )
            ),
            'public' => true,
            'has_archive' => true,
			'menu_icon' => 'dashicons-megaphone',
            'rewrite' => array('slug' => 'faq'),
            'show_in_rest' => true,
			'menu_position' => 7,
			'supports' => array( 
				'title', 
				'editor', 
				'thumbnail', 
				'custom-fields', 
				'revisions',
				'excerpt'
			  )
        )
    );

}
add_action( 'init', 'create_rn24_faq_post_type' );

function create_rn24_faq_taxonomy() {
    register_taxonomy(
        'faq_categories',
        'faq',
        array(
            'hierarchical' => true,
            'label' => 'Tipologia FAQ',
			'show_in_menu' => true,
			'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'faq_cat',
                'with_front' => false
            )
        )
    );
}
add_action( 'init', 'create_rn24_faq_taxonomy');