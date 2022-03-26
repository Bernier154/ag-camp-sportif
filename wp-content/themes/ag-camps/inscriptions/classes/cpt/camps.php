<?php
namespace Agcsi\CPT;

class Camp {
    function __constructor(){

    }

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
    }

}