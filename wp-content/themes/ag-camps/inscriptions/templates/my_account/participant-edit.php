<div class="info-box">
    <i class="fa-solid fa-circle-info"></i>
    <?php if(!$enfant->has_complete_info() && $enfant->ID): ?>
        <div class="error-box">
            <p>Pour obtenir le statut complet de la fiche, il vous manque les informations suivantes:</p>
            <ul>
                <?php foreach($enfant->has_complete_info(true) as $key=>$info):?>
                    <li><a href="#<?php echo $key ?>"><?php echo $info ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="" method="POST" class="form-enfant">
        <h3>Général</h3>
        <input type="hidden" name="agcsi_enfant_id" value="<?php agcsi_fill_text('agcsi_enfant_id',$enfant->ID) ?>">
        <?php wp_nonce_field( 'save_and_edit_enfant', 'save_enfant_nonce' ); ?>
        <div class="form-row">
            <label for="prenom">
                Prenom *
                <input type="text" name="agcsi_enfant_prenom" id="prenom" value="<?php agcsi_fill_text('agcsi_enfant_prenom',$enfant->prenom) ?>" required />
            </label>
            <label for="nom">
                Nom *
                <input type="text" name="agcsi_enfant_nom" id="nom" value="<?php agcsi_fill_text('agcsi_enfant_nom',$enfant->nom) ?>" required />
            </label>
        </div>
        <div class="form-row">
            <label for="date-de-naissance">
                Date de naissance
                <input type="date" name="agcsi_enfant_date_naissance" id="date-de-naissance" value="<?php agcsi_fill_text('agcsi_enfant_date_naissance',$enfant->date_naissance) ?>" />
            </label>
            <label for="assurance_maladie">
                Numéro d'assurance maladie
                <input type="text" name="agcsi_enfant_assurance_maladie" id="assurance_maladie" value="<?php agcsi_fill_text('agcsi_enfant_assurance_maladie',$enfant->assurance_maladie) ?>">
            </label>
        </div>
        <div class="form-row">
            <label class="full-width" for="sports_pratiques">
                Sport(s) pratiqué(s) lors des 12 derniers mois (Sport, niveau, ville)
                <textarea name="agcsi_enfant_sport_pratique" id="sports_pratiques" rows="3"><?php agcsi_fill_text('agcsi_enfant_sport_pratique',$enfant->sport_pratique) ?></textarea>
            </label>
        </div>
        <div class="form-row">
            <label for="grandeur-t-shirt">
                Grandeur T-shirt
                <fieldset class="is-grid">
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_taille_tshirt" value="YS" id="YS"  <?php  agcsi_check_radio('agcsi_enfant_taille_tshirt','YS',$enfant->taille_tshirt) ?> /><label for="YS">YS</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_taille_tshirt" value="YM" id="YM" <?php  agcsi_check_radio('agcsi_enfant_taille_tshirt','YM',$enfant->taille_tshirt) ?> /><label for="YM">YM</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_taille_tshirt" value="YL" id="YL" <?php  agcsi_check_radio('agcsi_enfant_taille_tshirt','YL',$enfant->taille_tshirt) ?> /><label for="YL">YL</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_taille_tshirt" value="YXL" id="YXL" <?php  agcsi_check_radio('agcsi_enfant_taille_tshirt','YXL',$enfant->taille_tshirt) ?> /><label for="YXL">YXL</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_taille_tshirt" value="S" id="S" <?php  agcsi_check_radio('agcsi_enfant_taille_tshirt','S',$enfant->taille_tshirt) ?> /><label for="S">S</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_taille_tshirt" value="M" id="M" <?php  agcsi_check_radio('agcsi_enfant_taille_tshirt','M',$enfant->taille_tshirt) ?> /><label for="M">M</label></span>
                </fieldset>
            </label>
            <label for="grandeur-t-shirt-hockey">
                Grandeur T-shirt
                <fieldset class="is-grid">
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_taille_tshirt_hockey" value="YS/YM" id="YS-h" <?php  agcsi_check_radio('agcsi_enfant_taille_tshirt_hockey','YS/YM',$enfant->taille_tshirt_hockey) ?> /><label for="YS-h">YS</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_taille_tshirt_hockey" value="YM/YXL" id="YM-h" <?php  agcsi_check_radio('agcsi_enfant_taille_tshirt_hockey','YM/YXL',$enfant->taille_tshirt_hockey) ?> /><label for="YM-h">YM</label></span>
                </fieldset>
            </label>
        </div>
        <div class="form-row">
            <label class="full-width" for="autorisation-photo">
                J'autorise AG Camp Sportif à prendre mon enfant en photo et que ces photos apparaissent sur nos réseaux sociaux et notre site internet?
                <fieldset>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_autorisation_photo" value="Oui" id="photo-oui" <?php  agcsi_check_radio('agcsi_enfant_autorisation_photo','Oui',$enfant->autorisation_photo) ?> /><label for="photo-oui">Oui</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_autorisation_photo" value="Non" id="photo-non" <?php  agcsi_check_radio('agcsi_enfant_autorisation_photo','Non',$enfant->autorisation_photo) ?> /><label for="photo-non">Non</label></span>
                </fieldset>
            </label>
        </div>
        <h3>Renseignements médicaux</h3>
        <div class="form-row">
            <label for="grandeur-t-shirt">
                Cochez si votre enfant souffre d'une des maladies suivantes.
                <fieldset>
                    <span class="checkbox-wrap"><input type="checkbox" name="agcsi_enfant_maladie[]"        value="asthme"      id="asthme"     <?php agcsi_check_checkbox('agcsi_enfant_maladie'       ,'asthme'   ,$enfant->maladies); ?> /><label for="asthme">Asthme</label></span>
                    <span class="checkbox-wrap"><input type="checkbox" name="agcsi_enfant_maladie[]"        value="épilepsie"   id="epilepsie"  <?php agcsi_check_checkbox('agcsi_enfant_maladie'       ,'épilepsie',$enfant->maladies); ?> /><label for="epilepsie">Épilepsie</label></span>
                    <span class="checkbox-wrap"><input type="checkbox" name="agcsi_enfant_maladie[]"        value="diabète"     id="diabete"    <?php agcsi_check_checkbox('agcsi_enfant_maladie'       ,'diabète'  ,$enfant->maladies); ?> /><label for="diabete">Diabète</label></span>
                    <span class="checkbox-wrap"><input type="checkbox" name="agcsi_enfant_autre_maladie"    value="autre"       id="autre"      <?php agcsi_check_checkbox('agcsi_enfant_autre_maladie' ,'autre'    ,agcsi_check_autre_maladie(['asthme','épilepsie','diabète'],$enfant->maladies)?true:false); ?> /><label for="autre">Autre: </label><input type="text" name="agcsi_enfant_maladie_autre_data" id="autre" value="<?php agcsi_fill_text('agcsi_enfant_maladie_autre_data',agcsi_check_autre_maladie(['asthme','épilepsie','diabète'],$enfant->maladies)) ?>" /></span>
                </fieldset>
            </label>
            <label for="depuis-quand">
                Si vous avez répondu oui à l'une des maladies, veuillez spécifier depuis quand.
                <input type="text" name="agcsi_enfant_maladie_debut" id="depuis-quand" value="<?php agcsi_fill_text('agcsi_enfant_maladie_debut',$enfant->maladie_debut) ?>" />
            </label>
        </div>
        <div class="form-row">
            <label for="allergies">
                Est-ce que votre enfant a des allergies?
                <fieldset>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_alergie" value="Oui" id="oui-allergie" <?php  agcsi_check_radio('agcsi_enfant_alergie','Oui',$enfant->alergie) ?> /><label for="oui-allergie">Oui</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_alergie" value="Non" id="non-allergie" <?php  agcsi_check_radio('agcsi_enfant_alergie','Non',$enfant->alergie) ?> /><label for="non-allergie">Non</label></span>
                </fieldset>
            </label>
            <label for="agcsi_allergies_details">
            Si oui, spécifier l'allergie(s)
                <input type="text" name="agcsi_allergies_details" id="agcsi_allergies_details" value="<?php agcsi_fill_text('agcsi_allergies_details',$enfant->allergies_details) ?>" />
            </label>
        </div>
        <div class="form-row">
            <label for="epipen">
                Est-ce que votre enfant a son épipen avec lui?
                <fieldset>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_epipen" value="Oui" id="oui-epipen" <?php  agcsi_check_radio('agcsi_enfant_epipen','Oui',$enfant->epipen) ?>  /><label for="oui-epipen">Oui</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_epipen" value="Non" id="non-epipen" <?php  agcsi_check_radio('agcsi_enfant_epipen','Non',$enfant->epipen) ?> /><label for="non-epipen">Non</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_epipen" value="n/a" id="nd-epipen"  <?php  agcsi_check_radio('agcsi_enfant_epipen','n/a',$enfant->epipen) ?> /><label for="nd-epipen">Mon enfant n'a pas d'allergies</label></span>
                </fieldset>
            </label>
            <label for="vaccination">
            En fonction des allergies de votre enfant, son carnet de vaccination est-il à jour?
                <fieldset>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_vaccination" value="Oui" id="oui-vaccination" <?php  agcsi_check_radio('agcsi_enfant_vaccination','Oui',$enfant->vaccination) ?>  /><label for="oui-vaccination">Oui</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_vaccination" value="Non" id="non-vaccination" <?php  agcsi_check_radio('agcsi_enfant_vaccination','Non',$enfant->vaccination) ?> /><label for="non-vaccination">Non</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_vaccination" value="n/a" id="nd-vaccination"  <?php  agcsi_check_radio('agcsi_enfant_vaccination','n/a',$enfant->vaccination) ?> />   <label for="nd-vaccination">Mon enfant n'a pas d'allergies</label></span>
                </fieldset>
            </label>
        </div>
        <div class="form-row">
            <label for="medicaments">
                Votre enfant prend-il des médicaments?
                <fieldset>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_medicament" value="Oui" id="oui-medicament" <?php  agcsi_check_radio('agcsi_enfant_medicament','Oui',$enfant->medicament) ?> /><label for="oui-medicament">Oui</label></span>
                    <span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_medicament" value="Non" id="non-medicament" <?php  agcsi_check_radio('agcsi_enfant_medicament','Non',$enfant->medicament) ?> /><label for="non-medicament">Non</label></span>
                </fieldset>
            </label>
            <label for="quel-medicament">
                Si oui, veuillez inscrire: Nom du médicament, dose, moment de la journée.
                <textarea name="agcsi_enfant_medicament_detail" id="quel-medicament" rows="3"><?php agcsi_fill_text('agcsi_enfant_medicament_detail',$enfant->medicament_detail) ?></textarea>
            </label>
        </div>
        <div class="form-row">
            <label class="full-width" for="particularite">
                Veuillez inscrire s'il y a des particuliarités que nous devrions savoir à propos de votre enfant.
                <textarea name="agcsi_enfant_particularite" id="particularite" rows="3"><?php agcsi_fill_text('agcsi_enfant_particularite',$enfant->particularite) ?></textarea>
            </label>
        </div>
        <div class="form-row">
            <label class="full-width" for="autorisation-urgence">
            J'autorise un membre de AG Camp Sportif a fournir les soins infirmiers nécessaires à mon enfant  en cas d'urgence ainsi que le transport à l'hôpital si nécessaire.
                <fieldset>
                    <span class="checkbox-wrap"><span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_autorisation_urgence" value="Oui" id="urgence-oui" <?php  agcsi_check_radio('agcsi_enfant_autorisation_urgence','Oui',$enfant->autorisation_urgence) ?> /><label for="urgence-oui">Oui</label></span></span>
                    <span class="checkbox-wrap"><span class="checkbox-wrap"><input type="radio" name="agcsi_enfant_autorisation_urgence" value="Non" id="urgence-non" <?php  agcsi_check_radio('agcsi_enfant_autorisation_urgence','Non',$enfant->autorisation_urgence) ?>  /><label for="urgence-non">Non</label></span></span>
                </fieldset>
            </label>
        </div>
        <div class="form-row">
            <label class="full-width" for="urgence-frais">
                Je consens qu'advenant un accident, AG Camp Sportif n'est pas responsable de couvrir les frais relié excepté si l'accident  est relié aux infrastructures. Dans ce cas, la ville de Mirabel et Blainville couvrira les frais.
                <fieldset>
                    <span class="checkbox-wrap"><input type="checkbox" name="agcsi_enfant_consent_frais_urgence" id="consent-urgence" <?php  agcsi_check_checkbox('agcsi_enfant_consent_frais_urgence','',agcsi_truth_to_bool($enfant->consent_frais_urgence)) ?> /><label for="consent-urgence">Je confirme avoir lu et compris la fiche médicale d'AG Camp Sportif</label></span>
                </fieldset>
            </label>
        </div>
        <div class="boutons">
            <input class="danger" type="submit" name="agcsi_save_enfant" value="Sauvegarder">
            <?php if($enfant->ID): ?>
                <a class="danger" href="<?php echo wc_get_endpoint_url('participants').'delete/'.$enfant->ID; ?>">Supprimer</a>
            <?php endif; ?>
        </div>
    </form>
</div>