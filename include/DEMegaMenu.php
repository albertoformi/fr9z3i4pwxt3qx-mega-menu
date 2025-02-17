<?php

class DE_Mega_menu extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'divi-mega-menu';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $name = 'divi-mega-menu';

	/**
	 * The extension's version
	 *
	 * @since 2.1.5
	 *
	 * @var string
	 */
	public $version = DE_DMM_VERSION;
	/**
	 * DE_Mega_menu constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'divi-mega-menu', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}

	/**
	 * Enqueues non-minified, hot reloaded javascript bundles.
	 *
	 * @since 3.1
	 */
	protected function _enqueue_debug_bundles() {
		// Frontend Bundle
		$site_url       = wp_parse_url( get_site_url() );
		$hot_bundle_url = "http://localhost:3000/static/js/frontend-bundle.js";

		wp_enqueue_script( "{$this->name}-frontend-bundle", $hot_bundle_url, $this->_bundle_dependencies['frontend'], $this->version, true );

		if ( et_core_is_fb_enabled() ) {
			// Builder Bundle
			$hot_bundle_url = "http://localhost:3000/static/js/builder-bundle.js";

			wp_enqueue_script( "{$this->name}-builder-bundle", $hot_bundle_url, $this->_bundle_dependencies['builder'], $this->version, true );
		}
	}
}

new DE_Mega_menu;
