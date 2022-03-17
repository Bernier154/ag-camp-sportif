<?php

namespace NinjaMail;

/**
 * A decorater for sending API based transactional email.
 */
class Mailer implements WordPress\Mailer
{
  protected $phpmailer;
  protected $server_url;

  public function __construct( $phpmailer, $server_url ) {
    $this->phpmailer = $phpmailer;
    $this->server_url = $server_url;
  }

  /**
   * Check for property/method in $phpmailer.
   */
  public function __get( $name ) {
    if( property_exists( $this->phpmailer, $name ) ) {
      return $this->phpmailer->$name;
    }
    return '';
  }

  public function __call( $name, $arguments ) {
    if( method_exists( $this->phpmailer, $name ) ) {
      return call_user_func( [ $this->phpmailer, $name ], $arguments );
    }
    return null;
  }

  public function getAttachments() {
    $attachments = $this->phpmailer->getAttachments();

    // Only return CSV attachments, per service requirement.
    $attachments = array_filter( $attachments, [ $this, 'filter_attachments_csv' ] );

    // Format the attachments, per service requirement.
    $attachments = array_map( [ $this, 'format_attachment' ], $attachments );

    return $attachments;
  }

  public function send() {

    $debug = get_option( 'ninja_forms_transactional_email_debug', false );

    $blocking = $debug || ( defined( 'WP_DEBUG' ) && WP_DEBUG );

    $client_id = \NinjaForms\OAuth::get_client_id();
    $client_hash = sha1( \NinjaForms\OAuth::get_client_id() . \NinjaForms\OAuth::get_client_secret() );

    $to_emails = array_map( [ $this, 'format_emails' ], $this->getToAddresses() );
    $cc_emails = array_map( [ $this, 'format_emails' ], $this->getCcAddresses() );
    $bcc_emails = array_map( [ $this, 'format_emails' ], $this->getBccAddresses() );
    $replyto = array_values( array_map( [ $this, 'format_emails' ], $this->getReplyToAddresses() ) );

    $args = [
      'blocking' => $blocking,
      'body' => [
        'client_id' => $client_id,
        'hash' => $client_hash,
        'email' => (array) $to_emails,
        'cc' => (array) $cc_emails,
        'bcc' => (array) $bcc_emails,
        'from' => $this->From,
        'from_name' => $this->FromName,
        'subject' => $this->Subject,
        'message' => $this->Body,
        'text' => $this->AltBody,
        'debug' => $debug
      ],
    ];

    if( $attachments = $this->getAttachments() ) {
      $args[ 'body' ][ 'attachments' ] = $attachments;
    }

    if ( isset( $replyto[ 0 ] ) ) {
      $args[ 'body' ][ 'replyto' ] = $replyto[ 0 ];
    }

    $response = wp_remote_post( $this->server_url, $args );

    /**
     * Users reporting duplicate sends - need to revisit the fallback feature.
     */
    // // Check for the server response and maybe fallback to phpmailer.
    // if( 200 !== wp_remote_retrieve_response_code( $response ) ) {
    //   return $this->phpmailer->send();
    // }

    /**
     * @param array $args The request arguments.
     * @param array|WP_Error $response Array of results including HTTP headers or WP_Error if the request failed.
     */
    do_action( 'ninja_mail_send', $args, $response );

    return true; // Sent by the Service.
  }

  protected function format_emails( $emails ) {
    return reset( $emails );
  }

  protected function format_attachment( $attachment ){
    return [
      'filename' => $attachment[1], // $filename per PHPMailer docs.
      'filedata' => file_get_contents( $attachment[0] ) // $path per PHPMailer docs.
    ];
  }

  protected function filter_attachments_csv( $attachment ){
    $filename = $attachment[1];
    return 'csv' == pathinfo( $filename, PATHINFO_EXTENSION );
  }
}
