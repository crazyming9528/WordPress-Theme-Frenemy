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
function basic_customize_register( $wp_customize ) {

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'basic_home_title',
			array(
				'selector'        => 'h1.site-name',
        'render_callback' => 'frenemy_customize_partial_basic_home_title',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'basic_sub_title',
			array(
				'selector'        => 'h2.site-description',
				'render_callback' => 'frenemy_customize_partial_basic_sub_title',
			)
		);
	}

	$wp_customize->add_section( 'frenemy_basic', array(
		'title'    => '基本设置',
		'panel'    => 'frenemy_appearance_settings',
		'priority' => 10
	) );

	// 首页描述标题
	$wp_customize->add_setting( 'basic_home_title', array(
		'default'           => '欢迎访问',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'basic_home_title',
		array(
			'label'    => __( '首页描述标题' ),
			'section'  => 'frenemy_basic',
			'settings' => 'basic_home_title',
			'type'     => 'text',
		)
	) );

	// 首页描述标题
	$wp_customize->add_setting( 'basic_sub_title', array(
		'default'           => '永远年轻，永远热泪盈眶！',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'basic_sub_title',
		array(
			'label'    => __( '首页描述标题' ),
			'section'  => 'frenemy_basic',
			'settings' => 'basic_sub_title',
			'type'     => 'textarea',
		)
	) );

	// 首页背景图
	$wp_customize->add_setting( 'basic_bg_image', array(
		'default'           => get_template_directory_uri() . '/assets/images/default-background-image.jpg',
		'transport'         => 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'basic_bg_image',
		array(
			'label'      => __( '首页背景图' ),
			'section'    => 'frenemy_basic',
			'settings'   => 'basic_bg_image',
			'context'    => 'your_setting_context'
		)
	));

}

add_action( 'customize_register', 'basic_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function frenemy_customize_partial_basic_home_title() {
  return get_theme_mod( 'basic_home_title' );
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function frenemy_customize_partial_basic_sub_title() {
  return get_theme_mod( 'basic_sub_title' );
}

