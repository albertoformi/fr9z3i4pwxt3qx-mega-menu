<?php
  include('titan-framework/titan-framework-embedder.php');
  $GLOBALS['mega_menu_options'] =  maybe_unserialize( get_option( 'divi-mega-menu_options' ));
function get_mega_menu_option( $option_name) {
	return $GLOBALS['mega_menu_options'][ $option_name ] ?: '';
}

function divi_mega_menu_settings() {
  $titan = TitanFramework::getInstance( 'divi-mega-menu' );
$get_divi_engine_menu = get_option('divi-engine-menu', null);
if ($get_divi_engine_menu == "" || $get_divi_engine_menu == "mega-menu-added" ) {
  update_option('divi-engine-menu', 'mega-menu-added');
  $titan = TitanFramework::getInstance( 'divi-mega-menu' );
$icon = plugins_url( 'images/dash-icon.svg', __FILE__ );
$admin_panel2 = $titan->createAdminPanel( array( 'name' => 'Divi Engine', 'capability' => 'manage_options' , 'icon' => $icon . '' , 'id' => 'divi-engine',) );
$welcometab = $admin_panel2->createTab(array('name' => 'Welcome',));
        $welcometab->createOption(array(
            'name' => esc_html__( 'Welcome to Divi Engine'),
            'type' => 'heading',
        ));

        $welcometab->createOption(array(
            'type' => 'note',
            'desc' => '<iframe class="nitro_videos" width="560" height="315" src="https://www.youtube.com/embed/jKio-EA4I0k" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
        ));

        $welcometab->createOption(array(
            'name' => esc_html__( 'Support'),
            'type' => 'heading',
        ));
        $welcometab->createOption(array(
            'type' => 'note',
            'desc' => esc_html__( 'We know that when building a website things may not always go according to plan. If you experience issues when using our plugins do not worry we are here to help. First take a look at our documentation ').'<a href="https://help.diviengine.com/ " target="_blank">'. esc_html__( 'here') .'</a>'. esc_html__( ' and if you cannot find a solution, please contact us ').' <a href="https://diviengine.com/support/" target="_blank">'. esc_html__( 'here').'</a>'. esc_html__( ' and we will help you resolve any issues.'),
        ));
        $welcometab->createOption(array(
            'name' => 'Feedback',
            'type' => 'heading',
        ));
        $welcometab->createOption(array(
            'type' => 'note',
            'desc' => esc_html__( 'We would love to hear from you, good or bad! We would really appreciate it if you could leave a review on our product page so that it helps others!')
        ));

        $welcometab->createOption(array(
            'name' => esc_html__( 'Do you have idea?'),
            'type' => 'heading',
        ));
        $welcometab->createOption(array(
            'type' => 'note',
            'desc' => esc_html__( 'If you have an idea for how to improve our plugins, please dont hesitate to contact us ') .'<a href="https://diviengine.com/contact/" target="_blank">'. esc_html__( 'here') .'</a>'. esc_html__( ' as we really want to make them better for everyone!')
        ));
}
else {
  # code...
}



$divi_mega_menu_settings_meta_box = $titan->createMetaBox( array(
       'name'      => 'Custom Identifier',
       'post_type' => array('dmmenu' ),
       'priority'  => 'high',
       'context' => 'side',
   ) );

   $divi_mega_menu_settings_meta_box->createOption( array(
   'name' => 'Enter Custom Identifier',
   'id' => 'divi_mm_custom_class',
   'type' => 'text',
   'desc' => 'Type in one custom identifier which will be used to identify this specific Mega Menu. The identifier should have no spaces and must consist of letters and the “_” sign.  word with no spaces. For example, you could use menu_one as your identifier.'
   ) );

   $divi_mega_menu_settings_meta_box_low = $titan->createMetaBox( array(
          'name'      => 'Mega Menu Style',
          'post_type' => array('dmmenu' ),
          'priority'  => 'low'
      ) );

      $divi_mega_menu_settings_meta_box_low_triangle = $titan->createMetaBox( array(
             'name'      => 'Mega Menu Triangle Style',
             'post_type' => array('dmmenu' ),
             'priority'  => 'low'
         ) );

         $divi_mega_menu_settings_meta_box_low_closeicon = $titan->createMetaBox( array(
                'name'      => 'Mega Menu Close Icon Style',
                'post_type' => array('dmmenu' ),
                'priority'  => 'low'
            ) );




                  $divi_mega_menu_settings_meta_box_low->createOption( array(
                  'name' => 'Menu Position',
                  'id' => 'divi_mm_style',
                  'type' => 'select',
                  'options' => array(
                  'default' => 'Default Menu',
                  'tooltip' => 'Tooltip',
                  ),
                  'default' => 'default',
                  'desc' => 'Choose the position for this Mega.',
                  ) );


                  $divi_mega_menu_settings_meta_box_low->createOption( array(
                    'name' => 'Tooltip Position Direction',
                    'id' => 'divi_mm_tooltip_direction',
                    'type' => 'select',
                    'options' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    ),
                    'default' => 'bottom',
                    'desc' => 'On tooltip, choose where you would like this menu to appear.',
                    ) );
      $divi_mega_menu_settings_meta_box_low->createOption( array(
      'name' => 'Menu Activate',
      'id' => 'divi_mm_activate',
      'type' => 'select',
      'options' => array(
      'hover' => 'Hover',
      'click' => 'Click',
      ),
      'default' => 'hover',
      'desc' => 'Choose how you want the menu to be shown, on click or hover',
      ) );

      $divi_mega_menu_settings_meta_box_low->createOption( array(
      'name' => 'Open Hover Delay Time',
      'id' => 'divi_mm_initial_hover_delay_time',
      'type' => 'number',
      'desc' => 'When hovering over the menu item or tooltip, set the delay time for the menu to appear.',
      'default' => '300',
      'min' => '0',
      'max' => '5000',
      'step' => '1',
      'unit' => 'ms',
      ) );

      $divi_mega_menu_settings_meta_box_low->createOption( array(
      'name' => 'Close Hover Delay Time',
      'id' => 'divi_mm_hover_delay_time',
      'type' => 'number',
      'desc' => 'On hover, set the time for this menu to dissappear.',
      'default' => '300',
      'min' => '0',
      'max' => '5000',
      'step' => '1',
      'unit' => 'ms',
      ) );

      $divi_mega_menu_settings_meta_box_low->createOption( array(
      'name' => 'Close on Scroll',
      'id' => 'divi_mm_activate_close_on_scroll',
      'type' => 'checkbox',
      'desc' => 'On click, check box if you would like this menu to close on scroll.',
      'default' => false,
      ) );


      $divi_mega_menu_settings_meta_box_low->createOption( array(
      'name' => 'Entrance Menu Animation',
      'id' => 'divi_mm_animation_name',
      'type' => 'select',
      'options' => array(
      'fadeBottom' => 'Fade Bottom',
      'fadeLeft' => 'Fade Left',
      'fadeRight' => 'Fade Right',
      'slideDown' => 'Slide Down',
      'fadeIn' => 'Fade In',
      'flipInX' => 'Flip In X',
      'flipInY' => 'Flip In Y',
      ),
      'default' => 'full',
      'desc' => 'Choose the animation for this menu.',
      ) );


    //   $divi_mega_menu_settings_meta_box_low->createOption( array(
    //   'name' => 'Exit Menu Animation',
    //   'id' => 'divi_mm_animation_name_exit',
    //   'type' => 'select',
    //   'options' => array(
    //    'none' => 'No Animation Exit',
    //   'fadeBottomExit' => 'Fade Bottom',
    //   'fadeLeftExit' => 'Fade Left',
    //   'fadeRightExit' => 'Fade Right',
    //   'fadeInExit' => 'Fade In',
    //   'flipInXExit' => 'Flip In X',
    //   'flipInYExit' => 'Flip In Y',
    //   ),
    //   'default' => 'none',
    //   'desc' => 'Choose the animation for this menu.',
    //   ) );
   
      $divi_mega_menu_settings_meta_box_low->createOption( array(
      'name' => 'Animation Duration',
      'id' => 'divi_mm_animation_duration',
      'type' => 'number',
      'desc' => 'Set the time it takes for the animation to complete.',
      'default' => '0.7',
      'min' => '0',
      'max' => '5',
      'step' => '0.1',
      'unit' => 's',
      ) );

      $divi_mega_menu_settings_meta_box_low_closeicon->createOption( array(
      'name' => 'Show Close Icon',
      'id' => 'divi_mm_activate_close_icon',
      'type' => 'checkbox',
      'desc' => 'Check this box if this menu is being activated by a click and if you want to have a close icon.',
      'default' => false,
      ) );

      $divi_mega_menu_settings_meta_box_low_closeicon->createOption( array(
      'name' => 'Close Icon Code',
      'id' => 'divi_mm_activate_close_icon_code',
      'type' => 'text',
      'default' => '4d',
      'desc' => 'Choose an icon <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">HERE</a> and then enter in the code. Copy the numbers and letters that appear after "x".',
      ) );

      $divi_mega_menu_settings_meta_box_low_closeicon->createOption( array(
      'name' => ''.esc_html__( "Close Icon Color", 'divi-bodyshop-woocommerce' ).'',
      'id' => 'divi_mm_activate_close_icon_color',
      'type' => 'color',
      'default' => '#ffffff',
      'alpha'  => 'true',
      ) );

      $divi_mega_menu_settings_meta_box_low_closeicon->createOption( array(
      'name' => 'Close Icon Font Size',
      'id' => 'divi_mm_activate_close_icon_fontsize',
      'type' => 'number',
      'default' => '20',
      'max' => '300',
      'step' => '1',
      'unit' => 'px',
      ) );

      $divi_mega_menu_settings_meta_box_low_closeicon->createOption( array(
      'name' => 'Close Icon Distance From Top',
      'id' => 'divi_mm_activate_close_icon_dis_top',
      'type' => 'number',
      'default' => '20',
      'max' => '300',
      'step' => '1',
      'unit' => 'px',
      ) );

      $divi_mega_menu_settings_meta_box_low_closeicon->createOption( array(
      'name' => 'Close Icon Distance From Right',
      'id' => 'divi_mm_activate_close_icon_dis_right',
      'type' => 'number',
      'default' => '20',
      'max' => '300',
      'step' => '1',
      'unit' => 'px',
      ) );

   $divi_mega_menu_settings_meta_box_low->createOption( array(
   'name' => 'Full Width',
   'id' => 'settings_fullwidth',
   'type' => 'enable',
   'default' => false,
   'enabled' => 'YES',
   'disabled' => 'NO',
   'desc' => 'Enable switch to force this menu fullwidth.',
   ) );

   $divi_mega_menu_settings_meta_box_low->createOption( array(
   'name' => 'Custom Width',
   'id' => 'divi_mm_custom_width',
   'type' => 'number',
   'desc' => 'Set the custom width of this menu.',
   'default' => '1080',
   'min' => '0',
   'max' => '3000',
   'step' => '1',
   'unit' => 'px',
   ) );

   $divi_mega_menu_settings_meta_box_low->createOption( array(
   'name' => 'Menu Relative Position',
   'id' => 'realtive_postion',
   'type' => 'checkbox',
   'desc' => 'Check this box if you want to have the menu drop down relative to the menu item - fine tune settings are below.',
   'default' => false,
   ) );

   $divi_mega_menu_settings_meta_box_low->createOption( array(
   'name' => 'Adjust From Left',
   'id' => 'divi_mm_adjust_left',
   'type' => 'number',
   'desc' => 'Fine tune how far left you want this menu to appear.',
   'default' => '0',
   'min' => '-3000',
   'max' => '3000',
   'step' => '1',
   'unit' => 'px',
   ) );

   $divi_mega_menu_settings_meta_box_low->createOption( array(
   'name' => 'Adjust From Top',
   'id' => 'divi_mm_adjust_top',
   'type' => 'number',
   'desc' => 'Fine tune how far from the top you want this menu to appear.',
   'default' => '0',
   'min' => '-1000',
   'max' => '1000',
   'step' => '1',
   'unit' => 'px',
   ) );

	$divi_mega_menu_settings_meta_box_low->createOption( array(
		'name' => 'Change top position on scroll ?',
		'id' => 'divi_mm_enable_adjust_top_on_scroll',
		'type' => 'enable',
		'default' => false,
		'enabled' => 'YES',
		'disabled' => 'NO',
		'desc' => 'Enable this if you would like to change the top position of this menu after the page is scrolled',
	) );

	$divi_mega_menu_settings_meta_box_low->createOption( array(
		'name' => 'Adjust From Top - On scroll',
		'id' => 'divi_mm_adjust_top_on_scroll',
		'type' => 'number',
		'desc' => 'Fine tune how far from the top you want this menu to appear on scroll.',
		'default' => '0',
		'min' => '-1000',
		'max' => '1000',
		'step' => '1',
		'unit' => 'px',
	) );

   $divi_mega_menu_settings_meta_box_low->createOption( array(
   'name' => 'Adjust From Top Mobile',
   'id' => 'divi_mm_adjust_top_mobile',
   'type' => 'number',
   'desc' => 'Fine tune how far from the top you want this menu to appear on mobile',
   'default' => '0',
   'min' => '-1000',
   'max' => '1000',
   'step' => '1',
   'unit' => 'px',
   ) );

   $divi_mega_menu_settings_meta_box_low->createOption( array(
   'name' => 'Disable On Mobile',
   'id' => 'settings_disable_mobile',
   'type' => 'enable',
   'default' => false,
   'enabled' => 'YES',
   'disabled' => 'NO',
   'desc' => 'Enable switch to disable this menu on mobile.',
   ) );

   $divi_mega_menu_settings_meta_box_low_triangle->createOption( array(
   'name' => 'Triangle Above Menu',
   'id' => 'divi_mm_triangle',
   'type' => 'checkbox',
   'desc' => 'Check this box if you want a triangle above your mega menu.',
   'default' => false,
   ) );

   $divi_mega_menu_settings_meta_box_low_triangle->createOption( array(
   'name' => 'Triangle Location',
   'id' => 'divi_mm_triangle_location',
   'type' => 'select',
   'options' => array(
   'megamenu' => 'On Mega Menu',
   'menu' => 'On Menu Link',
   ),
   'default' => 'megamenu',
   'desc' => 'By default the triangle will appear above the mega menu. If you are having issues with it being exactly where you want on the menu, change it to "On Menu Link."',
   ) );

   $divi_mega_menu_settings_meta_box_low_triangle->createOption( array(
    'name' => 'Turn Into Underline (must be "On Menu Link" above)',
    'id' => 'divi_mm_triangle_underline',
    'type' => 'enable',
    'default' => false,
    'enabled' => 'YES',
    'disabled' => 'NO',
    'desc' => 'Enable this if you want to make it underline and not a triangle.',
    ) );

   $divi_mega_menu_settings_meta_box_low_triangle->createOption( array(
   'name' => ''.esc_html__( "Triangle Color", 'divi-bodyshop-woocommerce' ).'',
   'id' => 'divi_mm_triangle_color',
   'type' => 'color',
   'default' => '#ffffff',
   'alpha'  => 'true',
   ) );

   $divi_mega_menu_settings_meta_box_low_triangle->createOption( array(
   'name' => 'Triangle/Underline Height',
   'id' => 'divi_mm_triangle_height',
   'type' => 'number',
   'default' => '20',
   'max' => '300',
   'step' => '1',
   'unit' => 'px',
   ) );

   $divi_mega_menu_settings_meta_box_low_triangle->createOption( array(
   'name' => 'Triangle/Underline Distance From Top',
   'id' => 'divi_mm_triangle_top_distance',
   'type' => 'number',
   'default' => '0',
   'min' => '-300',
   'max' => '300',
   'step' => '1',
   'unit' => 'px',
   ) );

   $divi_mega_menu_settings_meta_box_low_triangle->createOption( array(
   'name' => 'Triangle/Underline Distance Left/Right',
   'id' => 'divi_mm_triangle_horzontal_distance',
   'type' => 'number',
   'default' => '0',
   'min' => '-1000',
   'max' => '1000',
   'step' => '1',
   'unit' => 'px',
   ) );





