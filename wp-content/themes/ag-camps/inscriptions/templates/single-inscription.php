<?php 
    $inscription = \Agcsi\CPT\Inscription::get(get_the_ID());
    if(!$inscription){die;}
    if($inscription->parent != get_current_user_id() && !is_admin()){die;}
    $camp = $inscription->camp;
?>
<?php if(!is_admin()): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_the_title() ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/css/camp-fiche.min.css">
</head>
<body>
<?php endif; ?>
    <main>
        <header>
            <table width="100%">
                <tr>
                    <td>
                        <img src="<?= get_stylesheet_directory_uri() ?>/images/logo_200.png" alt="Logo AG Camps Sportif" />
                    </td>
                    <td class="no-insc">
                        #<?php echo str_pad($inscription->ID, 10, "0", STR_PAD_LEFT); ?>
                    </td>
                </tr>
            </table>
        </header>
        <div class="contenu">
            <?php if($camp): ?>
            <h2>Inscription pour: <?php echo $camp->post->post_title; ?></h2>
            <table width="100%">
                <tr>
                    <td width="50%">
                        <h4>Date(s): </h4>
                        <p>
                            <?php foreach($inscription->dates as $date): ?>
                                <span><?php echo date_i18n('j F Y',strtotime($date)) ?> <?php echo $camp->heures_html() ?></span><br>
                            <?php endforeach; ?>
                        </p>
                    </td>
                    <td width="50%">
                        <h4>Lieu:</h4>
                        <p><?php echo $camp->adresse(); ?> </p>
                    </td>
                </tr>
            </table>
            <?php else: ?>
                <h2><?php echo $inscription->post->post_title ?></h2>
            <?php endif; ?>
            
            
            <hr>
            <h2>Participants:</h2>
            <div class="participants">
            <?php foreach($inscription->participants as $enfantid): ?>
                <?php $enfant = \Agcsi\CPT\Enfant::get($enfantid); ?>
                <?php if($enfant): ?>
                    <div class="participant">
                        <h4><?php echo $enfant->prenom.' '.$enfant->nom ?></h4>
                        <p>Date de naissance: <?php echo $enfant->date_naissance ?></p>
                        <p>Taille T-shirt: <?php echo $enfant->taille_tshirt ?></p>
                        <p>Taille T-shirt Hockey: <?php echo $enfant->taille_tshirt_hockey ?></p>
                        <p>Alergies: <?php echo agcsi_truth_to_bool($enfant->alergie)?'<strong>Oui</strong>':'non' ?></p>
                        <p>A besoins de son épipen: <?php echo agcsi_truth_to_bool($enfant->epipen)?'<strong>Oui</strong>':'non' ?></p>
                        <p>Particuliarités:<br><?php echo $enfant->particularite ?></p>
                    </div>
                <?php else: ?>
                    <div class="participant">
                        <h4>Participant supprimé</h4>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
        </div>
        <hr>
        <h2>Notes:</h2>
        <p><?php echo get_option( 'note_sous_impression_inscription' ) ?></p>
    </main>
    <?php if(!is_admin()): ?>
    <div class="no-print print-btn"><button onClick="window.print()">Imprimer la fiche</button></div>
</body>
</html>
<?php endif; ?>