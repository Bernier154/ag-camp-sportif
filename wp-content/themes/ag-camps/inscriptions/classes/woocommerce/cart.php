<?php 
namespace Agcsi\WooCommerce;
use Agcsi\CPT\Camp;
use Agcsi\CPT\Enfant;


class Cart{
    
    /**
     * recalculate_cart_price
     *
     * @param  mixed $cart
     * @return void
     */
    public static function recalculate_cart_price( $cart ){
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ){ return; }
        if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ){ return; }

        foreach ( $cart->get_cart() as $cart_item ) {
            if(!isset($cart_item['camp'])){
                $cart->remove_cart_item( $cart_item['key'] );
            }else{
                $camp = Camp::get($cart_item['camp']);
                $dates = $cart_item['dates'];
                $participants = $cart_item['participants'];
    
                $calculated_price = $camp->price_for_one_day(count($cart->get_cart()),count($participants), count($dates) ) / 100;
            
                $cart_item['data']->set_price( $calculated_price  ); 
            }
        }
    }
    
    /**
     * validate_camp_ajax
     *
     * @param  mixed $request
     * @return void
     */
    public static function validate_camp_ajax($request){
        $params = $request->get_params();
        if(!isset($params["enfants[]"]) || !isset($params["dates"]) || !isset($params["campId"]) ){ return false; }
        $camp = Camp::get($params["campId"]);
        if(!$camp){ return false; }
        return [
            'camp'=>$camp,
            'dates'=> $params['dates'],
            'enfants'=> is_array($params["enfants[]"])?$params["enfants[]"]:[$params["enfants[]"]]
        ];
    }
    
    /**
     * load_camp_add_to_cart
     *
     * @param  mixed $request
     * @return void
     */
    public static function load_camp_add_to_cart($request){
        $validated = Cart::validate_camp_ajax($request);
        if(!$validated){ return ['success'=>false]; }
        
        $valid_days = $validated["camp"]->get_valid_days();
        $request_days = explode(', ',$validated['dates']);

        foreach($request_days as $date){
            if(!in_array($date,$valid_days)){
                return ['success'=>false];
            }
        }
        $response = ['success'=>true];
        $response['price'] = $validated['camp']->price_for_one_day(count($request_days)+0,count($validated['enfants']), count($request_days) ) / 100;
        return $response;
    }
    
    /**
     * add_camp_to_cart
     *
     * @param  mixed $request
     * @return void
     */
    public static function add_camp_to_cart( $request ){
        include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
        include_once WC_ABSPATH . 'includes/class-wc-cart.php';
        if ( is_null( WC()->cart ) ) { wc_load_cart(); }

        $validated = Cart::validate_camp_ajax($request);
        if(!$validated){ return ['success'=>false,'error'=>"Une erreur s'est produite, veuillez réessayer plus tard."]; }

        $valid_days = $validated['camp']->get_valid_days();
        $request_days = explode(', ',$validated['dates']);

        foreach($request_days as $date){

            //CHECK: si la date est valide dans les jours de camps sélectionnés
            if(!in_array($date,$valid_days)){
                return ['success'=>false,'error'=>"Une date sélectionnée n'est pas valide, veuillez rafraichir la page et réessayer."];
            }

            //CHECK: si il y a assez de place dans les journées sélectionnées
            $dispo = $validated['camp']->get_disponibility_for_day($date);
            $count = count($validated["enfants"]);
            if($dispo < $count){
                return ['success'=>false,'error'=>"La date: {$date} a une disponibilité de {$dispo} personne".($dispo>1?'s':'').", mais vous tentez d'inscrire $count participant".($count>1?'s':'')."."];
            }

            //CHECK: si un participant est déjà inscrit!
            foreach($validated["enfants"] as $enfantID){
                if(in_array($enfantID,$validated['camp']->get_participants_for_day($date,true)) ){
                    $enfant = Enfant::get($enfantID);
                    return ['success'=>false,'error'=>"Le participant {$enfant->prenom} est déjà inscrit pour ce camp le $date."];
                }
            }

            //CHECK: si un participant est déjà dans une inscription dans le cart
            foreach ( WC()->cart->get_cart() as $cart_item ) {
                $campID = $cart_item['camp'];
                $dates = $cart_item['dates'];
                $participants = $cart_item['participants'];
                if($validated['camp']->post->ID == $campID){
                    foreach( $dates as $cart_date){
                        if($cart_date == $date){
                            foreach($validated["enfants"] as $enfantID){
                                if(in_array($enfantID,$participants) ){
                                    $enfant = Enfant::get($enfantID);
                                    return ['success'=>false,'error'=>"Le participant {$enfant->prenom} est déjà inscrit pour ce camp le $date. Cette inscription est dans le panier"];
                                }
                            }
                        }
                    }
                }
            }

        }


        $price = $validated['camp']->price_for_one_day(count($request_days)+0,count($validated['enfants']), count($request_days) ) / 100;

        $response = ['success'=>true];

        $response['cart_id'] = WC()->cart->add_to_cart( get_option('produit_inscription'), 1, 0, array(), [
            'camp'=>$validated['camp']->post->ID,
            'dates'=>$request_days, 
            'participants'=>$validated["enfants"]
        ]);

        $response['redirect'] = wc_get_cart_url();
        return $response;
    }
    
    /**
     * override_cart_img
     *
     * @param  mixed $_product_img
     * @param  mixed $cart_item
     * @param  mixed $cart_item_key
     * @return void
     */
    public static function override_cart_img( $_product_img, $cart_item, $cart_item_key){
        $camp = Camp::get($cart_item['camp']);
        if(get_post_thumbnail_id($camp->post->ID)){
            $_product_img = '<img src="'.wp_get_attachment_image_url( get_post_thumbnail_id($camp->post->ID), 'full' ).'" alt="">';
        }
        return $_product_img;
    }
    
    /**
     * override_cart_permalink
     *
     * @param  mixed $permalink
     * @param  mixed $cart_item
     * @return void
     */
    public static function override_cart_permalink( $permalink, $cart_item){
        $camp = Camp::get($cart_item['camp']);
        if(get_permalink($camp->post->ID)){
            $permalink = get_permalink($camp->post->ID);
        }
        return $permalink;
    }
    
    /**
     * override_cart_quantity
     *
     * @param  mixed $product_quantity
     * @param  mixed $cart_item_key
     * @param  mixed $cart_item
     * @return void
     */
    public static function override_cart_quantity( $product_quantity, $cart_item_key, $cart_item ){
        if( is_cart() ){
            $product_quantity = sprintf( '%2$s <input type="hidden" name="cart[%1$s][qty]" value="%2$s" />', $cart_item_key, $cart_item['quantity'] );
        }
        return $product_quantity;
    }
    
    /**
     * override_cart_name
     *
     * @param  mixed $product_name
     * @param  mixed $cart_item
     * @param  mixed $cart_item_key
     * @return void
     */
    public static function override_cart_name( $product_name, $cart_item, $cart_item_key){
        $camp = Camp::get($cart_item['camp']);
        $html = '<p>'.$camp->post->post_title.'</p>';
        $html.= '<div class="metas">';
        $html.= '<h5>Journée(s):</h5>';
        $html.= '<p>'.implode(' ',array_map(function($date){
            return '<span class="pastille">'.date_i18n('j F Y',strtotime($date)).'</span>';
        },$cart_item['dates'])).'</p>';
        $html.= '<h5>Participant(s):</h5>';
        $html.= '<p>'.implode(', ',array_map(function($enfant_id){
            return '<span class="pastille">'.(Enfant::get($enfant_id))->prenom.'</span>';
        },$cart_item['participants'])).'</p>';
        $html.= '</div>';
        return $html;
    }

    public static function register(){
        add_filter('woocommerce_cart_item_name',__NAMESPACE__.'\Cart::override_cart_name',1,3);
        add_filter( 'woocommerce_cart_item_quantity', __NAMESPACE__.'\Cart::override_cart_quantity',10,3);
        add_filter( 'woocommerce_cart_item_permalink',__NAMESPACE__.'\Cart::override_cart_permalink',10,2);
        add_filter('woocommerce_cart_item_thumbnail',__NAMESPACE__.'\Cart::override_cart_img', 10, 3 );
        add_filter('woocommerce_before_calculate_totals',__NAMESPACE__.'\Cart::recalculate_cart_price');
        add_action( 'rest_api_init', function () {
            register_rest_route( 'inscriptions', '/load-add-to-cart', array(
                'methods' => 'POST',
                'callback' => __NAMESPACE__.'\Cart::load_camp_add_to_cart',
                'permission_callback'=>"__return_true",
                "args"=>["dates","enfants","campId"]
            ));
            register_rest_route( 'inscriptions', '/add-to-cart', array(
                'methods' => 'POST',
                'callback' => __NAMESPACE__.'\Cart::add_camp_to_cart',
                'permission_callback'=>"__return_true",
                "args"=>["dates","enfants","campId"]
            ));
        });
        add_filter( 'woocommerce_return_to_shop_redirect', function(){ return home_url('/').'inscriptions'; });
        add_filter( 'woocommerce_return_to_shop_text', function(){ return 'Retour au calendrier'; });

        remove_action('woocommerce_thankyou','woocommerce_order_details_table');
    }
}