// Settings

$admin_panel = $titan->createAdminPanel( array( 'name' => 'Mega Menu Settings', 'id' => 'divi-mega-menu', 'parent' => 'divi-engine', 'position' => '9',) );
$general = $admin_panel->createTab( array('name' => 'General Settings',) );
$mobile = $admin_panel->createTab( array('name' => 'Mobile Settings',) );



$mobile->createOption(array(
    'name' => 'Mobile Settings',
    'type' => 'heading',
));

$mobile->createOption( array(
  'name' => 'Disable on Mobile',
  'id' => 'divi_mm_disable',
  'type' => 'enable',
  'default' => false,
  'enabled' => 'YES',
  'disabled' => 'NO',
  'desc' => 'If you want to use the default Divi mobile menu and not the Mega Menu then enable this switch.',
  ) );

$mobile->createOption( array(
'name' => ''.esc_html__( "Mobile Menu Breakpoint", 'divi-bodyshop-woocommerce' ).'',
'id' => 'divi_mm_breakpoint',
'type' => 'text',
'default' => '980',
'desc' => 'Specify the screen size at which your Mega Menu should appear.',
) );
$mobile->createOption( array(
'name' => 'Fixed Mobile Menu',
'id' => 'fixed_mobile_menu',
'type' => 'checkbox',
'desc' => 'By default Divi does not use a fixed menu on mobile. However if you are using a fixed menu on mobile, please check this box.',
'default' => false,
) );
$mobile->createOption( array(
'name' => 'Stop Click Through',
'id' => 'stop_click_through_mobile',
'type' => 'checkbox',
'desc' => 'Check this box if you do not want your customer to be able to click on the parent menu item. To open the Mega Menu, the customer has to click on the arrow icon',
'default' => true,
) );


