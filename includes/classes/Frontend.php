<?php
namespace JwLoginCustomizer\Frontend;


class Frontend {

	public function init() {
		add_action( 'login_head', [ $this, 'customCss' ] );
		add_action( 'login_head', [ $this, 'customIcon' ] );
		add_action( 'login_header', [ $this, 'customMarkup' ] );
		add_filter( 'login_headerurl', [ $this, 'headerUrl' ] );
		add_filter( 'login_headertitle', [ $this, 'headerTitle' ] );
	}

	public function customCss() {
		$customCss = get_option(JW_LOGIN_CUSTOMIZER_DOMAIN . '-css');
		if (strlen($customCss) <= 0) {
			return;
		}

		echo sprintf('<style>%s</style>', esc_textarea($customCss));

	}

	public function customIcon() {
		$customIcon = get_option(JW_LOGIN_CUSTOMIZER_DOMAIN . '-icon-url');
		if (strlen($customIcon) <= 0) {
			return;
		}

		$customIconWidth = get_option(JW_LOGIN_CUSTOMIZER_DOMAIN . '-icon-width');
		$customIconHeight = get_option(JW_LOGIN_CUSTOMIZER_DOMAIN . '-icon-height');

		$iconSize = '';

		if ( strlen($customIconWidth) && strlen($customIconHeight) ) {
			$iconSize = 'background-size: ' . $customIconWidth . 'px ' . $customIconHeight . 'px;';
			$iconSize .= 'height: ' . $customIconHeight . 'px;';
			$iconSize .= 'width:' . $customIconWidth . 'px;';
		}

		echo sprintf('<style>.login h1 a{ background-image: url("%s"); %s }</style>', esc_url($customIcon), esc_attr($iconSize));

	}

	public function customMarkup(){
		$customMarkup = get_option(JW_LOGIN_CUSTOMIZER_DOMAIN . '-markup');
		echo $customMarkup;
	}

	public function headerUrl($url) {
		if (get_option(JW_LOGIN_CUSTOMIZER_DOMAIN . '-icon-home') === 'on') {
			return home_url();
		}
		return $url;
	}

	public function headerTitle($url) {
		if (get_option(JW_LOGIN_CUSTOMIZER_DOMAIN . '-icon-home') === 'on') {
			return get_option('blogname');
		}
		return $url;
	}
}
