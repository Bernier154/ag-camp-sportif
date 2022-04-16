<?php
namespace Agcsi\WcAccount;

use Agcsi\CPT\Inscription;

class AccountParent {

    /**
     * Ajoute les items participants, les enfants et les inscriptions au menu woocommerce my-account
     *
     * @param  mixed $items
     * @return void
     * @hooked woocommerce_account_menu_items
     */
    public static function add_menu_item($items) {
        $nouvel_items = ['parent' => 'Information parent'];
        $nouvel_item  = array_merge(array_slice($items, 0, 1, true), $nouvel_items, array_slice($items, 1, count($items), true));
        return $nouvel_item;
    }

    /**
     * Ajoute un url endpoint pour woocommerce wc-account
     *
     * @return void
     */
    public static function add_endpoint_wc() {
        add_rewrite_endpoint('parent', EP_PAGES);
    }

    /**
     * inclus les template de contenu pour les pages ajoutées au endpoint inscriptions.
     *
     * @return void
     * @hooked woocommerce_account_participants_endpoint
     */
    public static function parent_endpoint_content() {
        include AGCSI_ROOT . '/templates/my_account/parent.php';
    }

    /**
     * Accroche tout les hooks de la classe
     *
     * @return void
     * @hooked init
     */
    public static function register() {
        self::add_endpoint_wc();
        add_filter('woocommerce_account_menu_items', __NAMESPACE__ . '\AccountParent::add_menu_item', 99, 1);
        add_action('woocommerce_account_parent_endpoint', __NAMESPACE__ . '\AccountParent::parent_endpoint_content');

        if (isset($_POST['agcsi_save_parent'])) {
            add_action('template_redirect', __NAMESPACE__ . '\AccountParent::parse_form');
        }
    }

    public static function parse_form() {
        if (!isset($_POST['edit_parent_nonce']) || !wp_verify_nonce($_POST['edit_parent_nonce'], 'edit_parent')) {
            return;
        }
        $validated = self::validate_form();
        $user_id    = get_current_user_id();

        foreach($validated as $meta_key=>$meta_value){
            update_user_meta( $user_id, $meta_key, $meta_value);
        }
        
        wc_add_notice('Vos information ont été sauvegardés.');
    }

    public static function validate_form() {
        $validated = [
            "first_name"        => sanitize_text_field($_POST['agcsi_user_first_name']),
            "last_name"         => sanitize_text_field($_POST['agcsi_user_last_name']),
            "billing_phone"     => sanitize_text_field($_POST['agcsi_user_billing_phone']),
            "work_phone"        => sanitize_text_field($_POST['agcsi_user_work_phone']),
            "second_first_name" => sanitize_text_field($_POST['agcsi_user_second_first_name']),
            "second_last_name"  => sanitize_text_field($_POST['agcsi_user_second_last_name']),
            "second_phone"      => sanitize_text_field($_POST['agcsi_user_second_phone']),
            "second_adress"     => sanitize_text_field($_POST['agcsi_user_second_adress']),
            "urgent_first_name" => sanitize_text_field($_POST['agcsi_user_urgent_first_name']),
            "urgent_last_name"  => sanitize_text_field($_POST['agcsi_user_urgent_last_name']),
            "urgent_phone"      => sanitize_text_field($_POST['agcsi_user_urgent_phone']),
            "urgent_link"       => sanitize_text_field($_POST['agcsi_user_urgent_link']),
        ];
        return $validated;
    }
}
