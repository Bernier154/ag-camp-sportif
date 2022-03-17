<?php

add_action('admin_menu', 'sports_camp_menu_page_removing', 11);

function sports_camp_menu_page_removing() {
    remove_menu_page('edit.php?post_type=acf');
    remove_menu_page('edit.php');
    remove_menu_page('edit-comments.php');
}
