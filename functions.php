<?php
/** 
 * Functions for theme Relation
 * 
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * ******************************************************************
 * INFO: This is a ClassicPress version of Relations
 * CMS required: "wp_body_open" action or function call not inserted
 * ******************************************************************
 * @since 1.0.2
 */

// FAST LOADER References ( find @id in DocBlocks )
// ------------------------- Actions ---------------------------
// #f1
add_action( 'after_setup_theme',          'relation_theme_setup' );
// #f2
add_action( 'wp_print_scripts',           'relation_theme_queue_js' );
// #f3 
/* Priority 0 to make it available to lower priority callbacks. */
add_action( 'after_setup_theme',          'relation_content_width', 0 );
// #f4
add_action( 'wp_enqueue_scripts',         'relation_theme_scripts' );
// #f5
add_action( 'widgets_init',               'relation_register_sidebars' );
// #f6
add_action( 'wp_head',                    'relation_pingback_header' );
// #f7
add_action( 'relation_render_attachment', 'relation_render_attachment_link' ); 
// #f9
add_action( 'relation_render_thumbnail',  'relation_render_thumbnail_mod' );
// #f10 
add_action( 'relation_exerpt_render',     'relation_exerpt_render_thumbnail' );
// #f11
add_action( 'relation_footer_meta',       'relation_footer_meta_render' );
// ------------------------- Filters -----------------------------
// #f12
add_action( 'admin_init',   'relation_theme_add_editor_styles' );
// #f14
add_filter( 'excerpt_more', 'relation_custom_excerpt_more' );


/**
 * Setup function is hooked into the after_setup_theme hook, which runs before the init hook. 
 * The init hook is too late for some features, such as indicating support for post thumbnails.
 *
 * @since 1.0.1
 *
 * @id f1
 */

