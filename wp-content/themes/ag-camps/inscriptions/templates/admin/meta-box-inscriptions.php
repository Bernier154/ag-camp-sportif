Inscriptions
<?php global $post; ?>
<?php ?>
<?php $inscription = Agcsi\CPT\Inscription::get($post->ID) ?>
<p><?php print_r($inscription->participants) ?></p>
<p><?php print_r($inscription->dates) ?></p>
<p><?php print_r($inscription->camp) ?></p>
<p><?php print_r($inscription->parent) ?></p>
