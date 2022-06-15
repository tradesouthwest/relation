<?php 
/**
 * Template to show single posts
 * @since 1.0.0
 */

get_header(); ?>

	<main id="Main" class="main" role="main">

        <?php if ( have_posts() ) : ?>

	    <?php while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope 
            itemtype="https://schema.org/Article">

            <header class="single-article-header">
                <div class="perma-hover">
                    <span class="perma-hover-link">
                    <?php printf( '<i class="fa-copy-link" title="%s"></i><em>%s</em>',
                                      __( 'hover aside to copy link', 'relation'),
                                    esc_html( esc_url( get_permalink() ) )
                    ); ?>
                    </span>
                </div>
                <?php the_title( '<h2>', '</h2>' ); ?>
            </header>

            <section class="post-content">

                <?php 
                // check if the post has a Post Thumbnail assigned to it.
                if ( has_post_thumbnail() ) { 
                    do_action( 'relation_render_attachment' );
                } else {
                    echo '<div class="no-thumb"></div>'; }
                ?>

                <div class="inner_content">

                    <?php the_content( '', true ); ?>
                    
                </div>
                    <div class="post-footer">
                        <p><i class="fa-calendar-day"></i><span class="post_footer-date">
                        <?php printf( esc_attr( get_the_date() ) ); ?></span>
                        <i class="fa-category-folder"></i><span><?php the_category( ' &bull; ' ); ?></span>
                        <i class="fa-tags-list"></i><span><?php the_tags('<em class="tags">', ' ', '</em>'); ?></span></p>
                    </div>
                <div class="pagination">
                            
                    <?php wp_link_pages(); ?>
                            
                </div>
            </section>
        </article>

            <aside>

                <?php comments_template(); ?>
                
            </aside>
        
        <?php endwhile; ?>

		<?php else : ?>
            <div class="post-content">
		        <?php echo esc_url( home_url('/') ); ?>
            </div>
		<?php endif; ?>

        <nav class="faux-footer">
            <p class="aligncenter"><a href="#Main" 
                title="<?php esc_attr_e('Up to Top', 'relation'); ?>">
            <?php esc_attr_e('Up to Top', 'relation'); ?></a></p>
        </nav>

    </main>

<?php get_footer(); ?>
