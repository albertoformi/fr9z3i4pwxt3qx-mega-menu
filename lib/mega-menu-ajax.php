<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_ajax_divi_mega_menu_filterposts_handler', 'mega_menu_ajax' );
add_action( 'wp_ajax_nopriv_divi_mega_menu_filterposts_handler', 'mega_menu_ajax' );

function mega_menu_ajax(){
	ob_start();
	
	$megamenuitems = array();
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

			$custom_class = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_custom_class', true );
			$animation_duration = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_animation_duration', true );
			
			$megamenu = '<div id="' . esc_html( $custom_class ) . '" class="de-mega-menu ajaxloaded" style="" data-anim-time="' . esc_html( $animation_duration ) . '">';
			$megamenu_content =  do_shortcode( get_the_content() ); //apply_filters('the_content', get_the_content() ) ;
			$megamenu_content = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_mm_ajax_${1}_${2}_tb_body', $megamenu_content );
            $megamenu_content = preg_replace( '/et_pb_([a-z]+)_(\d+)( |")/', 'et_pb_mm_ajax_${1}_${2}${3}', $megamenu_content );
            $megamenu_content = str_replace('.de-mega-menu', '#top-menu .de-mega-menu', $megamenu_content );

            $megamenu .= $megamenu_content;
			$megamenu .= '</div>';

			$megamenuitems[$custom_class] = $megamenu;
		}

		wp_reset_postdata();
	}

	ob_end_clean();

	ob_start();

	// retrieve the styles for the modules
	$internal_style = ET_Builder_Element::get_style();
	// reset all the attributes after we retrieved styles
	ET_Builder_Element::clean_internal_modules_styles( false );
	$et_pb_rendering_column_content = false;

	// append styles
	if ( $internal_style ) {
?>
	<div class="divi_mega_menu-inner-styles">
<?php
	$cleaned_styles = str_replace("#et-boc .et-l","#et-boc .et-l .de-mega-menu.ajaxloaded", $internal_style);
	$cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_mm_ajax_${1}_${2}_tb_body', $cleaned_styles );
	$cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)( |\.|{)/', 'et_pb_mm_ajax_${1}_${2}${3}', $cleaned_styles );
	$cleaned_styles = str_replace(".de-mega-menu", "#top-menu .de-mega-menu", $cleaned_styles);
	

	/*$cleaned_styles = str_replace("#et-boc .et-l","#et-boc .et-l .de-mega-menu.ajaxloaded", $internal_style);
	$cleaned_styles = str_replace(".et_pb_section_",".de-mega-menu.ajaxloaded .et_pb_section_", $cleaned_styles);
	$cleaned_styles = str_replace(".et_pb_row_",".de-mega-menu.ajaxloaded .et_pb_row_", $cleaned_styles);
	$cleaned_styles = str_replace(".et_pb_module_",".de-mega-menu.ajaxloaded .et_pb_module_", $cleaned_styles);
	$cleaned_styles = str_replace(".et_pb_column_",".de-mega-menu.ajaxloaded .et_pb_column_", $cleaned_styles);
	$cleaned_styles = str_replace(".et_pb_de_mach_",".de-mega-menu.ajaxloaded .et_pb_de_mach_", $cleaned_styles);
	$cleaned_styles = str_replace(".de-mega-menu.ajaxloaded .de-mega-menu.ajaxloaded",".de-mega-menu.ajaxloaded", $cleaned_styles);
	$cleaned_styles = str_replace(".de-mega-menu.ajaxloaded .et_pb_section .de-mega-menu.ajaxloaded",".de-mega-menu.ajaxloaded", $cleaned_styles);*/

	printf(
		'<style type="text/css" class="divi_mega_menu_ajax_inner_styles">
			.de-mega-menu.ajaxloaded div.et_pb_section {background-color: #fff !important;background-image: inherit !important;padding: 0;}
			%1$s
		</style>',
		et_core_esc_previously( $cleaned_styles )
	);
?>
	</div>
<?php
	}

	$css_output = ob_get_contents();

	ob_end_clean();

	ob_start();

?>
<script>
;(function ( $ ) {
	'use strict';
	$( window ).ready(function() {
		$('.dmm-vert-tabs').closest('.et_pb_section').addClass('fullwidth-mm');
		var checkCursorOverDiviTabTimer = 0,
		checkDiviTabElem;

		// Enable Divi Toggle with hover
		$('.dmm-vert-tabs .et_pb_toggle').on( 'mouseenter', function(e) {
			$( this ).children('.et_pb_toggle_title').trigger( 'click' );
		});

		// Enable Divi Tabs with hover
		$('.et_pb_mm_tabs .et_pb_tabs_controls > [class^="et_pb_mm_ajax_tab_"]').on( 'mouseenter', function(e) {

			if ( ! $( this ).hasClass('et_pb_tab_active') ) {
				checkDiviTabElem = $( this );
				if ( ! checkDiviTabElem.parent().hasClass('et_pb_tab_active') ) {
					checkDiviTabElem.closest('.dmm-vert-tabs').find(".et_pb_tabs_controls li").removeClass('et_pb_tab_active');
					checkDiviTabElem.addClass('et_pb_tab_active');
					var classname = checkDiviTabElem.attr('class').split(' ')[0];
					checkDiviTabElem.closest('.dmm-vert-tabs').find(".et_pb_all_tabs .et_pb_tab").removeClass("et_pb_active_content");
					checkDiviTabElem.closest('.dmm-vert-tabs').find(".et_pb_all_tabs ."+classname+"").addClass('et_pb_active_content');
				}
			}else {
				checkDiviTabElem = false;
			}
		});

		function checkDiviTab() {

			if ( checkDiviTabElem ) {
				if ( ! checkDiviTabElem.parent().hasClass('et_pb_tab_active') ) {
					checkDiviTabElem.closest('.dmm-vert-tabs').find(".et_pb_tabs_controls li").removeClass('et_pb_tab_active');
					checkDiviTabElem.addClass('et_pb_tab_active');
					var classname = checkDiviTabElem.attr('class').split(' ')[0];
					checkDiviTabElem.closest('.dmm-vert-tabs').find(".et_pb_all_tabs .et_pb_tab").removeClass("et_pb_active_content");
					checkDiviTabElem.closest('.dmm-vert-tabs').find(".et_pb_all_tabs ."+classname+"").addClass('et_pb_active_content');
				}
			}
			//checkCursorOverDiviTabTimer = setTimeout( checkDiviTab, 150 );
		}
		//checkDiviTab();
	});
})( jQuery );
</script>
<?php

	$js_output = ob_get_contents();

	ob_end_clean();

	$return = array(
	  'posts' => $megamenuitems,
	  'css_output' => $css_output,
	  'js_output' => $js_output
	);

	wp_send_json($return);
	wp_die();
}
