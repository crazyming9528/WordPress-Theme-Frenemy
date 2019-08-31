<?php
/**
 * Custom template tags for this theme
 *
 * @package    WordPress
 * @subpackage Frenemy
 * @since      1.0.0
 */

if (!function_exists('frenemy_posted_on')) :
  /**
   * Prints HTML with meta information for the current post-date/time.
   */
  function frenemy_posted_on() {
    $time_string = '<time class="post-full-meta-date entry-date published updated" datetime="%1$s">%2$s</time>';

    $time_string = sprintf(
      $time_string,
      esc_attr(get_the_date(DATE_W3C)),
      esc_html(get_the_date())
    );

    printf($time_string);
  }
endif;

if (!function_exists('frenemy_posted_by')) :
  /**
   * Prints HTML with meta information about theme author.
   */
  function frenemy_posted_by() {
    printf(
    /* translators: 1: SVG icon. 2: post author, only visible to screen readers. 3: author link. */
      '<span class="byline">%1$s<span class="screen-reader-text">%2$s</span><span class="author vcard"><a class="url fn n" href="%3$s">%4$s</a></span></span>',
      __('Posted by'),
      esc_url(get_author_posts_url(get_the_author_meta('ID'))),
      esc_html(get_the_author())
    );
  }
endif;

if (!function_exists('frenemy_comment_count')) :
  /**
   * Prints HTML with the comment count for the current post.
   */
  function frenemy_comment_count() {
    if (!post_password_required() && (comments_open() || get_comments_number())) {
      echo '<span class="comments-link">';

      /* translators: %s: Name of current post. Only visible to screen readers. */
      comments_popup_link(sprintf(__('Leave a comment<span class="screen-reader-text"> on %s</span>'), get_the_title()));

      echo '</span>';
    }
  }
endif;

if (!function_exists('frenemy_entry_footer')) :
  /**
   * Prints HTML with meta information for the categories, tags and comments.
   */
  function frenemy_entry_footer() {

    // Hide author, post date, category and tag text for pages.
    if ('post' === get_post_type()) {

      // Posted by
      frenemy_posted_by();

      // Posted on
      frenemy_posted_on();

      /* translators: used between list items, there is a space after the comma. */
      $categories_list = get_the_category_list(__(', '));
      if ($categories_list) {
        printf(
        /* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of categories. */
          '<span class="cat-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>',
          __('Posted in'),
          $categories_list
        ); // WPCS: XSS OK.
      }

      /* translators: used between list items, there is a space after the comma. */
      $tags_list = get_the_tag_list('', __(', '));
      if ($tags_list) {
        printf(
        /* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of tags. */
          '<span class="tags-links">%1$s<span class="screen-reader-text">%2$s </span>%3$s</span>',
          __('Tags:'),
          $tags_list
        ); // WPCS: XSS OK.
      }
    }

    // Comment count.
    if (!is_singular()) {
      frenemy_comment_count();
    }

    // Edit post link.
    edit_post_link(
      sprintf(
        wp_kses(
        /* translators: %s: Name of current post. Only visible to screen readers. */
          __('Edit <span class="screen-reader-text">%s</span>'),
          array(
            'span' => array(
              'class' => array(),
            ),
          )
        ),
        get_the_title()
      ),
      '<span class="edit-link">',
      '</span>'
    );
  }
endif;

if (!function_exists('frenemy_post_thumbnail')) :
  /**
   * Displays an optional post thumbnail.
   *
   * Wraps the post thumbnail in an anchor element on index views, or a div
   * element when on single views.
   */
  function frenemy_post_thumbnail() {
    if (!frenemy_can_show_post_thumbnail()) {
      return;
    }

    if (is_singular()) :
      ?>

      <figure class="post-thumbnail">
        <?php the_post_thumbnail(); ?>
      </figure><!-- .post-thumbnail -->

    <?php
    else :
      ?>

      <figure class="post-thumbnail">
        <a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
          <?php the_post_thumbnail('post-thumbnail'); ?>
        </a>
      </figure>

    <?php
    endif; // End is_singular().
  }
endif;

if (!function_exists('frenemy_comment_avatar')) :
  /**
   * Returns the HTML markup to generate a user avatar.
   */
  function frenemy_get_user_avatar_markup($id_or_email = null) {

    if (!isset($id_or_email)) {
      $id_or_email = get_current_user_id();
    }

    return sprintf('<div class="comment-user-avatar comment-author vcard">%s</div>', get_avatar($id_or_email, frenemy_get_avatar_size()));
  }
endif;

if (!function_exists('frenemy_discussion_avatars_list')) :
  /**
   * Displays a list of avatars involved in a discussion for a given post.
   */
  function frenemy_discussion_avatars_list($comment_authors) {
    if (empty($comment_authors)) {
      return;
    }
    echo '<ol class="discussion-avatar-list">', "\n";
    foreach ($comment_authors as $id_or_email) {
      printf(
        "<li>%s</li>\n",
        frenemy_get_user_avatar_markup($id_or_email)
      );
    }
    echo '</ol><!-- .discussion-avatar-list -->', "\n";
  }
