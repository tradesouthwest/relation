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
    // Lead text
    $wp_customize->add_section('title_tagline', array(
            'title'             => __( 'Header and Lead Text', 'relation' ),
            'priority'          => 15
    )); 
    // Branding
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


    $wp_customize->add_setting( 'relation_thumbnail_display', array(
		'default'           => 'background_image',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'esc_textarea',
		'capability'        => 'edit_theme_options',
	) ); 
    $wp_customize->add_control( 'relation_thumbnail_display', array(
    
        'label'       => __( 'Thumbnail Position for Excerpts', 'relation' ),
        'description' => __( "Choose thumbnail layout. Will only show thumbnail if one exists.", 'relation' ),
        'section'     => 'relation_font_types',
        'type'        => 'select',
        'choices'     => array(
            'background_image' => __( 'Display as background image', 'relation' ),
            'above_excerpt'    => __( 'Display above the exceprt', 'relation' ),
            'no_thumbnail'     => __( 'No thumbnail at all', 'relation' ),
        ),
        'priority'    => '15',
    ) );


    $wp_customize->add_setting( 'relation_comment_counter', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'relation_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'relation_comment_counter', array(
        'type'        => 'checkbox',
        'section'     => 'relation_font_types', // Add a default or your own section
        'label'       => __( 'Remove Comment Count', 'relation' ),
        'description' => __( 'Check box to remove the displaying of comment counts in post excerpt footer meta.', 'relation' ),
        'priority'    => '20',
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
        'priority'    => '30',
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
        array('label'  => __( 'Color scheme for buttons and icons', 'relation' ),
            'section'  => 'colors',
            'settings' => 'relation_theme_color'
        ) ) 
    );

    $wp_customize->add_setting(
          'relation_excerpt_ghost', array(
          'default'           => 'rgba(255,255,255, .426)',
          'sanitize_callback' => 'relation_sanitize_rgba',
          'type'              => 'theme_mod',
          'capability'        => 'edit_theme_options'
        )
    );
    $wp_customize->add_control( 'relation_excerpt_ghost', array(
        'type'        => 'text',
        'section'     => 'colors',
        'label'       => __( 'Overlay Mask for Excerpt', 'relation' ),
        'description' => '<p>' . __('Select color and opacity of background overlay for 
                         excerpts with thumbnails.', 'relation' ) . '</p>' 
                         . '<p><em>' . __('Learn RGBA at www.w3.org/wiki/CSS/Properties/color/RGBA', 'relation') 
                         .'</em></p>' 
                         . '<strong>' . __( 'Example CSS "rgba(255, 255, 255, .4)"', 'relation' ) . '</strong>'
    ) );

}

// Easy Boolean checker
function relation_sanitize_checkbox( $checked ) {
  
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
} 

/**
 * Check if string starts with 'rgba', else use hex sanity
 * sanitize the hex color and convert hex to rgba
 * @since 1.0.2
 */
function relation_sanitize_rgba( $color ) {
    
    if ( empty( $color ) || is_array( $color ) )
        return 'rgba(0,0,0,0)';

    if ( false === strpos( $color, 'rgba' ) ) {
        return sanitize_hex_color( $color );
    }
    $color = str_replace( ' ', '', $color );
    sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
    return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
}