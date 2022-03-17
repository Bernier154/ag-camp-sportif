<?php 

/**
 * Set les couleurs du thème dans gutenberg et désactive les options superflu.
 *
 */
function setup_theme_color() {
	add_theme_support( 'editor-gradient-presets', array() );
	add_theme_support( 'disable-custom-gradients' );
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'editor-font-sizes', array() );

	// Editor Color Palette
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Color 1', 'theme-client' ),
			'slug'  => 'color-1',
			'color'	=> '#ce4141',
		),
		array(
			'name'  => __( 'Color 2', 'theme-client' ),
			'slug'  => 'color-2',
			'color'	=> '#212121',
		),
		array(
			'name'  => __( 'Color 3', 'theme-client' ),
			'slug'  => 'color-3',
			'color' => '#363636',
		),
		array(
			'name'  => __( 'Color 4', 'theme-client' ),
			'slug'  => 'color-4',
			'color' => '#fff',
		),
		array(
			'name'  => __( 'Color 5', 'theme-client' ),
			'slug'  => 'color-5',
			'color' => '#000',
		)
	) );
}
add_action( 'after_setup_theme', 'setup_theme_color' , 100);


/**
 * Enqueue les scripts et styles du thème.
 * 
 * @todo merge 'theme-client-navigation' & 'theme-client-skip-link-focus-fix'
 * @hooked wp_enqueue_scripts
 */
function theme_client_scripts() {
	wp_enqueue_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '4.1.1');
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700;800&display=swap', array(), null);

    wp_enqueue_style('theme-client-style', get_stylesheet_directory_uri() .'/css/style.min.css', array(), wp_get_theme()->get('Version'));

	wp_enqueue_script("main-script", get_stylesheet_directory_uri() . '/js/script.min.js',  array('jquery','theme-utils'), wp_get_theme()->get('Version'), true);
	wp_enqueue_script("theme-utils", get_stylesheet_directory_uri() . '/js/utils.min.js',  array('jquery'), wp_get_theme()->get('Version'), false);

	
}


add_action('wp_enqueue_scripts', 'theme_client_scripts', 11);

function create_posttype() {
 
	$taxArgs = array(
		'hierarchical'      => true,
		'labels'            => array(
			'name' => "Semaine"
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'edition' ),
	);
	register_taxonomy( 'semaine', 'booking', $taxArgs );

	register_post_type( 'booking',
		array(
			'labels' => array(
				'name' => _x('Enfants', 'post type general name', 'theme-client'),
				'singular_name' => _x('Enfant', 'post type singular name', 'theme-client')
			),
			'public' => false,
			'exclude_from_search' =>true,
			'show_ui' => true,
			'menu_icon' => 'dashicons-admin-page',
			'show_in_rest' => true,
			'supports' => array('title')
	)
);

}
add_action('init','create_posttype');

/**
 * theme-client functions et definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @hooked after_setup_theme
 * @package theme-client
 */
if (!function_exists('theme_client_setup')) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function theme_client_setup() {

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'menu-1' => esc_html__('Primary', 'theme-client'),
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		/**
		 * Ajoute l'option de mettre les blocs fullwidth.
		 */
		add_theme_support('align-wide');
	}

endif;
add_action('after_setup_theme', 'theme_client_setup');


/**
 * Ajoute un fichier pour modifier gutenberg
 */
function gutenberg_theme_client_enqueue_block_editor_assets() {
    // Enqueue our script
    wp_enqueue_script(
        'gutenberg_addons',
		get_stylesheet_directory_uri() .'/js/gutenberg_options/add_margin_col.min.js' ,
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        '1.0.0',
        true // Enqueue the script in the footer.
	);

	wp_enqueue_script(
        'gutenberg_addons_paralax_banner',
        get_stylesheet_directory_uri() .'/js/gutenberg_options/add_paralax_banner.min.js' ,
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        '1.0.0',
        true // Enqueue the script in the footer.
	);

	wp_enqueue_script(
        'gutenberg_addons_bg_col_logo',
		get_stylesheet_directory_uri() .'/js/gutenberg_options/add_bg_logo_col.min.js' ,
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        '1.0.0',
        true // Enqueue the script in the footer.
	);

	wp_enqueue_script(
        'add-animation-heading',
        get_stylesheet_directory_uri() .'/js/gutenberg_options/animation-heading.min.js' ,
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        '1.0.0',
        true // Enqueue the script in the footer.
	);
	wp_enqueue_script(
        'add-animation-paragraphe',
        get_stylesheet_directory_uri() .'/js/gutenberg_options/animation-paragraphe.min.js' ,
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        '1.0.0',
        true // Enqueue the script in the footer.
	);
	wp_enqueue_script(
        'add-animation-col',
        get_stylesheet_directory_uri() .'/js/gutenberg_options/animation-col.min.js' ,
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        '1.0.0',
        true // Enqueue the script in the footer.
	);
		
}add_action( 'enqueue_block_editor_assets', 'gutenberg_theme_client_enqueue_block_editor_assets' );