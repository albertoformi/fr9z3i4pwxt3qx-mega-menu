<?php

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
/*
 * WP_Customize_Control with description
 */
add_action( 'customize_register', 'registerTitanFrameworkCustomizeControl', 1 );
function registerTitanFrameworkCustomizeControl() {
	class TitanFrameworkCustomizeControl extends WP_Customize_Control {
		public $description;

		public function render_content() {
			parent::render_content();
			// ?><p class='description'><?php echo $this->description // phpcs:ignore ?></p> <?php
		}
	}
}
