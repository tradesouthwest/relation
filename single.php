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
            <header>
            <?php
            the_title(
            sprintf( '<h2 class="post-title h4" title="%s" id="bookmark">', 
            esc_attr( esc_url( get_permalink() ) ) ),
            '</h2>'
            );
            ?>
            </header>
            <div class="post-content">

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
            
            <aside>

                <?php comments_template(); ?>
                
            </aside>
        </article>
        
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
