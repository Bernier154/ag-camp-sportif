<?php 
namespace Agcsi\WcAccount;

use Agcsi\CPT\Enfant;

class AccountParticipants {
    
    /**
     * Ajoute les items participants, les enfants et les inscriptions au menu woocommerce my-account
     *
     * @param  mixed $items
     * @return void
     * @hooked woocommerce_account_menu_items
     */
    public static function add_menu_item($items){
        $nouvel_items = ['participants'   => 'Participants'];
        $enfants = Enfant::get_from_parent_ID(get_current_user_id());
        foreach($enfants as $enfant){
            $nouvel_items['participants/'.$enfant->ID] =  $enfant->prenom;
        }
        $nouvel_item = array_merge(array_slice($items, 0, 1, true),$nouvel_items,array_slice($items, 1, count($items), true));
        unset($nouvel_item['downloads']);
        return $nouvel_item;
    }
    
    /**
     * Ajoute la classe active au sous-item du menuu-item participant dans le menu my account
     *
     * @param  array $classes
     * @param  string $endpoint
     * @return array
     * @hooked woocommerce_account_menu_item_classes
     */
    public static function add_class_to_menu_items($classes,$endpoint){

        if(strpos($endpoint,'participants/') !== false){
            $classes[] = 'enfant';
            if($endpoint == 'participants/'.get_query_var( 'participants')){
                $classes[] = 'is-active';
            }
        }
        return $classes;
    }
    
    /**
     * Ajoute un url endpoint pour woocommerce wc-account
     *
     * @return void
     */
    public static function add_endpoint_wc(){
        add_rewrite_endpoint('participants', EP_PAGES);
    }
    
    /**
     * inclus les template de contenu pour les pages ajoutées au endpoint participants. 
     *
     * @return void
     * @hooked woocommerce_account_participants_endpoint
     */
    public static function participants_endpoint_content(){
        //if there is a query var, we want to show the edit form
        if(get_query_var( 'participants' ) != null || get_query_var( 'participants' ) != ""){
            $enfantID = get_query_var( 'participants' );
            //if new dont get info, just send an empty child
            if($enfantID == 'nouveau'){
                $enfant = new Enfant;
                include(AGCSI_ROOT.'/templates/my_account/participant-edit.php');
            //if delete, check if valid and if confirmed, proceed deletion;
            }else if(strpos($enfantID,'delete/') === 0){
                $deleteParams = explode('/',$enfantID);
                if(isset($deleteParams[1]) && is_numeric($deleteParams[1])){
                    $enfant = Enfant::get($deleteParams[1]);
                    if($enfant && $enfant->parentID == get_current_user_id()){
                        include(AGCSI_ROOT.'/templates/my_account/participant-delete.php');
                    }
                }
            //if not new or not delete, it must be an id, check if its numeric, if user is parent else show 404
            }else{
                $enfant = Enfant::get($enfantID);
                if($enfant && $enfant->parentID == get_current_user_id()){
                    include(AGCSI_ROOT.'/templates/my_account/participant-edit.php');
                    return;
                }
                include(AGCSI_ROOT.'/templates/my_account/participant-404.php');
            }
        //no query var, show the list
        }else{
            $enfants = Enfant::get_from_parent_ID(get_current_user_id());
            include(AGCSI_ROOT.'/templates/my_account/participants.php');
        }
        
    }
    
    /**
     * Recois les paramètres get de suppression de participants. Quelques sécutités pour ne pas permettre a personne autre que le user de lete un enfant
     *
     * @return void
     * @hooked template_redirect -> se fait au template redirect pour pemettre de kick le user non autorisé
     */
    public static function handle_enfant_delete(){
        if((get_query_var( 'participants' ) != null || get_query_var( 'participants' ) != "") && strpos(get_query_var( 'participants' ),'delete/') === 0){
            $deleteParams = explode('/',get_query_var( 'participants' ));
            if(isset($deleteParams[1]) && is_numeric($deleteParams[1]) && isset($deleteParams[2]) && $deleteParams[2] == 'confirm'){
                $enfant = Enfant::get($deleteParams[1]);
                if($enfant && $enfant->parentID == get_current_user_id()){
                        if(isset($deleteParams[2])){
                            if($deleteParams[2] == 'confirm'){
                                wp_delete_post( $enfant->ID, true );
                                wp_redirect(wc_get_endpoint_url('participants'));
                            }
                        }
                }
            }
        }
    }
    
