<div class="wrap">

  <h2><?php echo __( 'Ninja Mail', 'ninja-mail' ); ?></h2>

  <h2 class="nav-tab-wrapper">
    <a class="nav-tab <?php if( 'settings' == $tab ) echo 'nav-tab-active'; ?>" href="?page=ninja-mail">Settings</a>
    <a class="nav-tab <?php if( 'logs' == $tab ) echo 'nav-tab-active'; ?>" href="?page=ninja-mail&tab=logs">Logs</a>
  </h2>

  <?php echo $content; ?>

</div>
