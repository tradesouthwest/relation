<?php get_header(); ?>

	  <main id="Main" class="main" role="main">
      
        <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> 
                     itemscope itemtype="https://schema.org/Article">

                <header class="single-page-header">
                    <div class="perma-hover">
                    <span class="perma-hover-link">
                    <?php printf( '<i class="fa-copy-link" title="%s"></i><em>%s</em>',
                                    esc_attr__( 'hover aside to copy link', 'relation'),
                                    esc_html( esc_url( get_permalink() ) )
                    ); ?>
                    </span>
                    </div>
                    <?php
                    the_title( '<h2>', '</h2>' );
                    ?>
                </header>

                <section class="post-content page-post">
                    <figure class="relation-featured_image">
                        
                        <?php 
                        // check if the post has a Post Thumbnail assigned to it.
                        if ( has_post_thumbnail() ) { 
                            do_action( 'relation_render_attachment' );
                        } else {
                            echo '<div class="no-thumb"></div>'; }
                        ?>
                    </figure>
                    <div class="inner_content">

                        <?php the_content( '', true ); ?>

                    </div>
                    <div class="pagination">
                        
                        <?php wp_link_pages(); ?>
                        
                    </div>            
                </section>
            </article>

                <?php // if mod checked returns 1 
                    if ( relation_comment_notonpage_maybe() == 'false' ) { 
                ?>

                <aside class="comments-section">

                    <?php comments_template(); ?>  

                </aside> 

                    <?php 
                    } ?>

        <?php endwhile; ?>

		    <?php else : ?>
            
            <div class="post-content">
		        
            <?php echo esc_url( home_url('/') ); ?>
            
            </div>

		    <?php endif; ?>
        
    </main>

<?php get_footer(); ?>
