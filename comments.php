<?php
/**
 * The template for displaying Comments
 * @package Relation
 * @since 1.0.2
 * The area of the page that contains both current comments
 * and the comment form.
 */

/** 
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() )
    return;
    ?>

    <h5 class="comments-count-heading"><?php get_template_part( 'comments', 'count' ); ?></h5>
        <ol id="relationComm" class="commentlist" itemscope="commentText" 
            itemtype="https://schema.org/UserComments">
        <?php
            wp_list_comments( array(
                'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 34,
			) );
        ?></ol>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <ul id="comment-nav-below" class="navigation comment-navigation">
            <ul class="pager">
                <li class="previous"><?php previous_comments_link(
                        esc_attr__("&laquo; Older Comments", "relation") ); ?></li>
                <li class="next"><?php next_comments_link(
                        esc_attr__("Newer Comments &raquo;", "relation") ); ?></li>
            </ul>
        </ul>
        <?php endif; ?>

    <?php 
    $wurl = wp_login_url( apply_filters( 'the_permalink', esc_url(get_permalink()) ) );
    $comment_args = array(
    // Change the title of send button
    'label_submit' => esc_attr__( 'Send', 'relation' ),

    // Change the title of the reply section
    'title_reply' => esc_attr__( 'Reply or Comment', 'relation' ),

    // Remove "Text or HTML to be displayed after the set of comment fields".
    'comment_notes_after' => '<p class="form-allowed-tags">'
         . esc_html__( 'You may use these ', 'relation' ) . '<abbr title="' 
         . esc_attr__( 'HyperText Markup Language', 'relation') .'">'
         . esc_html__( 'HTML', 'relation' ) . '</abbr>'
         . esc_html__( ' tags and attributes: ', 'relation' ) . '</p>
         <span class="tagsatts"><code>' . allowed_tags() . '</code></span>',

    // Redefine default textarea (the comment body).
    'comment_field' => '<p class="comment-form-comment"><label for="comment">'
        . esc_attr__( 'Respond', 'relation' )
        . '<span class="screen-reader-text">'
        . esc_html__( 'Comment textarea box', 'relation' ) . '</label>
        <br /><textarea id="comment" name="comment" aria-required="true">
        </textarea></p>',

    //logged in check
    'must_log_in' => '<p class="must-log-in">'
        . esc_html__( 'You must be ', 'relation' ) . '<a href="'. esc_url($wurl) 
        .'">'. esc_html__( 'logged in ', 'relation' ) .'</a>'
        . esc_html__( 'to post a comment.', 'relation' ) .'</p>',


    'comment_notes_before' => '<p class="comment-notes">' .
        esc_html__( 'Your email address will not be published.', 'relation' ) 
        . '</p>',

);
            ?><div class="fieldset-commentform">
            <?php  comment_form( $comment_args ); ?>
            </div> 
