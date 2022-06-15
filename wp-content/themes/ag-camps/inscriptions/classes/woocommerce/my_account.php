<?php 
namespace Agcsi\WooCommerce;
use Agcsi\Cpt\Camp;
use Agcsi\Cpt\Enfant;

class MyAccount{
    public static function add_header_paiements(){
        echo '<div class="info-box full"><i class="fa-solid fa-credit-card"></i><h3>Moyens de paiements</h3>';
    }
    public static function add_header_user_details(){
        echo '<div class="info-box full"><i class="fa-solid fa-circle-user"></i><h3>Détails du compte</h3>';
    }
    public static function add_header_adresse(){
        echo '<div class="info-box full"><i class="fa-solid fa-map"></i>';
    }
    public static function add_header_orders(){
        echo '<div class="info-box full"><i class="fa-solid fa-basket-shopping"></i></i><h3>Factures</h3>';
    }
    public static function add_footer(){
        echo '</div><br>';
    }

    public static function edit_orders_menu_label($items){
        $items['orders'] = 'Factures';
        return $items;
    }

    public static function dashboard_content($items){
        include(AGCSI_ROOT.'/templates/my_account/dashboard.php');
    }
    

    public static function register(){
        remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );

        add_action('woocommerce_account_page_endpoint', __NAMESPACE__.'\MyAccount::dashboard_content');

        add_filter('woocommerce_account_menu_items', __NAMESPACE__.'\MyAccount::edit_orders_menu_label', 99, 1);

        add_action( 'woocommerce_before_account_payment_methods', __NAMESPACE__."\MyAccount::add_header_paiements" );
        add_action( 'woocommerce_after_account_payment_methods', __NAMESPACE__."\MyAccount::add_footer" ); 

        add_action( 'woocommerce_before_edit_account_form', __NAMESPACE__."\MyAccount::add_header_user_details" );
        add_action( 'woocommerce_after_edit_account_form', __NAMESPACE__."\MyAccount::add_footer" ); 

        add_action( 'woocommerce_before_edit_account_address_form', __NAMESPACE__."\MyAccount::add_header_adresse" );
        add_action( 'woocommerce_after_edit_account_address_form', __NAMESPACE__."\MyAccount::add_footer" ); 

        add_action( 'woocommerce_before_account_orders', __NAMESPACE__."\MyAccount::add_header_orders" );
        add_action( 'woocommerce_after_account_orders', __NAMESPACE__."\MyAccount::add_footer" ); 

        add_filter( 'woocommerce_display_item_meta', function($html, $item, $args){
            $camp = Camp::get($item['camp']);
            $html = '<p>'.$camp->post->post_title.'</p>';
            $html.= '<div class="metas">';
            $html.= '<h5>Journée(s):</h5>';
            $html.= '<p>'.implode(' ',array_map(function($date){
                return '<span class="pastille">'.date_i18n('j F Y',strtotime($date)).'</span>';
            },$item['dates'])).'</p>';
            $html.= '<h5>Participant(s):</h5>';
            $html.= '<p>'.implode(' ',array_map(function($enfant_id){
                return '<span class="pastille">'.(Enfant::get($enfant_id))->prenom.'</span>';
            },$item['participants'])).'</p>';
            $html.= '</div>';
            return $html;
        } ,10,3);
    }
}


