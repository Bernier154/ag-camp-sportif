<?php 
namespace Agcsi\Helpers;

class EditorDisable {

    public static function by_template_slug($template_slug){
        if (!(is_admin() && !empty($_GET['post']))) {
            return null;
        }
        if($template_slug == get_page_template_slug($_GET['post'])){
            add_filter('gutenberg_can_edit_post_type', __NAMESPACE__.'\EditorDisable::disable_gutenberg', 10, 2);
            add_filter('use_block_editor_for_post_type', __NAMESPACE__.'\EditorDisable::disable_gutenberg', 10, 2);
            add_action( 'admin_head', __NAMESPACE__.'\EditorDisable::disable_classic' );
        }
    }

    public static function disable_gutenberg($can_edit, $post_type){
        return false;
    }
    public static function disable_classic(){
        remove_post_type_support( 'page', 'editor' );
        remove_post_type_support( 'page', 'author' );
    }


}