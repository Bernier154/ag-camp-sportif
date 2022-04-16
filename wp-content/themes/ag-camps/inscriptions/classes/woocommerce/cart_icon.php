<?php 
namespace Agcsi\WooCommerce;

class CartIcon{

    public static function add_cart_icon($items, $args){
        if($args->menu->slug == 'menu-1'){
            $cart_count = WC()->cart->cart_contents_count;
            $cart_url = wc_get_cart_url();

            $item_cart = '<li><a class="cart-icon" href="'. $cart_url .'"><i class="fa-solid fa-cart-shopping"></i>';
            if($cart_count > 0){
                $item_cart.= '<span class="count">'.$cart_count.'</span>';
            }
            $item_cart .= '</a></li>';

            $items.=$item_cart;
        }
        return $items;
    }

    public static function register(){
         add_filter( 'wp_nav_menu_items', __NAMESPACE__.'\CartIcon::add_cart_icon', 10, 2 );
    }
}