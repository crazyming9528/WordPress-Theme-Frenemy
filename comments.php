<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link       https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package    Frenemy
 * @subpackage Twenty_Nineteen
 * @since      1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="<?php echo comments_open() ? 'comments-area' : 'comments-area comments-closed'; ?>">
	<?php
	if ( have_comments() ) :

		// Show comment form at top if showing newest comments at the top.
		if ( comments_open() ) {
      frenemy_comment_form( 'desc' );
		}

		?>
        <ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'walker'      => new Frenemy_Walker_Comment(),
					'avatar_size' => 60,
					'short_ping'  => true,
					'style'       => 'ol',
				)
			);
			?>
        </ol><!-- .comment-list -->
		<?php

		// Show comment navigation
		if ( have_comments() ) :
			the_comments_navigation(
				array(
					'prev_text'          => '<input name="prev" type="button" class="btn btn-primary" value="上一页">',
					'next_text'          => '<input name="next" type="button" class="btn btn-primary" value="下一页">',
					'screen_reader_text' => ' '
				)
			);
		endif;

		// Show comment form at bottom if showing newest comments at the bottom.
		if ( comments_open() && 'asc' === strtolower( get_option( 'comment_order', 'asc' ) ) ) :
			?>
            <div class="comment-form-flex">
				      <?php frenemy_comment_form( 'asc' ); ?>
            </div>
		<?php
		endif;

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
            <p class="no-comments">
				<?php _e( '评论已被关闭' ); ?>
            </p>
		<?php
		endif;

	else :

		// Show comment form.
    frenemy_comment_form( true );

	endif; // if have_comments();
	?>
</div><!-- #comments -->
