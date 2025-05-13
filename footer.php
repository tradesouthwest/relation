<?php 
 /** 
  * Ends container-main & page-wrap from header file
  * @package Relation 
  * @since 1.0.2
  */ 
?>
    
    </section>
        <footer id="copyFooterFooter">
            
            <div id="footer-floats" class="footer-page">
                <div class="maybe-copyright" style="display:block">
                    <p class="text-muted"><?php
                    esc_html_e( 'Copyright', 'relation' ); 
                    echo esc_attr( ' ' . gmdate( esc_attr__( 'Y', 'relation' ) ) . ' / ' );
                    printf( esc_attr( bloginfo( 'name' ) ) ); ?></p>
                </div>
        </footer>    
</div>

    <?php wp_footer(); ?>
</body>
</html> 