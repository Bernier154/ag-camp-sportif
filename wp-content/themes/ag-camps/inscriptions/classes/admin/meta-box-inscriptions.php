<?php 
namespace Agcsi\Admin;

class MetaBoxInscriptions {

    public static function add_meta_box(){
        add_meta_box( 'info_inscription', 'Informations de l\'inscription' ,__NAMESPACE__.'\MetaBoxInscriptions::meta_box_content' , 'inscriptions' , 'advanced', 'high' );

    }

    public static function meta_box_content(){
        global $post;
        include AGCSI_TEMPLATES.'single-inscription.php';
    }

}