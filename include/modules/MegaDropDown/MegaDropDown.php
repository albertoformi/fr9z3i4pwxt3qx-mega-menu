<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class divi_megamenu_drop_down_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DMM_PRODUCT_URL,
  'author'     => DE_DMM_AUTHOR,
  'author_uri' => DE_DMM_SITE_URL,
);



                function init() {
                    $this->name       = esc_html__( 'Mega Drop-down', 'divi-mega-menu' );
                    $this->slug = 'et_pb_dmm_dropdown';

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Module Options', 'divi-mega-menu' ),
					       'icon'          => esc_html__( 'Icon', 'divi-mega-menu' ),
                 'parent_items' => esc_html__( 'Parent Menu Items', 'divi-ajax-filter' ),
                 'sub_items' => esc_html__( 'Sub-Menu Items', 'divi-ajax-filter' ),
      				),
      			),
      			'advanced' => array(
      			),

      		);

          $this->main_css_element = '%%order_class%%';
          $this->advanced_fields = array(
            'fonts' => array(
              'menu_text'   => array(
                'label'    => esc_html__( 'Parent Menu Item', 'divi-mega-menu' ),
                'css'      => array(
                  'main' => "%%order_class%% .dmm-dropdown-ul li a, .et-db #et-boc .et-l %%order_class%% .dmm-dropdown-ul li a",
                  ),
                ),
                'submenu_text'   => array(
                  'label'    => esc_html__( 'Sub-Menu Item', 'divi-mega-menu' ),
                  'css'      => array(
                    'main' => "%%order_class%% .dmm-dropdown-ul li .sub-menu li a",
                  ),

                ),
            ),
            
            'box_shadow'            => array(
              'default' => array(
                'css' => array(
                  'main' => '%%order_class%% .dmm-dropdown-ul, %%order_class%% .dmm-dropdown-ul li .sub-menu',
                ),
              ),
            ),
              
              'background' => array(
                'css' => array(
                  'main' => "{$this->main_css_element} .dmm-dropdown-ul, {$this->main_css_element} .dmm-dropdown-ul li .sub-menu"
                ),
              ),
        			'border' => array(),
        			'custom_margin_padding' => array(
        				'css' => array(
        					'important' => 'all',
        				),
        			),

			'borders'               => array(
				'default' => array(
          'css' => array(
            'main'      => array(
              'border_menu_items'  => "%%order_class%% .dmm-dropdown-ul li a, .et-db #et-boc .et-l %%order_class%% .dmm-dropdown-ul li a",
            ),
            'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Menu items', 'divi-mega-menu' ),
				),
			),
        		);

		  $this->help_videos=array(
			  array(
				  'id'   => 'HpD569zGuWQ',
				  'name' => esc_html__( 'Divi Mega Menu - Mega Drop-down Module', 'divi-machine' ),
			  ),
			  array(
				  'id'   => '6Y3QEaEi_AE',
				  'name' => esc_html__( 'Explicando y aplicando el módulo de Dropdown de Divi Mega Menu', 'divi-machine' ),
			  ),
		  );

          }

          function get_fields() {
            
            $fields = array(
              
              'menu_id' => array(
                'label'           => esc_html__( 'Select Menu', 'divi-mega-menu' ),
         				'type'            => 'select',
                'computed_affects' => array(
                  '__getmegamenu',
                ),
				        'options'         => et_builder_get_nav_menus_options(),
                'option_category'   => 'layout',
         				'toggle_slug'     => 'main_content',
         				'description'     => esc_html__( 'Choose the menu you want to appear as a dropdown.', 'divi-mega-menu' ),
         			),
              'max_width_menu' => array(
                'default'           => "500",
                'label'             => esc_html__( 'Max-width of menu and sub-menus (add unit)', 'divi-mega-menu' ),
                'type'              => 'text',
                'computed_affects' => array(
                  '__getmegamenu',
                ),
                'description'       => esc_html__( 'Set the width - use either %, px, vw - whatever, you can even use calc() if you want', 'divi-mega-menu' ),
                'option_category'   => 'layout',
                'toggle_slug'     => 'main_content',
              ),
              'menu_app_side' => array(
                'label'             => esc_html__( 'Menu appear from', 'divi-mega-menu' ),
                'type'              => 'select',
                'options'           => array(
                  'right'  => esc_html__( 'Right', 'divi-mega-menu' ),
                  'left' => esc_html__( 'Left', 'divi-mega-menu' ),
                ),
                'computed_affects' => array(
                  '__getmegamenu',
                ),
                'default'           => 'right',
                'description'       => esc_html__( 'Set the width - use either %, px, vw - whatever, you can even use calc() if you want', 'divi-mega-menu' ),
                'option_category'   => 'layout',
                'toggle_slug'     => 'main_content',
              ),
              'parent_icon' => array(
                'default'           => "35",
                'label'             => esc_html__( 'Parent Menu Icon', 'divi-mega-menu' ),
                'type'              => 'text',
                'computed_affects' => array(
                  '__getmegamenu',
                ),
                'option_category'   => 'configuration',
                'description'       => esc_html__( 'Set the icon code by going to https://www.elegantthemes.com/blog/resources/elegant-icon-font and scroll down till you see the icons. Input the code that appears after the "x"', 'divi-mega-menu' ),
                'toggle_slug'         => 'icon',
              ),
              'icon_color' => array(
        				'label'             => esc_html__( 'Icon Color', 'divi-mega-menu' ),
        				'description'       => esc_html__( 'Here you can define a custom color for the parent icon.', 'divi-mega-menu' ),
        				'type'              => 'color-alpha',
        				'custom_color'      => true,
        				'tab_slug'          => 'advanced',
        				'toggle_slug'       => 'icon',
        				'hover'             => 'tabs',
        				'mobile_options'    => true,
        			),
        			'icon_font_size'        => array(
        				'label'            => esc_html__( 'Icon Font Size', 'divi-mega-menu' ),
        				'description'      => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'divi-mega-menu' ),
        				'type'             => 'range',
        				'option_category'  => 'font_option',
        				'tab_slug'         => 'advanced',
        				'toggle_slug'      => 'icon',
        				'default'          => '16px',
        				'default_unit'     => 'px',
        				'default_on_front' => '',
        				'range_settings'   => array(
        					'min'  => '1',
        					'max'  => '120',
        					'step' => '1',
        				),
        				'mobile_options'   => true,
        				'hover'            => 'tabs',
        			),

                'back_icon' => array(
                  'default'           => "34",
                  'label'             => esc_html__( 'Back Menu Icon', 'divi-mega-menu' ),
                  'type'              => 'text',
                  'computed_affects' => array(
                    '__getmegamenu',
                  ),
                  'option_category'   => 'configuration',
                  'description'       => esc_html__( 'Set the icon code by going to https://www.elegantthemes.com/blog/resources/elegant-icon-font and scroll down till you see the icons. Input the code that appears after the "x"', 'divi-mega-menu' ),
                  'toggle_slug'         => 'icon',
                ),

              'back_icon_color' => array(
                'label'             => esc_html__( 'Back Icon Color', 'divi-mega-menu' ),
                'description'       => esc_html__( 'Here you can define a custom color for the back icon.', 'divi-mega-menu' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'icon',
                'hover'             => 'tabs',
                'mobile_options'    => true,
              ),
              'back_icon_font_size'        => array(
                'label'            => esc_html__( 'Back Icon Font Size', 'divi-mega-menu' ),
                'description'      => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'divi-mega-menu' ),
                'type'             => 'range',
                'option_category'  => 'font_option',
                'tab_slug'         => 'advanced',
                'toggle_slug'      => 'icon',
                'default'          => '16px',
                'default_unit'     => 'px',
                'default_on_front' => '',
                'range_settings'   => array(
                  'min'  => '1',
                  'max'  => '120',
                  'step' => '1',
                ),
                'mobile_options'   => true,
                'hover'            => 'tabs',
              ),
              'parent_menu_background_color' => array(
                'label'             => esc_html__( 'Parent Menu Background Color', 'et_builder' ),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'parent_items',
                'description'       => esc_html__( 'This will change the background color of the parent menu items.', 'et_builder' ),
                'default'           => ""
            ),
            'parent_menu_padding_top' => array(
              'label'             => esc_html__( 'Parent Menu Padding Top', 'divi-ajax-filter' ),
              'type'              => 'range',
              'toggle_slug'     => 'parent_items',
              'tab_slug'          => 'advanced',
              'default'   => '15px',
                  'range_settings'  => array(
                    'min'  => '-300',
                    'max'  => '300',
                    'step' => '1',
                  ),
              'description'       => esc_html__( 'Change the padding on the top on the Parent Menu.', 'divi-ajax-filter' ),
            ),
            'parent_menu_padding_right' => array(
              'label'             => esc_html__( 'Parent Menu Padding Right', 'divi-ajax-filter' ),
              'type'              => 'range',
              'toggle_slug'     => 'parent_items',
              'tab_slug'          => 'advanced',
              'default'   => '12px',
                  'range_settings'  => array(
                    'min'  => '-300',
                    'max'  => '300',
                    'step' => '1',
                  ),
              'description'       => esc_html__( 'Change the padding on the right on the Parent Menu.', 'divi-ajax-filter' ),
            ),
            'parent_menu_padding_bottom' => array(
              'label'             => esc_html__( 'Parent Menu Padding Bottom', 'divi-ajax-filter' ),
              'type'              => 'range',
              'toggle_slug'     => 'parent_items',
              'tab_slug'          => 'advanced',
              'default'   => '15px',
                  'range_settings'  => array(
                    'min'  => '-300',
                    'max'  => '300',
                    'step' => '1',
                  ),
              'description'       => esc_html__( 'Change the padding on the bottom on the Parent Menu.', 'divi-ajax-filter' ),
            ),
            'parent_menu_padding_left' => array(
              'label'             => esc_html__( 'Parent Menu Padding Left', 'divi-ajax-filter' ),
              'type'              => 'range',
              'toggle_slug'     => 'parent_items',
              'tab_slug'          => 'advanced',
              'default'   => '12px',
                  'range_settings'  => array(
                    'min'  => '-300',
                    'max'  => '300',
                    'step' => '1',
                  ),
              'description'       => esc_html__( 'Change the padding on the left on the Parent Menu.', 'divi-ajax-filter' ),
            ),
            'parent_menu_border_color' => array(
              'label'             => esc_html__( 'Parent Menu Border Color', 'et_builder' ),
              'type'              => 'color-alpha',
              'tab_slug'          => 'advanced',
              'toggle_slug'       => 'parent_items',
              'description'       => esc_html__( 'Change the color of the border.', 'et_builder' ),
              'default'           => ""
          ),


            'sub_menu_background_color' => array(
              'label'             => esc_html__( 'Sub-Menu Background Color', 'et_builder' ),
              'type'              => 'color-alpha',
              'tab_slug'          => 'advanced',
              'toggle_slug'       => 'sub_items',
              'description'       => esc_html__( 'This will change the background color of the sub menu items.', 'et_builder' ),
              'default'           => ""
            ),
            'sub_menu_padding_top' => array(
              'label'             => esc_html__( 'Sub-Menu Padding Top', 'divi-ajax-filter' ),
              'type'              => 'range',
              'toggle_slug'     => 'sub_items',
              'tab_slug'          => 'advanced',
              'default'   => '15px',
                  'range_settings'  => array(
                    'min'  => '-300',
                    'max'  => '300',
                    'step' => '1',
                  ),
              'description'       => esc_html__( 'Change the padding on the top on the Parent Menu.', 'divi-ajax-filter' ),
            ),
            'sub_menu_padding_right' => array(
              'label'             => esc_html__( 'Sub-Menu Padding Right', 'divi-ajax-filter' ),
              'type'              => 'range',
              'toggle_slug'     => 'sub_items',
              'tab_slug'          => 'advanced',
              'default'   => '12px',
                  'range_settings'  => array(
                    'min'  => '-300',
                    'max'  => '300',
                    'step' => '1',
                  ),
              'description'       => esc_html__( 'Change the padding on the right on the Parent Menu.', 'divi-ajax-filter' ),
            ),
            'sub_menu_padding_bottom' => array(
              'label'             => esc_html__( 'Sub-Menu Padding Bottom', 'divi-ajax-filter' ),
              'type'              => 'range',
              'toggle_slug'     => 'sub_items',
              'tab_slug'          => 'advanced',
              'default'   => '15px',
                  'range_settings'  => array(
                    'min'  => '-300',
                    'max'  => '300',
                    'step' => '1',
                  ),
              'description'       => esc_html__( 'Change the padding on the bottom on the Parent Menu.', 'divi-ajax-filter' ),
            ),
            'sub_menu_padding_left' => array(
              'label'             => esc_html__( 'Sub-Menu Padding Left', 'divi-ajax-filter' ),
              'type'              => 'range',
              'toggle_slug'     => 'sub_items',
              'tab_slug'          => 'advanced',
              'default'   => '12px',
                  'range_settings'  => array(
                    'min'  => '-300',
                    'max'  => '300',
                    'step' => '1',
                  ),
              'description'       => esc_html__( 'Change the padding on the left on the Parent Menu.', 'divi-ajax-filter' ),
            ),
            'sub_menu_border_color' => array(
              'label'             => esc_html__( 'Sub-Menu Border Color', 'et_builder' ),
              'type'              => 'color-alpha',
              'tab_slug'          => 'advanced',
              'toggle_slug'       => 'sub_items',
              'description'       => esc_html__( 'Change the color of the border.', 'et_builder' ),
              'default'           => ""
          ),
              
              '__getmegamenu' => array(
                'type' => 'computed',
                'computed_callback' => array( 'divi_megamenu_drop_down_code', 'dmm_dropdown_code' ),
                'computed_depends_on' => array(
                  'menu_id'
                ),
              ),
            );


                       return $fields;

                   }


                   public static function dmm_dropdown_code ( $args = array(), $conditional_tags = array(), $current_page = array() ){


                     ob_start();

                    $menu_id = $args['menu_id'];

                     $dropdownMenu = wp_nav_menu( array(
                       'menu' => $menu_id,
                       'menu_class'        => "dmm-dropdown-ul",
                       'container'         => "div",
                       'container_class'   => "dmm-dropdown-wrapper",
                     ) );


                     echo esc_html($dropdownMenu);


                     $data = ob_get_clean();
                     return $data;

                   }

                   public function render( $attrs, $content, $render_slug ) {

                  //////////////////////////////////////////////////////////////////////
                  
                  $menu_id                         = $this->props['menu_id'];
                  $parent_icon                         = $this->props['parent_icon'];
                  $back_icon = $this->props['back_icon'];
                  $max_width = $this->props['max_width_menu'];
                  $menu_app_side = $this->props['menu_app_side'];
                  
                  $parent_menu_background_color = $this->props['parent_menu_background_color'];
                  $parent_menu_padding_top = $this->props['parent_menu_padding_top'];
                  $parent_menu_padding_right = $this->props['parent_menu_padding_right'];
                  $parent_menu_padding_bottom = $this->props['parent_menu_padding_bottom'];
                  $parent_menu_padding_left = $this->props['parent_menu_padding_left'];
                  


                  $sub_menu_background_color = $this->props['sub_menu_background_color'];
                  $sub_menu_padding_top = $this->props['sub_menu_padding_top'];
                  $sub_menu_padding_right = $this->props['sub_menu_padding_right'];
                  $sub_menu_padding_bottom = $this->props['sub_menu_padding_bottom'];
                  $sub_menu_padding_left = $this->props['sub_menu_padding_left'];
                  
                                
                  
                  $parent_menu_border_color = $this->props['parent_menu_border_color'];
                  $sub_menu_border_color = $this->props['sub_menu_border_color'];
                  
                  



                  
                  $num = wp_rand(100000,999999);
                  $css_class              = $render_slug . "_" . $num;
                  $this->add_classname( $css_class );
                  
                  $icon_color_values                     = et_pb_responsive_options()->get_property_values( $this->props, 'icon_color' );
                  $icon_color_hover                      = $this->get_hover_value( 'icon_color' );
                  $icon_font_size_values                 = et_pb_responsive_options()->get_property_values( $this->props, 'icon_font_size' );
                  $icon_font_size_hover                  = $this->get_hover_value( 'icon_font_size' );
                  $back_icon_color_values                     = et_pb_responsive_options()->get_property_values( $this->props, 'back_icon_color' );
                  $back_icon_color_hover                      = $this->get_hover_value( 'back_icon_color' );
                  $back_icon_font_size_values                 = et_pb_responsive_options()->get_property_values( $this->props, 'back_icon_font_size' );
                  $back_icon_font_size_hover                  = $this->get_hover_value( 'back_icon_font_size' );


                  // PARENT
                  if ( ! empty( $parent_menu_background_color ) ) {
                    self::set_style( $render_slug,
                    array(
                      'selector'    => '%%order_class%% .dmm-dropdown-ul li a, .et-db #et-boc .et-l %%order_class%% .dmm-dropdown-ul li a',
                      'declaration' => sprintf( 'background-color: %1$s;', esc_attr( $parent_menu_background_color ) ),
                    )
                    );
                  }
                  if ( ! empty( $parent_menu_border_color ) ) {
                    self::set_style( $render_slug,
                    array(
                      'selector'    => '%%order_class%% .dmm-dropdown-ul li a, .et-db #et-boc .et-l %%order_class%% .dmm-dropdown-ul li a',
                      'declaration' => sprintf( 'border-color: %1$s;', esc_attr( $parent_menu_border_color ) ),
                    )
                    );
                  }
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .dmm-dropdown-ul li a, .et-db #et-boc .et-l %%order_class%% .dmm-dropdown-ul li a',
                    'declaration' => sprintf(
                      'padding: %1$s %2$s %3$s %4$s;',
                      esc_html( $parent_menu_padding_top ),
                      $parent_menu_padding_right,
                      $parent_menu_padding_bottom,
                      $parent_menu_padding_left
                    ),
                  ) );


                  // SUB
                  if ( ! empty( $sub_menu_background_color ) ) {
                    self::set_style( $render_slug,
                    array(
                      'selector'    => '%%order_class%% .dmm-dropdown-ul li .sub-menu li a',
                      'declaration' => sprintf( 'background-color: %1$s;', esc_attr( $sub_menu_background_color ) ),
                    )
                    );
                  }
                  if ( ! empty( $sub_menu_border_color ) ) {
                    self::set_style( $render_slug,
                    array(
                      'selector'    => '%%order_class%% .dmm-dropdown-ul li .sub-menu li a',
                      'declaration' => sprintf( 'border-color: %1$s;', esc_attr( $sub_menu_border_color ) ),
                    )
                    );
                  }
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .dmm-dropdown-ul li .sub-menu li a',
                    'declaration' => sprintf(
                      'padding: %1$s %2$s %3$s %4$s;',
                      esc_html( $sub_menu_padding_top ),
                      $sub_menu_padding_right,
                      $sub_menu_padding_bottom,
                      $sub_menu_padding_left
                    ),
                  ) );


                          
                                  //ob_start();

                                  $dropdownMenu = wp_nav_menu( array(
                                    'menu' => $menu_id,
                                    'menu_class'        => "dmm-dropdown-ul",
                                    'container'         => "div",
                                    'container_class'   => "dmm-dropdown-wrapper",
                                    'echo'              => false,
                                  ) );


                                  $data = $dropdownMenu;

                                  if (is_numeric(substr($max_width, -1, 1))) {
                                    $max_width = $max_width . 'px';
                                  } else {
                                    $max_width = $max_width;
                                  }