endif;

if (!function_exists('frenemy_comment_form')) :
  /**
   * Documentation for function.
   */
  function frenemy_comment_form($order) {
    if (true === $order || strtolower($order) === strtolower(get_option('comment_order', 'asc'))) {

      comment_form(frenemy_comments_template());
    }
  }
endif;

if (!function_exists('frenemy_bootstrap_pagination')) :
  /**
   * Documentation for function.
   */
  function frenemy_bootstrap_pagination(\WP_Query $wp_query = null, $echo = true) {
    if (null === $wp_query) {
      global $wp_query;
    }

    $pages = paginate_links(
      [
        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'type' => 'array',
        'show_all' => false,
        'end_size' => 3,
        'mid_size' => 1,
        'prev_next' => true,
        'prev_text' => __('<span aria-hidden="true"><i class="fas fa-angle-left"></i></span>'),
        'next_text' => __('<span aria-hidden="true"><i class="fas fa-angle-right"></i></span>'),
        'add_args' => false,
        'add_fragment' => ''
      ]
    );
    if (is_array($pages)) {
      //$paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
      $pagination = '<div class="site-pagination"><nav aria-label="文章分页"><ul class="pagination">';
      foreach ($pages as $page) {
        $pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
      }
      $pagination .= '</ul></nav></div>';
      if ($echo) {
        echo $pagination;
      } else {
        return $pagination;
      }
    }

    return null;
  }
endif;

if (!function_exists('wp_body_open')) :
  /**
   * Fire the wp_body_open action.
   *
   * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
   *
   * @since Twenty Nineteen 1.4
   */
  function wp_body_open() {
    /**
     * Triggered after the opening <body> tag.
     *
     * @since Twenty Nineteen 1.4
     */
    do_action('wp_body_open');
  }
endif;

if (!function_exists('frenemy_category')) :
  /**
   * Display the first category of the post.
   */
  function frenemy_category() {
    $category = get_the_category();
    if ($category) {
      /* translators: %s is Category name */
      echo '<a href="' . esc_url(get_category_link($category[0]->term_id)) . '" title="' . esc_attr(sprintf(__('查看%s中的全部文章'), $category[0]->name)) . '" ' . '>' . esc_html($category[0]->name) . '</a> ';
    }
  }
endif;

if (!function_exists('frenemy_comments_template')) :
  /**
   * Custom list of comments for the theme.
   */
  function frenemy_comments_template() {

    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $args = array(
      'comment_notes_before' => '',
      'title_reply' => '',
      'title_reply_to' => '',
      'title_reply_before' => '',
      'title_reply_after' => '',
      'class_form' => 'form',
      'class_submit' => 'btn btn-primary pull-right',
      'must_log_in' => '<p class="must-log-in">' .
        sprintf(
          wp_kses(
          /* translators: %s is Link to login */
            __('你必须<a href="%s">登录</a>才能发表评论'), array(
              'a' => array(
                'href' => array(),
              ),
            )
          ), esc_url(wp_login_url(apply_filters('the_permalink', get_permalink())))
        ) . '</p> </div>',
      'fields' => apply_filters(
        'comment_form_default_fields', array(
          'author' => '<div class="row mt-3"> <div class="col-md-4"> <div class="form-group label-floating is-empty"><input id="author" name="author" placeholder="昵称" class="form-control" type="text"' . $aria_req . ' /> <span class="material-input"></span> </div> </div>',
          'email' => '<div class="col-md-4"> <div class="form-group label-floating is-empty"><input id="email" name="email" class="form-control" placeholder="邮箱" type="email"' . $aria_req . ' /> <span class="material-input"></span> </div> </div>',
          'url' => '<div class="col-md-4"> <div class="form-group label-floating is-empty"><input id="url" name="url" class="form-control" placeholder="网址" type="url"' . $aria_req . ' /> <span class="material-input"></span> </div> </div></div>'
        )
      ),
      'comment_field' => '<div class="form-group label-floating is-empty"><textarea id="comment" name="comment" class="form-control" rows="6" aria-required="true" placeholder="请输入评论内容"></textarea>',
    );

    return $args;
  }
endif;

add_filter('comment_form_field_cookies', '__return_false');

/**
 * 估算文章阅读时间
 *
 * @return float
 */
function frenemy_get_post_readtime() {
  global $post;
  preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $post->post_content, $strResult, PREG_PATTERN_ORDER);

  return ceil(strlen(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content)))) / 1600 + count($strResult[1]) * 8 / 60);
}

/**
 * 在文章列表判断文章是否包含特色图
 *
 * @param $post_id Number 文章id
 *
 * @return string 返回图片路径
 */
function frenemy_has_post_list_thumbnail($post_id) {
  $post_thumbnail_url = get_the_post_thumbnail_url($post_id, 'frenemy-post-list-images');
  if ('' == $post_thumbnail_url) {
    $post_thumbnail_url = get_template_directory_uri() . '/assets/images/no-post-thumbnail.png';
  }

  return $post_thumbnail_url;
}
