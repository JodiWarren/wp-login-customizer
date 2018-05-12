<?php

namespace JwLoginCustomizer\Admin;

class Setting {

	private $base = '';
	private $sectionSlug = '';
	private $sectionTitle = '';
	private $sectionCallback = '';

	/**
	 * Setting constructor.
	 *
	 * @param $base string Base string to namespace each setting
	 * @param $sectionSlug string A unique slug to append to the base
	 * @param $sectionTitle string A readable title for the section
	 * @param $sectionCallback callable Call this to render before each section's fields
	 */
	public function __construct($base, $sectionSlug, $sectionTitle, $sectionCallback) {
		$this->base = $base;
		$this->sectionSlug = $sectionSlug;
		$this->sectionTitle = $sectionTitle;
		$this->sectionCallback = $sectionCallback;
	}

	/**
	 * @param $slug string A unique slug to append to the base
	 * @param $title string A readable title for the field
	 * @param $callback callable Call this to render the field
	 * @param $type string The type of data associated with this setting. Valid values are 'string', 'boolean', 'integer', and 'number'
	 * @param $sanitize callable A callback function that sanitizes the option's value.
	 * @param $default mixed Default value.
	 */
	public function addField($slug, $title, $callback, $type, $sanitize, $default) {
		add_settings_field(
			$this->base . '-' . $slug,
			$title,
			$callback,
			JW_LOGIN_CUSTOMIZER_DOMAIN,
			$this->base . '-' .  $this->sectionSlug,
			['label_for' => $this->base . '-' .  $slug]
		);

		$field_args = [
			'type' => $type,
			'description' => $title,
			'sanitize_callback' => $sanitize,
			'default' => $default,
		];
		register_setting($this->base, $this->base . '-' .  $slug, $field_args);
	}

	public function registerSettings(){
		add_settings_section(
			$this->base . '-' .  $this->sectionSlug,
			$this->sectionTitle,
			$this->sectionCallback,
			JW_LOGIN_CUSTOMIZER_DOMAIN
		);
	}
}