    /**
     * Accroche tout les hooks de la classe
     *
     * @return void
     * @hooked init
     */
    public static function register(){
        self::add_endpoint_wc();
        add_filter('woocommerce_account_menu_items', __NAMESPACE__.'\AccountParticipants::add_menu_item', 99, 1);
        add_filter( 'woocommerce_account_menu_item_classes', __NAMESPACE__.'\AccountParticipants::add_class_to_menu_items' , 99, 2);
        add_action('woocommerce_account_participants_endpoint', __NAMESPACE__.'\AccountParticipants::participants_endpoint_content');
        add_action('template_redirect', __NAMESPACE__.'\AccountParticipants::handle_enfant_delete');
        if (isset($_POST['agcsi_save_enfant'])) {
            add_action('template_redirect', __NAMESPACE__.'\AccountParticipants::parse_form');
        }
        
    }
    
    /**
     * Recois le form, si tout est valide, enregistre un nouvel enfant
     *
     * @return void
     * @hooked template_redirect -> se fait au template redirect pour pemettre de kick le user non autorisé
     */
    public static function parse_form(){
        if (!isset($_POST['save_enfant_nonce']) || !wp_verify_nonce($_POST['save_enfant_nonce'], 'save_and_edit_enfant')) {
            return;
        }
        $validated = self::validate_form();
        $userID    = get_current_user_id();
        $enfantID = intval($_POST['agcsi_enfant_id']);

        $enfant = Enfant::get($enfantID);
        if($enfant){
            if($enfant->parentID != $userID){
                //IS NOT THE PARENT
                return null;
            }
        }else{
            $enfant = new Enfant();
        }

        $validated['parentID'] = $userID;

        foreach(Enfant::$fillables as $fillable){
            $enfant->{$fillable} = $validated[$fillable];
        }

        $enfant->save();
        wp_redirect(wc_get_endpoint_url('participants'));
    }

    public static function validate_form(){
        $validated = [
            "prenom"                => sanitize_text_field($_POST['agcsi_enfant_prenom']),
            "nom"                   => sanitize_text_field($_POST['agcsi_enfant_nom']),
            "date_naissance"        => sanitize_text_field($_POST['agcsi_enfant_date_naissance']),
            "assurance_maladie"     => sanitize_text_field($_POST['agcsi_enfant_assurance_maladie']),
            "sport_pratique"        => sanitize_text_field($_POST['agcsi_enfant_sport_pratique']),
            "taille_tshirt"         => sanitize_text_field($_POST['agcsi_enfant_taille_tshirt']),
            "taille_tshirt_hockey"  => sanitize_text_field($_POST['agcsi_enfant_taille_tshirt_hockey']),
            "autorisation_photo"    => agcsi_validate_yes_no($_POST['agcsi_enfant_autorisation_photo']),
            "maladies"              => agcsi_validate_checkbox_array((isset($_POST['agcsi_enfant_maladie']) ? $_POST['agcsi_enfant_maladie'] : []), isset($_POST['agcsi_enfant_autre_maladie']), $_POST['agcsi_enfant_maladie_autre_data']),
            "maladie_debut"         => sanitize_text_field($_POST['agcsi_enfant_maladie_debut']),
            "alergie"               => agcsi_validate_yes_no($_POST['agcsi_enfant_alergie']),
            "epipen"                => agcsi_validate_yes_no($_POST['agcsi_enfant_epipen']),
            "vaccination"           => agcsi_validate_yes_no($_POST['agcsi_enfant_vaccination']),
            "medicament"            => agcsi_validate_yes_no($_POST['agcsi_enfant_medicament']),
            "medicament_detail"     => sanitize_text_field($_POST['agcsi_enfant_medicament_detail']),
            "particularite"         => sanitize_text_field($_POST['agcsi_enfant_particularite']),
            "autorisation_urgence"  => agcsi_validate_yes_no($_POST['agcsi_enfant_autorisation_urgence']),
            "consent_frais_urgence" => isset($_POST['agcsi_enfant_consent_frais_urgence'])?'Oui':'Non',
        ];
        return $validated;
    }
}