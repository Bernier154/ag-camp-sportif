<?php

namespace NinjaMail;

/**
 * The main plugin class/singleton.
 */
class Plugin extends WordPress\Plugin
{
  const NINJA_FORMS_MIN_VERSION = '3.3.2';

  public function setup( $version, $file ) {
      $this->version = $version;
      $this->url = plugin_dir_url( $file );
      $this->dir = plugin_dir_path( $file );

      if( self::is_service_enabled() && self::is_service_connected() ){
        add_action( 'phpmailer_init', 'ninja_mail_override_phpmailer' );
        add_action( 'ninja_mail_send', 'ninja_mail_log_email', 10, 2 );
      }

      if( ! self::is_ninja_forms_installed() || ! defined('\Ninja_Forms::VERSION') || ! self::is_ninja_forms_compatible( \Ninja_Forms::VERSION, self::NINJA_FORMS_MIN_VERSION ) ){
        add_action( 'admin_notices', [ $this, 'ninja_forms_min_version' ] );
      }

      $this->service = (new Service)->setup();
  }

  public static function get_server_url() {
    return trailingslashit( NF_SERVER_URL ) . 'wp-json/txnmail/v1/mailing';
  }

  public static function is_service_enabled() {
    return get_option( 'ninja_forms_transactional_email_enabled', true );
  }

  public static function is_service_connected() {
    if( ! class_exists('\\NinjaForms\\OAuth') ) return false;
    return \NinjaForms\OAuth::is_connected();
  }

  public function is_ninja_forms_installed() {
    return ( class_exists ( 'Ninja_Forms', $autoload = false ) );
  }

  public static function is_ninja_forms_compatible( $version, $version_required ) {
    return version_compare( $version, $version_required, '>=' );
  }

  public function ninja_forms_min_version() {
    echo '<div class="error"><p>'
        . __( 'Ninja Mail requires the latest version of Ninja Forms.', 'ninja-mail' )
        . '</p></div>';
  }
}
