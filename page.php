<?php get_header(); ?>

	  <main id="Main" class="main" role="main">
      
        <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> 
                     itemscope itemtype="https://schema.org/Article">

                <div class="perma-hover">
                    <?php printf( '<i class="fa-copy-link" title="%s"></i>',
                                  __( 'hover aside to copy link', 'relation') ); ?> 
                    <span class="perma-hover-link">
                      <?php echo esc_attr( esc_url( get_permalink() ) ); ?>
                    </span>
                </div>

                <header>
                <?php
                the_title(
                sprintf( '<h2 class="post-title h4" title="%s" id="bookmark">', 
                esc_attr( esc_url( get_permalink() ) ) ),
                '</h2>'
                );
                ?>
                </header>

                <div class="post-content page-post">
                    <figure class="relation-featured_image">
                    <?php 
                    if( function_exists('relation_loop_featured_image') ) : 
                        do_action( 'relation_featured_image' ); 
                    else: 
                        the_post_thumbnail(); 
                    endif; 
                    ?>
                    </figure>
                    <div class="inner_content">

                        <?php the_content( '', true ); ?>

                    </div>
                        <div class="comments-section">

                            <?php comments_template(); ?>  

                        </div>
                            <div class="pagination">
                        
                                <?php wp_link_pages(); ?>
                        
                            </div>

                    
                </div>
                
            </article>
        
        <?php endwhile; ?>

		    <?php else : ?>
            
            <div class="post-content">
		        
            <?php echo esc_url( home_url('/') ); ?>
            
            </div>

		    <?php endif; ?>
        
    </main>

<?php get_footer(); ?>
