<?php
/** 
 * Functions for theme Relation
 * 
 * Sets up theme defaults and registers support for various WordPress features.
 * *************************************************************
 * INFO: This is a ClassicPress version of Relations
 * CMS required: wp_body_open action or function call not inserted
 * *************************************************************
 * @since 1.0.2
 */
// FAST LOADER 
// #f1
add_action( 'after_setup_theme',  'relation_theme_setup' );
// #f2
add_action( 'wp_print_scripts',   'relation_theme_queue_js' );
// #f3
add_action( 'after_setup_theme',  'relation_content_width', 0 );
// #f4
add_filter( 'excerpt_more',       'relation_custom_excerpt_more' );
// #f4
add_action( 'wp_enqueue_scripts', 'relation_theme_scripts' );
// #f5
add_action( 'widgets_init',       'relation_register_sidebars' );
// #f6
add_action( 'wp_head',            'relation_pingback_header' );

/**
 *  Setup function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 * @since 1.0.1
 * @id f1
 */

function relation_theme_setup() {
/**
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
/**
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 */
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' ); // rss feederz
/**
 * Enable support for Post Thumbnails on posts and pages.
 * wp thumbnails (sizes handled below)
 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
 */
    add_theme_support( 'post-thumbnails', array( 'post', 'page') );
    
    // register new featured image size. width, height, and crop 
    add_image_size( 'relation-featured', 520, 300, false);  // 4:3 ratio 

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
    //add_editor_style('editor-style.css');    

    // main nav in header - also nav menu in footer and modal are same
    register_nav_menus(
        array(
            'primary' => __('Main Menu Top', 'relation'),
            'social'  => __('Social Link in Header', 'relation')
        )
    );

    load_theme_textdomain( 'relation', get_template_directory_uri() . '/languages' );

    //woocommerce filters below setup
    add_theme_support( 'woocommerce' );
}

/**
 * only enable js if the visitor is browsing either a page or a post    
 * or if comments are open for the entry, or threaded comments are enabled
 * @id f2
*/

function relation_theme_queue_js(){
    if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') )
        wp_enqueue_script( 'comment-reply' );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 * @id f3
*/
function relation_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'relation_content_width', 520 );
}

// Register the custom image size for use in Add Media library.
//add_filter( 'image_size_names_choose', 'relation_custom_thumb_sizes' );
function relation_custom_thumb_sizes( $sizes ) {

    return array_merge( $sizes, array(
        'relation-featured' => __( 'This is a 5:4 image size', 'relation' ),
    ) );
}

/**
 * Enqueue scripts and styles.
 * @id f4
 */
function relation_theme_scripts() {

    // For use of child themes
    wp_enqueue_style( 'relation-style', get_stylesheet_uri() );
    /* wp_enqueue_script( 'relation',
                        get_template_directory_uri() . '/deps/relation.js',
                        array ( 'jquery' ),
                        '',
                        true); */
    wp_enqueue_style( 'dashicons' );
}

/**
 * Attachment link for featured images
 * @since 1.0.2
 * @return HTML
 */
add_action( 'relation_render_attachment', 'relation_render_attachment_link' ); 
function relation_render_attachment_link(){

?>  <figure class="linked-attachment-container">
    <a class="imgwrap-link"
       href="<?php echo esc_url( get_attachment_link( get_post_thumbnail_id() ) ); ?>">
    <?php 
    the_post_thumbnail( 'relation-featured', array( 
                        'itemprop' => 'image', 
                        'class' => 'relation-featured',
                        'alt' => '' ) ); ?></a>
    </figure><?php 
}
/**
 * relation_social_menu
 *
 */
function relation_social_menu_render(){
 
    return false;
} 

/**
 * support for logo upload, output.
 * Output sanitized in header to assure all html displays.
 * @since 1.0.1 
 */
function relation_theme_custom_logo() {
    $output = '';
    if ( function_exists( 'the_custom_logo' ) ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        if ( has_custom_logo() ) {
            $output = '<div class="header-logo"><img src="'. esc_url( $logo[0] ) .'" 
            alt="'. get_bloginfo( 'name' ) .'"></div>'; 
            } 
            else 
                { $output = ''; }
    }
    return $output;
}

//https://themefoundation.com/wordpress-theme-customizer/
function relation_sanitize_text( $input ) {

    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Remove ellipsis and set read more text.
 * Dev note: Title attribute is not attribute realted, 
 * it is text from the theme_mod only. Only `get_the_title` would work
 * if you want the actual title of the post.
 * @id f4
 */
function relation_custom_excerpt_more($link) {
    return sprintf( '<em class="excrpt-more"><a href="%1$s" class="more-link">%2$s</a></em>',
          esc_url( get_permalink( get_the_ID() ) ),
          sprintf( __( 'Continue reading %s', 'relation' ), 
          '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
    );
}

// @id f5 Footer sidebar declarations
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
 * @id f6
 */
function relation_pingback_header() {

	if ( is_singular() && pings_open() ) {

		printf( '<link rel="pingback" href="%s">'
                 . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

/**woo weady
 * Removes woo wrappers and replace with this theme's content
 * wrappers so that woo content fits in this theme.
 * @https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
*/
if ( class_exists( 'WooCommerce' ) ) : 
function relation_woocommerce_support() {
   
remove_action( 'woocommerce_before_main_content',
               'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content',
               'woocommerce_output_content_wrapper_end', 10);
add_action(    'woocommerce_before_main_content',
               'relation_theme_wrapper_start', 10);
add_action(    'woocommerce_after_main_content',
               'relation_theme_wrapper_end', 10);
}
function relation_theme_wrapper_start() {
    echo '<div id="content-woo">';
}

function relation_theme_wrapper_end() {
    echo '</div>';
}
endif;

/**
 * @example for path if using a child theme
 * require_once ( get_stylesheet_directory() . '/theme-options.php' );
 * @usage You would use the above method for any file you move to child dir
 */

//Register Customizer assets
require_once get_template_directory() . '/inc/customizer.php';

//Register Theme option assets
require_once get_template_directory() . '/inc/theme-options.php';
?>
