<div id="lower-navigation">
    <?php if (get_next_posts_link() || get_previous_posts_link()) { ?>
    <div class="postlink">
        <nav class="nav-block" itemscope="itemscope" 
            itemtype="https://schema.org/SiteNavigationElement">
            <ul class="list-inline">
            
            <?php //only show if there are more posts
            if( get_next_posts_link() ) { ?>
            
                <li class="btn btn-paging notblank previous">
            
                    <?php next_posts_link("&laquo; "
                          . __('Older posts', "relation")); ?></li>
            <?php } ?>
            
                <li></li>
            
                <?php //only show if more pagination of posts
                if( get_previous_posts_link()) { ?>
            
                <li></li>
                <li class="btn btn-paging notblank next">
            
                    <?php previous_posts_link(
                          __('Newer posts', "relation") . " &raquo;"); ?></li>
                <?php } ?>
            
            </ul>
        </nav>
    </div>
    <?php } ?>


    <?php if( is_page() || is_single() ) { 
    ?>
        <nav class="pagination" itemscope="itemscope" 
            itemtype="https://schema.org/SiteNavigationElement">
        <?php
        the_post_navigation( array(
            'prev_text' => '<span class="screen-reader-text">'
            . __( 'Previous Post', 'relation' )
            . '</span><span aria-hidden="true" class="nav-subtitle">'
            . __( '&laquo; Previous: ', 'relation' ) . '</span>
            <span class="nav-pills">%title</span>',

            'next_text' => '<span class="screen-reader-text">'
            . __( 'Next Post', 'relation' ) . '</span>
            <span aria-hidden="true" class="nav-subtitle">'
            . __( 'Next: ', 'relation' ) . '</span>
            <span class="nav-pills">%title</span><span class="nav-subtitle"> &raquo;</span>',
            ) );
        ?>
        </nav>
    <?php
    }
    ?>
        <section id="sidebar">

            <?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
            
            <?php dynamic_sidebar( 'footer-sidebar' ); ?><br>
            
                <?php else : ?>
            
                <div class="meta-default">

                    <?php get_search_form(); ?>
                            
                    <ul><?php wp_loginout(); ?></ul>
                </div>

            <?php endif;  ?>

        </section>
</div>