$css = sprintf(
'<style>
.%4$s .dmm-dropdown-ul, .de-mega-menu .%4$s .dmm-dropdown-ul li .sub-menu .menu-item-has-children{max-width: %3$s;}
.de-mega-menu .%4$s .dmm-dropdown-ul li .sub-menu {width: %3$s !important;%5$s: -%3$s !important;}
.%4$s .dmm-dropdown-ul .menu-item-has-children > a:after {content: "\%1$s" !important;}
.%4$s .dmm-overlay .go-back:before {content: "\%2$s" !important;}
</style>',
  $parent_icon,
  $back_icon,
  $max_width,
  $css_class,
  $menu_app_side
  );

  $data = $css . $dropdownMenu; // phpcs:ignore

//$data = ob_get_clean();

                                   //////////////////////////////////////////////////////////////////////

// ICON FONT SIZE/COLOR
et_pb_responsive_options()->generate_responsive_css( $icon_color_values, '%%order_class%% .dmm-dropdown-ul .menu-item-has-children > a:after', 'color', $render_slug, '', 'color', ET_Builder_Element::DEFAULT_PRIORITY );

if ( et_builder_is_hover_enabled( 'icon_color', $this->props ) ) {
  ET_Builder_Element::set_style( $render_slug, array(
    'selector'    => '%%order_class%% .dmm-dropdown-ul .menu-item-has-children > a:hover:after',
    'priority'    => ET_Builder_Element::DEFAULT_PRIORITY,
    'declaration' => sprintf(
      'color: %1$s;',
      esc_html( $icon_color_hover )
    ),
  ) );
}
et_pb_responsive_options()->generate_responsive_css( $icon_font_size_values, '%%order_class%% .dmm-dropdown-ul .menu-item-has-children > a:after', 'font-size', $render_slug );
if ( et_builder_is_hover_enabled( 'icon_font_size', $this->props ) && '' !== $icon_font_size_hover ) {
  // Hover Icon Size.
  ET_Builder_Element::set_style( $render_slug, array(
    'selector'    => '%%order_class%% .dmm-dropdown-ul .menu-item-has-children > a:hover:after',
    'declaration' => sprintf(
      'font-size:%1$s;',
      esc_html( $icon_font_size_hover )
    ),
  ) );
}





