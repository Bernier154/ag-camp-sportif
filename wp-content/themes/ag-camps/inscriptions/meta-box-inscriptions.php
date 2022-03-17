<?php 

function add_inscriptions_meta_box(){
    add_meta_box( 'info_inscription', 'Informations de l\'inscription' ,'inscription_meta_box' , 'inscriptions' , 'advanced', 'high' );
}

function inscription_meta_box(){
    echo 'inscription';
}