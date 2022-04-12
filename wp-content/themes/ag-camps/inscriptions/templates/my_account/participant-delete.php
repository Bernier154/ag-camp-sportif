<div class="info-box danger">
    <i class="fa-solid fa-circle-exclamation"></i>  
    <h2>Vous êtes sur le point de supprimer: <?php echo $enfant->prenom.' '.$enfant->nom ?></h2>
    <div class="boutons">
        <a  href="<?php echo wc_get_endpoint_url('participants')?>">Annuler</a>
        <a class="danger" href="<?php echo wc_get_endpoint_url('participants').'delete/'.$enfant->ID; ?>/confirm">Confirmer</a>
    </div>
</div>
