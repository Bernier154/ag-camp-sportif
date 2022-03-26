<?php
namespace Agcsi\CPT;

class Inscription {
    function __constructor(){

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
            'show_in_rest'        => true,
            'menu_position'       => 5,
            'menu_icon'         => 'dashicons-clipboard',
            'show_in_nav_menus'   => true,
            'publicly_queryable'  => false,
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