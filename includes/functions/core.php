<?php
namespace JwLoginCustomizer\Core;

/**
 * Default setup routine
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'init', $n( 'i18n' ) );
	add_action( 'init', $n( 'init' ) );
	add_action( 'wp_enqueue_scripts', $n( 'scripts' ) );
	add_action( 'wp_enqueue_scripts', $n( 'styles' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_scripts' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_styles' ) );

	// Editor styles. add_editor_style() doesn't work outside of a theme.
	add_filter( 'mce_css', $n( 'mce_css' ) );

	do_action( 'jw_login_customizer_loaded' );
}

/**
 * Registers the default textdomain.
 *
 * @return void
 */
function i18n() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'jw-login-customizer' );
	load_textdomain( 'jw-login-customizer', WP_LANG_DIR . '/jw-login-customizer/jw-login-customizer-' . $locale . '.mo' );
	load_plugin_textdomain( 'jw-login-customizer', false, plugin_basename( JW_LOGIN_CUSTOMIZER_PATH ) . '/languages/' );
}

/**
 * Initializes the plugin and fires an action other plugins can hook into.
 *
 * @return void
 */
function init() {
	do_action( 'jw_login_customizer_init' );
}

/**
 * Activate the plugin
 *
 * @return void
 */
function activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	init();
	flush_rewrite_rules();
}

/**
 * Deactivate the plugin
 *
 * Uninstall routines should be in uninstall.php
 *
 * @return void
 */
function deactivate() {

}

/**
 * Generate an URL to a script, taking into account whether SCRIPT_DEBUG is enabled.
 *
 * @param string $script Script file name (no .js extension)
 * @param string $context Context for the script ('admin', 'frontend', or 'shared')
 *
 * @return string|WP_Error URL
 */
function script_url( $script, $context ) {

	if( !in_array( $context, ['admin', 'frontend', 'shared'], true) ) {
		error_log('Invalid $context specfied in JwLoginCustomizer script loader.');
		return '';
	}

	return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
		JW_LOGIN_CUSTOMIZER_URL . "assets/js/${context}/{$script}.js" :
		JW_LOGIN_CUSTOMIZER_URL . "dist/js/${context}.min.js" ;

}

/**
 * Generate an URL to a stylesheet, taking into account whether SCRIPT_DEBUG is enabled.
 *
 * @param string $stylesheet Stylesheet file name (no .css extension)
 * @param string $context Context for the script ('admin', 'frontend', or 'shared')
 *
 * @return string URL
 */
function style_url( $stylesheet, $context ) {

	if( !in_array( $context, ['admin', 'frontend', 'shared'], true) ) {
		error_log('Invalid $context specfied in JwLoginCustomizer stylesheet loader.');
		return '';
	}

	return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
		JW_LOGIN_CUSTOMIZER_URL . "assets/css/${context}/{$stylesheet}.css" :
		JW_LOGIN_CUSTOMIZER_URL . "dist/css/${stylesheet}.min.css" ;

}

/**
 * Enqueue scripts for front-end.
 *
 * @return void
 */
function scripts() {

	wp_enqueue_script(
		'jw_login_customizer_shared',
		script_url( 'shared', 'shared' ),
		[],
		JW_LOGIN_CUSTOMIZER_VERSION,
		true
	);

	wp_enqueue_script(
		'jw_login_customizer_frontend',
		script_url( 'frontend', 'frontend' ),
		[],
		JW_LOGIN_CUSTOMIZER_VERSION,
		true
	);

}

/**
 * Enqueue scripts for admin.
 *
 * @return void
 */
function admin_scripts() {

	wp_enqueue_script(
		'jw_login_customizer_shared',
		script_url( 'shared', 'shared' ),
		[],
		JW_LOGIN_CUSTOMIZER_VERSION,
		true
	);

	wp_enqueue_script(
		'jw_login_customizer_admin',
		script_url( 'admin', 'admin' ),
		[],
		JW_LOGIN_CUSTOMIZER_VERSION,
		true
	);

}

/**
 * Enqueue styles for front-end.
 *
 * @return void
 */
function styles() {

	wp_enqueue_style(
		'jw_login_customizer_shared',
		style_url( 'shared-style', 'shared' ),
		[],
		JW_LOGIN_CUSTOMIZER_VERSION
	);

	if( is_admin() ) {
		wp_enqueue_script(
			'jw_login_customizer_admin',
			style_url( 'admin-style', 'admin' ),
			[],
			JW_LOGIN_CUSTOMIZER_VERSION,
			true
		);
	}
	else {
		wp_enqueue_script(
			'jw_login_customizer_frontend',
			style_url( 'style', 'frontend' ),
			[],
			JW_LOGIN_CUSTOMIZER_VERSION,
			true
		);
	}

}

/**
 * Enqueue styles for admin.
 *
 * @return void
 */
function admin_styles() {

	wp_enqueue_style(
		'jw_login_customizer_shared',
		style_url( 'shared-style', 'shared' ),
		[],
		JW_LOGIN_CUSTOMIZER_VERSION
	);

	wp_enqueue_script(
		'jw_login_customizer_admin',
		style_url( 'admin-style', 'admin' ),
		[],
		JW_LOGIN_CUSTOMIZER_VERSION,
		true
	);

}

/**
 * Enqueue editor styles
 *
 * @return string
 */
function mce_css( $stylesheets ) {

	function style_url() {

		return JW_LOGIN_CUSTOMIZER_URL . ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
			"assets/css/frontend/editor-style.css" :
			"dist/css/editor-style.min.css" );

	}

	return $stylesheets . ',' . style_url();
}
