<?php
/**
 * Plugin Name: JwLoginCustomiser
 * Plugin URI:
 * Description:
 * Version:     0.1.0
 * Author:      10up
 * Author URI:  https://10up.com
 * Text Domain: jw-login-customiser
 * Domain Path: /languages
 */

// Useful global constants
define( 'JW_LOGIN_CUSTOMISER_VERSION', '0.1.0' );
define( 'JW_LOGIN_CUSTOMISER_URL',     plugin_dir_url( __FILE__ ) );
define( 'JW_LOGIN_CUSTOMISER_PATH',    dirname( __FILE__ ) . '/' );
define( 'JW_LOGIN_CUSTOMISER_INC',     JW_LOGIN_CUSTOMISER_PATH . 'includes/' );
define( 'JW_LOGIN_CUSTOMISER_DOMAIN',    'jw-login-customiser' );

// Include files
require_once JW_LOGIN_CUSTOMISER_INC . 'functions/core.php';
require_once JW_LOGIN_CUSTOMISER_INC . 'classes/admin.php';


// Activation/Deactivation
register_activation_hook( __FILE__, '\JwLoginCustomiser\Core\activate' );
register_deactivation_hook( __FILE__, '\JwLoginCustomiser\Core\deactivate' );

// Bootstrap
JwLoginCustomiser\Core\setup();

$admin = new JwLoginCustomiser\Admin\Admin();
$admin->init();
