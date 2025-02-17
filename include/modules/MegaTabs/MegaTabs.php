<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class divi_megamenu_tabs_code extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Mega Tabs', 'et_builder' );
		$this->plural          = esc_html__( 'Mega Tabs', 'et_builder' );
		$this->slug            = 'et_pb_mm_tabs';
		$this->vb_support      = 'on';
		$this->child_slug      = 'et_pb_tab';
		$this->child_item_text = esc_html__( 'Tab', 'et_builder' );
		$this->main_css_element = '%%order_class%%.et_pb_tabs';

		$this->settings_modal_toggles = array(
		'general' => array(
		'toggles' => array(
		'tablinks' => esc_html__( 'Tab Extras', 'divi-mega-menu' ),
		),
		),
		);

		$this->advanced_fields = array(
			'borders'               => array(
				'default' => array(
					'css'      => array(
						'main' => array(
							'border_radii'  => $this->main_css_element,
							'border_styles' => $this->main_css_element,
						),
					),
					'defaults' => array(
						'border_radii'  => 'on||||',
						'border_styles' => array(
							'width' => '1px',
							'color' => '#d9d9d9',
							'style' => 'solid',
						),
					),
				),
			),
			'fonts'                 => array(
				'body' => array(
					'label'          => esc_html__( 'Body', 'et_builder' ),
					'css'            => array(
						'main'         => "{$this->main_css_element} .et_pb_all_tabs .et_pb_tab",
						'limited_main' => "{$this->main_css_element} .et_pb_all_tabs .et_pb_tab, {$this->main_css_element} .et_pb_all_tabs .et_pb_tab p",
						'line_height'  => "{$this->main_css_element} .et_pb_tab p",
					),
					'block_elements' => array(
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
					),
				),
				'tab'  => array(
					'label'            => esc_html__( 'Tab', 'et_builder' ),
					'css'              => array(
						'main'        => "{$this->main_css_element} .et_pb_tabs_controls li, {$this->main_css_element} .et_pb_tabs_controls li a",
						'color'       => "{$this->main_css_element} .et_pb_tabs_controls li a",
						'hover'       => "{$this->main_css_element} .et_pb_tabs_controls li:hover, {$this->main_css_element} .et_pb_tabs_controls li:hover a",
						'color_hover' => "{$this->main_css_element} .et_pb_tabs_controls li:hover a",
					),
					'hide_text_align'  => true,
					'options_priority' => array(
						'tab_text_color' => 9,
					),
				),
			),
			'background'            => array(
				'css' => array(
					'main' => "{$this->main_css_element} .et_pb_all_tabs",
				),
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'margin_padding' => array(
				'css' => array(
					'padding' => '%%order_class%% .et_pb_tab',
					'important' => array( 'custom_margin' ), // needed to overwrite last module margin-bottom styling
				),
			),
			'text'                  => false,
			'button'                => false,
		);

		$this->custom_css_fields = array(
			'tabs_controls' => array(
				'label'    => esc_html__( 'Tabs Controls', 'et_builder' ),
				'selector' => '.et_pb_tabs_controls',
			),
			'tab' => array(
				'label'    => esc_html__( 'Tab', 'et_builder' ),
				'selector' => '.et_pb_tabs_controls li',
			),
			'active_tab' => array(
				'label'    => esc_html__( 'Active Tab', 'et_builder' ),
				'selector' => '.et_pb_tabs_controls li.et_pb_tab_active',
			),
			'tabs_content' => array(
				'label'    => esc_html__( 'Tabs Content', 'et_builder' ),
				'selector' => '.et_pb_tab',
			),
		);

		$this->help_videos=array(
			array(
				'id'   => 'ozMi0GCG_No',
				'name' => esc_html__( 'Divi Mega Menu - Mega Tabs Module', 'divi-machine' ),
			),
			array(
				'id'   => 'D8YodgZbrlE',
				'name' => esc_html__( 'Explicando y aplicando el módulo de Dropdown de Divi Mega Menu', 'divi-machine' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
		'select_options' => array(
			'label'           => esc_html__( 'Tab Links', 'et_builder' ),
			'type'            => 'sortable_list',
			'option_category' => 'configuration',
			'toggle_slug'     => 'tablinks',
			'description'       => esc_html__( 'If you want to have the tab titles linking to a URL, add the URL in this list and make sure they are in the same order as your tabs above', 'divi-mega-menu' ),
		),
			'active_tab_background_color' => array(
				'label'             => esc_html__( 'Active Tab Background Color', 'et_builder' ),
				'description'       => esc_html__( 'Pick a color to be used for active tab backgrounds. You can assign a unique color to active tabs to differentiate them from inactive tabs.', 'et_builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'tab',
				'hover'             => 'tabs',
				'mobile_options'    => true,
			),
			'inactive_tab_background_color' => array(
				'label'             => esc_html__( 'Inactive Tab Background Color', 'et_builder' ),
				'description'       => esc_html__( 'Pick a color to be used for inactive tab backgrounds. You can assign a unique color to inactive tabs to differentiate them from active tabs.', 'et_builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'tab',
				'hover'             => 'tabs',
				'mobile_options'    => true,
			),
			'active_tab_text_color'         => array(
				'label'          => esc_html__( 'Active Tab Text Color', 'et_builder' ),
				'description'    => esc_html__( 'Pick a color to use for tab text within active tabs. You can assign a unique color to active tabs to differentiate them from inactive tabs.', 'et_builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tab',
				'hover'          => 'tabs',
				'mobile_options' => true,
			),
		'tab_images' => array(
			'label'           => esc_html__( 'Tab Images', 'et_builder' ),
			'type'            => 'upload-gallery',
			'option_category' => 'configuration',
			'toggle_slug'     => 'tablinks',
			'description'       => esc_html__( 'If you want to have the tab titles with an image before each of them, add them here and make sure they are in the same order as your tabs above', 'divi-mega-menu' ),
		),
		'tab_images_width'      => array(
			'label'            => esc_html__( 'Tab Images Width', 'divi-machine' ),
			'description'      => esc_html__( 'Control the tab image width by increasing or decreasing the range.', 'divi-machine' ),
			'type'             => 'range',
			'tab_slug'         => 'advanced',
			'toggle_slug'      => 'width',
			'default'          => '36px',
			'default_unit'     => 'px',
			'default_on_front' => '',
			'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
			'range_settings'   => array(
				'min'  => '1',
				'max'  => '500',
				'step' => '1',
			),
			'responsive'       => true,
		),
		);
		return $fields;
	}

	public function get_transition_fields_css_props() {
		$fields = parent::get_transition_fields_css_props();

		$fields['inactive_tab_background_color'] = array( 'background-color' => '%%order_class%% .et_pb_tabs_controls li' );
		$fields['active_tab_background_color']   = array( 'background-color' => '%%order_class%% .et_pb_tabs_controls li' );
		$fields['active_tab_text_color']         = array( 'color' => '%%order_class%% .et_pb_tabs_controls li a' );

		return $fields;
	}

	/**
	 * Outputs tabs module nav markup
	 * The nav output is abstracted into method so tabs module can be extended
	 *
	 * @since 3.29
	 *
	 * @return string
	 */
	public function get_tabs_nav() {
		global $et_pb_tab_titles;
		global $et_pb_tab_classes;

		$tabs = '';

		$i = 0;
		if ( ! empty( $et_pb_tab_titles ) ) {
			foreach ( $et_pb_tab_titles as $key => $tab_title ){
				++$i;
				$tabs .= sprintf( '<li class="%4$s%1$s">%3$s%2$s</li>',
					( 1 === $i ? ' et_pb_tab_active' : '' ),
					et_pb_multi_view_options( $this )->render_element( array(
						'tag'     => 'a',
						'content' => '{{tab_title}}',
						'attrs'   => array(
							'href' => '#',
						),
						'custom_props' => array(
							'tab_title' => $tab_title,
						)
					) ),
					et_pb_multi_view_options( $this )->render_element( array(
						'tag'     => 'img',
						'content' => '',
						'attrs'   => array(
							'src' => '#',
							'class'=>'et_pb_mega_menu_tab_image'
						)
					) ),
					esc_attr( ltrim( $et_pb_tab_classes[ $i-1 ] ) )
				);
			}
		}

		return $tabs;
	}

	/**
	 * Outputs tabs content markup
	 * The tabs content is abstracted into method so tabs module can be extended
	 *
	 * @since 3.29
	 *
	 * @return string
	 */
	public function get_tabs_content() {
		return $this->content;
	}

	public function render( $attrs, $content, $render_slug ) {
		$active_tab_background_color_hover    = $this->get_hover_value( 'active_tab_background_color' );
		$active_tab_background_color_values   = et_pb_responsive_options()->get_property_values( $this->props, 'active_tab_background_color' );
		$inactive_tab_background_color_hover  = $this->get_hover_value( 'inactive_tab_background_color' );
		$inactive_tab_background_color_values = et_pb_responsive_options()->get_property_values( $this->props, 'inactive_tab_background_color' );
		$active_tab_text_color_hover          = $this->get_hover_value( 'active_tab_text_color' );
		$active_tab_text_color_values         = et_pb_responsive_options()->get_property_values( $this->props, 'active_tab_text_color' );

		$select_options                         = $this->props['select_options'];
		$tab_images                             = $this->props['tab_images'] ?: '';
		$tab_images_width                       = $this->props['tab_images_width'] ?: '';

		ET_Builder_Element::set_style($render_slug, array(
			'selector'    => '%%order_class%% .et_pb_mega_menu_tab_image',
			'declaration' => sprintf(
				'width : %1$s;',
				$tab_images_width
			),
		));

		$num = wp_rand(100000,999999);
		$css_class              = $render_slug . "_" . $num;


		$this->add_classname($css_class);

		$all_tabs_content = $this->get_tabs_content();

		global $et_pb_tab_titles;
		global $et_pb_tab_classes;

		// Inactive Tab Background Color.
		et_pb_responsive_options()->generate_responsive_css( $inactive_tab_background_color_values, '%%order_class%% .et_pb_tabs_controls li', 'background-color', $render_slug, '', 'color' );

		if ( et_builder_is_hover_enabled( 'inactive_tab_background_color', $this->props ) ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_pb_tabs_controls li:hover',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $inactive_tab_background_color_hover )
				),
			) );
		}

		// Active Tab Background Color.
		et_pb_responsive_options()->generate_responsive_css( $active_tab_background_color_values, '%%order_class%% .et_pb_tabs_controls li.et_pb_tab_active', 'background-color', $render_slug, '', 'color' );

		if ( et_builder_is_hover_enabled( 'active_tab_background_color', $this->props ) ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_pb_tabs_controls li.et_pb_tab_active:hover',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $active_tab_background_color_hover )
				),
			) );
		}

		// Active Text Color
		et_pb_responsive_options()->generate_responsive_css( $active_tab_text_color_values, '%%order_class%% .et_pb_tabs_controls li.et_pb_tab_active a', 'color', $render_slug, ' !important;', 'color' );

		if ( et_builder_is_hover_enabled( 'active_tab_text_color', $this->props ) ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_pb_tabs_controls li.et_pb_tab_active:hover a',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $active_tab_text_color_hover )
				),
			) );
		}

		$tabs = $this->get_tabs_nav();

		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$et_pb_tab_titles = $et_pb_tab_classes = array();

		// Module classnames
		$this->add_classname( array(
			$this->get_text_orientation_classname(),
		) );


		$option_search  = array( '&#91;', '&#93;' );
		$option_replace = array( '[', ']' );
		$select_options = str_replace( $option_search, $option_replace, $select_options );
		$select_options = json_decode( $select_options );

		$finalarray = array();

		foreach ( $select_options as $option ) {
			if ($option->value !== "") {
				$finalarray[] = $option->value;
			}
		}
		if(!empty($tab_images)){
			$tab_images=explode(',',$tab_images);
			foreach($tab_images as &$tab_image){
				$tab_image=wp_get_attachment_url($tab_image);
			}
		}
		if (empty($finalarray) && empty($tab_images)) {
			$js_output = "";

			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => '%%order_class%% .et_pb_mega_menu_tab_image',
				'declaration' => sprintf(
					'display: none !important;'
				),
			));
			

		} else {
		$js_output = '
		<script>
		jQuery(document).ready(function($){
		let tab_urls = ' . wp_json_encode($finalarray) . ';
		$.each(tab_urls, function(index, item) {
		index++;
		$(".dmm-vert-tabs.' . $css_class . ' ul.et_pb_tabs_controls li:nth-child("+index+") a").attr("href", item);
		});
        let tab_images='.wp_json_encode($tab_images).';
        if(tab_images){
	        $.each(tab_images,function (index,image){
	            index++;
	            $(".dmm-vert-tabs.' . $css_class . ' ul.et_pb_tabs_controls li:nth-child("+index+") img").attr("src", image);
	        });
        }else{
            $(".dmm-vert-tabs.' . $css_class . ' ul.et_pb_tabs_controls li img").remove();
        }
		});
		</script>
		';
	}


		$output = sprintf(
			'<div %3$s class="dmm-vert-tabs et_pb_tabs %4$s" %7$s>
				%6$s
				%5$s
				<ul class="et_pb_tabs_controls clearfix">
					%1$s
				</ul>
				<div class="et_pb_all_tabs">
					%2$s
				</div> <!-- .et_pb_all_tabs -->
				%8$s
			</div> <!-- .et_pb_tabs -->',
			$tabs,
			$all_tabs_content,
			$this->module_id(),
			$this->module_classname( $render_slug ),
			$video_background,
			$parallax_image_background,
			/* 7$s */ 'et_pb_wc_tabs' === $render_slug ? $this->get_multi_view_attrs() : '',
			$js_output
 		);

		return $output;
	}

	public function process_box_shadow( $function_name ) {
		$boxShadow = ET_Builder_Module_Fields_Factory::get( 'BoxShadow' );
		$style     = $boxShadow->get_value( $this->props );

		if ( $boxShadow->is_inset( $style ) ) {
			$this->advanced_fields['box_shadow'] = array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%% .et-pb-active-slide',
					),
				),
			);


		}

		parent::process_box_shadow( $function_name );
	}
}

new divi_megamenu_tabs_code;