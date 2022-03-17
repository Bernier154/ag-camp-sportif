<?php

/**
 * Plugin Name: Ninja Mail
 * Plugin URI: http://ninjaforms.com/
 * Description: A transactional email service for Ninja Forms.
 * Version: 1.0.6
 * Author: Ninja Forms
 * Author URI: http://ninjaforms.com
 * Text Domain: ninja-mail
 *
 * Copyright 2018 Ninja Forms.
 */

 /**
   * Display an error notice if the PHP version is lower than 5.3.
   *
   * @return void
   */
  function ninja_mail_sunset_notice() {
    if ( current_user_can( 'activate_plugins' ) ) {
      echo '<div class="error"><p>' . __( 'Ninja Mail has been shut down as of April 1, 2021. We highly recommend upgrading to our new service <a href="https://sendwp.com">SendWP</a>. No email will be sent by Ninja Mail after March 31st, 2021. Please deactivate Ninja Mail.', 'ninja-mail' ) . '</p></div>';
    }
  }
  add_action( 'admin_notices', 'ninja_mail_sunset_notice' );

if( version_compare( PHP_VERSION, '5.6', '>=' ) ) {

  require_once( plugin_dir_path( __FILE__ ) . 'bootstrap.php' );

  \NinjaMail\Plugin::getInstance()->setup( '1.0.5', __FILE__ );

  register_activation_hook( __FILE__, function() {
    update_option( 'ninja_forms_transactional_email_enabled', false );
  } );

} else {

  /**
   * Display an error notice if the PHP version is lower than 5.3.
   *
   * @return void
   */
  function ninja_mail_below_php_version_notice() {
    if ( current_user_can( 'activate_plugins' ) ) {
      echo '<div class="error"><p>' . __( 'Your version of PHP is below the minimum version of PHP required by Ninja Mail. Please contact your host and request that your version be upgraded to 5.6 or later.', 'ninja-mail' ) . '</p></div>';
    }
  }
  add_action( 'admin_notices', 'ninja_mail_below_php_version_notice' );

}
