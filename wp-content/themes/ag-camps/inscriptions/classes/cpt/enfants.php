<?php
namespace Agcsi\CPT;

class Enfant {
    function __constructor(){

    }

    public static function register_post_type(){
        register_post_type('enfants', [
            'labels' => [
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
            'description'         => 'Affiche les enfants',
            'taxonomies'          => [],
            'public'              => true,
            'show_in_rest'        => true,
            'menu_position'       => 5,
            'menu_icon'         => 'dashicons-admin-users',
            'show_in_nav_menus'   => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => false,
            'has_archive'         => false,
            'query_var'           => true,
            'rewrite'             => true,
            'capability_type'     => 'post',
            'supports'            => [ 'title','thumbnail','custom-fields', 'page-attributes'],
            'register_meta_box_cb'=> '\Agcsi\Admin\MetaBoxEnfantsFiche::add_meta_box'
        ]);
    }

}