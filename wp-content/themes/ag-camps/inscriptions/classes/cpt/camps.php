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
        if(strtotime($date) < strtotime(date("Y-m-d"))){
            $disponibility = 0;
        }
        return $disponibility;
    }

    public function heures_html($abrege = true){
        $debut = get_field('heure_debut',$this->post) == null || get_field('heure_debut',$this->post) == "" ?'7:30':get_field('heure_debut',$this->post);
        $fin = get_field('heure_fin',$this->post) == null || get_field('heure_fin',$this->post) == "" ?'17:00':get_field('heure_fin',$this->post);
        if($abrege){
            return $debut.'@'.$fin;
        }else{
            return $debut.' à '.$fin;
        }
        
    }

    public function adresse(){
        $adresse = "";
        if(get_field('lieu',$this->post)){
            $adresse = get_field('lieu',$this->post)['address'];
        }
        return $adresse;
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
     * @param  mixed $cumulative_days
     * @param  mixed $nb_participants
     * @param  mixed $nb_jours
     * @return void
     */
    public function price_for_one_day($cumulative_days = 1,$nb_participants = 1 , $nb_jours = 1 ){
        $prix_total = 0;
        $prix_base = get_field('prix',$this->ID);
        $rabais_prix_jour = 0;

        $rabais_nb_enfants = [
            "1" => 0,
            "2" => get_option('rabais_2_enfants',true),
            "3" => get_option('rabais_3_enfants',true)
        ];
        $rabais_nb_jours_cumulatif = [
            "0" => 0,
            "5" => get_option('rabais_5_jours',true),
            "15" => get_option('rabais_15_jours',true),
            "30" => get_option('rabais_30_jours',true)
        ];
        

        if(!get_field('no_rebate',$this->ID)){
            foreach($rabais_nb_jours_cumulatif as $key=>$val){
                if(($cumulative_days + $nb_jours) >= intval($key)){
                    $rabais_prix_jour = $val;
                }
            }
        }

        for($i = 1; $i<= $nb_participants; $i++){
            $rabais_prix_enfant = 0;
            if(!get_field('no_rebate',$this->ID)){
                foreach($rabais_nb_enfants as $key=>$val){
                    if($i >= intval($key)){
                        $rabais_prix_enfant = $val;
                    }
                }
            }
            
            $rabais_jours_decimal = $rabais_prix_jour > 0 ? 1 - ($rabais_prix_jour/100) : 1;
            $rabais_enfants_decimal = $rabais_prix_enfant > 0 ? 1 - ($rabais_prix_enfant/100) : 1;


            $prix_individuel = (($prix_base * $rabais_jours_decimal) * $rabais_enfants_decimal) ;
            $prix_total += $prix_individuel * $nb_jours;
            
        }

        
        return (int) ($prix_total * 100) ;
    }
    
    /**
     * get_price_bracket
     *
     * @return void
     */
    public static function get_price_bracket($days){
        $level = 1;
        $brackets = ['1','5','15','30'];
        foreach($brackets as $key){
            if($days >= intval($key)){
                $level = $key;
            }
        }
        return $level;
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
     * all
     *
     * @return array[Camp]
     */
    public static function all() {
        $posts = get_posts([
            'post_type'=>'camps',
            'post_per_page'=>-1
        ]);
        $arr = [];
        if ($posts) {
            foreach($posts as $post){
                if($post->post_type == 'camps'){
                    $arr[]= Camp::from_post($post);
                }
            } 
        }
        return $arr;
    }
    

    /**
     * all_not_past
     *
     * @return array[Camp]
     */
    public static function all_not_past() {
        $posts = get_posts([
            'post_type'=>'camps',
            'posts_per_page'=>-1
        ]);
        $arr = [];
        if ($posts) {
            foreach($posts as $post){
                if($post->post_type == 'camps'){
                    $camp = Camp::from_post($post);
                    $days = $camp->get_valid_days();
                    if(strtotime(end($days)) > strtotime('now')){
                        $arr[]= Camp::from_post($post);
                    }
                    
                }
            } 
        }
        return $arr;
    }

    /**
     * single_page_small_banner
     *
     * @param  mixed $is_small
     * @return bool
     */
    public static function single_page_small_banner($is_small){
        global $post;

        if($post){
            if($post->post_type == 'camps'){
                return true;
            }
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
        if($post){
            if($post->post_type == 'camps'){
                return get_post_thumbnail_id($post->ID);
            }
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
