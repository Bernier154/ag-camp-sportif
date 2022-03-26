<?php 
namespace Agcsi\WcAccount;

class AccountParticipants {

    public static function add_menu_item($items){
        $nouvel_item = ['participants'   => 'Participants'];
        $nouvel_item = array_slice($items, 0, 1, true) + $nouvel_item + array_slice($items, 1, count($items), true);
        return $nouvel_item;
    }

    public static function add_endpoint_wc(){
        add_rewrite_endpoint('participants', EP_PAGES);
        add_rewrite_endpoint('participants-edition', EP_PAGES);
    }

    public static function participants_endpoint_content(){
        include(AGCSI_ROOT.'/templates/my_account/participants.php');
    }

    public static function participants_edition_endpoint_content(){
        include(AGCSI_ROOT.'/templates/my_account/participant-edit.php');
    }

    public static function register(){
        add_filter('woocommerce_account_menu_items', __NAMESPACE__.'\add_menu_item', 99, 1);
        add_filter('init', __NAMESPACE__.'\add_endpoint_wc',);
        add_action('woocommerce_account_participants_endpoint', __NAMESPACE__.'\participants_endpoint_content');
        add_action('woocommerce_account_participants-edition_endpoint', __NAMESPACE__.'\participants_edition_endpoint_content');

        if (isset($_POST['agcsi_save_enfant'])) {
            self::parse_form();
        }
        
    }

    public static function parse_form(){
        if (!isset($_POST['save_enfant_nonce']) || !wp_verify_nonce($_POST['save_enfant_nonce'], 'save_and_edit_enfant')) {
            return;
        }
        $validated = self::validate_form();
        $userid    = get_current_user_id();
    }

    public static function validate_form(){
        $validated = [
            "agcsi_enfant_id"                    => intval($_POST['agcsi_enfant_id']),
            "agcsi_enfant_prenom"                => sanitize_text_field($_POST['agcsi_enfant_prenom']),
            "agcsi_enfant_nom"                   => sanitize_text_field($_POST['agcsi_enfant_nom']),
            "agcsi_enfant_date_naissance"        => sanitize_text_field($_POST['agcsi_enfant_date_naissance']),
            "agcsi_enfant_assurance_maladie"     => sanitize_text_field($_POST['agcsi_enfant_assurance_maladie']),
            "agcsi_enfant_sport_pratique"        => sanitize_text_field($_POST['agcsi_enfant_sport_pratique']),
            "agcsi_enfant_taille_tshirt"         => sanitize_text_field($_POST['agcsi_enfant_taille_tshirt']),
            "agcsi_enfant_taille_tshirt_hockey"  => sanitize_text_field($_POST['agcsi_enfant_taille_tshirt_hockey']),
            "agcsi_enfant_autorisation_photo"    => agcsi_validate_yes_no($_POST['agcsi_enfant_autorisation_photo']),
            "agcsi_enfant_maladies"              => agcsi_validate_checkbox_array((isset($_POST['agcsi_enfant_maladie']) ? $_POST['agcsi_enfant_maladie'] : []), isset($_POST['agcsi_enfant_autre_maladie']), $_POST['agcsi_enfant_maladie_autre_data']),
            "agcsi_enfant_maladie_debut"         => sanitize_text_field($_POST['agcsi_enfant_maladie_debut']),
            "agcsi_enfant_alergie"               => agcsi_validate_yes_no($_POST['agcsi_enfant_alergie']),
            "agcsi_enfant_epipen"                => agcsi_validate_yes_no($_POST['agcsi_enfant_epipen']),
            "agcsi_enfant_vaccination"           => agcsi_validate_yes_no($_POST['agcsi_enfant_vaccination']),
            "agcsi_enfant_medicament"            => agcsi_validate_yes_no($_POST['agcsi_enfant_medicament']),
            "agcsi_enfant_medicament_detail"     => sanitize_text_field($_POST['agcsi_enfant_medicament_detail']),
            "agcsi_enfant_particularite"         => sanitize_text_field($_POST['agcsi_enfant_particularite']),
            "agcsi_enfant_autorisation_urgence"  => agcsi_validate_yes_no($_POST['agcsi_enfant_autorisation_urgence']),
            "agcsi_enfant_consent_frais_urgence" => isset($_POST['agcsi_enfant_consent_frais_urgence']),
        ];
    }
}