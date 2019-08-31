<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link       https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package    WordPress
 * @subpackage Frenemy
 * @since      1.0.0
 */

get_header();

$post_thumbnail_url = get_theme_mod( 'basic_bg_image' );
$post_class         = 'responsive-title-img';
$post_style         = 'style="background-image:url(' . $post_thumbnail_url . ')"';
if ( '' == $post_thumbnail_url ) {
	$post_class = 'responsive-title-no-img';
	$post_style = '';
}
?>

    <section class="site-hero <?php echo $post_class ?>" <?php echo $post_style ?>>
        <div class="container">
            <div class="hero-content">
                <h1 class="site-name"><?php echo get_theme_mod( 'basic_home_title' ); ?></h1>
                <h2 class="site-description"><?php echo get_theme_mod( 'basic_sub_title' ); ?></h2>
            </div>
        </div>
    </section>
    <main class="site-main container">
        <div class="inner row">
            <div class="site-post-list">
                <div class="post-list">
					<?php
					if ( have_posts() ) {

						// Load posts loop.
						while ( have_posts() ) {
							the_post();
							get_template_part( 'template-parts/content/content' );
						}

					} else {

						// If no content, include the "No posts found" template.
						get_template_part( 'template-parts/content/content', 'none' );

					}
					?>
                </div>
            </div>
			<?php
			if ( have_posts() ) {

				// Previous/next page navigation.
				frenemy_bootstrap_pagination();

			}
			?>
        </div>
    </main>

<?php
get_footer();
