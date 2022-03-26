<?php 
namespace Agcsi\Admin;

class OptionPage {

    public static function add_menu_item(){
        add_menu_page(
            'Page d\'options',
            'Options camps',
            'manage_options',
            'page-options-agcsi',
            __NAMESPACE__.'\OptionPage::page_content',
            'dashicons-admin-generic',
            3
        );
    }

    public static function add_settings() {
        add_settings_section(
            'section_options_generales_agcsi',
            'Options générales',
            null,
            'page-options-agcsi'
        );
    
        add_settings_field(
            'note_sous_calendrier',
            'Note affichée sous le calendrier dans la page inscriptions',
            __NAMESPACE__.'\OptionPage::setting_note_calendrier',
            'page-options-agcsi',
            'section_options_generales_agcsi'
        );
        register_setting( 'page-options-agcsi', 'note_sous_calendrier' );
    }

    public static function page_content() {
        include(AGCSI_TEMPLATES.'admin/options-form.php');
    }

    public static function setting_note_calendrier() {
        wp_editor( get_option( 'note_sous_calendrier' ), 'note_sous_calendrier', $settings = array('textarea_name'=>'note_sous_calendrier') );
    }

    public static function register(){
        add_action( 'admin_menu', __NAMESPACE__.'\OptionPage::add_menu_item' );
        add_action( 'admin_init', __NAMESPACE__.'\OptionPage::add_settings' );
    }

}