// BACK ICON FONT SIZE/COLOR
et_pb_responsive_options()->generate_responsive_css( $back_icon_color_values, '%%order_class%% .dmm-overlay .go-back:before', 'color', $render_slug, '', 'color', ET_Builder_Element::DEFAULT_PRIORITY );

if ( et_builder_is_hover_enabled( 'icon_color', $this->props ) ) {
  ET_Builder_Element::set_style( $render_slug, array(
    'selector'    => '%%order_class%% .dmm-overlay .go-back:hover:before',
    'priority'    => ET_Builder_Element::DEFAULT_PRIORITY,
    'declaration' => sprintf(
      'color: %1$s;',
      esc_html( $back_icon_color_hover )
    ),
  ) );
}
et_pb_responsive_options()->generate_responsive_css( $back_icon_font_size_values, '%%order_class%% .dmm-overlay .go-back:before', 'font-size', $render_slug );
if ( et_builder_is_hover_enabled( 'icon_font_size', $this->props ) && '' !== $back_icon_font_size_hover ) {
  // Hover Icon Size.
  ET_Builder_Element::set_style( $render_slug, array(
    'selector'    => '%%order_class%% .dmm-overlay .go-back:hover:before',
    'declaration' => sprintf(
      'font-size:%1$s;',
      esc_html( $back_icon_font_size_hover )
    ),
  ) );
}




                                return $data;
                  }
              }

            new divi_megamenu_drop_down_code;
