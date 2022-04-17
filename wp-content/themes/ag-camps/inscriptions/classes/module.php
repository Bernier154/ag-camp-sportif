<?php
namespace Agcsi;

use Agcsi\Admin\OptionPage;
use Agcsi\CPT\Camp;
use Agcsi\CPT\Enfant;
use Agcsi\CPT\Inscription;
use Agcsi\Endpoints\CampsEndpoint;
use Agcsi\Endpoints\CampFicheEndpoint;
use Agcsi\Helpers\EditorDisable;
use Agcsi\WcAccount\AccountInscriptions;
use Agcsi\WcAccount\AccountParticipants;
use Agcsi\WcAccount\AccountParent;
use Agcsi\WooCommerce\Cart;
use Agcsi\WooCommerce\CartIcon;
use Agcsi\WooCommerce\Checkout;
use Agcsi\WooCommerce\MyAccount;

class Module {

    public static $templates = [
        'template-inscriptions.php' => [
            'label' => 'Inscriptions',
            'url'   => AGCSI_TEMPLATES . 'template-inscriptions.php'],
    ];

    public static function enqueue_scripts() {
        global $post;
        if ($post) {
            wp_enqueue_style('inscriptions', get_stylesheet_directory_uri() . '/css/inscriptions.min.css', [], '5.10.2');
            if (get_page_template_slug($post->ID) == 'template-inscriptions.php') {
                wp_enqueue_style('fullcalendar', get_stylesheet_directory_uri() . '/inscriptions/vendors/fullcalendar/main.min.css', [], '5.10.2');
                wp_enqueue_script('popper', get_stylesheet_directory_uri() . '/inscriptions/vendors/tippy/popper.js', [], '5.10.2', false);
                wp_enqueue_script('tippy', get_stylesheet_directory_uri() . '/inscriptions/vendors/tippy/tippy.js', ['popper'], '5.10.2', false);
                wp_enqueue_script('fullcalendar', get_stylesheet_directory_uri() . '/inscriptions/vendors/fullcalendar/main.min.js', ['tippy', 'popper'], '5.10.2', false);
                wp_enqueue_script('fullcalendar-locale-fr_CA', get_stylesheet_directory_uri() . '/inscriptions/vendors/fullcalendar/locales/fr-ca.js', ['fullcalendar'], '5.10.2', false);
                wp_enqueue_script('inscriptions', get_stylesheet_directory_uri() . '/js/inscriptions.min.js', [], '5.10.2', false);
                wp_localize_script( 'inscriptions', 'siteData', array( 'home_url' => home_url('/')));

            }

            if (get_post_type($post->ID) === 'camps') {
                wp_enqueue_script('popper', get_stylesheet_directory_uri() . '/inscriptions/vendors/tippy/popper.js', [], '5.10.2', false);
                wp_enqueue_script('tippy', get_stylesheet_directory_uri() . '/inscriptions/vendors/tippy/tippy.js', ['popper'], '5.10.2', false);
                wp_enqueue_style('flatpickr', get_stylesheet_directory_uri() . '/inscriptions/vendors/flatpickr/flatpickr.min.css', [], '5.10.2');
                wp_enqueue_script('flatpickr-fr', get_stylesheet_directory_uri() . '/inscriptions/vendors/flatpickr/fr.js', ['flatpickr'], '5.10.2', false);
                wp_enqueue_script('flatpickr', get_stylesheet_directory_uri() . '/inscriptions/vendors/flatpickr/flatpickr.min.js', [], '5.10.2', false);
                wp_enqueue_script('camps', get_stylesheet_directory_uri() . '/js/camps.min.js', ['wp-api-fetch'], '5.10.2', false);
                wp_enqueue_script('google-map-api', 'https://maps.googleapis.com/maps/api/js?key='.GOOGLE_MAP_API, ['wp-api-fetch'], '5.10.2', false);

            }
        }
    }

    public static function enqueue_admin_scripts() {
        wp_enqueue_style('meta-camps', get_stylesheet_directory_uri() . '/css/meta-camp.min.css', [], '1.0.0');
    }

    public static function register_templates($templates) {
        foreach (self::$templates as $key => $data) {
            $templates[$key] = $data['label'];
        }
        return $templates;
    }

    public static function template_hierarchy_override($template, $type) {
        $id            = get_queried_object_id();
        $template_slug = get_page_template_slug();

        if (in_array($template_slug, array_keys(self::$templates))) {
            return self::$templates[$template_slug]['url'];
        }

        if ($type == 'single' && get_post_type($id) == 'camps') {
            return AGCSI_TEMPLATES . 'single-camps.php';
        }

        if ($type == 'single' && get_post_type($id) == 'inscriptions') {
            return AGCSI_TEMPLATES . 'single-inscription.php';
        }

        return $template;
    }

    public static function init() {

        Enfant::register_post_type();
        Inscription::register_post_type();
        Camp::register_post_type();

        CampsEndpoint::register();
        CampFicheEndpoint::register();

        OptionPage::register();

        EditorDisable::by_template_slug('template-inscriptions.php');

        AccountParticipants::register();
        AccountInscriptions::register();
        AccountParent::register();

        Cart::register();
        Checkout::register();
        CartIcon::register();
        MyAccount::register();

        add_filter('theme_templates', __NAMESPACE__ . '\Module::register_templates', 1, 10);
        add_filter('page_template', __NAMESPACE__ . '\Module::template_hierarchy_override', 2, 10);
        add_filter('single_template', __NAMESPACE__ . '\Module::template_hierarchy_override', 2, 10);
        add_action('wp_enqueue_scripts', __NAMESPACE__ . '\Module::enqueue_scripts', 11);
        add_action('admin_enqueue_scripts', __NAMESPACE__ . '\Module::enqueue_admin_scripts', 11);
    }

}
