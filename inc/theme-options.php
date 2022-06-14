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
// tm0
add_action( 'wp_head', 'relation_theme_customizer_css', 2 );  

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
    remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles',     'print_emoji_styles' );
    remove_action( 'admin_print_styles',  'print_emoji_styles' );

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

/**
 * relation_comment_notonpage from customizer
 * @since 1.0.2
 * @param string $show checked = hide div
 * @return Bool
 */

function relation_comment_notonpage_maybe(){
    $rtrn = 'false';
    $show = get_theme_mod( 'relation_comment_notonpage' );
    $rtrn = ( '' != ( $show ) || $show == '1' ) ? 'true' : 'false';
        
        return $rtrn;
}

/**
 * Check to display comment counts from customizer
 * @since 1.0.2
 * @param string $show checked = hide div
 * @return Bool
 */

function relation_comment_counter_maybe(){
    $rtrn = 'false';
    $show = get_theme_mod( 'relation_comment_counter' );
    $rtrn = ( '' != ( $show ) || $show == '1' ) ? 'true' : 'false';
        
        return $rtrn;
}

/**
 * Text to header from customizer
 * @since 1.0.1
 * @return HTML string
 */
if ( !function_exists( 'relation_header_lead_render' ) ) : 
function relation_header_lead_render(){
    
    $lead = '';
        
    if ( get_theme_mod( 'relation_header_lead' ) ) :
    
        $lead = get_theme_mod( 'relation_header_lead' );
    
    endif;     

        return sanitize_text_field( $lead );
}
endif;

/** tm0
 * CUSTOM FONT OUTPUT, CSS
 * The @font-face rule should be added to the stylesheet before any styles. (priority 2)
 * @uses background-image as linear gradient meerly remove any input background image.
 * @since 1.0.1
*/

function relation_theme_customizer_css() 
{   
    
        $font = '';
        $uria  = get_stylesheet_directory_uri() . '/deps/kmK_Zq85QVWbN1eW6lJV0A7d.woff2';
        $urib  = get_stylesheet_directory_uri() . '/deps/JTUHjIg1_i6t8kCHKm4532VJOt5-QNFgpCtr6Hw5aXo.woff2';
        $arialstack = 'font-family: "Myriad Pro", Myriad, "Liberation Sans", "Nimbus Sans L", "DejaVu Sans Condensed",
        Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", Tahoma, Geneva, "Helvetica Neue", 
        Helvetica, Arial, sans-serif';
        $fnt  = (empty( get_theme_mod( 'relation_font_choices' ) ) ) ? 'arial' 
                    : get_theme_mod( 'relation_font_choices' );
        $clr  = ( empty( get_theme_mod( 'relation_theme_color' ) ) ) ? '#50c77a' 
                    : get_theme_mod( 'relation_theme_color' );
        $ghs  = ( empty ( get_theme_mod( 'relation_excerpt_ghost' ) ) ) 
              ? "rgba(255,255,255, .426)" : get_theme_mod( 'relation_excerpt_ghost' );
    
    /* use above set values into inline styles */

    if ( $fnt == 'arial' ) { 
        $font .= '<style id="relation-arial-style" type="text/css">';
        $font .= 
        "body, button, input, select, textarea{";
        $font .= $arialstack . '}.fa-comm-count:before,.fa-copy-link:before,.fa-tags-list:before,.fa-category-folder:before,.fa-calendar-day:before{
        color: ' . $clr . '}.excerpt-ghost{background: '. $ghs .'}
        .nav-previous, .nav-next, .postlink .btn-paging, .search-submit, .submit{
        background-image: linear-gradient( '. $clr .', '. $clr .', '. $clr .' );}</style>'; 

    } elseif ( $fnt == 'mono' ) {
        $font .= '<style id="relation-mono-style" type="text/css">';
        $font .= 
        "@font-face {
        font-family: 'B612 Mono';
        font-style: normal;
        font-weight: 400;
        src: url( $uria );
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }";
        $font .= 'body, button, input, select, textarea{';
        $font .= 'font-family: "B612 Mono"}.fa-comm-count:before,.fa-copy-link:before,.fa-tags-list:before,.fa-category-folder:before,.fa-calendar-day:before{
        color: ' . $clr . '}.excerpt-ghost{background: '. $ghs .'}
        .nav-previous, .nav-next, .postlink .btn-paging, .search-submit, .submit{
        background-image: linear-gradient( '. $clr .', '. $clr .', '. $clr .' );}</style>'; 
    } elseif ( $fnt == 'montserrat' ) {
        $font .= '<style id="relation-montserrat-style" type="text/css">';
        $font .= 
        "@font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 400;
        src: url( $urib ) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }";
        $font .= 'body, button, input, select, textarea{';
        $font .= 'font-family: "Montserrat";}.fa-comm-count:before,.fa-copy-link:before,.fa-tags-list:before,.fa-category-folder:before,.fa-calendar-day:before{
        color: ' . $clr . '}.excerpt-ghost{background: '. $ghs .'}
        .nav-previous, .nav-next, .postlink .btn-paging, .search-submit, .submit{
        background-image: linear-gradient( '. $clr .', '. $clr .', '. $clr .' );}</style>';
    } else {
    
        $font .= '<style id="relation-arial-style" type="text/css">';
        $font .= 
        "body, button, input, select, textarea{";
        $font .= $arialstack . '}.fa-comm-count:before,.fa-copy-link:before,.fa-tags-list:before,.fa-category-folder:before,.fa-calendar-day:before{
        color: ' . $clr . '}.excerpt-ghost{background: '. $ghs .'}
        .nav-previous, .nav-next, .postlink .btn-paging, .search-submit, .submit, #lower-navigation a, .search-submit{
        background-image: linear-gradient( '. $clr .', '. $clr .', '. $clr .' );}</style>'; 
    } 

        ob_start();
        print( $font );
        echo ob_get_clean(); 
} 
