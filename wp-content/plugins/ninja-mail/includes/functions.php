<?php

// register_shutdown_function(function(){
//   if( ! error_get_last() ) return;
//   echo '<pre>';
//   print_r( error_get_last() );
//   echo '</pre>';
// });

function ninja_mail_override_phpmailer( &$phpmailer ) {

  $headers = $phpmailer->getCustomHeaders();

  // Expecting headers in an array format.
  if( ! $headers || ! is_array( $headers ) ) return;

  // Check for Ninja Forms headers. If not there, move along.
  if( ! in_array( 'X-Ninja-Forms', $headers[0] ) ) return;

  $server_url = NinjaMail\Plugin::get_server_url();

  // Wrap $phpmailer for sending email via the API.
  $mailer = new NinjaMail\Mailer( $phpmailer, $server_url );

  // Override $phpmailer avoid returning a false-positive.
  $phpmailer = $mailer;
}

function ninja_mail_log_email( $args, $response ){
  NinjaMail\Logger::add( $args );
}
