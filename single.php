<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Frenemy
 * @since 1.0.0
 */

get_header();

$post_thumbnail_url = get_the_post_thumbnail_url( get_the_ID() );
$post_class = 'responsive-title-img';
$post_style = 'style="background-image:url('. $post_thumbnail_url .')"';
if ( '' == $post_thumbnail_url ) {
	$post_class = 'responsive-title-no-img';
	$post_style = '';
}
?>
    <section class="site-hero <?php echo $post_class?>" <?php echo $post_style?>>
        <div class="container">
            <div class="hero-content">
                <?php the_title( '<h1 class="post-full-title">', '</h1>'); ?>
                <section class="post-full-meta">
	                <?php frenemy_posted_on(); ?>
                    <span class="date-divider">/</span>
                    <?php frenemy_category(); ?>
                </section>
            </div>
        </div>
    </section>
    <main class="site-main container">
        <div class="inner row">
	        <?php

	        /* Start the Loop */
	        while ( have_posts() ) :
		        the_post();

		        get_template_part( 'template-parts/content/content', 'single' );

	        endwhile; // End of the loop.
	        ?>
        </div>
    </main>
<?php
get_footer();
