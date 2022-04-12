<?php 
namespace Agcsi;

use Agcsi\CPT\Enfant;
use Agcsi\CPT\Inscription;
use Agcsi\CPT\Camp;
use Agcsi\Endpoints\CampsEndpoint;
use Agcsi\Admin\OptionPage;
use Agcsi\Helpers\EditorDisable;
use Agcsi\WcAccount\AccountParticipants;
use Agcsi\WcAccount\AccountInscriptions;
use Agcsi\WooCommerce\Cart;
use Agcsi\WooCommerce\Checkout;
use Agcsi\WooCommerce\CartIcon;


class Module {

    public static $templates = [
        'template-inscriptions.php'=>[
            'label'=>'Inscriptions',
            'url'=>AGCSI_TEMPLATES.'template-inscriptions.php'],
    ];

    public static function enqueue_scripts(){
        global $post;

        wp_enqueue_style('inscriptions', get_stylesheet_directory_uri() . '/css/inscriptions.min.css', [], '5.10.2');
        if(get_page_template_slug($post->ID) == 'template-inscriptions.php'){
            wp_enqueue_style('fullcalendar', get_stylesheet_directory_uri() . '/inscriptions/vendors/fullcalendar/main.min.css', [], '5.10.2');
            wp_enqueue_script('popper', get_stylesheet_directory_uri() . '/inscriptions/vendors/tippy/popper.js', [], '5.10.2', false);
            wp_enqueue_script('tippy', get_stylesheet_directory_uri() . '/inscriptions/vendors/tippy/tippy.js', ['popper'], '5.10.2', false);
            wp_enqueue_script('fullcalendar', get_stylesheet_directory_uri() . '/inscriptions/vendors/fullcalendar/main.min.js', ['tippy','popper'], '5.10.2', false);
            wp_enqueue_script('fullcalendar-locale-fr_CA', get_stylesheet_directory_uri() . '/inscriptions/vendors/fullcalendar/locales/fr-ca.js', ['fullcalendar'], '5.10.2', false);
            wp_enqueue_script('inscriptions', get_stylesheet_directory_uri() . '/js/inscriptions.min.js', [], '5.10.2', false);
        }

        if(get_post_type($post->ID) === 'camps'){
            wp_enqueue_script('popper', get_stylesheet_directory_uri() . '/inscriptions/vendors/tippy/popper.js', [], '5.10.2', false);
            wp_enqueue_script('tippy', get_stylesheet_directory_uri() . '/inscriptions/vendors/tippy/tippy.js', ['popper'], '5.10.2', false);
            wp_enqueue_style('flatpickr', get_stylesheet_directory_uri() . '/inscriptions/vendors/flatpickr/flatpickr.min.css', [], '5.10.2');
            wp_enqueue_script('flatpickr', get_stylesheet_directory_uri() . '/inscriptions/vendors/flatpickr/flatpickr.min.js', [], '5.10.2', false);
            wp_enqueue_script('camps', get_stylesheet_directory_uri() . '/js/camps.min.js', ['wp-api-fetch'], '5.10.2', false);
        }
    }

    public static function register_templates($templates){
        foreach(self::$templates as $key=>$data){
            $templates[$key] = $data['label'];
        }
        return $templates;
    }

    public static function template_hierarchy_override($template,$type){
        $id = get_queried_object_id();
        $template_slug = get_page_template_slug();

        if(in_array($template_slug, array_keys(self::$templates))){
            return self::$templates[$template_slug]['url'];
        }
        
        if($type == 'single' && get_post_type($id) == 'camps' ){
            return AGCSI_TEMPLATES.'single-camps.php';
        }

    
        return $template;
    }

    public static function init(){

        Enfant::register_post_type();
        Inscription::register_post_type();
        Camp::register_post_type();

        CampsEndpoint::register();

        OptionPage::register();

        EditorDisable::by_template_slug('template-inscriptions.php');

        AccountParticipants::register();
        AccountInscriptions::register();
        
        Cart::register();
        Checkout::register();
        CartIcon::register();

        add_filter( 'theme_templates', __NAMESPACE__.'\Module::register_templates',1,10 );
        add_filter( 'page_template', __NAMESPACE__.'\Module::template_hierarchy_override',2,10 );
        add_filter( 'single_template', __NAMESPACE__.'\Module::template_hierarchy_override',2,10 );
        add_action('wp_enqueue_scripts', __NAMESPACE__.'\Module::enqueue_scripts', 11);
    }

}
