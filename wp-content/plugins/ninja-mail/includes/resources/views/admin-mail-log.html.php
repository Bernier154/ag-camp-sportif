<style media="screen">
  .ninja-mail-disabled-notice {
    color: white;
    text-align: center;
    padding: 10px;
    margin-left: -20px; /* Account for admin menu margin. */
    background-color: red;
  }
  #ninjaMailLog {
    border-collapse: collapse;
  }
  #ninjaMailLog th {
    text-align: left;
  }
  #ninjaMailLog th,
  #ninjaMailLog td {
    padding: 10px;
    white-space: nowrap;
  }
  #ninjaMailLog tbody tr:nth-of-type(2n+1) {
    background-color: lightgray;
  }
</style>

<?php if( ! $enabled ): ?>
  <div class="ninja-mail-disabled-notice">
    Transactional Email is currently disabled.
  </div>
<?php endif; ?>
<div class="wrap">

  <table id="ninjaMailLog" style="width: 100%;">
    <thead>
      <tr style="text-align:left;">
        <th></th>
        <th>To</th>
        <th>From</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Attachments</th>
        <th>Request</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $logs as $log ): ?>
      <?php
        $message = htmlspecialchars( json_encode( trim( $log[ 'data' ][ 'body' ][ 'message' ] ) ) );

        if( isset( $log[ 'data' ][ 'body' ][ 'attachments' ] ) ){
          $attachments = implode( array_map( function( $attachment ){
            return $attachment[ 'filename' ];
          }, $log[ 'data' ][ 'body' ][ 'attachments' ] ));
        } else {
          $attachments = [];
        }
        $raw_request = htmlspecialchars( json_encode( $log[ 'data' ][ 'body' ] ) );
      ?>
      <tr>
        <td><?php echo date_i18n( $datetime_format, $log[ 'timestamp' ] ); ?></td>
        <td><?php echo implode( $log[ 'data' ][ 'body' ][ 'email' ] ); ?></td>
        <td><?php echo $log[ 'data' ][ 'body' ][ 'from' ]; ?></td>
        <td><?php echo $log[ 'data' ][ 'body' ][ 'subject' ]; ?></td>
        <td>
          <button type="button" onclick="alert('<?php echo $message; ?>');">View Message</button>
        </td>
        <td>
          <button type="button" onclick="alert('<?php echo $attachments; ?>');">View Attachments</button>
        </td>
        <td>
          <button type="button" onclick="alert('<?php echo $raw_request; ?>');">View Request</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <?php if( defined( 'WP_DEBUG' ) && WP_DEBUG ): ?>
    <tfoot>
      <tr>
        <td colspan="7">
          <button id="ninjaMailLogClear">Clear</button>
          <button id="ninjaMailLogSeed">Seed</button>
        </td>
      </tr>
    </tfoot>
    <?php endif; ?>
  </table>
</div>

<?php if( defined( 'WP_DEBUG' ) && WP_DEBUG ): ?>
<script type="text/javascript">
  jQuery( document ).ready( function() {

    jQuery( '#ninjaMailLogClear' ).click( function(){
      jQuery.post( '<?php echo add_query_arg( 'action', 'ninja_mail_logger_clear', admin_url( 'admin-post.php' ) ); ?>', function( response ) {
        location.reload();
      });
    });

    jQuery( '#ninjaMailLogSeed' ).click( function(){
      jQuery.post( '<?php echo add_query_arg( 'action', 'ninja_mail_logger_seed', admin_url( 'admin-post.php' ) ); ?>', function( response ) {
        location.reload();
      });
    });

  });
</script>
<?php endif; ?>
