<?php
    $user = wp_get_current_user();
?><div class="info-box full">
    <i class="fa-solid fa-circle-user"></i>
    <h3>Information du parent</h3>
    <?php if(!user_has_complete_info(get_current_user_id())): ?>
        <div class="error-box">
            <p>Pour obtenir le statut complet de la fiche, il vous manque les informations suivantes:</p>
            <ul>
                <?php foreach(user_has_complete_info(get_current_user_id(),true) as $key=>$info):?>
                    <li><a href="#<?php echo $key ?>"><?php echo $info ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="" method="POST" class="form-enfant">
        <?php wp_nonce_field( 'edit_parent', 'edit_parent_nonce' ); ?>
        <div class="form-row">
            <label for="first_name">
                Prenom *
                <input type="text" name="agcsi_user_first_name" id="first_name" value="<?php agcsi_fill_text('agcsi_user_first_name',get_user_meta($user->ID,'first_name',true)) ?>" required />
            </label>
            <label for="last_name">
                Nom *
                <input type="text" name="agcsi_user_last_name" id="last_name" value="<?php agcsi_fill_text('agcsi_user_last_name',get_user_meta($user->ID,'last_name',true)) ?>" required />
            </label>
        </div>
        <div class="form-row">
            <label for="billing_phone">
                Numéro de téléphone cellulaire *
                <input type="text" name="agcsi_user_billing_phone" id="billing_phone" value="<?php agcsi_fill_text('agcsi_user_billing_phone',get_user_meta($user->ID,'billing_phone',true)) ?>" placeholder="(000) 000-0000" />
            </label>
            <label for="work_phone">
                Numéro de téléphone au travail
                <input type="text" name="agcsi_user_work_phone" id="work_phone" value="<?php agcsi_fill_text('agcsi_user_work_phone',get_user_meta($user->ID,'work_phone',true)) ?>" placeholder="(000) 000-0000" />
            </label>
        </div>
        <div class="form-row">
            <label for="billing_address">
                Adresse <small>(gérée par l'adresse de facturation)</small>
                <input type="text" name="agcsi_user_billing_address" id="billing_address" value="<?php
                    echo get_user_meta($user->ID,'billing_address_1',true).' '.get_user_meta($user->ID,'billing_city',true).' '.get_user_meta($user->ID,'billing_postcode',true).' '.get_user_meta($user->ID,'billing_state',true).' '.get_user_meta($user->ID,'billing_country',true);
                ?>" disabled title="Cette address est générée avec l'adresse de facturation"  />
            </label>
            <label for="user_email">
                Adresse Courriel <small>(gérée dans la section Détails du compte)</small>
                <input type="text" name="agcsi_user_user_email" id="user_email" value="<?php agcsi_fill_text('agcsi_user_user_email',$user->user_email) ?>" disabled  />
            </label>
        </div>
        <hr>
        <h3>Deuxièmme parent</h3>
        <div class="form-row">
            <label for="second_first_name">
                Prenom *
                <input type="text" name="agcsi_user_second_first_name" id="second_first_name" value="<?php agcsi_fill_text('agcsi_user_second_first_name',get_user_meta($user->ID,'second_first_name',true)) ?>"  />
            </label>
            <label for="second_last_name">
                Nom *
                <input type="text" name="agcsi_user_second_last_name" id="second_last_name" value="<?php agcsi_fill_text('agcsi_user_second_last_name',get_user_meta($user->ID,'second_last_name',true)) ?>"  />
            </label>
        </div>
        <div class="form-row">
            <label for="second_phone">
                Numéro de téléphone
                <input type="text" name="agcsi_user_second_phone" id="second_phone" value="<?php agcsi_fill_text('agcsi_user_second_phone',get_user_meta($user->ID,'second_phone',true)) ?>" placeholder="(000) 000-0000" />
            </label>
            <label for="second_adress">
                Adresse (si différente du 1er parent)
                <input type="text" name="agcsi_user_second_adress" id="second_adress" value="<?php agcsi_fill_text('agcsi_user_second_adress',get_user_meta($user->ID,'second_adress',true)) ?>"  />
            </label>
        </div>
        <h3>Contact en cas d'urgence (autre que les parents)</h3>
        <div class="form-row">
            <label for="urgent_first_name">
                Prenom *
                <input type="text" name="agcsi_user_urgent_first_name" id="urgent_first_name" value="<?php agcsi_fill_text('agcsi_user_urgent_first_name',get_user_meta($user->ID,'urgent_first_name',true)) ?>"  />
            </label>
            <label for="urgent_last_name">
                Nom *
                <input type="text" name="agcsi_user_urgent_last_name" id="urgent_last_name" value="<?php agcsi_fill_text('agcsi_user_urgent_last_name',get_user_meta($user->ID,'urgent_last_name',true)) ?>"  />
            </label>
        </div>
        <div class="form-row">
            <label for="urgent_phone">
                Numéro de téléphone
                <input type="text" name="agcsi_user_urgent_phone" id="urgent_phone" value="<?php agcsi_fill_text('agcsi_user_urgent_phone',get_user_meta($user->ID,'urgent_phone',true)) ?>" placeholder="(000) 000-0000" />
            </label>
            <label for="urgent_link">
                Lien avec l'enfant
                <input type="text" name="agcsi_user_urgent_link" id="urgent_link" value="<?php agcsi_fill_text('agcsi_user_urgent_link',get_user_meta($user->ID,'urgent_link',true)) ?>" placeholder="" />
            </label>
        </div>
        <br>
        <div class="boutons">
            <input class="positive" type="submit" name="agcsi_save_parent" value="Sauvegarder">
        </div>
    </form>
    </div>
</div>