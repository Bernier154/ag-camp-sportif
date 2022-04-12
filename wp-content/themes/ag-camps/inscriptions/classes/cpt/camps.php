<?php
namespace Agcsi\CPT;
use Agcsi\CPT\Enfant;
use Agcsi\CPT\Inscription;

class Camp {

    public $ID;
    public $post;
    public $max_disponibilite;

    function __constructor(){

    }

    
    public function get_disponibility_for_day($date,$remove_cart_disponibility = false){
        $nb_max = $this->max_disponibilite;
        $nb_participants = count($this->get_participants_for_day($date));
        $disponibility = $nb_max - $nb_participants;
        if($remove_cart_disponibility){
            include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
            include_once WC_ABSPATH . 'includes/class-wc-cart.php';
            if ( is_null( WC()->cart ) ) { wc_load_cart(); }
            foreach ( WC()->cart->get_cart() as $cart_item ) {
                $campID = $cart_item['camp'];
                $dates = $cart_item['dates'];
                $participants = $cart_item['participants'];
                if($this->ID == $campID){
                    if(in_array($date,$dates)){
                        $disponibility-=count($participants);
                    }
                }
            }
        }
        return $disponibility;
    }


    public function get_highest_disponibility(){
        $val = 0;
        foreach($this->get_valid_days() as $date){
            $nb_max = $this->max_disponibilite;
            $nb_participants = count($this->get_participants_for_day($date));
            if(($nb_max - $nb_participants) > $val){
                $val = $nb_max - $nb_participants;
            }
        }
        return $val;
    }

    /**
     * retourne les jours valide de l'activités
     *
     * @return void
     */
    public function get_valid_days(){
        $start = get_field('date_de_debut',$this->post);
        $end = get_field('date_de_fin',$this->post);
        $period = asgsi_get_dates_from_range($start,$end);
        return $period;
    }

    /**
     * retourne les jours valide de l'activités
     *
     * @return void
     */
    public function get_participants_for_day($date,$return_as_id = false){
        $participants = [];
        $inscriptions = Inscription::get_from_camp($this->ID);
        foreach($inscriptions as $inscription){
            if(in_array($date,$inscription->dates)){
                foreach($inscription->participants as $participant){
                    $participants[] = $return_as_id?$participant:Enfant::get($participant);
                }
            }
        }
        return $participants;
    }
    
    /**
     * Retourne le prix d'une journée selon le nombre de jour achetés
     *
     * @param  mixed $days_in_cart
     * @param  mixed $nb_participants
     * @param  mixed $nb_jours
     * @return void
     */
    public function price_for_one_day($days_in_cart = 1,$nb_participants = 1 , $nb_jours = 1 ){
        $prix_base = price_to_int_notation(get_field('prix',$this->ID));
        

        if($days_in_cart >= 7 && $nb_participants >= 3){
            $prix_base = $prix_base * 0.29;
        }else if($days_in_cart >=42){
            $prix_base = $prix_base * 0.53;
        }else if($days_in_cart >=21){
            $prix_base = $prix_base * 0.57;
        }else if($days_in_cart >=7){
            $prix_base = $prix_base * 0.62;
        }

        $prix_total = $prix_base;

        if($nb_participants == 2 || ($nb_participants >= 2 && $days_in_cart < 7)){
            $prix_total += $prix_base * 0.8183 ;
        }
        


        return (int) $prix_total * $nb_jours;
    }
    
    /**
     * from_post
     *
     * @param  mixed $post
     * @return void
     */
    public static function from_post($post){
        
        $camp = new Camp();
        $camp->post = $post;
        $camp->ID = $camp->post->ID;
        $camp->max_disponibilite = get_field('disponibilite',$post);
        
        return $camp;
    }
    
    /**
     * get
     *
     * @param  mixed $ID
     * @return void
     */
    public static function get($ID) {
        $post = get_post($ID);
        if ($post) {
            if($post->post_type == 'camps'){
                return Camp::from_post($post);
            }
        }
        return null;
    }
    
    /**
     * single_page_small_banner
     *
     * @param  mixed $is_small
     * @return bool
     */
    public static function single_page_small_banner($is_small){
        global $post;
        if($post->post_type == 'camps'){
            return true;
        }
        return $is_small;
    }
    
    /**
     * single_page_banner_image
     *
     * @param  integer $image
     * @return WP_POST
     */
    public static function single_page_banner_image($image){
        global $post;
        if($post->post_type == 'camps'){
            return get_post_thumbnail_id($post->ID);
        }
        return $image;
    }
        
    /**
     * register_post_type
     *
     * @return void
     */
    public static function register_post_type(){
        register_post_type('camps', [
            'labels' => [
                'name'               => 'camps',
                'singular_name'      => 'camp',
                'add_new'            => 'Planifier un camp',
                'add_new_item'       => 'Planifier un camp',
                'edit_item'          => 'Modifier le camp',
                'new_item'           => 'Nouveau Camp',
                'view_item'          => 'Voir le camp',
                'search_items'       => 'Chercher les camps',
                'not_found'          => 'Aucuns camps trouvés',
                'not_found_in_trash' => 'Aucuns camps trouvés dans la corbeille',
                'menu_name'          => 'Camps',
            ],
            'description'         => 'Organise les camp',
            'taxonomies'          => [],
            'public'              => true,
            'show_in_rest'        => true,
            'menu_position'       => 5,
            'menu_icon'         => 'dashicons-calendar-alt',
            'show_in_nav_menus'   => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'has_archive'         => false,
            'query_var'           => true,
            'rewrite'             => true,
            'capability_type'     => 'post',
            'supports'            => [ 'title','thumbnail','custom-fields', 'page-attributes'],
            'register_meta_box_cb'=> '\Agcsi\Admin\MetaBoxCampsHoraire::add_meta_box'
        ]);
        add_filter('banner_size' ,__NAMESPACE__.'\Camp::single_page_small_banner');
        add_filter('banner_image',__NAMESPACE__.'\Camp::single_page_banner_image');
    }
}
