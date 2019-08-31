<?php
/**
 * Frenemy: Customizer
 *
 * @package WordPress
 * @subpackage Frenemy
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function seo_customize_register( $wp_customize ) {

    $wp_customize->add_section( 'frenemy_seo', array(
        'title' => 'SEO设置',
        'panel'    => 'frenemy_appearance_settings',
        'priority' => 20
    ) );

	// 网站描述
    $wp_customize->add_setting('seo_description', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'seo_description',
        array(
            'label' => __('网站描述'),
            'section' => 'frenemy_seo',
            'settings' => 'seo_description',
            'type' => 'textarea',
        )
    ));

	// 网站关键词
	$wp_customize->add_setting('seo_keywords', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field'
	));

	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'seo_keywords',
		array(
			'label' => __('网站关键词'),
			'section' => 'frenemy_seo',
			'settings' => 'seo_keywords',
			'type' => 'textarea',
		)
	));

	//备案号
	$wp_customize->add_setting( 'seo_icp', array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'seo_icp',
		array(
			'label' => __('备案号'),
			'section'  => 'frenemy_seo',
			'type'     => 'text',
		)
	));

	//公安备案号
	$wp_customize->add_setting( 'seo_public_icp', array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'seo_public_icp',
		array(
			'label' => __('公安备案号'),
			'description' => __( '例如：苏公网安备32010402000447号' ),
			'section'  => 'frenemy_seo',
			'type'     => 'text',
		)
	));

	//页脚代码
	$wp_customize->add_setting( 'seo_footer_code', array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'esc_html'
		)
	);

	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'seo_footer_code',
		array(
			'label' => __('页脚脚本区域'),
			'description' => __( '例如统计代码等' ),
			'section'  => 'frenemy_seo',
			'type'     => 'textarea',
		)
	));

}
add_action( 'customize_register', 'seo_customize_register' );