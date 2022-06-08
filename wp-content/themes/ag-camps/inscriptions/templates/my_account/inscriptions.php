<div class="info-box full">
    <i class="fa-solid fa-circle-check"></i>
    <h3>Réservations</h3>
    <div class="table-overflow">
        <table class="wc-table participants">
            <tr>
                <th>Nom</th>
                <th>Participants</th>
                <th>Date</th>
                <th>Lieu</th>
                <th class="right"><a href="mailto:<?php echo get_option('adresse_contact') ?>" class="add-participant">Demander une annulation</a></th>
            </tr>
            <?php foreach($inscriptions as $inscription): ?>
                <?php if($inscription->camp): ?>
                    <tr>
                        <td class="dates"><p><a href="<?php echo get_permalink($inscription->camp->post) ?>" ><?php echo $inscription->camp->post->post_title ?></a></p></td>
                        <td>
                            <?php ?>
                            <?php foreach($inscription->participants as $participant): $enfant = \Agcsi\CPT\Enfant::get($participant); ?>
                                <?php if($enfant): ?>
                                    <a href="<?php echo get_permalink($enfant->post) ?>" class="pastille-fiche inscription" ><?php echo $enfant->prenom ?></a>
                                <?php else: ?>
                                    <a href="#" class="pastille-fiche inscription" >Supprimé</a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                        <td class="dates">
                            <?php foreach($inscription->dates as $date): ?>
                                <p><?php echo date_i18n('j F Y',strtotime($date)) ?> <?php echo $inscription->camp->heures_html() ?></p>
                            <?php endforeach; ?>
                        </td>
                        <td class="dates">
                            <p><a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($inscription->camp->adresse()) ?>"><?php echo $inscription->camp->adresse() ?></a></p>
                        </td>
                        <td class="right">
                            <a target="_blank" href="<?php echo get_permalink($inscription->post) ?>"><i class="fa-solid fa-print"></i></a>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td class="dates" colspan="4"><?php echo $inscription->post->post_title ?> (camp supprimé) </td>
                        <td class="right">
                            <a target="_blank" href="<?php echo get_permalink($inscription->post) ?>"><i class="fa-solid fa-print"></i></a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </div>
</div>