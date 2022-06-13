<?php 
/**
 * This is the file that produces the blog output.
 * @package Relation
 * @since 1.0.0
 */

get_header(); ?>

    <main id="Main" class="main" role="main">
    
		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope 
                itemtype="https://schema.org/Article">

            <div class="post-content">
                <div class="excerpt-content">
                    <header class="excerpt-header">
                    
                    <?php the_title(
                        sprintf( '<h2 class="post-title h4"><a href="%s" rel="bookmark">', 
                            esc_attr( esc_url( get_permalink() ) ) 
                            ), '</a></h2>' ); ?>

                    </header>
                    <div class="inner_content">
                    <?php 
                    $reclass = ( empty( get_theme_mod( 'relation_thumbnail_display' ) ) )
                        ? 'background_image' : get_theme_mod( 'relation_thumbnail_display' );
                    
                    
                    if ( has_post_thumbnail() ) { 
                        $feat_url = wp_get_attachment_url( get_post_thumbnail_id() ); 
                        ?>
                        
                        <?php // reclass set to background_image
                        if ( $reclass == 'background_image' ) : ?>

                        <div class="<?php print( $reclass ); ?>" 
                             style="background-image: url(<?php echo esc_url($feat_url); ?>)">
                            <span class="excerpt-ghost">
                            
                                <?php  the_excerpt(); ?>
                        
                            </span>
                        </div>

                        <?php // above-excerpt
                        elseif ( $reclass == 'above_excerpt' ) : ?>
                        
                        <div class="thumbnail-above">
                            <figure class="aligncenter">
                                
                                <?php the_post_thumbnail(); ?>
                            
                            </figure>
                                <span class="excerpt-nothumb">
                                
                                    <?php the_excerpt(); ?>
                            
                                </span>
                        </div>

                        <?php // none
                        else: ?>

                        <div class="no_thumbnail">
                            <span class="excerpt-nothumb">
                            
                                <?php  the_excerpt(); ?>
                        
                            </span>
                        </div>

                        <?php // ends check for reclass
                        endif; ?>
                    <?php   // post has no thumbnail or featured image
                    } else { ?>

                        <div class="no_thumbnail">
                            <span class="excerpt-nothumb">
                            
                                <?php  the_excerpt(); ?>
                        
                            </span>
                        </div>

                    <?php // ends check for thumbnail or featured image 
                    } ?>

                    </div>   
                </div>
                <div class="post-footer">
                    
                    <?php do_action( 'relation_footer_meta' ); ?>
                
                </div>
            </div>
            
        </article>

		<?php 
        endwhile; ?>

		<?php 
        else : ?>
        <div class="post-content">
		
            <?php print('add posts please'); ?>
    
        </div>
		<?php endif; ?>
    
        <?php get_template_part( 'nav', 'content' ); ?>

    </main>

<?php get_footer(); ?>
