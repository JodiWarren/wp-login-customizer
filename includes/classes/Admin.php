<?php

namespace JwLoginCustomizer\Admin;

use function JwLoginCustomizer\AdminTemplate\get_page_contents;

class Admin {

	/**
	 * Add hooks
	 */
	public function init() {
		add_action( 'admin_menu', [ $this, 'addMenuItem' ] );
		add_action( 'admin_init', [ $this, 'addSettings' ] );
	}

	/**
	 * Add Login Customizer to Appearance menu
	 */
	public function addMenuItem() {
		add_submenu_page( 'themes.php', 'JW Login Customizer', 'Login Customizer', 'customize',
			JW_LOGIN_CUSTOMIZER_DOMAIN, [ $this, 'adminPage' ] );
	}

	public function adminPage() {
		require_once JW_LOGIN_CUSTOMIZER_INC . 'templates/admin.php';
		get_page_contents();
	}

	public function addSettings() {

		$custom_css = new Setting(
			JW_LOGIN_CUSTOMIZER_DOMAIN,
			'css-section',
			_x( 'Custom CSS', 'Custom CSS section title', JW_LOGIN_CUSTOMIZER_DOMAIN ),
			[ $this, 'renderCssSection' ]
		);
		$custom_css->addField(
			'css',
			_x( 'Custom CSS', 'Custom CSS field title', JW_LOGIN_CUSTOMIZER_DOMAIN ),
			[ $this, 'renderCssField' ],
			'string',
			[ $this, 'cleanCSS' ],
			''
		);
		$custom_css->registerSettings();

		$custom_icon = new Setting(
			JW_LOGIN_CUSTOMIZER_DOMAIN,
			'icon-section',
			_x( 'Login Page Icon', 'Login Page icon section title', JW_LOGIN_CUSTOMIZER_DOMAIN ),
			[ $this, 'iconSection' ]
		);
		$custom_icon->addField(
			'icon-url',
			_x( 'Icon URL', 'Icon URL field title', JW_LOGIN_CUSTOMIZER_DOMAIN ),
			[ $this, 'renderIconUrlField' ],
			'string',
			[ $this, 'cleanText' ],
			''
		);
		$custom_icon->addField(
			'icon-width',
			_x( 'Icon Width (in px)', 'Custom icon width field title', JW_LOGIN_CUSTOMIZER_DOMAIN ),
			[ $this, 'renderIconSizeField' ],
			'number',
			[ $this, 'cleanText' ],
			''
		);
		$custom_icon->addField(
			'icon-height',
			_x( 'Icon Height (in px)', 'Custom icon height field title', JW_LOGIN_CUSTOMIZER_DOMAIN ),
			[ $this, 'renderIconSizeField' ],
			'number',
			[ $this, 'cleanText' ],
			''
		);
		$custom_icon->addField(
			'icon-home',
			_x(
				'Do you want to set the icon to point to your home page?',
				'Icon destination toggle field title',
				JW_LOGIN_CUSTOMIZER_DOMAIN
			),
			[ $this, 'renderIconHomeField' ],
			'boolean',
			[ $this, 'cleanBoolean' ],
			''
		);
		$custom_icon->registerSettings();

		$custom_css = new Setting(
			JW_LOGIN_CUSTOMIZER_DOMAIN,
			'markup-section',
			_x( 'Custom Text', 'Custom Markup section title', JW_LOGIN_CUSTOMIZER_DOMAIN ),
			[ $this, 'renderMarkupSection' ]
		);
		$custom_css->addField(
			'markup',
			_x( 'Custom Markup', 'Custom Markup field title', JW_LOGIN_CUSTOMIZER_DOMAIN ),
			[ $this, 'renderMarkupField' ],
			'string',
			null,
			''
		);
		$custom_css->registerSettings();
	}

	public function renderCssSection() {
		echo '<p>' . __('Enter custom CSS here to be rendered on the login page', JW_LOGIN_CUSTOMIZER_DOMAIN) . '</p>';
	}

	public function renderCssField( $args ) {
		$field_name = $args['label_for'];
		$currentCss = esc_textarea( get_option( $field_name, '' ) );
		echo sprintf( '<textarea style="display:block;" cols="40" rows="10" name="%1$s" id="%1$s" class="regular-text">%2$s</textarea>',
			$field_name, $currentCss );
	}

	public function cleanCSS( $css ) {
		return wp_strip_all_tags( $css, false );
	}

	public function iconSection() {
		echo '<p>' . __('Control the icon which is rendered on the login page', JW_LOGIN_CUSTOMIZER_DOMAIN) . '</p>';
	}

	public function renderIconUrlField( $args ) {
		$field_name = $args['label_for'];
		$currentCss = sanitize_text_field( get_option( $field_name, '' ) );
		echo sprintf( '<input type="text" name="%1$s" id="%1$s" class="regular-text" value="%2$s" />', $field_name,
			$currentCss );
	}

	public function renderIconSizeField( $args ) {
		$field_name = $args['label_for'];
		$currentCss = sanitize_text_field( get_option( $field_name, '' ) );
		echo sprintf( '<input type="number" name="%1$s" id="%1$s" step="1" class="small-text" value="%2$s" />', $field_name,
			$currentCss );
	}

	public function renderIconHomeField( $args ) {
		$field_name = $args['label_for'];
		$checked    = get_option( $field_name ) === 'on' ? 'checked' : '';
		echo sprintf( '<input name="%1$s" id="%1$s" class="checkbox" type="checkbox" %2$s />', $field_name, $checked );
	}

	public function renderMarkupSection() {
		echo '<p>' . __('Add custom markup before the login form', JW_LOGIN_CUSTOMIZER_DOMAIN) . '</p>';
		echo '<p><strong>Please take care with what is placed in here. Do not enter any code which you are not sure about.</strong></p>';
	}

	public function renderMarkupField($args) {
		$field_name = $args['label_for'];
		$currentCss = esc_textarea( get_option( $field_name, '' ) );
		echo sprintf( '<textarea style="display:block;" cols="40" rows="10" name="%1$s" id="%1$s" class="regular-text">%2$s</textarea>',
			$field_name, $currentCss );
	}

	public function cleanText( $text ) {
		return sanitize_text_field( $text );
	}

	public function cleanBoolean( $bool ) {
		return $bool;
	}
}
