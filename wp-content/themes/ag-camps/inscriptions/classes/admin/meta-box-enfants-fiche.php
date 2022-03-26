<?php 
namespace Agcsi\Admin;

class MetaBoxEnfantsFiche {

    public static function add_meta_box(){
        add_meta_box( 'info_enfant', 'Informations de l\'enfant' ,__NAMESPACE__.'\MetaBoxEnfantsFiche::meta_box_content' , 'enfants' , 'advanced', 'high' );
    }

    public static function meta_box_content(){
        include(AGCSI_TEMPLATES.'admin/meta-box-enfants-fiche.php');
    }

}