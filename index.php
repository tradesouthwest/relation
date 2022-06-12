<?php get_header(); ?>

    <main id="Main" class="main" role="main">
    
		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope 
                itemtype="https://schema.org/Article">

            <div class="post-content">
                <div class="excerpt-content">
                    <header class="excerpt-header">
                    <?php the_title(
                    sprintf( '<h2 class="post-title h4"><a href="%s" rel="bookmark">', 
                        esc_attr( esc_url( get_permalink() ) ) ), 
                        '</a></h2>'
                    );
                    ?>
                    </header>
                    <div class="inner-content">
                        <?php 
                        if ( has_post_thumbnail() ) { 
                        $feat_url = wp_get_attachment_url( get_post_thumbnail_id() );
                        ?>
                            <div class="excerpt-backgrnd" 
                                 style="background-image: url(<?php echo esc_url($feat_url); ?>)">
                            <span class="excerpt-ghost">
                                <?php the_excerpt(); ?>
                            </span>
                            </div>
                            
                        <?php
                        } else {
                            the_excerpt();  
                        }
                        ?>
                    </div>
                                
                </div>
                
                    <div class="post-footer">
                        <p><i class="fa-calendar-day"></i><span class="post_footer-date">
                        <?php printf( esc_attr( get_the_date() ) ); ?></span>
                        <i class="fa-category-folder"></i><span><?php the_category( ' &bull; ' ); ?></span>
                        <i class="fa-tags-list"></i><span><?php the_tags('<em class="tags">', ' ', '</em>'); ?></span></p>
                    </div>
            </div>
            
        </article>

		<?php endwhile; ?>

		<?php else : ?>
        <div class="post-content">
		
            <?php print('add posts please'); ?>
    
        </div>
		<?php endif; ?>
    
        <?php get_template_part( 'nav', 'content' ); ?>

    </main>

<?php get_footer(); ?>
