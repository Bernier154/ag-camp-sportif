<?php 
define('AGCSI_ROOT',__DIR__.'/');
define('AGCSI_TEMPLATES',__DIR__.'/templates/');

require_once AGCSI_ROOT.'scripts/templates-helpers.php';

require_once AGCSI_ROOT.'classes/cpt/enfants.php';
require_once AGCSI_ROOT.'classes/cpt/inscriptions.php';
require_once AGCSI_ROOT.'classes/cpt/camps.php';

require_once AGCSI_ROOT.'classes/endpoints/camps.php';

require_once AGCSI_ROOT.'classes/wcaccount/participants.php';

require_once AGCSI_ROOT.'classes/helpers/editor-disable.php';

require_once AGCSI_ROOT.'classes/admin/option-page.php';
require_once AGCSI_ROOT.'classes/admin/meta-box-camps-horaire.php';
require_once AGCSI_ROOT.'classes/admin/meta-box-enfants-fiche.php';
require_once AGCSI_ROOT.'classes/admin/meta-box-inscriptions.php';

require_once AGCSI_ROOT.'classes/module.php';


add_action('init','\Agcsi\Module::init');