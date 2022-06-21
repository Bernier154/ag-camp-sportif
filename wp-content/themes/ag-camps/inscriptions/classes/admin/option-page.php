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
            'adresse_contact',
            'Adresse courriel de contact',
            __NAMESPACE__.'\OptionPage::setting_adresse_contact',
            'page-options-agcsi',
            'section_options_generales_agcsi'
        );

        add_settings_field(
            'produit_inscription',
            'Produit woocommerce vendu lors d\'une vente. Ne pas toucher.',
            __NAMESPACE__.'\OptionPage::setting_produit_inscription',
            'page-options-agcsi',
            'section_options_generales_agcsi'
        );

        add_settings_field(
            'note_sous_impression_inscription',
            'Note sous la feuille de confirmation d\'inscription',
            __NAMESPACE__.'\OptionPage::note_sous_impression_inscription',
            'page-options-agcsi',
            'section_options_generales_agcsi'
        );
    
        add_settings_field(
            'note_sous_calendrier',
            'Note affichée sous le calendrier dans la page inscriptions',
            __NAMESPACE__.'\OptionPage::setting_note_calendrier',
            'page-options-agcsi',
            'section_options_generales_agcsi'
        );

        

        register_setting( 'page-options-agcsi', 'adresse_contact' );
        register_setting( 'page-options-agcsi', 'produit_inscription' );
        register_setting( 'page-options-agcsi', 'note_sous_impression_inscription' );
        register_setting( 'page-options-agcsi', 'note_sous_calendrier' );


    }

    public static function add_rebate_settings() {

        add_settings_section(
            'section_rabais_agcsi',
            'Pourcentages de rabais',
            null,
            'page-options-agcsi'
        );

        add_settings_field( 'rabais_2_enfants','Rabais pour 2ième enfant (%)', __NAMESPACE__.'\OptionPage::setting_percentage_rebate', 'page-options-agcsi', 'section_rabais_agcsi',['field'=>'rabais_2_enfants']);
        add_settings_field( 'rabais_3_enfants','Rabais pour 3ième enfant et plus (%)', __NAMESPACE__.'\OptionPage::setting_percentage_rebate', 'page-options-agcsi', 'section_rabais_agcsi',['field'=>'rabais_3_enfants']);

        add_settings_field( 'rabais_5_jours','Rabais appliqué après 5 jours cummulé acheté (%)' , __NAMESPACE__.'\OptionPage::setting_percentage_rebate', 'page-options-agcsi', 'section_rabais_agcsi',['field'=>'rabais_5_jours']);
        add_settings_field( 'rabais_15_jours','Rabais appliqué après 15 jours cummulé acheté (%)', __NAMESPACE__.'\OptionPage::setting_percentage_rebate', 'page-options-agcsi', 'section_rabais_agcsi',['field'=>'rabais_15_jours']);
        add_settings_field( 'rabais_30_jours','Rabais appliqué après 30 jours cummulé acheté (%)', __NAMESPACE__.'\OptionPage::setting_percentage_rebate', 'page-options-agcsi', 'section_rabais_agcsi',['field'=>'rabais_30_jours']);

        register_setting( 'page-options-agcsi', 'rabais_2_enfants' );
        register_setting( 'page-options-agcsi', 'rabais_3_enfants' );

        register_setting( 'page-options-agcsi', 'rabais_5_jours' );
        register_setting( 'page-options-agcsi', 'rabais_15_jours' );
        register_setting( 'page-options-agcsi', 'rabais_30_jours' );

    }

    public static function page_content() {
        include(AGCSI_TEMPLATES.'admin/options-form.php');
    }

    public static function setting_produit_inscription() {
        ?>
        <select name="produit_inscription" id="">
            <option value=""   <?php echo get_option('produit_inscription') == null ?'selected':'' ?> >Choisir...</option>
            <?php foreach(get_posts(['post_type'=>'product','post_per_page'=>-1]) as $prod): ?>
                <option value="<?php echo $prod->ID ?>"  <?php echo get_option('produit_inscription') == $prod->ID?'selected':'' ?> ><?php  echo $prod->post_title ?></option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public static function setting_adresse_contact() {
        ?>
        <input type="email" name="adresse_contact" value="<?php echo get_option('adresse_contact') ?>" >
        <?php
    }

    public static function note_sous_impression_inscription() {
        wp_editor( get_option( 'note_sous_impression_inscription' ), 'note_sous_impression_inscription', $settings = array('textarea_name'=>'note_sous_impression_inscription') );
    }

    public static function setting_note_calendrier() {
        wp_editor( get_option( 'note_sous_calendrier' ), 'note_sous_calendrier', $settings = array('textarea_name'=>'note_sous_calendrier') );
    }

    public static function setting_percentage_rebate($args) {
        ?>
        <input type="number" name="<?php echo $args['field'] ?>" value="<?php echo get_option($args['field']) ?>" >
        <?php
    }

    public static function register(){
        add_action( 'admin_menu', __NAMESPACE__.'\OptionPage::add_menu_item' );
        add_action( 'admin_menu', __NAMESPACE__.'\OptionPage::add_rebate_settings' );
        add_action( 'admin_init', __NAMESPACE__.'\OptionPage::add_settings' );
    }

}