$mobile->createOption( array(
'name' => ''.esc_html__( "Specify Mobile Menu ID", 'divi_mobile_settings' ).'',
'id' => 'specific_mobile_id',
'type' => 'text',
'default' => '',
'desc' => ''.esc_html__( "If you have created multiple menus using the Divi theme builder then you will need to specify which menu module you would like Mega Menu to target. You do so by using a custom ID. Please read our detailed documentation for this and contact us for support.").'',
) );

$mobile->createOption( array(
'type' => 'save',
) );

$general->createOption(array(
    'name' => 'General Settings',
    'type' => 'heading',
));

$general->createOption( array(
'name' => ''.esc_html__( "Navigational Header", 'divi-bodyshop-woocommerce' ).'',
'id' => 'mega_menu_header_type',
'type' => 'select',
'desc' => ''.esc_html__( "Please select the software you are using for your header navigation. If your software is not in this list, please contact us.", 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'default' => ''.esc_html__( "Default Divi", 'divi-bodyshop-woocommerce' ).'',
'theme_builder_alt' => ''.esc_html__( "Theme Builder", 'divi-bodyshop-woocommerce' ).'',
'fullwidth_header' => ''.esc_html__( "Menu added on each page (not theme builder)", 'divi-bodyshop-woocommerce' ).'',
'mhmm' => ''.esc_html__( "Mhmm. Mighty Header & Menu Maker", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'default',
) );

$general->createOption( array(
'name' => ''.esc_html__( "Mega Menu Method", 'divi-bodyshop-woocommerce' ).'',
'id' => 'mega_menu_injection_method',
'type' => 'select',
'desc' => ''.esc_html__( "Choose a Mega Menu Method - currently we only have a default method, but will be bringing out  new methods soon.", 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'default' => ''.esc_html__( "Default", 'divi-bodyshop-woocommerce' ).'',
// 'ajax' => ''.esc_html__( "Ajax", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'default',
) );

$general->createOption( array(
'name' => 'Desktop Header Fixed',
'id' => 'fixed_custom_header_desktop',
'type' => 'checkbox',
'desc' => 'Check this box if you are using Divi 4 custom headers and have fixed it on desktop when scrolling.',
'default' => false,
) );
$general->createOption( array(
'name' => 'Stop Click Through',
'id' => 'stop_click_through',
'type' => 'checkbox',
'desc' => 'Check this box if you do not want your customer to be able to click on the parent menu item.',
'default' => false,
) );

$general->createOption( array(
'name' => 'Enable Background Overlay',
'id' => 'divi_mm_overlay',
'type' => 'checkbox',
'desc' => 'Check this box to enable a background overlay color behind the Mega Menu.',
'default' => false,
) );

$general->createOption( array(
'name' => ''.esc_html__( "Overlay Background Color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'divi_mm_overlay_color',
'type' => 'color',
'desc' => 'Select background overlay color.',
'default' => 'rgba(0,0,0,0.65)',
'alpha'  => 'true',
) );

$general->createOption( array(
    'name' => ''.esc_html__( "Menu Overflow Breakpoint/Max Height", 'divi-bodyshop-woocommerce' ).'',
    'id' => 'divi_mm_overflow_breakpoint',
    'type' => 'number',
    'desc' => 'Specify the max height when the browser gets too short (in viewport height), it will have a scroll bar. To have no scroll bar, set as 0. For example, if you set it as 80 (default) - it will be 80vh',
    'default' => '0',
    'min' => '0',
    'max' => '100',
    'step' => '1',
    'unit' => 'vh',
    ) );

$general->createOption( array(
	'name' => ''.esc_html__( 'Delete all settings when plugin is removed', 'divi-mega-menu' ).'',
	'id' => 'settings_delete_from_database',
	'type' => 'enable',
	'default' => false,
	'enabled' => ''.esc_html__( 'YES', 'divi-mega-menu' ).'',
	'disabled' => ''.esc_html__( 'NO', 'divi-mega-menu' ).'',
	'desc' => ''.esc_html__( 'Enable this option if you want to remove all settings associated with this plugin upon removal.', 'divi-mega-menu' ).'',
) );

$general->createOption( array(
	'name' => ''.esc_html__( 'Delete all mega menus when plugin is removed', 'divi-mega-menu' ).'',
	'id' => 'posts_delete_from_database',
	'type' => 'enable',
	'default' => false,
	'enabled' => ''.esc_html__( 'YES', 'divi-mega-menu' ).'',
	'disabled' => ''.esc_html__( 'NO', 'divi-mega-menu' ).'',
	'desc' => ''.esc_html__( 'Enable this option if you want to remove all the mega menus created with this plugin upon removal.', 'divi-mega-menu' ).'',
) );

$general->createOption( array(
'type' => 'save',
) );

if(class_exists('DE_DMM_options_interface')){
    $licensestab = $admin_panel->createTab( array('name' => ''.esc_html__( "Mega Menu License", 'divi-mega-menu' ).'',) );

    $licensestab->createOption(array(
    'name' => 'Divi Mega Menu Software License',
    'type' => 'heading',
    ));


    if (isset($_GET['page']) && ($_GET['page'] == 'divi-mega-menu')) {  // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $de_dn_option = new DE_DMM_options_interface();

        $licensestab->createOption(array(
            'type' => 'custom',
            'custom' => $de_dn_option->admin_menu(),
        ));

        add_action('init', array($de_dn_option, 'options_update'), 1);
    }
}


}
add_action( 'tf_create_options', 'divi_mega_menu_settings' );

add_action( 'wp_dashboard_setup', 'dmm_check_validation' );

function dmm_check_validation() {

    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }

    $a_result = '';

    $de_su = 'https://diviengine.com/';

    $de_su_json = $de_su . 'wp-json/de_plugins/products';

    $site_url = get_option( 'siteurl' );
    $site_url = str_replace( 'https://', '', $site_url );
    $site_url = str_replace( 'http://', '', $site_url );
    $site_url = rtrim( $site_url, '/' );

    $aj_gaket = get_option( 'et_automatic_updates_options' );
    if ( !empty( $aj_gaket ) && isset( $aj_gaket['api_key'] ) ) {
        $aj_gaket_val = trim($aj_gaket['api_key']);
    } else {
        $aj_gaket_val = '';
    }
    
    $code_l = get_option('dmm_license');
    $code_d = "Y";

    if ( isset( $code_l['key'] ) && $code_l['key'] !== '' ) {
        $code_d = $code_l['key'];
    }

    $product_id = '352';
    $et_status = 'N';

    if ( DE_DMM_P == 'm_a' && $aj_gaket_val != '' ) {
        $json = file_get_contents('https://www.elegantthemes.com/marketplace/index.php/wp-json/api/v1/check_subscription/product_id/'.$product_id.'/api_key/'.$aj_gaket_val);
        if ( $json ) {
            $data = json_decode($json);
            $code_m = $data->code;
            if ( $code_m == 'subscription_active') {
                $et_status = 'Y';
            }     
        }
    }

    $secure_string = $site_url . '|' . 'de_mm' . '|' . DE_DMM_P . '|' . $code_d . '|' . $et_status;

    $file = DE_DMM_PATH . '/key.rem';

    $de_keys = get_option( 'de_keys', array() );
    if ( !file_exists( $file ) ) {
        if ( !empty( $de_keys['de_mm'] ) ) {
            $keypair = $de_keys['de_mm'];
            file_put_contents($file, $keypair);
        } else {
            $keypair = md5( $site_url );
            file_put_contents($file, $keypair);
            $de_keys['de_mm'] = $keypair;
            update_option( 'de_keys', $de_keys );
        }
    } else {
        $keypair = file_get_contents( $file );
        $de_keys['de_mm'] = $keypair;
        update_option( 'de_keys', $de_keys );
    }

    $body = array(
        'keypair'   => $keypair,
        'secure_str'    => base64_encode( $secure_string )
    );

    $args = array(
        'body'        => $body,
    );

    $response = wp_remote_post( $de_su_json, $args );
    $a_result = str_replace('"', '', wp_remote_retrieve_body( $response ));

    if ( $a_result == 'msg_ok' ) {
        return true;
    } else {
        return false;
    }
}