<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function divi_mega_menu_filterposts_handler() {

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
      $megamenu .= apply_filters('the_content', get_post_field('post_content'));
      $megamenu .= '</div>';


      $megamenuitems[$custom_class] = $megamenu;

  }


  wp_reset_postdata();
}
?> </div> <?php

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
      $cleaned_styles = str_replace(".et_pb_section_",".de-mega-menu.ajaxloaded .et_pb_section_", $cleaned_styles);
      $cleaned_styles = str_replace(".et_pb_row_",".de-mega-menu.ajaxloaded .et_pb_row_", $cleaned_styles);
      $cleaned_styles = str_replace(".et_pb_module_",".de-mega-menu.ajaxloaded .et_pb_module_", $cleaned_styles);
      $cleaned_styles = str_replace(".et_pb_column_",".de-mega-menu.ajaxloaded .et_pb_column_", $cleaned_styles);
      $cleaned_styles = str_replace(".et_pb_de_mach_",".de-mega-menu.ajaxloaded .et_pb_de_mach_", $cleaned_styles);
      $cleaned_styles = str_replace(".de-mega-menu.ajaxloaded .de-mega-menu.ajaxloaded",".de-mega-menu.ajaxloaded", $cleaned_styles);
      $cleaned_styles = str_replace(".de-mega-menu.ajaxloaded .et_pb_section .de-mega-menu.ajaxloaded",".de-mega-menu.ajaxloaded", $cleaned_styles);

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

  $return = array(
      'posts' => $megamenuitems,
      'css_output' => $css_output
  );

  wp_send_json($return);
  wp_die();

}

//add_action( 'wp_ajax_divi_mega_menu_filterposts_handler', 'divi_mega_menu_filterposts_handler' );
