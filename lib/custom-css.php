<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('wp_enqueue_scripts', 'divi_mega_menu_custom_css', 99999999 );
function divi_mega_menu_custom_css(){

wp_enqueue_style( 'divi-mega-menu-custom-css', DE_DMM_URL . '/styles/divi-mega-menu-custom.min.css' , array(), DE_DMM_VERSION, 'all' );

include(DE_DMM_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-mega-menu' );
$check_fixed_mobile_menu = $titan->getOption( 'fixed_mobile_menu' );
$divi_mm_overlay_color = $titan->getOption( 'divi_mm_overlay_color' );
$divi_mm_breakpoint = $titan->getOption( 'divi_mm_breakpoint' );
$divi_mm_overflow_breakpoint = $titan->getOption( 'divi_mm_overflow_breakpoint' );

$divi_mm_breakpoint_min = ((int)$divi_mm_breakpoint + 1);

$disable_mega_menu_on_mobile = $titan->getOption( 'divi_mm_disable' ) == "1";


if ($check_fixed_mobile_menu == 1 ) {
	$display_fixed = '
	#main-header {position: fixed !important;}
	.de-mega-menu {
		position: fixed !important;
max-height: 70vh;
overflow: hidden;
overflow-y: auto;
}';
}
else {
	$display_fixed = "";
}

$menu_height = get_option( 'et_divi' );



if (isset($menu_height["menu_height"])) {
$menu_height_value = $menu_height["menu_height"];
}
else {
	$menu_height_value = "80";
}

if (isset($menu_height["minimized_menu_height"])) {
$minimized_menu_height_value = $menu_height["minimized_menu_height"];
}
else {
	$minimized_menu_height_value = "40";
}



$minimized_menu_height_value_display = $minimized_menu_height_value + "13";

$menu_height_value_display = $menu_height_value + "13";


$args = apply_filters( 'get_all_divi_mega_menu_args', array(
	'post_type'           => 'dmmenu',
	'post_status'         => array( 'publish', 'hidden' ),
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => -1,
	'orderby'             => 'date',
	'order'               => 'desc'
) );

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
while ( $query->have_posts() ) {
$query->the_post();


$animation_name = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_animation_name', true );
$custom_class = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_custom_class', true );
$animation_duration = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_animation_duration', true );
$divi_mm_custom_width = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_custom_width', true );
$divi_mm_adjust_top = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_adjust_top', true );
$divi_mm_enable_adjust_top_on_scroll = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_enable_adjust_top_on_scroll', true );
$divi_mm_adjust_top_on_scroll = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_adjust_top_on_scroll', true );
$divi_mm_adjust_top_mobile = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_adjust_top_mobile', true );
if ($divi_mm_adjust_top_mobile == "" ) { $divi_mm_adjust_top_mobile = "0"; };
$divi_mm_triangle = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle', true );


$menu_divi_mm_activate_close_icon = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon', true );
$menu_divi_mm_activate_close_icon_code = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon_code', true );
$menu_divi_mm_activate_close_icon_color = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon_color', true );
$menu_divi_mm_activate_close_icon_fontsize = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon_fontsize', true );
$menu_divi_mm_activate_close_icon_dis_top = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon_dis_top', true );
$menu_divi_mm_activate_close_icon_dis_right = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon_dis_right', true );


$divi_mm_triangle_color = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_color', true );
$divi_mm_triangle_height = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_height', true );
$divi_mm_triangle_location = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_location', true );
$divi_mm_triangle_underline = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_underline', true );

$divi_mm_triangle_top_distance = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_top_distance', true );
$divi_mm_triangle_horzontal_distance = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_horzontal_distance', true );


$settings_disable_mobile = get_post_meta( get_the_ID(), 'divi-mega-menu_settings_disable_mobile', true );
$settings_fullwidth = get_post_meta( get_the_ID(), 'divi-mega-menu_settings_fullwidth', true );

$mm_style = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_style', true );
$divi_mm_adjust_left = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_adjust_left', true );

if ($mm_style == 'tooltip') {

	// if divi_mm_adjust_left has "-" then we remove it. If it does not have "-" then we add "-" to it.
	if (strpos($divi_mm_adjust_left, '-') !== false) {
		$divi_mm_adjust_left = str_replace('-', '', $divi_mm_adjust_left);
	} else {
		$divi_mm_adjust_left = '-' . $divi_mm_adjust_left;
	}

	$divi_mm_adjust_left_dis = 'margin-right: '.$divi_mm_adjust_left.'px;';
} else {
	$divi_mm_adjust_left_dis = 'margin-left: '.$divi_mm_adjust_left.'px;';
}

if ($settings_disable_mobile == "1") {
	$settings_disable_mobile_dis = '
	#'.$custom_class.', .'.$custom_class.':before, .'.$custom_class.'.de-mega-menu-item.menu-item-has-children>a:after {
		display: none !important;
	}
	';
} else {
	$settings_disable_mobile_dis = '';
}


if ($settings_fullwidth == "1") {
	$settings_fullwidth_dis = '

		#'.$custom_class.'.de-mega-menu {
		width: 100vw !important;
max-width: 100vw !important;
left: 0 !important;
right: 0 !important;
	}

	';
} else {
	$settings_fullwidth_dis = '';
}


$divi_mm_triangle_height_int = (int)$divi_mm_triangle_height;

if ($divi_mm_triangle_top_distance == "") {
	$divi_mm_triangle_top = $divi_mm_triangle_height_int / 2;
	$divi_mm_triangle_top_dis = '-' . $divi_mm_triangle_top . 'px';
	$divi_mm_triangle_top_distance_dis = "";
} else {
if ($divi_mm_triangle_top_distance == "0") {
	$divi_mm_triangle_top = $divi_mm_triangle_height_int / 2;
	$divi_mm_triangle_top_dis = '-' . $divi_mm_triangle_top . 'px';
	$divi_mm_triangle_top_distance_dis = "";
} else {
	$divi_mm_triangle_top_dis = $divi_mm_triangle_top_distance . 'px';
	$divi_mm_triangle_top_distance_dis = "margin-top: " . $divi_mm_triangle_top_distance . "px;";
}

}



if ($menu_divi_mm_activate_close_icon == "1" && $menu_divi_mm_activate_close_icon_code != "") {
$show_close_icon = sprintf('#%s .close-icon:after {content:"\%s" !important;color:%s !important; font-size:%spx !important;}.close-icon {top:%spx !important;right:%spx !important;}',$custom_class, $menu_divi_mm_activate_close_icon_code, $menu_divi_mm_activate_close_icon_color, $menu_divi_mm_activate_close_icon_fontsize, $menu_divi_mm_activate_close_icon_dis_top, $menu_divi_mm_activate_close_icon_dis_right);
} else {
$show_close_icon = "";
}


if ($divi_mm_triangle == "1") {
if ($divi_mm_triangle_location == "menu") {

	if ($divi_mm_triangle_underline == "1") {

		$show_triangle = '
		.'.$custom_class.' {
			position: relative !important;
		}
		.'.$custom_class.'.megamenu-show:before {
				opacity: 1;
				display: block !important;
		}
		.'.$custom_class.':before {
				opacity: 0;
				background-color: '.$divi_mm_triangle_color.';
				content: "";
				height: '.$divi_mm_triangle_height.'px;
				left: 0;
				position: absolute;
				bottom: '.$divi_mm_triangle_top_dis.';
				'.$divi_mm_triangle_top_distance_dis.'
				width: 100%;
		}
		@media all and (max-width: '.$divi_mm_breakpoint.'px) {
		.'.$custom_class.' {
			margin-left: 0px;
			width: 100%;
				max-width: 100%;
		}
		}
		';

	} else {

		$show_triangle = '
		.'.$custom_class.' {
			position: relative !important;
		}
		.'.$custom_class.'.megamenu-show:before {
				opacity: 1;
		}
		.'.$custom_class.':before {
				opacity: 0;
				background-color: '.$divi_mm_triangle_color.';
				border-bottom-left-radius: 1px;
				border-right: 0;
				border-top: 0;
				content: "";
				height: '.$divi_mm_triangle_height.'px;
				left: calc(50%);
				position: absolute;
				bottom: '.$divi_mm_triangle_top_dis.';
				'.$divi_mm_triangle_top_distance_dis.'
				transform: rotate(135deg);
				width: '.$divi_mm_triangle_height.'px;
				margin-left: '.$divi_mm_triangle_horzontal_distance.'px;
		}
		@media all and (max-width: '.$divi_mm_breakpoint.'px) {
		.'.$custom_class.' {
			margin-left: 0px;
			width: 100%;
				max-width: 100%;
		}
		}
		';

	}



} else {

	$show_triangle = '
	#'.$custom_class.'.de-mega-menu:before {
			background-color: '.$divi_mm_triangle_color.';
			border-bottom-left-radius: 1px;
			border-right: 0;
			border-top: 0;
			content: "";
			height: '.$divi_mm_triangle_height.'px;
			left: calc(50%);
			position: absolute;
			top: '.$divi_mm_triangle_top_dis.';
			'.$divi_mm_triangle_top_distance_dis.'
			transform: rotate(135deg);
			width: '.$divi_mm_triangle_height.'px;
			margin-left: '.$divi_mm_triangle_horzontal_distance.'px;
	}
	@media all and (max-width: '.$divi_mm_breakpoint.'px) {
	#'.$custom_class.'.de-mega-menu {
		margin-left: 0px;
		width: 100%;
			max-width: 100%;
	}
	}
	';

}

} else {
$show_triangle = "";
}

