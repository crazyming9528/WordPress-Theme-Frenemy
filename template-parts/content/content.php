<?php
/**
 * Template part for displaying posts
 *
 * @link       https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package    WordPress
 * @subpackage Frenemy
 * @since      1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php

    ?>
    <a href="<?php echo esc_url( get_permalink() ) ?>" class="post-card-image-link">
        <div class="post-card-image" style="background-image: url(<?php echo frenemy_has_post_list_thumbnail( get_the_ID() ); ?>)"></div>
    </a>
    <div class="post-card-content">
        <header>
            <ul class="post-tags">
                <li class="post-tag"><?php frenemy_category() ?></li>
            </ul>
			<?php the_title( sprintf( '<h3 class="post-card-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
        </header>
        <section class="post-card-excerpt">
			<?php
			$excerpt_more = strpos( $post->post_content, '<!--more' );
			if ( $excerpt_more ) :
				$content = get_the_content( '阅读更多&hellip;' );
				echo strip_tags( apply_filters( 'the_content', $content ), '<a>' );
			else :
				echo get_the_excerpt();
			endif;
			?>
        </section>
        <footer class="post-meta">
            <ul class="author-list">
                <li class="author-list-item">
					<?php
					printf(
						sprintf(
							'<a href="%2$s" title="%1$s" class="static-avatar"><img class="author-profile-image" src="%3$s" alt="%1$s"><span class="author-profile-name">%1$s</span></a>',
							esc_html( get_the_author() ),
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
							esc_html( get_avatar_url( get_the_author_meta( 'ID' ), 100 ) )
						)
					)
					?>
                </li>
            </ul>
            <span class="reading-time"><i class="far fa-clock"></i>  <?php echo frenemy_get_post_readtime(); ?>分钟阅读</span>
        </footer>
    </div>
</article>
