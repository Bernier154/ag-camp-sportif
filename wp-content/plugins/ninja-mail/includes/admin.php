<?php

/*
 * Email log menu screen.
 */
add_action( 'admin_menu', function() {
  add_submenu_page( 'ninja-forms', 'Ninja Mail', 'Ninja Mail', 'manage_options', 'ninja-mail', function() {

    if( isset( $_POST[ 'ninja_mail_enabled' ] ) ){
      update_option( 'ninja_forms_transactional_email_enabled', absint( $_POST[ 'ninja_mail_enabled' ] ) );
    }

    if( isset( $_POST[ 'ninja_mail_debug' ] ) ){
      update_option( 'ninja_forms_transactional_email_debug', absint( $_POST[ 'ninja_mail_debug' ] ) );
    }

    $tab = ( isset( $_GET[ 'tab' ] ) ) ? $_GET[ 'tab' ] : 'settings';

    switch( $tab ){
      case 'settings':
        $enabled = get_option( 'ninja_forms_transactional_email_enabled', false );
        $debug = get_option( 'ninja_forms_transactional_email_debug', false );
        $content = \NinjaMail\Plugin::view( 'admin-settings.html.php', compact( 'enabled', 'debug' ) );
        break;
      case 'logs':
        $logs = array_reverse( NinjaMail\Logger::all() );
        $enabled = get_option( 'ninja_forms_transactional_email_enabled', true );
        $datetime_format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
        $content = \NinjaMail\Plugin::view( 'admin-mail-log.html.php', compact( 'logs', 'enabled', 'datetime_format' ) );
        break;
    }

    echo \NinjaMail\Plugin::view( 'admin-menu.html.php', compact( 'tab', 'content' ) );
  });
}, 9001 );

/*
 * Personal Data Exporter
 */
add_filter( 'wp_privacy_personal_data_exporters', function( $exporters ) {
  $exporters[ 'ninja-mail' ] = array(
    'exporter_friendly_name' => __( 'Ninja Mail', 'ninja-mail' ),
    'callback' => [ 'NinjaMail\Logger', 'export' ],
  );
  return $exporters;
}, 10 );

/*
 * Personal Data Eraser
 */
add_filter( 'wp_privacy_personal_data_erasers', function( $erasers ) {
  $erasers[ 'ninja-mail' ] = array(
    'eraser_friendly_name' => __( 'Ninja Mail', 'ninja-mail' ),
    'callback' => [ 'NinjaMail\Logger', 'delete' ],
  );
  return $erasers;
}, 10 );

add_action( 'admin_post_ninja_mail_logger_clear', function(){
  if( defined( 'WP_DEBUG' ) && WP_DEBUG ){
    update_option( NinjaMail\Logger::OPTION, [] );
    die( 1 );
  }
  die( 0 );
} );

add_action( 'admin_post_ninja_mail_logger_seed', function(){
  if( defined( 'WP_DEBUG' ) && WP_DEBUG ){
    $logs = [];
    for( $i = 0; $i <= 10; $i++ ){
      $id = time() . '_' . $i;
      $logs[] = [
        'data' => [
          'body' => [
            'email' => [ $id . '@test.test' ],
            'from' => $id . '@from.test',
            'subject' => $id,
            'message' => 'This is an email form ' . $id,
            'attachments' => []
          ]
        ],
        'timestamp' => time()
      ];
    }
    update_option( NinjaMail\Logger::OPTION, $logs );
    die( 1 );
  }
  die( 0 );
} );
