<?php
/**
 * Plugin Name: JwLoginCustomizer
 * Plugin URI:
 * Description:
 * Version:     0.1.0
 * Author:      10up
 * Author URI:  https://10up.com
 * Text Domain: jw-login-customizer
 * Domain Path: /languages
 */

// Useful global constants
define( 'JW_LOGIN_CUSTOMIZER_VERSION', '0.1.0' );
define( 'JW_LOGIN_CUSTOMIZER_URL',     plugin_dir_url( __FILE__ ) );
define( 'JW_LOGIN_CUSTOMIZER_PATH',    dirname( __FILE__ ) . '/' );
define( 'JW_LOGIN_CUSTOMIZER_INC',     JW_LOGIN_CUSTOMIZER_PATH . 'includes/' );
define( 'JW_LOGIN_CUSTOMIZER_DOMAIN',    'jw-login-customizer' );

// Include files
require_once JW_LOGIN_CUSTOMIZER_INC . 'functions/core.php';
require_once JW_LOGIN_CUSTOMIZER_INC . 'classes/Admin.php';
require_once JW_LOGIN_CUSTOMIZER_INC . 'classes/Frontend.php';
require_once JW_LOGIN_CUSTOMIZER_INC . 'classes/Setting.php';


// Activation/Deactivation
register_activation_hook( __FILE__, '\JwLoginCustomizer\Core\activate' );
register_deactivation_hook( __FILE__, '\JwLoginCustomizer\Core\deactivate' );

// Bootstrap
JwLoginCustomizer\Core\setup();

$admin = new JwLoginCustomizer\Admin\Admin();
$admin->init();

$frontend = new JwLoginCustomizer\Frontend\Frontend();
$frontend->init();
