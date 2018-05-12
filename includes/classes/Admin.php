<?php

namespace JwLoginCustomizer\Admin;
use function JwLoginCustomizer\AdminTemplate\get_page_contents;

class Admin {

	/**
	 * Add hooks
	 */
	public function init() {
		add_action('admin_menu', [$this,'addMenuItem']);
		add_action('admin_init', [$this,'addSettings']);
	}

	/**
	 * Add Login Customizer to Appearance menu
	 */
	public function addMenuItem() {
		add_submenu_page('themes.php', 'JW Login Customizer', 'Login Customizer', 'customize', JW_LOGIN_CUSTOMIZER_DOMAIN, [$this,'adminPage']);
	}

	public function adminPage() {
		require_once JW_LOGIN_CUSTOMIZER_INC . 'templates/admin.php';
		get_page_contents();
	}

	public function addSettings() {

		$custom_css = new Setting(JW_LOGIN_CUSTOMIZER_DOMAIN, 'css-section', 'Custom CSS', [$this, 'renderCssSection']);
		$custom_css->addField('css', 'Custom CSS', [$this, 'renderCssField'], 'string', [$this, 'cleanCSS'], '');
		$custom_css->registerSettings();

		$custom_icon = new Setting(JW_LOGIN_CUSTOMIZER_DOMAIN, 'icon-section', 'Login Page Icon', [$this, 'iconSection']);
		$custom_css->addField('icon-url', 'Icon URL', [$this, 'renderIconUrlField'], 'string', [$this, 'cleanIcon'], '');
		$custom_css->addField('icon-home', 'Do you want to set the icon to point to your home page?', [$this, 'renderIconHomeField'], 'boolean', [$this, 'cleanBoolean'], '');
		$custom_css->registerSettings();
	}

	public function renderCssSection() {
		echo '<p>Enter custom CSS here to be rendered on the login page</p>';
	}

	public function renderCssField($args) {
		$field_name = $args['label_for'];
		$currentCss = sanitize_textarea_field(get_option($field_name, ''));
		echo sprintf('<textarea cols="40" rows="10" name="%1$s" id="%1$s" class="regular-text">%2$s</textarea>', $field_name, $currentCss);
	}

	public function cleanCSS($css) {
		return wp_strip_all_tags($css, false);
	}

	public function iconSection() {
		echo '<p>Enter custom CSS here to be rendered on the login page</p>';
	}

	public function renderIconUrlField($args) {
		$field_name = $args['label_for'];
		$currentCss = sanitize_text_field(get_option($field_name, ''));
		echo sprintf('<input type="text" name="%1$s" id="%1$s" class="regular-text" value="%2$s" />', $field_name, $currentCss);
	}

	public function renderIconHomeField($args) {
		$field_name = $args['label_for'];
		$checked = get_option($field_name) === 'on' ? 'checked' : '';
		echo sprintf('<input name="%1$s" id="%1$s" class="checkbox" type="checkbox" %2$s />', $field_name, $checked);
	}

	public function cleanIcon($url) {
		return sanitize_text_field($url);
	}

	public function cleanBoolean($bool) {
		return $bool;
	}
}