$css_mega_menu_each = '

'.$settings_fullwidth_dis.'

#'.$custom_class.'.de-mega-menu {
-webkit-animation-name: '.$animation_name.';
-moz-animation-name: '.$animation_name.';
-ms-animation-name: '.$animation_name.';
-o-animation-name: '.$animation_name.';
animation-name: '.$animation_name.';
max-width: '.$divi_mm_custom_width.'px;
margin-top: '.$divi_mm_adjust_top.'px;
'.$divi_mm_adjust_left_dis.'
}

#'.$custom_class.'.de-mega-menu .dmm-dropdown-ul li .sub-menu {
width: '.$divi_mm_custom_width.'px;
right: -'.$divi_mm_custom_width.'px;
}

.rtl  #'.$custom_class.'.de-mega-menu .dmm-dropdown-ul li .sub-menu {
	right: auto !important;
}


'.$show_triangle.'

'.$show_close_icon.'

.et_pb_fullwidth_menu--with-logo .et_pb_menu__menu>nav>ul>li.'.$custom_class.'>a, .et_pb_menu--with-logo .et_pb_menu__menu>nav>ul>li.'.$custom_class.'>a,
.'.$custom_class.' a{
		padding-right: 20px;
}

@media all and (max-width: '.$divi_mm_breakpoint.'px) {

	'.$settings_disable_mobile_dis.'

	#'.$custom_class.'.de-mega-menu {
	margin-top: '.$divi_mm_adjust_top_mobile.'px;
	}


	.mm-overlay.active {
	    opacity: 0 !important;
	}

