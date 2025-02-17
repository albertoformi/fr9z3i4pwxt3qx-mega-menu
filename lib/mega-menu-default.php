<?php

if ( ! defined( 'ABSPATH' ) ) exit;


$theme = wp_get_theme(get_template());
if( !defined( 'DIVIENGINE_THEME_NAME' ) ){
  define( 'DIVIENGINE_THEME_NAME', strtolower($theme->Name) );
}

if (DIVIENGINE_THEME_NAME == "extra") {
  add_action('wp_footer', 'mega_menu_content');
} else {
  add_action('wp_footer', 'mega_menu_content');
}

global $current_menu;
add_filter('wp_get_nav_menu_object', 'divi_mega_menu_current_menu', 10, 2);

function divi_mega_menu_current_menu($menu_obj, $menu){
  global $current_menu;
  if ( !empty( $menu ) ) {
    if ( is_object( $menu ) && isset( $menu->term_id ) ) {
      $current_menu[] = $menu->term_id;
    } else {
      $current_menu[] = $menu;
    }

    $current_menu = array_unique($current_menu);
  }

  return $menu_obj;
}

function mega_menu_content(){
  $titan = TitanFramework::getInstance( 'divi-mega-menu' );
  $mega_menu_header_type = $titan->getOption( 'mega_menu_header_type' ) ?: 'default';
  $mega_menu_injection_method = $titan->getOption( 'mega_menu_injection_method' );
  $stop_click_through = $titan->getOption( 'stop_click_through' ) ?: '0';
  $divi_mm_overlay = $titan->getOption( 'divi_mm_overlay' ) ?: '0';
  $fixed_mobile_menu = $titan->getOption( 'fixed_mobile_menu' ) ?: '0';
  $stop_click_through_mobile = $titan->getOption( 'stop_click_through_mobile' ) ?: '0';
  $stop_click_through_dis = $titan->getOption( 'stop_click_through' ) ?: '0';
  $fixed_custom_header_desktop = $titan->getOption( 'fixed_custom_header_desktop' ) ?: '0';
  $divi_mm_breakpoint = $titan->getOption( 'divi_mm_breakpoint' );
  $specific_mobile_id = $titan->getOption( 'specific_mobile_id' );
  $divi_mm_disable = $titan->getOption( 'divi_mm_disable' );

  global $current_menu;

  $mega_menu_classes = array();

  if ( !empty( $current_menu ) ) {
    foreach ($current_menu as $menu) {
      $menu_items = wp_get_nav_menu_items( $menu );

      if ( !empty( $menu_items ) ) {
        foreach ( $menu_items as $menu_item ) {
          if ( !empty( $menu_item->classes ) ) {
            foreach ( $menu_item->classes as $class ) {
              if ( $class != '' ) {
                $mega_menu_classes[] = $class;
              }
            }
          }
        }
      }
    }  
  } 
  
  $mega_menu_classes = array_unique($mega_menu_classes);

  if (DIVIENGINE_THEME_NAME == "extra") {
    $et_theme = 'extra';
  } else {
    $et_theme = 'divi';
  }
  ?>
  <div class="de-mega-menu-container" data-main-settings='{"et_theme" : "<?php echo esc_html($et_theme) ?>", "mega_menu_header_type" : "<?php echo esc_html( $mega_menu_header_type ) ?>","mega_menu_injection_method" : "<?php echo esc_html( $mega_menu_injection_method ) ?>","stop_click_through" : "<?php echo esc_html( $stop_click_through ) ?>","divi_mm_overlay" : "<?php echo esc_html( $divi_mm_overlay ) ?>","fixed_mobile_menu" : "<?php echo esc_html( $fixed_mobile_menu ) ?>","stop_click_through_mobile" : "<?php echo esc_html( $stop_click_through_mobile ) ?>","stop_click_through_dis" : "<?php echo esc_html( $stop_click_through_dis ) ?>","fixed_custom_header_desktop" : "<?php echo esc_html( $fixed_custom_header_desktop ) ?>","divi_mm_breakpoint" : "<?php echo esc_html( $divi_mm_breakpoint ) ?>","specific_mobile_id" : "<?php echo esc_html( $specific_mobile_id ) ?>","divi_mm_disable" : "<?php echo esc_html( $divi_mm_disable ) ?>"}'> 
  
  <?php
  $args = apply_filters( 'get_all_divi_mega_menu_args', array(
    'post_type'           => 'dmmenu',
    'post_status'         => array( 'publish', 'hidden' ),
    'ignore_sticky_posts' => 1,
    'posts_per_page'      => -1,
    'orderby'             => 'date',
    'order'               => 'desc'
  ) );

  /* if ( !empty( $mega_menu_classes ) ) {
    // Meta Query with divi-mega-menu_divi_mm_custom_class 
    $args['meta_query'] = array(
      'relation' => 'AND',
      array(
        'key'     => 'divi-mega-menu_divi_mm_custom_class',
        'value'   => $mega_menu_classes,
        'compare' => 'IN',
      ),
    );
  } */

  $query = new WP_Query( $args );

  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
      $query->the_post();
      
      $div_id = 'et-boc';

      $custom_class = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_custom_class', true );
      $animation_duration = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_animation_duration', true );

       
      $divi_mm_activate_close_icon = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon', true );
      $divi_mm_style = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_style', true );
      $divi_mm_activate = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate', true );
      $divi_mm_activate_close_icon = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon', true );
      $divi_mm_activate_close_icon_code = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon_code', true );
      $divi_mm_activate_close_icon_color = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon_color', true );
      $divi_mm_activate_close_icon_fontsize = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon_fontsize', true );
      $divi_mm_activate_close_icon_dis_top = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon_dis_top', true );
      $divi_mm_activate_close_icon_dis_right = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_icon_dis_right', true );
      $divi_mm_animation_name = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_animation_name', true );
      $divi_mm_animation_name_exit = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_animation_name_exit', true );
      
      $divi_mm_tooltip_direction = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_tooltip_direction', true );
      $divi_mm_hover_delay_time = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_hover_delay_time', true );
      $divi_mm_initial_hover_delay_time = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_initial_hover_delay_time', true );      
      $divi_mm_animation_duration = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_animation_duration', true );
      $settings_fullwidth = get_post_meta( get_the_ID(), 'divi-mega-menu_settings_fullwidth', true );
      $divi_mm_custom_width = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_custom_width', true );
      $realtive_postion = get_post_meta( get_the_ID(), 'divi-mega-menu_realtive_postion', true );
      $divi_mm_adjust_left = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_adjust_left', true );
      $divi_mm_adjust_top = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_adjust_top', true );
      $divi_mm_adjust_top_mobile = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_adjust_top_mobile', true );
      $settings_disable_mobile = get_post_meta( get_the_ID(), 'divi-mega-menu_settings_disable_mobile', true );
      $divi_mm_triangle = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle', true );
      $divi_mm_triangle_location = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_location', true );
      $divi_mm_triangle_color = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_color', true );
      $divi_mm_triangle_height = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_height', true );
      $divi_mm_triangle_top_distance = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_top_distance', true );
      $divi_mm_triangle_horzontal_distance = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_triangle_horzontal_distance', true );
      $divi_mm_activate_close_on_scroll = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_activate_close_on_scroll', true ) ?: "0";
      $divi_mm_enable_adjust_top_on_scroll = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_enable_adjust_top_on_scroll', true );
      $divi_mm_adjust_top_on_scroll = get_post_meta( get_the_ID(), 'divi-mega-menu_divi_mm_adjust_top_on_scroll', true );
      
      ?>
      <div id="<?php echo esc_html( $custom_class ); ?>" class="de-mega-menu" style="display:none;" data-settings='{"custom_class" : "<?php echo esc_html( $custom_class ); ?>", "divi_mm_activate_close_icon" : "<?php echo esc_html( $divi_mm_activate_close_icon ); ?>","divi_mm_style" : "<?php echo esc_html( $divi_mm_style ); ?>","divi_mm_activate" : "<?php echo esc_html( $divi_mm_activate ); ?>","divi_mm_activate_close_icon" : "<?php echo esc_html( $divi_mm_activate_close_icon ); ?>","divi_mm_activate_close_icon_code" : "<?php echo esc_html( $divi_mm_activate_close_icon_code ); ?>","divi_mm_activate_close_icon_color" : "<?php echo esc_html( $divi_mm_activate_close_icon_color ); ?>","divi_mm_activate_close_icon_fontsize" : "<?php echo esc_html( $divi_mm_activate_close_icon_fontsize ); ?>","divi_mm_activate_close_icon_dis_top" : "<?php echo esc_html( $divi_mm_activate_close_icon_dis_top ); ?>","divi_mm_activate_close_icon_dis_right" : "<?php echo esc_html( $divi_mm_activate_close_icon_dis_right ); ?>","divi_mm_animation_name" : "<?php echo esc_html( $divi_mm_animation_name ); ?>","divi_mm_animation_name_exit" : "<?php echo esc_html( $divi_mm_animation_name_exit ); ?>","divi_mm_tooltip_direction" : "<?php echo esc_html( $divi_mm_tooltip_direction ); ?>","divi_mm_hover_delay_time" : "<?php echo esc_html( $divi_mm_hover_delay_time ); ?>","divi_mm_initial_hover_delay_time" : "<?php echo esc_html( $divi_mm_initial_hover_delay_time ); ?>","divi_mm_animation_duration" : "<?php echo esc_html( $divi_mm_animation_duration ); ?>","settings_fullwidth" : "<?php echo esc_html( $settings_fullwidth ); ?>","divi_mm_custom_width" : "<?php echo esc_html( $divi_mm_custom_width ); ?>","realtive_postion" : "<?php echo esc_html( $realtive_postion ); ?>","divi_mm_adjust_left" : "<?php echo esc_html( $divi_mm_adjust_left ); ?>","divi_mm_adjust_top" : "<?php echo esc_html( $divi_mm_adjust_top ); ?>","divi_mm_adjust_top_mobile" : "<?php echo esc_html( $divi_mm_adjust_top_mobile ); ?>","settings_disable_mobile" : "<?php echo esc_html( $settings_disable_mobile ); ?>","divi_mm_triangle" : "<?php echo esc_html( $divi_mm_triangle ); ?>","divi_mm_triangle_location" : "<?php echo esc_html( $divi_mm_triangle_location ); ?>","divi_mm_triangle_color" : "<?php echo esc_html( $divi_mm_triangle_color ); ?>","divi_mm_triangle_height" : "<?php echo esc_html( $divi_mm_triangle_height ); ?>","divi_mm_triangle_top_distance" : "<?php echo esc_html( $divi_mm_triangle_top_distance ); ?>","divi_mm_triangle_horzontal_distance" : "<?php echo esc_html( $divi_mm_triangle_horzontal_distance ); ?>","divi_mm_activate_close_on_scroll" : "<?php echo esc_html( $divi_mm_activate_close_on_scroll ); ?>", "divi_mm_enable_adjust_top_on_scroll" : "<?php echo esc_html( $divi_mm_enable_adjust_top_on_scroll ); ?>","divi_mm_adjust_top_on_scroll" : "<?php echo esc_html( $divi_mm_adjust_top_on_scroll ); ?>"}'>
        <div id="<?php echo esc_attr($div_id) ?>" class="mm-added">
        <div class="et-l">
          <?php
          if ( et_core_is_fb_enabled() ) {
          } else {

            $post_content = do_shortcode(get_post_field('post_content', get_the_ID())); //$post_content = apply_filters( 'the_content', get_post_field('post_content', get_the_ID()) );
            $post_content = preg_replace( '/et_pb_section_(\d+)_tb_body/', 'et_pb_mega_menu_section_${1}_tb_body', $post_content );
            $post_content = preg_replace( '/et_pb_row_(\d+)_tb_body/', 'et_pb_mega_menu_row_${1}_tb_body', $post_content );
            $post_content = preg_replace( '/et_pb_column_(\d+)_tb_body/', 'et_pb_mega_menu_column_${1}_tb_body', $post_content );
            $post_content = preg_replace( '/et_pb_section_(\d+)( |")/', 'et_pb_mega_menu_section_${1}${2}', $post_content );
            $post_content = preg_replace( '/et_pb_row_(\d+)( |")/', 'et_pb_mega_menu_row_${1}${2}', $post_content );
            $post_content = preg_replace( '/et_pb_column_(\d+)( |")/', 'et_pb_mega_menu_column_${1}${2}', $post_content );

            $post_content = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_mega_menu_${1}_${2}_tb_body', $post_content );
            $post_content = preg_replace( '/et_pb_([a-z]+)_(\d+)_wrapper/', 'et_pb_mega_menu_${1}_${2}_wrapper', $post_content );
            $post_content = preg_replace( '/et_pb_([a-z]+)_(\d+)( |")/', 'et_pb_${1}_${2} et_pb_mega_menu_${1}_${2}${3}', $post_content );

            echo $post_content;  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Output has style part of the content
          }
          ?>
        </div>
        </div>
        <?php
        // retrieve the styles for the modules
        $internal_style = ET_Builder_Element::get_style();
        // reset all the attributes after we retrieved styles
        ET_Builder_Element::clean_internal_modules_styles( false );
        $et_pb_rendering_column_content = false;
        // append styles
        if ( $internal_style ) {
          ?>
          <div class="mega-menu-inner-styles">
          <?php
          $cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_mega_menu_${1}_${2}_tb_body', $internal_style );
          $cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)( |"|.)/', 'et_pb_mega_menu_${1}_${2}${3}', $cleaned_styles ); 
          $cleaned_styles = str_replace( 'body #page-container .et_pb_section .et_pb_mega_menu_button_0 {', '.et-db #et-boc .et-l .et_pb_button.et_pb_mega_menu_button_0, body #page-container .et_pb_section.et_pb_mega_menu_button_0 {', $cleaned_styles );
          $cleaned_styles = str_replace( 'body #page-container .et_pb_section .et_pb_mega_menu_button_0:hover {', '.et-db #et-boc .et-l .et_pb_button.et_pb_mega_menu_button_0:hover, body #page-container .et_pb_section.et_pb_mega_menu_button_0:hover {', $cleaned_styles );
            printf(
              '<style type="text/css" class="mega_menu_inner_styles">
              %1$s
              </style>',
              et_core_esc_previously( $cleaned_styles )
            );

            // CPT styles fix 
            // TODO: Make it only add this CSS when its a CPT template, hard to get now as this code is in the mega menu so will always return CPT true 

            // add temp removethis123 to avoid adding .et-db #et-boc .et-l at the start of every et_pb selector (like .et_pb_section_1.et_pb_section)
            $cleaned_cpt_styles = preg_replace('/et_pb_([a-z|_]+)_(\d+).et_pb/', 'et_pb_${1}_${2}.removethis123', $cleaned_styles);
            // $cleaned_cpt_styles = preg_replace('/\.et_pb_/', '.et-db #et-boc .et-l .et_pb_', $cleaned_cpt_styles);
            $cleaned_cpt_styles = preg_replace('/.et_pb_([a-z|_]+)_(\d+)/', '.et-db #et-boc .et-l .et_pb_${1}_${2}', $cleaned_cpt_styles );
            // replace removethis123 with et_pb
            $cleaned_cpt_styles = str_replace('.removethis123', '.et_pb', $cleaned_cpt_styles);
            $cleaned_cpt_styles = str_replace('body #page-container .et_pb_section .et-db #et-boc .et-l', '.et-db #et-boc .et-l .et_pb_section', $cleaned_cpt_styles);
            $cleaned_cpt_styles = str_replace('body #page-container .et_pb_section .et_pb', '.et-db #et-boc .et-l .et_pb_section .et_pb', $cleaned_cpt_styles);
            $cleaned_cpt_styles = str_replace('body.et-db #page-container #et-boc .et-l .et_pb_section .et-db #et-boc .et-l', '.et-db #et-boc .et-l .et_pb_section', $cleaned_cpt_styles);
            
           
          
            printf(
              '<style type="text/css" class="mega_menu_cpt_inner_styles">
              %1$s
              </style>',
              et_core_esc_previously( $cleaned_cpt_styles )
            );
            ?>
          </div>
          <?php
        }

       
        ?>
      </div>
      <?php
      

    }
    wp_reset_postdata();
  }
  ?> </div> <?php
}

add_action('wp_footer', 'mega_menu_js');
function mega_menu_js(){

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
    }
    wp_reset_postdata();
  }
}

