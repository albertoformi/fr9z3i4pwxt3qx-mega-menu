<?php
/*
Plugin Name: Divi Mega Menu
Plugin URL: https://diviengine.com
Description: Create Stunning Mega Menu's using the Divi Builder
Version: 3.5.3.6
Author: Divi Engine
Author URI: https://diviengine.com
Update URI: https://diviengine.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: divi-mega-menu
@author      diviengine.com
@copyright   2019 diviengine.com

DE_DMM_P: d_e | m_a

I pray that you bless the people who interact and who own this website - I pray the blessing to be one that goes beyond worldly treasures but understanding the deep love you have for them. In Jesus name, Amen

John 14:6
I am the way, and the truth, and the life. No one comes to the Father except through me.
*/



if ( ! defined( 'ABSPATH' ) ) exit;

define('DE_DMM_VERSION', '3.5.3.6');

define('DE_DMM_PATH',   plugin_dir_path(__FILE__));
define('DE_DMM_URL',    plugins_url('', __FILE__));
define('DE_DMM_APP_API_URL', 'https://diviengine.com/index.php');
define('DE_DMM_PRODUCT_ID', 'WP-DE-DMM');
define('DE_DMM_INSTANCE', str_replace(array ("https://" , "http://"), "", home_url()));

define( 'DE_DMM_AUTHOR', 'Divi Engine' );
define( 'DE_DMM_PRODUCT_URL', 'https://diviengine.com/product/divi-mega-menu/' );
define( 'DE_DMM_SITE_URL', 'https://www.diviengine.com' );
define('DE_DMM_NAME',plugin_basename( __FILE__ ));
defined('DE_DMM_P') or define('DE_DMM_P', 'd_e');

include(DE_DMM_PATH . '/functions.php');
// include(DE_DMM_PATH . '/include/classes/init.class.php');
include(DE_DMM_PATH . '/lib/custom-css.php');


// if DE_DMM_P is d_e then load the Divi Engine Updater
if (DE_DMM_P == 'd_e') {
    include(DE_DMM_PATH . '/include/classes/class.wooslt.php');
    include(DE_DMM_PATH . '/include/classes/class.licence.php');
    include(DE_DMM_PATH . '/include/classes/class.options.php');
    include(DE_DMM_PATH . '/include/classes/class.updater.php');
}

