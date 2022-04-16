<style>
    .fiche-enfant{
        border-collapse:collapse;
    }
    .fiche-enfant th,.fiche-enfant td{
        padding:1em;
        text-align:left;
        vertical-align:top;
        width: 25%;
        border:1px solid #000;
    }
</style>
<h2>Géméral</h2>
<table class="fiche-enfant" width="100%" style="max-width:1000px" >
    <tr>
        <th>Nom: </th>
        <td><?php echo $enfant->prenom.' '.$enfant->nom ?></td>
        <th>Taille t-shirt: </th>
        <td><?php echo $enfant->taille_tshirt ?></td>
    </tr>
    <tr>
        <th>Parent: </th>
        <td><a href="<?php echo get_edit_user_link($enfant->parent->ID) ?>"><?php echo $enfant->parent->first_name.' '.$enfant->parent->last_name ?></a></td>
        <th>Taille t-shirt hockey: </th>
        <td><?php echo $enfant->taille_tshirt_hockey ?></td>
    </tr>
    <tr>
        <th>Date de naissance: </th>
        <td><?php echo $enfant->date_naissance ?></td>
        <th>Autorisation photo: </th>
        <td><?php echo $enfant->autorisation_photo ?></td>
    </tr>
    <tr>
        <th>Sport(s) pratiqué(s) lors des 12 derniers mois: </th>
         <td><?php echo $enfant->sport_pratique ?></td>
         <th>particularite: </th>
        <td><?php echo $enfant->particularite ?></td>
    </tr>
</table>
<hr>
<h2>Fiche médicale</h2>
<table class="fiche-enfant" width="100%" style="max-width:1000px" >
    <tr>
        <th>#Assurance maladies: </th>
        <td><?php echo$enfant->assurance_maladie ?></td>
        <th> </th>
        <td></td>
    </tr>
    <tr>
        <th>Maladies déclarés: </th>
        <td><?php echo implode(',',$enfant->maladies) ?></td>
        <th>Carnet de vaccination complet: </th>
        <td><?php echo $enfant->vaccination ?></td>
    </tr>
    <tr>
        <th>À des allergies: </th>
        <td><?php echo $enfant->alergie ?></td>
        <th>À besoins de médicament: </th>
        <td><?php echo $enfant->medicament ?></td>
    </tr>
    <tr>
        <th>À une épipen: </th>
        <td><?php echo $enfant->epipen ?></td>
        <th>Détails médicaments: </th>
        <td><?php echo $enfant->medicament_detail ?></td>
    </tr>
    <tr>
        <th>Autorisation a fournir les soins infirmiers nécessaire en cas d'urgence : </th>
        <td><?php echo $enfant->autorisation_urgence ?></td>
        <th>Consentement AG Camp Sportif n'est pas responsable de couvrir les frais relié excepté si l'accident est relié aux infrastructures. Dans ce cas, la ville de Mirabel couvrira les frais. : </th>
        <td><?php echo $enfant->consent_frais_urgence ?></td>
    </tr>
</table>