<?php

if ( !defined('NF_SERVER_URL') )
 	define('NF_SERVER_URL', 'https://my.ninjaforms.com');

require_once( plugin_dir_path( __FILE__ ) . 'lib/wordpress/mailer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'lib/wordpress/plugin.php' );

require_once( plugin_dir_path( __FILE__ ) . 'includes/app/mailer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/app/logger.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/app/service.php' );

require_once( plugin_dir_path( __FILE__ ) . 'includes/tests.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/admin.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/plugin.php' );
