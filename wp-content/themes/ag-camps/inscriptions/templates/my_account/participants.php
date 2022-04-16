<div class="info-box full">
    <i class="fa-solid fa-circle-user"></i>
    <h3>Participants</h3>
    <div class="table-overflow">
        <table class="wc-table participants">
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Fiche complète</th>
                <th class="right"><a href="<?php echo wc_get_endpoint_url('participants').'nouveau'; ?>" class=" add-participant">Ajouter un participant</a></th>
            </tr>
            <?php foreach($enfants as $enfant): ?>
                <tr>
                    <td><?php echo $enfant->prenom ?></td>
                    <td><?php echo $enfant->nom ?></td>
                    <td><span class="pastille-fiche <?php echo $enfant->has_complete_info()?'complete':'incomplete' ?>"><?php echo $enfant->has_complete_info()?'Complète':'Incomplète' ?></span></td>
                    <td class="right">
                        <a href="<?php echo wc_get_endpoint_url('participants').$enfant->ID; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="<?php echo wc_get_endpoint_url('participants').'delete/'.$enfant->ID; ?>"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>