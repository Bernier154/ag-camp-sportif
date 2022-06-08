<div class="info-box full">
    <i class="fa-solid fa-house"></i>
    <h3>Bonjour <?php echo wp_get_current_user()->first_name ?>,
        <br>
        <small>Ce n'est pas vous? <a href="<?php echo esc_url( wc_logout_url() ) ?>">Se déconnecter</a></small>
    </h3>
    <?php if(!user_has_complete_info(get_current_user_id())): ?>
        <div class="error-box">
            <p>Pour obtenir le statut complet de la fiche, il vous manque les informations suivantes:</p>
            <ul>
                <?php foreach(user_has_complete_info(get_current_user_id(),true) as $key=>$info):?>
                    <li><a href="#<?php echo $key ?>"><?php echo $info ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <div class="error-box good">
            <p>Votre profil est complété.</p>
        </div>
    <?php endif; ?>
    <h3>Rubrique d'aide: </h3>
    <ul class="tutoriels">
        <li>
            <h4>Entrer les informations de contact: </h4>
            <figure>
                <a target="_blank" href="<?php echo get_stylesheet_directory_uri() ?>/images/info-parent.webp">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/info-parent.webp" alt="">
                </a>
            </figure>
            <ol>
               <li>Allez sure la page "<a href="<?php echo esc_url( wc_get_endpoint_url( 'parent' ) ) ?>"><strong>Information parent</strong></a>" de la section "<a href="<?php echo esc_url( wc_get_endpoint_url( '' ) ) ?>"><strong>Mon compte</strong></a>".</li> 
               <li>Entrez le <strong>prénom</strong>, le <strong>nom</strong>, et un <strong>numéro de téléphone</strong> du parent prinçipal.</li> 
               <li>Entrez le <strong>prénom</strong>, le <strong>nom</strong>, le <strong>lien avec l'enfant</strong>, et un <strong>numéro de téléphone</strong> du contact d'urgence supplémentaire.</li> 
               <li>Cliquez sur sauvegarder</li> 
               <li>Si une information est manquante, un encadré rouge apparaîtra pour vous informer. </li> 
            </ol>
        </li>
        <li>
            <h4>Entrer un nouveau participant: </h4>
            <figure>
                <a target="_blank" href="<?php echo get_stylesheet_directory_uri() ?>/images/ajouter-participant.webp">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/ajouter-participant.webp" alt="">
                </a>
            </figure>
            <ol>
                <li>Allez sur la page "<a href="<?php echo esc_url( wc_get_endpoint_url( 'participants' ) ) ?>"><strong>Participants</strong></a>" de la section "<a href="<?php echo esc_url( wc_get_endpoint_url( '' ) ) ?>"><strong>Mon compte</strong></a>".</li> 
                <li>Cliquez sur "<strong>Ajouter un participant</strong>".</li> 
                <li>Remplissez la fiche pour le participant. Vous pourrez ensuite recommencer pour ajouter un autre participant.</li> 
                <li>Cliquez sur sauvegarder</li> 
                <li>Si une information est manquante, un encadré rouge apparaîtra pour vous informer. </li> 
                <li><strong>Important: La fiche du participant doit être complète pour pouvoir être inscrit à une activité.</strong></li> 
            </ol>
        </li>
        <li>
            <h4>Inscrire un participant à une semaine/journée de camp: </h4>
            <figure>
                <a target="_blank" href="<?php echo get_stylesheet_directory_uri() ?>/images/inscription.webp">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/inscription.webp" alt="">
                </a>
            </figure>
            <ol>
               <li>Pour pouvoir passer à cette étape, vous devez avoir préalablement inscrit un participant, remplis sa fiche d'inscription et entré vos informations de contact d'urgence!</li> 
               <li>Cliquez sur le bouton "<strong>Inscriptions</strong>" du menu prinçipal.</li> 
               <li>Naviguez le calendrier et sélectionnez une semaine disponible.</li> 
               <li>Dans la page de l'activité, sélectionnez les <strong>dates</strong> voulues de la période et les <strong>participants</strong> à inscrire.</li> 
               <li>Appuyez sur "<strong>Ajouter au panier</strong>"</li> 
               <li>Recommencez pour plus d'inscriptions, ou finalisez votre achat pour terminer l'inscription. <strong>Veuillez noter qu'ajouter une inscription au panier ne sécurise pas votre inscription.</strong></li> 
            </ol>
        </li>
        <li>
            <h4>Imprimer une fiche de réservation: </h4>
            <figure>
                <a target="_blank" href="<?php echo get_stylesheet_directory_uri() ?>/images/imprimer.webp">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/imprimer.webp" alt="">
                </a>
            </figure>
            <ol>
                <li>Allez sur la page "<a href="<?php echo esc_url( wc_get_endpoint_url( 'reservations' ) ) ?>"><strong>Réservations</strong></a>" de la section "<a href="<?php echo esc_url( wc_get_endpoint_url( '' ) ) ?>"><strong>Mon compte</strong></a>".</li> 
                <li>Cliquez sur l'icone imprimante d'une inscription pour imprimer la fiche.</li>
            </ol>
        </li>
    </ul>

</div>