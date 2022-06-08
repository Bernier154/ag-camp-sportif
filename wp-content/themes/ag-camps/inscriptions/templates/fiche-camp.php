<?php 
$camp = \Agcsi\CPT\Camp::get(get_query_var( 'campsid' ));
$date = get_query_var( 'date' );
if(!$camp || !$date || !current_user_can('manage_options')){
    die('FORBIDDEN');
}
$date_start;
$date_end;
if($date == 'all'){
    $period = $camp->get_valid_days();
    $date_start = $period[0];
    $date_end = end($period);
}

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $date.' / '.$camp->post->post_title ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/css/camp-fiche.min.css">
</head>
<body>
    <main>
        <header>
            <table width="100%">
                <tr>
                    <td>
                        <img src="<?= get_stylesheet_directory_uri() ?>/images/logo_200.png" alt="Logo AG Camps Sportif" />
                    </td>
                    <td class="no-insc">
                        <?php if($date == 'all'): ?>
                            <?php echo $camp->post->post_title.' | '.date_i18n('j F Y',strtotime($date_start)).' au '.date_i18n('j F Y',strtotime($date_end)) ?>

                        <?php else: ?>
                            <?php echo $camp->post->post_title.' | '.date_i18n('j F Y',strtotime($date)) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <div class="content-presence">
                <table>
                    <tr>
                        <th>&nbsp;&nbsp;Présence&nbsp;&nbsp;</th>
                        <th>&nbsp;&nbsp;Nom&nbsp;&nbsp;</th>
                        <th>&nbsp;&nbsp;Prénom&nbsp;&nbsp;</th>
                        <th>Note</th>
                    </tr>
                    <?php 
                        $participants;
                        if($date == 'all'){
                            foreach($camp->get_valid_days() as $day){
                                foreach($camp->get_participants_for_day($day) as $participant){
                                    $participants[$participant->ID] = $participant;
                                }
                            }
                        }else{
                            $participants = $camp->get_participants_for_day($date);
                        }
                    
                    ?>
                    <?php foreach($participants as $enfant): ?>
                    <tr>
                        <td class="small presence">
                            <div>
                                <?php if($date == 'all'): ?>
                                    <?php foreach($camp->get_valid_days() as $d): ?>
                                        <div>
                                            <span><?php echo (date_i18n('D',strtotime($d)))[0] ?></span>
                                            <input type="checkbox" name="" id="">
                                            <input type="checkbox" name="" id="">
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div>
                                        <span><?php echo (date_i18n('D',strtotime($date)))[0] ?></span>
                                        <input type="checkbox" name="" id="">
                                        <input type="checkbox" name="" id="">
                                    </div>
                                <?php endif; ?>
                                
                            </div>
                            
                        </td>
                        <td class="small">&nbsp;&nbsp;<?php echo $enfant->nom ?>&nbsp;&nbsp;</td>
                        <td class="small">&nbsp;&nbsp;<?php echo $enfant->prenom ?>&nbsp;&nbsp;</td>
                        <td class="left limit table">
                            <table>
                                <tr>
                                    <th>urgences:</th>
                                    <td>
                                        <?php echo esc_html(get_user_meta($enfant->parentID,'billing_phone',true)) ?>
                                            <?php echo get_user_meta($enfant->parentID,'billing_phone',true)!=''?' | <small>'.get_user_meta($enfant->parentID,'first_name',true).' '.get_user_meta($enfant->parentID,'last_name',true).'</small><br>':'' ?>


                                        <?php echo esc_html(get_user_meta($enfant->parentID,'work_phone',true)) ?>
                                            <?php echo get_user_meta($enfant->parentID,'work_phone',true)!=''?' | <small>'.get_user_meta($enfant->parentID,'first_name',true).' '.get_user_meta($enfant->parentID,'last_name',true).'</small><br>':'' ?>


                                        <?php echo esc_html(get_user_meta($enfant->parentID,'second_phone',true)) ?>
                                            <?php echo get_user_meta($enfant->parentID,'second_phone',true)!=''?' | <small>'.get_user_meta($enfant->parentID,'second_first_name',true).' '.get_user_meta($enfant->parentID,'second_last_name',true).'</small><br>':'' ?>


                                        <?php echo esc_html(get_user_meta($enfant->parentID,'urgent_phone',true)) ?>
                                            <?php echo get_user_meta($enfant->parentID,'work_phone',true)!=''?' | <small>'.get_user_meta($enfant->parentID,'urgent_first_name',true).' '.get_user_meta($enfant->parentID,'urgent_last_name',true).' '.get_user_meta($enfant->parentID,'urgent_link',true).'</small>':'' ?>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th>#As. Maladies:</th>
                                    <td><?php echo $enfant->assurance_maladie ?></td>
                                </tr>
                                <?php if($enfant->alergie=='Oui'): ?>
                                    <tr>
                                        <th>Allergies:</th>
                                        <td class="<?php echo $enfant->alergie=='Oui'?'important':'' ?> "><?php echo $enfant->alergie ?><br><?php echo $enfant->epipen=='Oui'?'! Epipen !':'' ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if($enfant->medicament=='Oui'): ?>
                                    <tr>
                                        <th>Médicaments:</th>
                                        medicament

                                        <td class="<?php echo $enfant->medicament=='Oui'?'important':'' ?> "><?php echo $enfant->medicament ?><br><?php echo $enfant->medicament_detail ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>note:</th>
                                    <td><?php echo $enfant->particularite ?></td>
                                </tr>
                            </table>
                            
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </header>
    </main>
</body>
</html>

