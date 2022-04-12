<?php 
    $camp = Agcsi\CPT\Camp::get(get_the_id());
?>
<?php get_header(); ?>
<main id="main" class="site-main-wrapper">
    <?php get_template_part('parts/inc','banner') ?>
    <div class="content">
        <div class="info-camp">
            <?php if(get_post_thumbnail_id($post->ID)): ?>
                <figure class="camp-banner">
                    <img src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id($post->ID), 'full' ); ?>" alt="">
                </figure>
            <?php endif; ?>
            <h2>Description</h2>
            <p><?php echo get_field('description') ?></p>
            <h2>Tarification</h2>
            <div class="grille-tarification">
                <table>
                    <tr>
                        <th>switch</th>
                        <th>1 enfant</th>
                        <th>2 enfants<br><small>(2 Enfants 15% de réduction sur le 2e enfant)</small></th>
                        <th>3 enfants<br><small>(Et plus)</small></th>
                    </tr>
                    <tr>
                        <td>1 journée </i> </td>
                        <td><?php echo $camp->price_for_one_day(1) / 100 ?>$</td>
                        <td><?php echo $camp->price_for_one_day(1,2) / 100 ?>$</td>
                        <td><?php echo $camp->price_for_one_day(1,3) / 100 ?>$</td>
                    </tr>
                    <tr>
                        <td>1 semaine <i class="fa-solid fa-circle-info"></i> </td>
                        <td><?php echo $camp->price_for_one_day(7,1,7) / 100 ?>$/sem</td>
                        <td><?php echo $camp->price_for_one_day(7,2,7) / 100 ?>$/sem</td>
                        <td rowspan="3">3 enfants et plus d'une même famille à <?php echo $camp->price_for_one_day(7,3,7) / 100 ?>$/sem</td>
                    </tr>
                    <tr>
                        <td>3 semaines <i class="fa-solid fa-circle-info"></i> </td> 
                        <td><?php echo $camp->price_for_one_day(21,1,7) / 100 ?>$/sem</td>
                        <td><?php echo $camp->price_for_one_day(21,2,7) / 100 ?>$/sem</td>
                    </tr>
                    <tr>
                        <td>6 semaines <i class="fa-solid fa-circle-info"></i> </td>
                        <td><?php echo $camp->price_for_one_day(42,1,7) / 100 ?>$/sem</td>
                        <td><?php echo $camp->price_for_one_day(42,2,7) / 100 ?>$/sem</td>
                    </tr>
                </table>
            </div>
        </div>
        <form id="inscription" class="camp-reservation <?php echo is_user_logged_in()?'':'need-login' ?>">
            <input type="hidden" name="campId" value="<?php echo $camp->post->ID ?>">
            <h2>Inscription</h2>
            <div class="section">
                <h4>Dates: </h4>
                <label for="">Sélectionnez les dates voulues:</label>
                <div class="calendar-wrapper">
                    <input type="text" name="dates" class="date-picker-input" id="calendrier" />
                    <datalist id="valid-days">
                        <?php foreach($camp->get_valid_days() as $day): ?>
                            <?php if($camp->get_disponibility_for_day($day,true) != 0 ): ?>
                                <option value="<?php echo $day ?>"><?php echo $camp->get_disponibility_for_day($day,true) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </datalist>
                    <datalist id="full-days">
                        <?php foreach($camp->get_valid_days() as $day): ?>
                            <?php if($camp->get_disponibility_for_day($day,true) == 0 ): ?>
                                <option value="<?php echo $day ?>"></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </datalist>
                    <legend>
                        <p class="indispo">Les journées grisées ne sont plus disponibles.</p>
                        <p class="dispo">Les disponibilités sont inscrites dans les petits cercles rouges.</p>
                    </legend>
                    
                    <button id="all-week" class="ins-btn" >Sélectionner la période complète</button>
                </div>
                        </div>
            <?php if(is_user_logged_in()): ?>
                <div class="section">
                    <h4>Participants à inscrire: </h4>
                    <div class="liste-enfants">
                        <?php foreach(\Agcsi\CPT\Enfant::get_from_parent_ID(get_current_user_id()) as $enfant): ?>
                            <?php if($enfant->has_complete_info()): ?>
                                <label for="p-<?php echo $enfant->ID ?>"><input id="p-<?php echo $enfant->ID ?>" name="enfants[]" type="checkbox" value="<?php echo $enfant->ID ?>"/><?php echo $enfant->prenom ?></label>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <small><a href="<?php echo wc_get_endpoint_url('participants','',get_permalink( get_option('woocommerce_myaccount_page_id') )).'nouveau'; ?>">Enregistrer un nouveau participant.</a></small>
                </div>
                <div class="section">
                    <div id="add-to-cart">
                        <div class="inner">
                            <h4>Prix:</h4>
                        </div>
                        <div class="no-choice">
                            <p>Veuillez choisir une date et au moins un participant.</p>
                        </div>
                        <div class="loader hide"><i class="fa-solid fa-circle-notch fa-spin"></i></div>
                        <p class="error"></p>
                    </div>
                    
                </div>
            <?php else: ?>
                <div class="need-login-container">
                    <div class="contenu">
                        <p>Veuillez vous connecter avant de créer une inscription.</p>
                        <p><a class="ins-btn" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">Connexion</a></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </form>

</main>
<?php  get_footer(); ?>