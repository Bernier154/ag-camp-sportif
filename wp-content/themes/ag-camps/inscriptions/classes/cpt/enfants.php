<?php
namespace Agcsi\CPT;

class Enfant {
    public $ID;
    public $prenom;
    public $nom;
    public $date_naissance;
    public $assurance_maladie;
    public $sport_pratique;
    public $taille_tshirt;
    public $taille_tshirt_hockey;
    public $autorisation_photo;
    public $maladies;
    public $maladie_debut;
    public $alergie;
    public $epipen;
    public $vaccination;
    public $medicament;
    public $medicament_detail;
    public $particularite;
    public $autorisation_urgence;
    public $consent_frais_urgence;
    public $parentID;
    public $post;

    public static $meta_prefix = "agcsi_enfant_";

    public static $fillables = [
        'prenom',
        'nom',
        'date_naissance',
        'assurance_maladie',
        'sport_pratique',
        'taille_tshirt',
        'taille_tshirt_hockey',
        'autorisation_photo',
        'maladies',
        'maladie_debut',
        'alergie',
        'epipen',
        'vaccination',
        'medicament',
        'medicament_detail',
        'particularite',
        'autorisation_urgence',
        'consent_frais_urgence',
        'parentID',
    ];

    public function save() {
        if (empty($this->prenom) || empty($this->nom)) {
            return false;
        }
        $args = [
            'post_type'  => 'enfants',
            'post_status'=>'publish',
            'post_title' => $this->prenom . ' ' . $this->nom,
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
            $array[self::$meta_prefix . $fillable] = $this->{$fillable};
        }
        return $array;
    }

    public function fill_fillable_from_meta() {
        foreach (self::$fillables as $fillable) {
            $this->{$fillable} = get_post_meta($this->post->ID, self::$meta_prefix . $fillable, true);
        }
    }

    public function has_complete_info(){
        return  $this->prenom != '' &&
                $this->nom != '' &&
                $this->date_naissance != '' &&
                $this->assurance_maladie != '' &&
                strtolower($this->autorisation_urgence) == 'oui' &&
                strtolower($this->consent_frais_urgence) == 'oui';
    }

    public static function from_post($post){
        $enfant = new Enfant();
        $enfant->post = $post;
        $enfant->ID = $enfant->post->ID;
        $enfant->fill_fillable_from_meta();
        return $enfant;
    }

    public static function get($ID) {
        $post = get_post($ID);
        if ($post) {
            if($post->post_type == 'enfants'){
                return Enfant::from_post($post);
            }
        }
        return null;
    }

    public static function get_from_parent_ID($parentID) {
        $enfants = [];
        if(is_int($parentID)){
            $posts = get_posts([
                'post_type'=>'enfants',
                'post_status'=>'publish',
                'meta_query'=>[
                    [
                        'key'=>self::$meta_prefix.'parentID',
                        'value'=>$parentID
                    ]
                ],
                'orderby'=>'title',
                'order'=>'ASC',
                'post_per_page' => -1
            ]);
            foreach($posts as $post){
                $enfants[] = Enfant::from_post($post);
            }
        }
        return $enfants;
    }

    public static function register_post_type() {
        register_post_type('enfants', [
            'labels'               => [
                'name'               => 'enfants',
                'singular_name'      => 'enfant',
                'add_new'            => 'Ajouter un enfant',
                'add_new_item'       => 'Ajouter un enfant',
                'edit_item'          => 'Modifier la fiche',
                'new_item'           => 'Nouvelle fiche',
                'view_item'          => 'Voir la fiche',
                'search_items'       => 'Chercher les enfants',
                'not_found'          => 'Aucuns enfants trouvés',
                'not_found_in_trash' => 'Aucuns enfants trouvés dans la corbeille',
                'menu_name'          => 'Enfants',
            ],
            'description'          => 'Affiche les enfants',
            'taxonomies'           => [],
            'public'               => true,
            'show_in_rest'         => true,
            'menu_position'        => 5,
            'menu_icon'            => 'dashicons-admin-users',
            'show_in_nav_menus'    => true,
            'publicly_queryable'   => false,
            'exclude_from_search'  => false,
            'has_archive'          => false,
            'query_var'            => true,
            'rewrite'              => true,
            'capability_type'      => 'post',
            'supports'             => ['title', 'thumbnail', 'custom-fields', 'page-attributes'],
            'register_meta_box_cb' => '\Agcsi\Admin\MetaBoxEnfantsFiche::add_meta_box',
        ]);
    }

}