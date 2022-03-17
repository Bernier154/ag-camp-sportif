<?php

/**
 * Plugin Name: Ninja Mail
 * Plugin URI: http://ninjaforms.com/
 * Description: A transactional email service for Ninja Forms.
 * Version: 1.0.3
 * Author: Ninja Forms
 * Author URI: http://ninjaforms.com
 * Text Domain: ninja-mail
 *
 * Copyright 2018 Ninja Forms.
 */

if( version_compare( PHP_VERSION, '5.6', '>=' ) ) {

  require_once( plugin_dir_path( __FILE__ ) . 'bootstrap.php' );

  \NinjaMail\Plugin::getInstance()->setup( '1.0.3', __FILE__ );

  register_activation_hook( __FILE__, function() {
    update_option( 'ninja_forms_transactional_email_enabled', true );
  } );

} else {

  /**
   * Display an error notice if the PHP version is lower than 5.3.
   *
   * @return void
   */
  function ninja_mail_below_php_version_notice() {
    if ( current_user_can( 'activate_plugins' ) ) {
      echo '<div class="error"><p>' . __( 'Your version of PHP is below the minimum version of PHP required by Ninja Mail. Please contact your host and request that your version be upgraded to 5.3 or later.', 'ninja-mail' ) . '</p></div>';
    }
  }
  add_action( 'admin_notices', 'ninja_mail_below_php_version_notice' );

}
