<?php 
/**
 * Template to show attachment posts
 * @since 1.0.0
 */

get_header(); ?>

	<main id="Main" class="main" role="main">

    
            <?php
            if ( have_posts() ) : while ( have_posts() ) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope 
                itemtype="https://schema.org/Article">
            
                <h1><?php the_title(); ?></h1>

                <div class="entry-attachment">
                    <?php if ( wp_attachment_is_image( $post->id ) ) :
                        $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>

                    <p class="attachment">
                       <a href="<?php echo esc_attr( wp_get_attachment_url( $post->id ) ); ?>"
                       title="<?php the_title_attribute(); ?>"
                       rel="attachment"><img src="<?php echo esc_attr($att_image[0]);?>"
                       width="<?php echo esc_attr($att_image[1]);?>"
                       height="<?php echo esc_attr($att_image[2]);?>"
                       class="img-responsive"
                       alt="<?php the_title_attribute(); ?>" /></a>
                    </p>

                        <?php else : ?>

                        <a href="<?php echo esc_url(wp_get_attachment_url($post->ID)) ?>"
                           title="<?php echo esc_attr(get_the_title($post->ID), 1 ) ?>"
                           rel="attachment"><?php printf( esc_url( basename($post->guid) ) ); ?></a>

                    <?php endif; ?>

                    <?php the_excerpt(); // could be description of attachment ?>

                </div>

		            <div class="post-footer">
                        <p><i class="fa-calendar-day"></i><span class="post_footer-date">
                        <?php printf( esc_attr( get_the_date() ) ); ?></span>
                        <i class="fa-category-folder"></i><span><?php the_category( ' &bull; ' ); ?></span>
                        <i class="fa-tags-list"></i><span><?php the_tags('<em class="tags">', ' ', '</em>'); ?></span></p>
                    </div>

                    <div class="inner_content">

                        <?php the_excerpt(); // could be description of atachment 
                        ?>
                    </div>
            <aside>

                <?php comments_template(); ?>
                
            </aside>
        </article>

		<?php endwhile; ?>

		<?php else : ?>

		  <?php echo esc_url( home_url('/') ); ?>

		<?php endif; ?>

    <?php get_template_part( 'nav', 'content' ); ?>

   
<?php get_footer(); ?> 