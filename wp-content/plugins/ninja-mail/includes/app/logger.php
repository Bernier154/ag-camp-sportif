<?php

namespace NinjaMail;

/**
 * A simple WP Option based logger.
 */
class Logger
{
  const OPTION = 'ninja-mail-log';

  public static function all() {
    return (array) get_option( self::OPTION, [] );
  }

  public static function add( $data ) {
    $logs = self::all();
    $logs[] = [
      'data' => $data,
      'timestamp' => time(),
    ];
    update_option( self::OPTION, array_slice( $logs, -50 ) ); // Limit 50.
  }

  /*
   * WordPress Personal Data Exporter
   *
   * Export the email log.
   * - Includes the subject and the message of the email.
   * - Includes the email key as the to address,
   *     but not the full array of addresses (to avoid leaking other emails).
   */
  public static function export( $email_address, $page = 1 ) {

    $logs = array_filter( self::all(), function( $log ) use ( $email_address ) {
      return in_array( $email_address, $log[ 'data' ][ 'body' ][ 'email' ] );
    });

    $export_items = array_map( function( $log ){
      return array(
        'group_id' => 'ninja-mail-log',
        'group_label' => __( 'Ninja Mail Log', 'ninja-mail' ),
        'item_id' => $log[ 'timestamp' ],
        'data' => array(
          array(
            'name' => __( 'To' ),
            'value' => $email_address,
          ),
          array(
            'name' => __( 'Subject' ),
            'value' => $log[ 'data' ][ 'body' ][ 'subject' ]
          ),
          array(
            'name' => __( 'Message' ),
            'value' => $log[ 'data' ][ 'body' ][ 'message' ]
          ),
        ),
      );
    }, $logs );

    return array(
      'data' => $export_items,
      'done' => true,
    );
  }

  /*
   * WordPress Personal Data Eraser
   *
   * Delete the email logs for a given by email address.
   */
  public static function delete( $email_address, $page = 1 ) {

    $all_logs = self::all();

    $filtered_logs = array_filter( self::all(), function( $log ) use ( $email_address ) {
      return ! in_array( $email_address, $log[ 'data' ][ 'body' ][ 'email' ] );
    });

    update_option( self::OPTION, $filtered_logs );

    // Compare the counts to determine if anything was filtered out.
    $items_removed = ( count( $all_logs ) > count( $filtered_logs ) );

    return array(
      'items_removed' => $items_removed,
      'items_retained' => false, // always false in this example
      'messages' => [], // no messages in this example
      'done' => true,
    );
  }
}
