<?php
/**
 * Customizer settings here.
 * @package: relation Theme for ClassicPress
 * Header text setting and Theme specific attributes.
 *
 * https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
 *
*/

add_action( 'customize_register', 'relation_register_theme_customizer_setup' );

/**
 * Remove parts of the Options menu we don't use.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @since 1.0.2
*/

function relation_register_theme_customizer_setup($wp_customize)
{

    $wp_customize->add_section('title_tagline', array(
            'title'             => __( 'Header and Lead Text', 'relation' ),
            'priority'          => 15
        )); 
    $wp_customize->add_section('colors', array(
            'title'             => __( 'Colors and Theme Branding', 'relation' ),
            'priority'          => 25
        )); 
    // Theme font choice section
    $wp_customize->add_section( 'relation_font_types', array(
        'title'       => __( 'Theme and Font Settings', 'relation' ),
        'capability'  => 'edit_theme_options',
        'description' => __( 'Select font type for theme', 'relation' ),
        'priority'    => 20,
    ) );

    //-----------------Settings and Controls ----------------------------------

    $wp_customize->add_setting(	'relation_header_lead', 
        array(
        'default'           => __('Keeping Classic with ClassicPress', 'relation'),
        'sanitize_callback'	=> 'sanitize_text_field',
        'transport'			=> 'refresh'
        )
    );
    $wp_customize->add_control( 'relation_header_lead_control', 
        array(
            'settings'    => 'relation_header_lead',
            'section'     => 'title_tagline',
            'type'        => 'text',
            'label'       => __( 'Write a Lead Line for the Header', 'relation' ),
            'description' => __( 'Appears just below site title and tag line. Try Authored by...', 'relation' ),
        )
    );
    

    $wp_customize->add_setting( 'relation_font_choices', array(
		'default'           => 'arial',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'esc_textarea',
		'capability'        => 'edit_theme_options',
	) );

    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'container_type', array(
            'label'       => __( 'Font Choices', 'relation' ),
            'description' => __( "Choose between Monospace fonts and Arial fontstack", 'relation' ),
            'section'     => 'relation_font_types',
            'settings'    => 'relation_font_choices',
            'type'        => 'select',
            'choices'     => array(
                'mono'       => __( 'B612 Mono', 'relation' ),
                'montserrat'       => __( 'Montserrat', 'relation' ),
                'arial' => __( 'Helvetica, Arial font-stack', 'relation' ),
            ),
            'priority'    => '10',
        )
    ) );

    $wp_customize->add_setting( 'relation_checkbox_emojicon', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'relation_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'relation_checkbox_emojicon', array(
        'type'        => 'checkbox',
        'section'     => 'relation_font_types', // Add a default or your own section
        'label'       => __( 'Remove Emojicons', 'relation' ),
        'description' => __( 'Check box to remove emojicons from theme head. This saves bandwidth when page loads.', 'relation' ),
    ) );

    
    $wp_customize->add_setting(
          'relation_theme_color', array(
          'default'           => '#50c77a',
          'sanitize_callback' => 'sanitize_hex_color',
          'type'              => 'theme_mod',
          'capability'        => 'edit_theme_options'
        )
    );

    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'relation_theme_color',
        array('label' => __( 'Color scheme for buttons and icons', 'relation' ),
            'section' => 'colors',
            'settings' => 'relation_theme_color'
        ) ) 
    );

}

function relation_sanitize_checkbox( $checked ) {
  // Boolean check.
  return ( ( isset( $checked ) && true == $checked ) ? true : false );
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

// tm0
add_action( 'wp_head', 'relation_customize_css', 2 );  

/** tm0
 * CUSTOM FONT OUTPUT, CSS
 * The @font-face rule should be added to the stylesheet before any styles. (priority 2)
 * @uses background-image as linear gradient meerly remove any input background image.
 * @since 1.0.1
*/

function relation_customize_css() 
{   
    if ( !get_theme_mods() ) return false;    
        
        $font = '';
        $arialstack = 'font-family: "Myriad Pro", Myriad, "Liberation Sans", "Nimbus Sans L", "DejaVu Sans Condensed",
    Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", Tahoma, Geneva, "Helvetica Neue", 
    Helvetica, Arial, sans-serif';
        $uria  = get_stylesheet_directory_uri() . '/deps/kmK_Zq85QVWbN1eW6lJV0A7d.woff2';
        $urib  = get_stylesheet_directory_uri() . '/deps/JTUHjIg1_i6t8kCHKm4532VJOt5-QNFgpCtr6Hw5aXo.woff2';
     
        $fnt  = get_theme_mod( 'relation_font_choices' );
        $clr  = get_theme_mod( 'relation_theme_color' );

    if ( $fnt == 'arial' ) { 
        $font .= '<style id="relation-arial-styles" type="text/css">';
        $font .= 
        "body, button, input, select, textarea{";
        $font .= $arialstack . '}.fa-copy-link:before,.fa-tags-list:before,.fa-category-folder:before,.fa-calendar-day:before{
        color: ' . $clr . '}
        .nav-previous, .nav-next, .postlink .btn-paging, .search-submit{
        background-image: linear-gradient( '. $clr .', '. $clr .', '. $clr .' );}</style>'; 

    } elseif ( $fnt == 'mono' ) {
        $font .= '<style id="relation-mono-styles" type="text/css">';
        $font .= 
        "@font-face {
        font-family: 'B612 Mono';
        font-style: normal;
        font-weight: 400;
        src: url( $uria );
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }";
        $font .= 'body, button, input, select, textarea{';
        $font .= 'font-family: "B612 Mono"}.fa-copy-link:before,.fa-tags-list:before,.fa-category-folder:before,.fa-calendar-day:before{
        color: ' . $clr . '}
        .nav-previous, .nav-next, .postlink .btn-paging, .search-submit{
        background-image: linear-gradient( '. $clr .', '. $clr .', '. $clr .' );}</style>'; 
    } elseif ( $fnt == 'montserrat' ) {
        $font .= '<style id="relation-montserrat-styles" type="text/css">';
        $font .= 
        "@font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 400;
        src: url( $urib ) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }";
        $font .= 'body, button, input, select, textarea{';
        $font .= 'font-family: "Montserrat";}.fa-copy-link:before,.fa-tags-list:before,.fa-category-folder:before,.fa-calendar-day:before{
        color: ' . $clr . '}
        .nav-previous, .nav-next, .postlink .btn-paging, .search-submit{
        background-image: linear-gradient( '. $clr .', '. $clr .', '. $clr .' );}</style>';
    } else {
    
        $font .= '';
    }
        ob_start();
        print( $font );
        echo ob_get_clean(); 
} 
