<?php

function agcs_register_post_types() {

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
        'publicly_queryable'  => false,
        'exclude_from_search' => false,
        'has_archive'         => false,
        'query_var'           => true,
        'rewrite'             => true,
        'capability_type'     => 'post',
        'supports'            => [ 'title','thumbnail','custom-fields', 'page-attributes']
    ]);

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
        'register_meta_box_cb'=> 'add_enfants_meta_box'
    ]);
    
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
        'register_meta_box_cb'=> 'add_inscriptions_meta_box'
    ]);
}
add_action('init', 'agcs_register_post_types');