<?php 
namespace Agcsi;

use Agcsi\CPT\Enfant;
use Agcsi\CPT\Inscription;
use Agcsi\CPT\Camp;
use Agcsi\Endpoints\CampsEndpoint;
use Agcsi\Admin\OptionPage;
use Agcsi\Helpers\EditorDisable;


class Module {

    public static function enqueue_scripts(){
        global $post;
        
        if(get_page_template_slug($post->ID) == 'template-inscriptions.php'){
            wp_enqueue_style('fullcalendar', get_stylesheet_directory_uri() . '/inscriptions/vendors/fullcalendar/main.min.css', [], '5.10.2');
            wp_enqueue_script('popper', get_stylesheet_directory_uri() . '/inscriptions/vendors/tippy/popper.js', [], '5.10.2', false);
            wp_enqueue_script('tippy', get_stylesheet_directory_uri() . '/inscriptions/vendors/tippy/tippy.js', ['popper'], '5.10.2', false);
            wp_enqueue_script('fullcalendar', get_stylesheet_directory_uri() . '/inscriptions/vendors/fullcalendar/main.min.js', ['tippy','popper'], '5.10.2', false);
            wp_enqueue_script('fullcalendar-locale-fr_CA', get_stylesheet_directory_uri() . '/inscriptions/vendors/fullcalendar/locales/fr-ca.js', ['fullcalendar'], '5.10.2', false);
            wp_enqueue_script('inscriptions', get_stylesheet_directory_uri() . '/js/inscriptions.min.js', [], '5.10.2', false);
        }
    }

    public static function template_hierarchy_override($template,$type){
        $pages_templates = [
            'template-inscriptions.php'=>'inscriptions/templates/template-inscriptions.php'
        ];

        return $template;
    }

    public static function init(){

        Enfant::register_post_type();
        Inscription::register_post_type();
        Camp::register_post_type();

        CampsEndpoint::register();

        OptionPage::register();

        EditorDisable::by_template_slug('template-inscriptions.php');

        add_filter( 'page_template', __NAMESPACE__.'\Module::template_hierarchy_override',2,10 );
        add_action('wp_enqueue_scripts', __NAMESPACE__.'\Module::enqueue_scripts', 11);
    }

}