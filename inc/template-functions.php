<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package    WordPress
 * @subpackage Frenemy
 * @since      1.0.0
 */

/**
 * 判断当前页面添加body样式
 *
 * @param $classes
 *
 * @return array
 */
function frenemy_body_classes( $classes ) {

	if ( is_front_page() && is_home() ) {
		$classes[] = 'home-template';
	}

	return $classes;
}

add_filter( 'body_class', 'frenemy_body_classes' );

/**
 * Adds custom class to the array of posts classes.
 */
function frenemy_post_classes( $classes, $class, $post_id ) {
	global $wp_query;

	if ( $wp_query->current_post % 2 == 0 ) {
		$post_class = 'align-right';
	} else {
		$post_class = 'align-left';
	}

	$classes[] = 'post-card ' . $post_class;

	return $classes;
}

add_filter( 'post_class', 'frenemy_post_classes', 10, 3 );

/**
 * 更换头像镜像
 *
 * @param $avatar
 *
 * @return mixed
 */
function frenemyget_ssl_avatar( $avatar ) {
	$avatar = str_replace(
		array(
			"www.gravatar.com",
			"0.gravatar.com",
			"1.gravatar.com",
			"2.gravatar.com",
			"secure.gravatar.com"
		), "cn.gravatar.com", $avatar );

	return $avatar;
}

add_filter( 'get_avatar', 'frenemyget_ssl_avatar' );

/*
 * 文章外部链接加上nofollow
 */
function cn_nf_url_parse( $content ) {

	$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
	if ( preg_match_all( "/$regexp/siU", $content, $matches, PREG_SET_ORDER ) ) {
		if ( ! empty( $matches ) ) {

			$srcUrl = get_option( 'siteurl' );
			for ( $i = 0; $i < count( $matches ); $i ++ ) {

				$tag  = $matches[ $i ][0];
				$tag2 = $matches[ $i ][0];
				$url  = $matches[ $i ][0];

				$noFollow = '';

				$pattern = '/target\s*=\s*"\s*_blank\s*"/';
				preg_match( $pattern, $tag2, $match, PREG_OFFSET_CAPTURE );
				if ( count( $match ) < 1 ) {
					$noFollow .= ' target="_blank" ';
				}

				$pattern = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
				preg_match( $pattern, $tag2, $match, PREG_OFFSET_CAPTURE );
				if ( count( $match ) < 1 ) {
					$noFollow .= ' rel="nofollow" ';
				}

				$pos = strpos( $url, $srcUrl );
				if ( $pos === false ) {
					$tag     = rtrim( $tag, '>' );
					$tag     .= $noFollow . '>';
					$content = str_replace( $tag2, $tag, $content );
				}
			}
		}
	}
	$content = str_replace( ']]>', ']]>', $content );

	return $content;
}

add_filter( 'the_content', 'cn_nf_url_parse' );

/**
 * 字符截断
 *
 * @param $str
 * @param $start
 * @param $width
 * @param $trimmarker
 *
 * @return string
 */
function dm_strimwidth( $str, $start, $width, $trimmarker ) {
	$output = preg_replace( '/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $width . '}).*/s', '\1', $str );

	return $output . $trimmarker;
}

/**
 * 页脚脚本
 */
function track_code() {
	if ( get_theme_mod( 'seo_footer_code' ) ) {
		echo str_replace(
			array( '&lt;', '&gt;', '&quot;', '&#039;' ), array(
			'<',
			'>',
			'"',
			"'"
		), get_theme_mod( "seo_footer_code" ) );
	}
}

add_action( "wp_footer", "track_code" );