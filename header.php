<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="//gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<a class="skip-link screen-reader-text" href="#content">
<?php esc_attr_e( 'Skip to content', 'relation' ); ?></a>
<div class="page-wrap">
    <section class="sidemount">
    
        <header class="site-header">
            <div class="space-above"></div>
                
                <figure class="site-logo">
                  <?php if( has_custom_logo() ) : ?>
                  <?php if( function_exists( 'relation_theme_custom_logo' ) ) : ?>
                    <a title="<?php bloginfo('description'); ?>" 
                       href="<?php echo esc_url(home_url('/')); ?>">
                    <?php echo wp_kses_post( force_balance_tags( relation_theme_custom_logo() ) ); ?></a>
                  <?php endif; ?>
                  <?php endif; ?>
                </figure>

                    <section class="hgroup">
                    <h1 class="site-title h1">
                    <a title="<?php bloginfo('description'); ?>" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('name') ?></a></h1>
                    <h4 class=""site-description"><?php bloginfo('description') ?></h4>
                    
                    <?php if( function_exists( 'relation_header_lead_render' ) ) : ?>
                    <p class="descriptor-alt"><?php print( relation_header_lead_render() ); ?></p>
                    <?php endif; ?>
                    
                    <div class="site-icons">
                    <?php if ( function_exists( 'relation_social_menu_render' ) ) : ?>
                    <nav class="social-sites">
                        <?php
                        wp_nav_menu( array(
                            'theme_location'  => 'social',
                            'fallback_cb' => 'relation_social_menu_render'
                        )); 
                        ?>
                    </nav>
                    <?php else: ?>
                      <p class="apport-social"><em>*</em><em>*</em><em>*</em><em>*</em><em>*</em></p>
                    <?php endif; ?>
                    </div>
                    </section>
        </header>
      
        <footer id="copyFooter">
            <div id="footer-floats" class="footer-page">
                <div class="maybe-copyright" style="display:block">
                    <p class="text-muted"><?php
                    $year  = date_i18n(__( 'Y', 'relation' ));
                    esc_html_e( 'Copyright ', 'relation' ); 
                    echo esc_attr( ' ' . $year . ' ' );
                    printf( esc_attr( bloginfo( 'name' ) ) ); ?></p>
                </div>
        </footer>

    </section>

        <section class="container-main">
            <header class="navbar-fixed">
                <nav id="nav" class="navbar navigation-top"> 

                <?php wp_nav_menu( array(
                    'theme_location'  => 'primary',
                    'fallback_cb' => 'wp_nav_menus'
                )); ?>

                </nav>
            </header><div class="clearfix"></div> 
