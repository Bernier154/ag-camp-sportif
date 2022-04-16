<?php 
namespace Agcsi\WcAccount;

use Agcsi\CPT\Inscription;

class AccountInscriptions {
    
    /**
     * Ajoute les items participants, les enfants et les inscriptions au menu woocommerce my-account
     *
     * @param  mixed $items
     * @return void
     * @hooked woocommerce_account_menu_items
     */
    public static function add_menu_item($items){
        $nouvel_items = ['inscriptions'   => 'Inscriptions'];
        $nouvel_item = array_merge(array_slice($items, 0, 1, true),$nouvel_items,array_slice($items, 1, count($items), true));
        return $nouvel_item;
    }
    
    /**
     * Ajoute un url endpoint pour woocommerce wc-account
     *
     * @return void
     */
    public static function add_endpoint_wc(){
        add_rewrite_endpoint('inscriptions', EP_PAGES);
    }
    
    /**
     * inclus les template de contenu pour les pages ajoutées au endpoint inscriptions. 
     *
     * @return void
     * @hooked woocommerce_account_participants_endpoint
     */
    public static function participants_endpoint_content(){
        $inscriptions = Inscription::get_from_parent_ID(get_current_user_id());
        include(AGCSI_ROOT.'/templates/my_account/inscriptions.php');
    }

    /**
     * Accroche tout les hooks de la classe
     *
     * @return void
     * @hooked init
     */
    public static function register(){
        self::add_endpoint_wc();
        add_filter('woocommerce_account_menu_items', __NAMESPACE__.'\AccountInscriptions::add_menu_item', 99, 1);
        add_action('woocommerce_account_inscriptions_endpoint', __NAMESPACE__.'\AccountInscriptions::participants_endpoint_content');
    }

}