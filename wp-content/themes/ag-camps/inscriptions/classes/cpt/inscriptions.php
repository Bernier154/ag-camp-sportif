<?php
namespace Agcsi\CPT;
use Agcsi\CPT\Camp;

class Inscription {
    public $ID;
    public $participants;
    public $dates;
    public $camp;
    public $parent;
    public $post;

    public static $meta_prefix = "agcsi_inscription_";

    public static $fillables = [
        'participants',
        'dates',
        'camp',
        'parent',
    ];

    public function save() {
        $args = [
            'post_type'  => 'inscriptions',
            'post_status'=>'publish',
            'post_title' => 'Inscription pour: '.$this->camp->post->post_title,
            'meta_input' => $this->return_fillable_as_meta(),
        ];
        if ($this->post) {
            $args['ID'] = $this->post->ID;
        }
        $this->ID = wp_insert_post($args);
    }

    public function return_fillable_as_meta() {
        $array = [];
        foreach (self::$fillables as $fillable) {
            switch($fillable){
                case 'camp':
                    $array[self::$meta_prefix . $fillable] = $this->{$fillable}->post->ID;
                break;
                default:
                    $array[self::$meta_prefix . $fillable] = $this->{$fillable};
                break;
            }
        }
        return $array;
    }

    public function fill_fillable_from_meta() {
        foreach (self::$fillables as $fillable) {
            switch($fillable){
                case 'camp':
                    $this->{$fillable} = Camp::get(get_post_meta($this->post->ID, self::$meta_prefix . $fillable, true));
                break;
                default:
                    $this->{$fillable} = get_post_meta($this->post->ID, self::$meta_prefix . $fillable, true);
                break;
            }
        }

    }

    public static function from_post($post){
        $inscription = new Inscription();
        $inscription->post = $post;
        $inscription->ID = $inscription->post->ID;
        $inscription->fill_fillable_from_meta();
        return $inscription;
    }

    public static function get($ID) {
        $post = get_post($ID);
        if ($post) {
            if($post->post_type == 'inscriptions'){
                return Inscription::from_post($post);
            }
        }
        return null;
    }

    public static function get_from_camp($camp) {
        $inscriptions = [];
        $posts = get_posts([
            'post_type'=>'inscriptions',
            'post_status'=>'publish',
            'meta_query'=>[
                [
                    'key'=>self::$meta_prefix.'camp',
                    'value'=>$camp
                ]
            ],
            'orderby'=>'title',
            'order'=>'ASC',
            'post_per_page' => -1
        ]);
        foreach($posts as $post){
            $inscriptions[] = Inscription::from_post($post);
        }
        return $inscriptions;
    }

    public static function get_from_parent_ID($parentID) {
        $enfants = [];
        if(is_int($parentID)){
            $posts = get_posts([
                'post_type'=>'inscriptions',
                'post_status'=>'publish',
                'meta_query'=>[
                    [
                        'key'=>self::$meta_prefix.'parent',
                        'value'=>$parentID
                    ]
                ],
                'orderby'=>'title',
                'order'=>'ASC',
                'post_per_page' => -1
            ]);
            foreach($posts as $post){
                $enfants[] = Inscription::from_post($post);
            }
        }
        return $enfants;
    }
    

    public static function register_post_type(){

        register_post_type('inscriptions', [
            'labels' => [
                'name'               => 'inscriptions',
                'singular_name'      => 'inscription',
                'add_new'            => 'Ajouter une inscription',
                'add_new_item'       => 'Ajouter une inscription',
                'edit_item'          => 'Modifier l\'inscription',
                'new_item'           => 'Nouvelle inscription',
                'view_item'          => 'Voir l\'inscription',
                'search_items'       => 'Chercher les inscription',
                'not_found'          => 'Aucunes inscription trouvés',
                'not_found_in_trash' => 'Aucunes inscription trouvés dans la corbeille',
                'menu_name'          => 'Inscriptions',
            ],
            'description'         => 'Affiche les inscriptions',
            'taxonomies'          => [],
            'public'              => true,
            'has_archive'          => false,
            'show_in_rest'        => true,
            'menu_position'       => 5,
            'menu_icon'         => 'dashicons-clipboard',
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'has_archive'         => false,
            'query_var'           => true,
            'rewrite'             => true,
            'capability_type'     => 'post',
            'supports'            => [ 'title','custom-fields'],
            'register_meta_box_cb'=> '\Agcsi\Admin\MetaBoxInscriptions::add_meta_box'
        ]);

        

    }
}


