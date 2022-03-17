<?php

namespace NinjaMail;

/**
 * The Ninja Forms "Service" registration.
 */
class Service
{
  protected $base_url;

  public function __construct() {
    $this->base_url = trailingslashit( NF_SERVER_URL ) . 'wp-json/txnmail/v1/client/';
  }

  public function setup() {

    add_action( 'ninja_forms_oauth_disconnect', [ $this, 'disconnect' ] );
    add_filter( 'ninja_forms_services', [ $this, 'register_service' ] );
    add_action( 'wp_ajax_nf_service_ninja-mail', [ $this, 'sync_service' ] );

    add_filter( 'ninja-forms-dashboard-promotions', [ $this, 'remove_promotion' ] );

    return $this;
  }

  public function disconnect() {
    $args = [
      'body' => [
        'hash' => sha1( \NinjaForms\OAuth::get_client_id() . \NinjaForms\OAuth::get_client_secret() ),
      ]
    ];
    wp_remote_post( $this->base_url . \NinjaForms\OAuth::get_client_id() . '/disable', $args );
  }

  public function register_service( $services ){

    $services[ 'ninja-mail' ] = [
      'name' => __( 'Ninja Mail - Transactional Email', 'ninja-mail' ),
      'slug' => 'ninja-mail',
      'description' => 'Increase Email Deliverability with a dedicated email service by Ninja Forms for only $5/month/site.',
      'connect_url' => \NinjaForms\OAuth::connect_url( 'txnmail/app' ),
      'successMessage' => '<div style="padding:0 20px 20xp"><h2>You did it!</h2>
<p>Ninja Forms submission emails will now be delivered by the Ninja Mail transactional service.</p>
<p>If you want to temporarily disable the service, you can use the green toggle on the Ninja Mail module.</p>
<button style="display:block;width:100%;text-align:center;" class="nf-button primary">Got It!</button></div>',
      'successMessageTitle' => 'Ninja Mail Setup Successfully',
    ];

    if( $this->is_service_enabled() ){
      $services[ 'ninja-mail' ][ 'enabled' ] = get_option( 'ninja_forms_transactional_email_enabled', true );
      $services[ 'ninja-mail' ][ 'serviceLink' ] = [
        'text' => 'Manage Subscription',
        'href' => NF_SERVER_URL . '/oauth/txnmail/account/manage',
        'classes' => '',
        'target' => '_blank',
      ];
    } else {
      $services[ 'ninja-mail' ][ 'learnMoreTitle' ] = 'Improve Ninja Forms Email Reliability!';
      $services[ 'ninja-mail' ][ 'learnMore' ] = '
      <div style="padding:20px;">
        <h2>Frustrated that Ninja Forms email isn’t being received?</h2>
        <p>Form submission notifications not hitting your inbox? Some of your visitors getting form feedback via email, others not? By default, your WordPress site sends emails through your web host, which can be unreliable. Your host has spent lots of time and money optimizing to serve your pages, not send your emails.</p>
        <h3>Sign up for Ninja Mail today, and never deal with form email issues again!</h3>
        <p>Ninja Mail is a transactional email service that removes your web host from the email equation.</p>
        <ul style="list-style-type:initial;margin-left: 20px;">
          <li>Sends email through dedicated email service, increasing email deliverability.</li>
          <li>Keeps form submission emails out of spam by using a trusted email provider.</li>
          <li>On a shared web host? Don’t worry about emails being rejected because of blocked IP addresses.</li>
          <li><strong>Only $5/month. Free 14-day trial. Cancel anytime!</strong></li>
        </ul>
        <br />
        <button style="display:block;width:100%;text-align:center;" class="nf-button primary" onclick="Backbone.Radio.channel( \'dashboard\' ).request( \'install:service\', \'ninja-mail\' );var spinner = document.createElement(\'span\'); spinner.classList.add(\'dashicons\', \'dashicons-update\', \'dashicons-update-spin\'); this.innerHTML = spinner.outerHTML; console.log( spinner )">SIGNUP FOR NINJA MAIL NOW!</button>
      </div>
      ';
      $services[ 'ninja-mail' ][ 'serviceLink' ] = [
        'text' => 'Setup',
        'href' => NF_SERVER_URL . '/oauth/txnmail/app?client_id=' . \NinjaForms\OAuth::get_client_id(),
        'classes' => 'nf-button primary'
      ];
    }

    return $services;
  }

  public function sync_service(){
    if( isset( $_POST[ 'enabled' ] ) ){
      $enabled = ( 'false' !== $_POST[ 'enabled' ] );
      $updated = update_option( 'ninja_forms_transactional_email_enabled', $enabled );
      if( ! $updated ){
        wp_die( json_encode( [ 'error' => 'Whoops!' ] ) );
      } else {
        wp_die( 1 );
      }
    }
    wp_die( 0 );
  }

  public function remove_promotion( $promotions ){
    if( $this->is_service_enabled() ){
      unset( $promotions[ 'ninja-mail' ] );
    }
    return $promotions;
  }

  protected function is_service_enabled() {

    if( ! class_exists('\\NinjaForms\\OAuth') ) return false;

    $args = [];
    $response = wp_remote_get( $this->base_url . \NinjaForms\OAuth::get_client_id(), $args );
    $service_data = json_decode( wp_remote_retrieve_body( $response ) );

    if( ! $service_data ) return false;

    $scope = explode( ' ', $service_data->scope );
    return $enabled = ( false !== array_search( 'txnmail', $scope ) );
  }
}
