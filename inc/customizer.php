<?php
/**
 * Frenemy: Customizer
 *
 * @package    WordPress
 * @subpackage Frenemy
 * @since      1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function frenemy_customize_register($wp_customize) {
  $wp_customize->get_setting('blogname')->transport = 'postMessage';

  if (isset($wp_customize->selective_refresh)) {
    $wp_customize->selective_refresh->add_partial(
      'blogname',
      array(
        'selector' => '.navbar .navbar-brand',
        'render_callback' => 'frenemy_customize_partial_blogname',
      )
    );
  }

  $wp_customize->add_panel(
    'frenemy_appearance_settings', array(
      'priority' => 160,
      'title' => esc_html__('主题设置'),
    )
  );
}

add_action('customize_register', 'frenemy_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function frenemy_customize_partial_blogname() {
  bloginfo('name');
}

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function frenemy_customize_preview_js() {
  wp_enqueue_script('frenemy-customize-preview', get_theme_file_uri('/inc/js/customize-preview.js'), array('customize-preview'), '20181231', true);
}

add_action('customize_preview_init', 'frenemy_customize_preview_js');

/**
 * Load dynamic logic for the customizer controls area.
 */
function frenemy_panels_js() {
  wp_enqueue_script('frenemy-customize-controls', get_theme_file_uri('/inc/js/customize-controls.js'), array(), '20181231', true);
}

add_action('customize_controls_enqueue_scripts', 'frenemy_panels_js');
