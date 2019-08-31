<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Frenemy
 * @since 1.0.0
 */

?>

<article>
    <section class="post-content">
        <?php the_content(); ?>
    </section>
</article>
<ul class="post-copyright">
    <li class="post-copyright-author">
        <strong>文章作者： </strong><?php echo esc_html( get_the_author() ) ?></li>
    <li class="post-copyright-link">
        <strong>文章链接：</strong>
        <a href="<?php echo esc_url( get_permalink() );?>" title="<?php the_title(); ?>"><?php echo esc_url( get_permalink() );?></a>
    </li>
    <li class="post-copyright-license">
        <strong>版权声明： </strong>本博客所有文章除特别声明外，均采用 <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/" rel="external nofollow" target="_blank">CC BY-NC-SA 4.0</a> 许可协议。转载请注明出处！
    </li>
</ul>


<div class="post-comments">
    <?php
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) {
	    comments_template();
    }
    ?>
</div>
