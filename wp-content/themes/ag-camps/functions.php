<?php

include __DIR__.'/inscriptions/core.php';

/**
 * Set les couleurs du thème dans gutenberg et désactive les options superflu.
 *
 */
function setup_theme_color() {
    add_theme_support('editor-gradient-presets', array());
    add_theme_support('disable-custom-gradients');
    add_theme_support('disable-custom-font-sizes');
    add_theme_support('editor-font-sizes', array());
    // Editor Color Palette
    add_theme_support('editor-color-palette', [
        ['name' => __('Color 1', 'theme-client'), 'slug' => 'color-1', 'color' => '#ce4141'],
        ['name' => __('Color 2', 'theme-client'), 'slug' => 'color-2', 'color' => '#212121'],
        ['name' => __('Color 3', 'theme-client'), 'slug' => 'color-3', 'color' => '#363636'],
        ['name' => __('Color 4', 'theme-client'), 'slug' => 'color-4', 'color' => '#fff'],
        ['name' => __('Color 5', 'theme-client'), 'slug' => 'color-5', 'color' => '#000'],
    ]);
}
add_action('after_setup_theme', 'setup_theme_color', 100);

/**
 * Enqueue les scripts et styles du thème.
 *
 * @todo merge 'theme-client-navigation' & 'theme-client-skip-link-focus-fix'
 * @hooked wp_enqueue_scripts
 */
function theme_client_scripts() {
    wp_enqueue_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '4.1.1');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap', array(), null);
    wp_enqueue_style('theme-client-style', get_stylesheet_directory_uri() . '/css/style.min.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_script("main-script", get_stylesheet_directory_uri() . '/js/script.min.js', array('jquery', 'theme-utils'), wp_get_theme()->get('Version'), true);
    wp_enqueue_script("theme-utils", get_stylesheet_directory_uri() . '/js/utils.min.js', array('jquery'), wp_get_theme()->get('Version'), false);
}
add_action('wp_enqueue_scripts', 'theme_client_scripts', 11);

/**
 * theme-client functions et definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @hooked after_setup_theme
 * @package theme-client
 */
if (!function_exists('theme_client_setup')):
    function theme_client_setup() {
        add_theme_support('post-thumbnails');
        register_nav_menus(['menu-1' => esc_html__('Primary', 'theme-client')]);
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ]);
        add_theme_support('align-wide');
    }
endif;
add_action('after_setup_theme', 'theme_client_setup');

/**
 * Ajoute un fichier pour modifier gutenberg
 */

function gutenberg_theme_client_enqueue_block_editor_assets() {
    wp_enqueue_script('gutenberg_addons', get_stylesheet_directory_uri() . '/js/gutenberg_options/add_margin_col.min.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), '1.0.0', true);
    wp_enqueue_script('gutenberg_addons_paralax_banner', get_stylesheet_directory_uri() . '/js/gutenberg_options/add_paralax_banner.min.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), '1.0.0', true);
    wp_enqueue_script('gutenberg_addons_bg_col_logo', get_stylesheet_directory_uri() . '/js/gutenberg_options/add_bg_logo_col.min.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), '1.0.0', true);
    wp_enqueue_script('add-animation-heading', get_stylesheet_directory_uri() . '/js/gutenberg_options/animation-heading.min.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), '1.0.0', true);
    wp_enqueue_script('add-animation-paragraphe', get_stylesheet_directory_uri() . '/js/gutenberg_options/animation-paragraphe.min.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), '1.0.0', true);
    wp_enqueue_script('add-animation-col', get_stylesheet_directory_uri() . '/js/gutenberg_options/animation-col.min.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), '1.0.0', true);
}add_action('enqueue_block_editor_assets', 'gutenberg_theme_client_enqueue_block_editor_assets');