#'.$custom_class.'.de-mega-menu {
animation-duration: '.$animation_duration.'s;
margin-left: 0px !important;
}
}
';
if($divi_mm_enable_adjust_top_on_scroll){
	$css_mega_menu_each.='header:has(.has_et_pb_sticky) + #et-main-area .de-mega-menu-container #'.$custom_class.'.de-mega-menu,
header.et-fixed-header + #et-main-area .de-mega-menu-container #'.$custom_class.'.de-mega-menu {
margin-top: '.$divi_mm_adjust_top_on_scroll.'px;
}';
}
$css_mega_menu_each_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_mega_menu_each );
wp_add_inline_style( 'divi-mega-menu-custom-css', $css_mega_menu_each_min );
}
wp_reset_postdata();
}


if ($disable_mega_menu_on_mobile) {
	$css_disable_mobile = '
	@media all and (max-width: ' . $divi_mm_breakpoint . 'px) {
		.de-mega-menu-container {
		display: none !important;
		}
	}
	@media all and (min-width: '.$divi_mm_breakpoint_min.'px) {
		header .menu-item.mega-menu .sub-menu {
			display: none;
		}
	}';
} else {
	$css_disable_mobile = '
	header .menu-item.mega-menu .sub-menu, header .et_pb_menu .et_mobile_menu li.menu-item.mega-menu ul.sub-menu  {
		display: none !important;
	}';
}

