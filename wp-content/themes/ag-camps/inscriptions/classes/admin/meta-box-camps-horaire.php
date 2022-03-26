<?php 
namespace Agcsi\Admin;

class MetaBoxCampsHoraire {

    public static function add_meta_box(){
        add_meta_box( 'info_camp', 'Horaire du camp' ,__NAMESPACE__.'\MetaBoxCampsHoraire::meta_box_content' , 'camps' , 'advanced', 'high' );
    }

    public static function meta_box_content(){
        global $post;
        include(AGCSI_TEMPLATES.'admin/meta-box-camps-horaire.php');
    }

}