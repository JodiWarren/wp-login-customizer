<?php
namespace JwLoginCustomizer\Frontend;


class Frontend {

	public function init() {
		add_action( 'login_head', [ $this, 'outputCSS' ] );
		add_filter( 'login_headerurl', [ $this, 'headerUrl' ] );
		add_filter( 'login_headertitle', [ $this, 'headerTitle' ] );
	}

	public function outputCSS() {
		$customCss = get_option(JW_LOGIN_CUSTOMIZER_DOMAIN . '-css');
		if (strlen($customCss) <= 0) {
			return;
		}

		echo sprintf('<style>%s</style>', $customCss);

	}

	public function headerUrl($url) {
		if (get_option(JW_LOGIN_CUSTOMIZER_DOMAIN . 'icon-home')) {
			return home_url();
		}
		return $url;
	}

	public function headerTitle($url) {
		if (get_option(JW_LOGIN_CUSTOMIZER_DOMAIN . 'icon-home')) {
			return get_option('blogname');
		}
		return $url;
	}
}
