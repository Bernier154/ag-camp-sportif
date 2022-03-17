<?php

add_filter( 'kozo_register_tests', function( $tests ) {
  return array_merge( $tests, [
    'ninja_mail_version_compare_1' => [
      'id' => 'ninja_mail_version_compare_1',
      'name' => 'Ninja Mail Version Compare 1',
      'expect' => false,
      'callback' => function(){
        return \NinjaMail\Plugin::is_ninja_forms_compatible( '3.3.1', '3.3.2' );
      }
    ],
    'ninja_mail_version_compare_2' => [
      'id' => 'ninja_mail_version_compare_2',
      'name' => 'Ninja Mail Version Compare 2',
      'expect' => true,
      'callback' => function(){
        return \NinjaMail\Plugin::is_ninja_forms_compatible( '3.3.2', '3.3.2' );
      }
    ],
    'ninja_mail_version_compare_3' => [
      'id' => 'ninja_mail_version_compare_3',
      'name' => 'Ninja Mail Version Compare 3',
      'expect' => false,
      'callback' => function(){
        return \NinjaMail\Plugin::is_ninja_forms_compatible( '3.3.2-alpha', '3.3.2' );
      }
    ],
    'ninja_mail_version_compare_4' => [
      'id' => 'ninja_mail_version_compare_4',
      'name' => 'Ninja Mail Version Compare 4',
      'expect' => true,
      'callback' => function(){
        return \NinjaMail\Plugin::is_ninja_forms_compatible( '3.3.3', '3.3.2' );
      }
    ],
  ]);
} );
