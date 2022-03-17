<?php 

function add_enfants_meta_box(){
    add_meta_box( 'info_enfant', 'Informations de l\'enfant' ,'enfant_meta_box' , 'enfants' , 'advanced', 'high' );
}

function enfant_meta_box(){
    echo 'jesus';
}