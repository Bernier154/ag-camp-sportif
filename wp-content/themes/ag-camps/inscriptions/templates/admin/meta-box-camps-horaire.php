<?php
if(agcsi_is_edit_page('new')): ?>
    <h3><strong>Enregistrer le camps pour une première fois avant d'éditer l'horaire. Sauvegarder en tant que brouillon pour éviter qu'il s'affiche pour les utilisateur.</strong></h3>
<?php else :

    $is_published = 'publish' === get_post_status( $post->ID );
    $camp = \Agcsi\CPT\Camp::get($post->ID);
    $nb_places = get_field('disponibilite',$post);
    $participations = [];
    foreach($camp->get_valid_days() as $date){
        $participations[$date] = $camp->get_participants_for_day($date);
    }

?>

<?php $parentsID = []; ?>


<div class="meta-camp">
    <h2>Horaire</h2>
    <p><a target="_blank" href="<?php echo home_url('/').'camps/fiche/'.$camp->ID.'/all' ?>" class="button button-primary">Imprimer la fiche de tout les jours.</a></p>
    <div class="horaire">
        
        <?php foreach($participations as $date=>$participants): ?>
            <div class="jour">
                <p class="nom"><?php echo date_i18n('j F Y',strtotime($date)) ?></p>
                <div class="participants">
                    <?php $participant_arr = array_values($participants); ?>
                    <?php for($i=0;$i<$nb_places;$i++): ?>
                        <?php if(isset($participant_arr[$i])): ?>
                            <p><?php echo $participant_arr[$i]->prenom.' '.$participant_arr[$i]->nom ?></p>
                            <?php $parentsID[] = $participant_arr[$i]->parentID; ?>
                        <?php else: ?>
                            <p>Disponible</p>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <div style="text-align:center;">
                    <a target="_blank" href="<?php echo home_url('/').'camps/fiche/'.$camp->ID.'/'.$date ?>" class="button button-primary">Imprimer la fiche du jour.</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <hr>

    <h2><strong>Email des parents</strong></h2>
    <p style="width:100%"><?php echo implode(', ',array_map(function($id){
        $user = get_user_by('id', $id);
        return $user->user_email;
    },array_unique($parentsID))) ?></p>
</div>




<?php endif;?>