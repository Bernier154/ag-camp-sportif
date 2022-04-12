<?php foreach(\Agcsi\CPT\Enfant::$fillables as $fillable): ?>
    <h3><?php echo $fillable ?></h3>
    <pre><?php print_r($enfant->{$fillable}) ?></pre> 
<?php endforeach; ?>