<div class="wrap">

  <form id="nfTxnmailSettings" action="" method="post"  style="display:none">

    <table class="form-table">
      <tbody>

        <!-- Enabled -->
        <tr>
          <th scope="row">
            <label for="ninja_mail_enabled">Enabled</label>
          </th>
          <td>
            <input type="hidden" name="ninja_mail_enabled" value="0">
            <input type="checkbox" name="ninja_mail_enabled" value="1" <?php if( $enabled ) echo 'checked'; ?>>
            <?php echo __( 'Send email with Ninja Mail.', 'ninja-mail' ); ?>
          </td>
        </tr>

        <!-- Debug Mode -->
        <tr>
          <th scope="row">
            <label for="ninja_mail_debug">Debug Mode</label>
          </th>
          <td>
            <input type="hidden" name="ninja_mail_debug" value="0">
            <input type="checkbox" name="ninja_mail_debug" value="1" <?php if( $debug ) echo 'checked'; ?>>
            <?php echo __( 'Debugging mode.', 'ninja-mail' ); ?>
          </td>
        </tr>

      </tbody>
    </table>

    <p class="submit">
      <button type="submit" class="button button-primary" data-label="Save Settings">Save Settings</button>
    </p>

  </form>

</div>
