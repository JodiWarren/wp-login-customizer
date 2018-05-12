<?php

namespace JwLoginCustomiser\Admin;

class Admin {
	public function __construct() {
	}

	public function init() {
		add_action('admin_menu', [$this,'addMenuItem']);
	}

	public function addMenuItem() {
		add_submenu_page('themes.php', 'JW Login Customiser', 'Login Customiser', 'customize', 'jw-login-customiser', [$this,'adminPage']);
	}

	public function adminPage() {
		require_once JW_LOGIN_CUSTOMISER_INC . 'templates/admin.php';
	}
}