$mydata = get_option( 'divi-mega-menu_options' );
$mydata = unserialize($mydata);
if (isset($mydata['mega_menu_injection_method'])) {

if ($mydata['mega_menu_injection_method'] == "ajax") {
    include_once(DE_DMM_PATH . '/lib/mega-menu-ajax.php');
    //require_once dirname( __FILE__ ) .'/include/ajaxcalls/post-ajax.php';

    function load_mm_scripts(){
    	wp_enqueue_script( 'divi-mega-menu-ajax-js', DE_DMM_URL . '/scripts/ajax-mega-menu.min.js', array( 'jquery', 'jquery-ui-slider' ), DE_DMM_VERSION, true );
    	wp_localize_script( 'divi-mega-menu-ajax-js', 'ajax_object',
    		array(
    			'ajax_url' => admin_url( 'admin-ajax.php' )
    		)
    	);
    }
    add_action( 'wp_enqueue_scripts', 'load_mm_scripts', 99 );

} else {
    include(DE_DMM_PATH . '/lib/mega-menu-default.php');

    function load_mm_2_scripts(){
        wp_enqueue_script( 'divi-mega-menu-js', plugins_url() . '/fR9z3I4PWXT3qx-mega-menu/scripts/divi-mega-menu.min.js', array('jquery'), DE_DMM_VERSION, true );
    }
    add_action( 'wp_enqueue_scripts', 'load_mm_2_scripts', 99 );
    
}

} else {
include(DE_DMM_PATH . '/lib/mega-menu-default.php');

function load_mm_3_scripts(){
    wp_enqueue_script( 'divi-mega-menu-js', plugins_url() . '/fR9z3I4PWXT3qx-mega-menu/scripts/divi-mega-menu.min.js', array('jquery'), DE_DMM_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'load_mm_3_scripts', 99 );

}


/**
 * Flushed permalinks on activation.
 *
 * @see    function MegaMenu_Activate_hook
 * @return void
 */
function MegaMenu_Activate_Deactivate_hook() {
    add_action( 'shutdown', 'MegaMenu_Flush_Rewrite_Rules' );
}
register_activation_hook( __FILE__, 'MegaMenu_Activate_Deactivate_hook' );
register_deactivation_hook( __FILE__, 'MegaMenu_Activate_Deactivate_hook' );

function MegaMenu_Flush_Rewrite_Rules() {
    update_option( 'rewrite_rules', '' );
}


function dmm_get_theme_details(){

	$theme = wp_get_theme(get_template());

	if( !defined( 'DIVIENGINE_THEME_NAME' ) ){
        define( 'DIVIENGINE_THEME_NAME', strtolower($theme->Name) );
	}
}

dmm_get_theme_details();

// initialise Divi Modules
if ( !function_exists( 'de_dmm_initialise_ext' ) ) {
    function de_dmm_initialise_ext()
    {
        require_once DE_DMM_PATH . 'include/DEMegaMenu.php';
    }
    add_action( 'divi_extensions_init', 'de_dmm_initialise_ext' );
}



// function divi_mega_menu_js() {
//     wp_enqueue_script( 'divi-mega-menu-script',  plugins_url() . '/fR9z3I4PWXT3qx-mega-menu/js/mega-menu.min.js', array(), DE_DMM_VERSION, true );
// }
// add_action( 'wp_enqueue_scripts', 'divi_mega_menu_js' );

add_action( 'admin_enqueue_scripts', 'divi_mega_menu_load_admin_css' , 20);
function divi_mega_menu_load_admin_css() {


if ( 'dmmenu' === get_post_type() ) {
	$jsfile = plugins_url( 'scripts/admin.min.js', __FILE__ );
    wp_enqueue_script( 'divi-megamenu-admin-script', $jsfile, array( 'jquery' ), DE_DMM_VERSION );
}

$screen = get_current_screen();

if ( $screen->id == 'divi-engine_page_divi-mega-menu' )
{
	$jsfile = plugins_url( 'scripts/admin-settings.min.js', __FILE__ );
    wp_enqueue_script( 'divi-megamenu-admin-settings-script', $jsfile, array( 'jquery' ), DE_DMM_VERSION );
}

$cssfile = plugins_url( 'styles/divi-engine.css', __FILE__ );
$cssfile2 = plugins_url( 'styles/admin.css', __FILE__ );
 wp_enqueue_style( 'divi_engine_mage_admin_css', $cssfile , false, DE_DMM_VERSION );
  wp_enqueue_style( 'divi_engine_mage_admin_css_two', $cssfile2 , false, DE_DMM_VERSION );

  
}

function create_dmm_post_type() {
    register_post_type( 'dmmenu',
        array(
            'labels' => array(
                'name' => 'Mega Menu',
                'singular_name' => 'Divi Mega Menu',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Divi Mega Menu',
                'edit' => 'Edit',
                'edit_item' => 'Edit Divi Mega Menu',
                'new_item' => 'New Divi Mega Menu',
                'view' => 'View',
                'view_item' => 'View Divi Mega Menu',
                'search_items' => 'Search Divi Mega Menu',
                'not_found' => 'No Mega Menus found',
                'not_found_in_trash' => 'No Divi Mega Menu found in Trash',
                'parent' => 'Parent Divi Mega Menu'
            ),

            'public' => false,
            'query_var' => false,
            'show_ui' => TRUE,
            'exclude_from_search' => true,
            'publicaly_queryable' => false,
						'show_in_nav_menus'     => false,
            'menu_position' => 100,
            'supports' => array( 'title', 'custom-fields', 'editor' ),
            'has_archive' => false,
            'show_in_menu' => 'divi-engine'
        )
    );
}
add_action( 'init', 'create_dmm_post_type' );

function remove_megamenu_for_users() {
    if( !current_user_can( 'administrator' ) ):
        remove_menu_page( 'divi-engine' );
    endif;
}
add_action( 'admin_menu', 'remove_megamenu_for_users' );


function my_et_builder_post_types_mega_menu( $post_types ) {
    $post_types[] = 'dmmenu';

    return $post_types;
}
add_filter( 'et_builder_third_party_post_types', 'my_et_builder_post_types_mega_menu' );

// add_filter( 'et_pb_show_all_layouts_built_for_post_type', 'et_pb_show_all_layouts_built_for_post_type_mega_menu' );

// function et_pb_show_all_layouts_built_for_post_type_mega_menu() {
//  return 'page';
// }


register_deactivation_hook( __FILE__, 'mega_menu_deactivation_hook' );

function mega_menu_deactivation_hook() {
  delete_option( 'divi-engine-menu' );
}

function delete_mega_menu_posts(){
	$get_all_dmmenu_posts = get_posts( array( 'post_type' => 'dmmenu'));
	foreach( $get_all_dmmenu_posts as $dmmenu_posts ) {
		wp_delete_post( $dmmenu_posts->ID, true);
	}
}

if ( !function_exists('de_dmm_uninstall_hook')) {
	function de_dmm_uninstall_hook() {
		$remove_settings = get_mega_menu_option( 'settings_delete_from_database' );
		$remove_posts    = get_mega_menu_option( 'posts_delete_from_database' );
		if ( $remove_settings ) {
			delete_option( 'divi-mega-menu_options' );
		}
		if ( $remove_posts ) {
			delete_mega_menu_posts();
		}

	}

	register_uninstall_hook( __FILE__, 'de_dmm_uninstall_hook' );
}

function divi_mega_menu_load_actions_ajax( $actions ) {
  $actions[] = 'divi_mega_menu_filterposts_handler';
    $actions[] = 'divi_mega_menu_loadmore_ajax_handler';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'divi_mega_menu_load_actions_ajax' );

if ( !function_exists('de_dmm_plugin_action_links')) {
	function de_dmm_plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=divi-mega-menu' ) . '" aria-label="' . esc_attr__( 'View Mega Menu settings', 'divi-mega-menu' ) . '">' . esc_html__( 'Settings', 'divi-mega-menu' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	add_filter( 'plugin_action_links_' . DE_DMM_NAME, 'de_dmm_plugin_action_links' );
}

if ( !function_exists('divi_mega_menu_dynamic_css_assets_atf')) {
    /**
     * Force load module styles above the fold.
     *
     * @return array
     */
    function divi_mega_menu_dynamic_css_assets_atf( $atf_modules ) {
        array_push( $atf_modules, 'et_pb_tabs' );
        return $atf_modules;
    }
    add_filter( 'et_dynamic_assets_modules_atf', 'divi_mega_menu_dynamic_css_assets_atf', 20 );
  }
  
  
  if ( !function_exists('divi_mega_menu_dynamic_css_assets')) {
    /**
     * Force load module styles.
     *
     * @return array
     */
    function divi_mega_menu_dynamic_css_assets( $modules ) {
      array_push( $modules, 'et_pb_tabs' );
        return $modules;
    }
    add_filter( 'et_required_module_assets', 'divi_mega_menu_dynamic_css_assets', 99 );
  }


if ( DE_DMM_P == 'd_e' ) {
    global $DE_DMM;
    $DE_DMM = new DE_DMM();
}