if ($divi_mm_overflow_breakpoint == '0') {
	$divi_mm_overflow_breakpoint_dis = '';
} else {
	$divi_mm_overflow_breakpoint_dis = '
		max-height: '.$divi_mm_overflow_breakpoint.'vh;
		overflow: auto;
	';
}


$css_mega_menu = '

		.remove-before:before {
			display: none !important;
		}

		.mm-overlay {
			opacity: 0;
			position: fixed;
	    width: 100vw;
	    height: 100vh;
	    top: 0;
	    background-color: '.$divi_mm_overlay_color.';
	    z-index: -1;
		left: 0;
		}
			.de-mega-menu {
	        width: 80%;
	        max-width: 1080px;
	        margin: 0 auto;
	        z-index: 99999999999;
	        display: none;
	        top: '.$menu_height_value_display.'px;
	  -webkit-animation-timing-function: ease-in-out;
	    -moz-animation-timing-function: ease-in-out;
	    -ms-animation-timing-function: ease-in-out;
	    -o-animation-timing-function: ease-in-out;
	    animation-timing-function: ease-in-out;
	position: absolute;
	'.$divi_mm_overflow_breakpoint_dis.'
	  }

	  .de-mega-menu.fixed {
	  top: '.$minimized_menu_height_value_display.'px;
	  }


		@media all and (max-width: '.$divi_mm_breakpoint.'px) {
			.de-mega-menu .et_pb_column .dmm-dropdown-ul .menu-item-has-children>a:after {
				display: block !important;
			}
			#page-container #et-main-area .de-mega-menu .dmm-dropdown-ul li .sub-menu,
			#page-container #et-main-area .de-mega-menu .dmm-dropdown-ul li .sub-menu .menu-item-has-children {
				width: 100% !important;
				max-width: 100% !important;
				left: 0 !important;
				right: auto !important;
				top: 54px;
		}
		#page-container #et-main-area .de-mega-menu .dmm-dropdown-ul li .sub-menu .menu-item-has-children {
			top: 0 !important
		}
		.dmm-dropdown-ul li.active>.sub-menu {
			opacity: 1 !important;
			visibility: visible !important;
			display: block !important;
		}
		.close-icon {display: none;}
	  .de-mega-menu {margin-top:0px; padding-top:0px;}
	.de-mega-menu .et_pb_section, .de-mega-menu .et_pb_row {width: 100%; max-width: 100%;}
	'.$display_fixed.'
	}

	@media all and (min-width: '.$divi_mm_breakpoint_min.'px) {
	#top-menu .dmm-dropdown-ul li:hover>.sub-menu,
.dmm-dropdown-ul li:hover>.sub-menu {
  opacity: 1 !important;
  visibility: visible !important;
  display: block !important;
}
.dmm-dropdown-ul li:hover>.sub-menu li.dmm-overlay:hover>.sub-menu {
  opacity: 0;
  visibility: hidden
}
}

	'.$css_disable_mobile.'

	 ';


   $css_mega_menu_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_mega_menu );

  wp_add_inline_style( 'divi-mega-menu-custom-css', $css_mega_menu_min );
}
