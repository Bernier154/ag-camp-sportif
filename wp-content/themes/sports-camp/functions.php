<?php

require_once __DIR__ . '/utils/index.php';

require_once __DIR__ . '/database/index.php';
require_once __DIR__ . '/hooks/index.php';

require_once __DIR__ . '/start.php';

add_filter( 'ninja_forms_i18n_front_end', 'my_custom_ninja_forms_i18n_front_end' );
function my_custom_ninja_forms_i18n_front_end( $strings )
{
    $strings['fieldsMarkedRequired'] = 'Les champs sont tous requis*';
    return $strings;
}