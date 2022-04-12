<?php 
namespace Agcsi\WooCommerce;
use Agcsi\CPT\Camp;
use Agcsi\CPT\Enfant;
use Agcsi\CPT\Inscription;


class Checkout{
    
    /**
     * create_inscription_on_order_creation
     *
     * @param  mixed $order_id
     * @return void
     */
    public static function create_inscription_on_order_creation($order_id){
        if ( ! $order_id ){
            return;
        }
        if( ! get_post_meta( $order_id, '_inscription_for_order_made', true ) ) {
            $order = wc_get_order( $order_id );
            foreach ( $order->get_items() as $item_id => $item ) {
                $camp = Camp::get($item->get_meta('camp'));
                $participants = $item->get_meta('participants');
                $dates = $item->get_meta('dates');
                $parent = $order->get_user_id();

                $inscription = new Inscription();

                $inscription->camp = $camp;
                $inscription->participants = $participants;
                $inscription->dates = $dates;
                $inscription->parent = $parent;

                $inscription->save();
            }
            
            $order->update_meta_data( '_inscription_for_order_made', true );
            $order->save();
        }

    }
    
    /**
     * transfer_cart_item_extra_to_order_item
     *
     * @param  mixed $item
     * @param  mixed $cart_item_key
     * @param  mixed $values
     * @param  mixed $order
     * @return void
     */
    public static function transfer_cart_item_extra_to_order_item($item, $cart_item_key, $values, $order){
        if ( isset($values['camp']) ) {
            $item->update_meta_data( 'camp', $values['camp'] );
        }
        if ( isset($values['participants']) ) {
            $item->update_meta_data( 'participants', $values['participants'] );
        }
        if ( isset($values['dates']) ) {
            $item->update_meta_data( 'dates', $values['dates'] );
        }
    }

    public static function register(){
        add_action('woocommerce_thankyou', __NAMESPACE__.'\Checkout::create_inscription_on_order_creation', 10, 1);
        add_action( 'woocommerce_checkout_create_order_line_item', __NAMESPACE__.'\Checkout::transfer_cart_item_extra_to_order_item', 10, 4 );
    }
}