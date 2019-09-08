<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link       https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    WordPress
 * @subpackage Frenemy
 * @since      1.0.0
 */

$description = '';
$keywords    = '';
if ( is_home() || is_page() ) {
	// 将以下引号中的内容改成你的主页description
	$description = get_theme_mod( 'seo_description' );

	// 将以下引号中的内容改成你的主页keywords
	$keywords = get_theme_mod( 'seo_keywords' );
} elseif ( is_single() ) {
	$description1 = get_post_meta( $post->ID, "description", true );
	$description2 = str_replace( "\n", "", dm_strimwidth( strip_tags( $post->post_content ), 0, 200, "…", 'utf-8' ) );

	// 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
	$description = $description1 ? $description1 : $description2;

	// 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词
	$keywords = get_post_meta( $post->ID, "keywords", true );
	if ( $keywords == '' ) {
		$tags = wp_get_post_tags( $post->ID );
		foreach ( $tags as $tag ) {
			$keywords = $keywords . $tag->name . ", ";
		}
		$keywords = rtrim( $keywords, ', ' );
	}
} elseif ( is_category() ) {
	// 分类的description可以到后台 - 文章 -分类目录，修改分类的描述
	$description = category_description();
	$keywords    = single_cat_title( '', false );
} elseif ( is_tag() ) {
	// 标签的description可以到后台 - 文章 - 标签，修改标签的描述
	$description = tag_description();
	$keywords    = single_tag_title( '', false );
}
$description = trim( strip_tags( $description ) );
$keywords    = trim( strip_tags( $keywords ) );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="<?php echo $description; ?>"/>
    <meta name="keywords" content="<?php echo $keywords; ?>"/>
    <link rel="profile" href="https://gmpg.org/xfn/11"/>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site-warp">
    <header class="site-header fixed-top" style="top: auto;list-style: none">
        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php esc_attr_e( '顶部菜单' ); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'menu-top',
						'menu_class'      => 'navbar-nav ml-auto',
						'depth'           => 1, // 1 = no dropdowns, 2 = with dropdowns.
						'container'       => 'div',
						'container_class' => 'collapse navbar-collapse',
						'container_id'    => 'navbarSupportedContent',
						'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
						'walker'          => new WP_Bootstrap_Navwalker()
					)
				);
				?>
                <li class="nav-item m-0 d-none d-md-block d-lg-block d-xl-block">
                  <div class="site-searchbar">
                    <label for="nav-top-search"></label>
                    <input id="nav-top-search" class="search-input" type="text" placeholder="Search...">
                    <a class="search-icon"><i class="fas fa-search"></i></a>
                  </div>
                </li>
                <li class="nav-item d-block d-md-none d-lg-none d-xl-none">
                  <form class="mobile-search">
                    <div class="input-group">
                      <input type="text" class="mobile-search-input form-control" placeholder="Search..." aria-label="Search Input">
                    </div>
                  </form>
                </li>
                <li class="nav-item">
                  <label class="dark-switch-label" for="darkSwitch">
                    <a class="dark-switch-label-span" data-toggle="tooltip" data-placement="bottom" title="日夜模式">
                      <i class="fas fa-sun"></i>
                    </a>
                  </label>
                  <input type="checkbox" class="custom-control-input" id="darkSwitch">
                </li>

            </div>
        </nav>
    </header>
