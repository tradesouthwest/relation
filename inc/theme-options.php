<?php
/**
 * Hooks and filters settings
 *
 * @package: Relation Theme for ClassicPress
 * Theme specific attributes.
 * @since 1.0.1
*/

// to1
add_action( 'init', 'relation_check_disable_emojicons' );

/**
 * Disable emojis in wp head
 * Defers emojis back to core files.
 *
 * @since 1.0.1
 * @return hooks 
*/

function relation_disable_wp_emojicons() 
{
    // all actions related to emojis 
    remove_filter( 'wp_mail',          'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_action('wp_head', 'print_emoji_detection_script', 7 );
    remove_action('admin_print_scripts', 'print_emoji_detection_script' );
    remove_action('wp_print_styles', 'print_emoji_styles' );
    remove_action('admin_print_styles', 'print_emoji_styles' );

    add_filter ( 'emoji_svg_url', '__return_false' );
    // filter to remove TinyMCE emojis
    // add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}

/** to1
 * Disable emojis in wp head conditional
 *
 * @since 1.0.1
 * @return Bool
*/

function relation_check_disable_emojicons()
{
    //if ( !get_theme_mods() ) return;    
    $istrue = relation_mods_fire_once();
    // Make sure the request is for a user-facing page
    if ( !$istrue ) {

    $cleanhead = get_theme_mod( 'relation_checkbox_emojicon' );
    $clean     = ( empty( $cleanhead ) ) ? false : $cleanhead;
    
    if ( $clean == true ) : 

        return add_action( 'wp',    'relation_disable_wp_emojicons' );
    else: 
        return remove_action( 'wp', 'relation_disable_wp_emojicons' );
    endif;
    }
   
        return false;
} 

/**
 * Verify the request is for an actual page vs. resources or images.
 * @uses Normally fires during 'template_redirect' action hook.
 * @since 1.0.1
 * @return bool
*/

function relation_mods_fire_once() {
    // Make sure the request is for a user-facing page
    if ( 
        ! is_singular() && 
        ! is_page() && 
        ! is_single() && 
        ! is_archive() && 
        ! is_home() &&
        ! is_front_page() 
    ) {
        return false;
    } else {
        //run check for theme mod disable_emojicon
        return true;
    }

} 
