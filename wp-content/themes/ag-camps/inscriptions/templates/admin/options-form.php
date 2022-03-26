<style>
    .options-form textarea,
    .options-form input:not([name="submit"]) {
        width: 450px;
    }
</style>
<h1>Page d'options du module de camps</h1>
<br>
<form method="POST" class="options-form" action="options.php">
    <?php
    settings_fields( 'page-options-agcsi' );
    do_settings_sections( 'page-options-agcsi' );
    submit_button();
    ?>
</form>