function relation_theme_setup() {
/* a.
 * Switch default core markup for search form, comment form, and comments to output valid HTML5.
 */
/* b.
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded "title" tag in the document head, and expect WordPress to provide it for us.
 *
 * Enable support for Post Thumbnails on posts and pages.
 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
 */
/** @since 1.0.2 */
if ( function_exists( 'is_classicpress' ) && version_compare( '2.0', $cp_version, '<' ) ) {
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
    // b.
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' ); // rss feederz
    add_theme_support( 'post-thumbnails', array( 'post', 'page') );
    
    // register new phone-landscape featured image size. @width, @height, and @crop
    add_image_size( 'relation-featured', 520, 300, false);   

    //page background image and color support
    $defaults = array(
	   'default-color'      => '#fcfcfc',
	   'default-image'       => '',
	   'wp-head-callback'     => '_custom_background_cb',
	   'admin-head-callback'   => '',
	   'admin-preview-callback' => ''
    );
    add_theme_support( 'custom-background', $defaults );
    add_theme_support( 'custom-logo' );

    // woocommerce filters in lower part of this file
    add_theme_support( 'woocommerce' );

    // main nav in header - also nav menu in side-header
    register_nav_menus(
        array(
            'primary' => __('Main Menu Top', 'relation'),
            'social'  => __('Social Link in Header', 'relation')
        )
    );

    // TODO add_editor_style('editor-style.css');    
    load_theme_textdomain( 'relation', get_template_directory_uri() . '/languages' );
}

/**
 * Only enable js if the visitor is browsing either a page or a post    
 * or if comments are open for the entry, or threaded comments are enabled
 *
 * @id f2
 * @since 1.0.0 
 */

function relation_theme_queue_js(){

    if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') )
        wp_enqueue_script( 'comment-reply' );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 *
 * @id f3
 * @since 1.0.0
 */

function relation_content_width() {

	$GLOBALS['content_width'] = apply_filters( 'relation_content_width', 520 );
}

/**
 * Enqueue scripts and styles.
 *
 * @id f4
 * @since 1.0.0 
 */

function relation_theme_scripts() {

    // Load the main stylesheet.
    wp_enqueue_style( 'relation-style', get_stylesheet_uri(), [], time(), false );
    // Add Dashicons, used in the main stylesheet.
    wp_enqueue_style( 'dashicons' );
}

/**
 * Registers an editor stylesheet for the theme.
 *
 * @since 1.0.2
 * @id f12
 */
function relation_theme_add_editor_styles() {

    add_editor_style( 'editor-style.css' );
}

/** 
 * Attachment link for featured images
 *
 * @since 1.0.2
 * @return HTML
 * @id f7 action
 */

function relation_render_attachment_link(){
?>  
    <figure class="linked-attachment-container">
    <a class="imgwrap-link"
       href ="<?php echo esc_url( get_attachment_link( get_post_thumbnail_id() ) ); ?>" 
       title="<?php the_title_attribute( 'before=Permalink to: &after=' ); ?>">
    <?php 
    the_post_thumbnail( 'relation-featured', array( 
            'itemprop' => 'image', 
            'class'  => 'relation-featured',
            'alt'  => get_attachment_link( get_post_thumbnail_id() )
        ) 
    ); ?></a>
    </figure><?php 
}

/** 
 * Position thumbnail inside or above excerpt in blog posts relation_thumbnail_display
 *
 * @since 1.0.2
 * @return HTML
 * @id f10
 */

function relation_exerpt_render_thumbnail(){

    $class     = '';
    if ( !get_theme_mods() ) : 
        $class = "excerpt-background";
    else: 
    $choices   = ( empty( get_theme_mod( 'relation_thumbnail_display' ) ) )
               ? 'background_image' : get_theme_mod( 'relation_thumbnail_display' );

    switch ( $choices ) {
        case "background_image":
            $class = "excerpt-backgrnd";
        break;
        case "above_excerpt"   :
            $class = "above-excerpt";
        break;
        case "no_thumbnail"    :
            $class = "excerpt-nothumb";
        break;
        default                :
         $class="excerpt-backgrnd";
    }
    endif; 
            return $class;
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
    $rtrn = ( ( '' != $show ) || $show == '1' ) ? 'true' : 'false';
        
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
 * Render footer meta with option to hide comment counts
 * 
 * @since 1.0.2
 * @return HTML
 */

function relation_footer_meta_render(){
    $html   = '';
    $iscomm = relation_comment_counter_maybe();
    ?>
    <p class="excerpt-meta"><i class="fa-calendar-day"></i><span class="post_footer-date">
    <?php printf( esc_attr( get_the_date() ) ); ?></span>
    <i class="fa-category-folder"></i><span><?php the_category( ' &bull; ' ); ?></span>
    <i class="fa-tags-list"></i><span><?php the_tags('<em class="tags">', ' ', '</em>'); ?></span>
    <?php 
	if ( $iscomm == 'false' ): 
    ?>
    <span class="comments-count-heading"><i class="fa-comm-count"></i>
    <?php get_template_part( 'comments', 'count' ); ?></span>
    <?php endif;
    ?>
    </p><?php
}

/**
 * Relation_social_menu only used as fallback
 *
 * @since 1.0.1 
 * @return null
 */
function relation_social_menu_render(){
 
    return false;
} 

/**
 * Support for logo upload, output. 
 *
 * @since 1.0.1 
 */
function relation_theme_custom_logo() {
    $output = '';

    if ( function_exists( 'the_custom_logo' ) ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo           = wp_get_attachment_image_src( $custom_logo_id , 'full' );

        if ( has_custom_logo() ) {
            $output = '<div class="header-logo"><img src="'. esc_url( $logo[0] ) .'" 
            alt="'. get_bloginfo( 'name' ) .'"></div>'; 
        } else { 
            $output = ''; 
        }
    }

        // Output sanitized in header to assure all html displays.
        return $output;
}

/**
 * Sanity check
 * @see https://themefoundation.com/wordpress-theme-customizer/
 */ 
function relation_sanitize_text( $input ) {

    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Remove ellipsis and set read more text.
 * Dev note: Title attribute is not attribute realted, it is text from the theme_mod only. 
 * Only `get_the_title` would work if you want the actual title of the post.
 * @return HTML
 *
 * @id f14
 */

function relation_custom_excerpt_more($link) {

    return 
    sprintf( '<em class="excrpt-more"><a href="%1$s" class="more-link">%2$s</a></em>',
        esc_url( get_permalink( get_the_ID() ) ),
        sprintf( __( 'Continue reading %s', 'relation' ), 
        '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' 
        )
    );
}

/**
 * Footer sidebar/widget declarations
 *
 * @id f5 
 */

function relation_register_sidebars() {

    register_sidebar(array(
        'id'            => 'footer-sidebar',
        'name'          => __('Sidebar as Footer', 'relation'),
        'description'   => __('Used on every page.', 'relation'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
    ));
}

/**
 * Header for singular articles
 * Add pingback url auto-discovery header for singular articles.
 *
 * @since 1.0.0
 * @return wp_head
 * @id f6
 */
function relation_pingback_header() {

	if ( is_singular() && pings_open() ) {

		printf( '<link rel="pingback" href="%s">'
                 . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

/** 
 * -------- Woo support --------
 * Removes woo wrappers and replace with this theme's content
 * wrappers so that woo content fits in this theme.
 *
 * @https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 */

if ( class_exists( 'WooCommerce' ) ) : 

function relation_woocommerce_support() {
   
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10);
    add_action(    'woocommerce_before_main_content', 'relation_theme_wrapper_start', 10);
    add_action(    'woocommerce_after_main_content',  'relation_theme_wrapper_end', 10);
}
// start wrapper
function relation_theme_wrapper_start() {
    echo '<div id="content-woo">';
}
// end wrapper
function relation_theme_wrapper_end() {
    echo '</div>';
}

endif;
/* -------- ends Woo weady -------- */

/**
 * **************** CHILD THEME INFO ****************
 * @example for path if using a child theme
 * "require_once ( get_stylesheet_directory() . '/theme-options.php' );"
 *
 * @uses You would use the above method for any file you move to child theme directory.
 */

/**
 * Customizer additions.
 *
 * @since 1.0.0 
 */ 
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Customizer extensions and addtional functionality.
 *
 * @since 1.0.1
 */
require_once get_template_directory() . '/inc/theme-options.php';
?>
