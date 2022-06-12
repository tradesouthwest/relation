<?php 
 /* ends container-main & page-wrap @package Relation */ 
?>
    </section>
        <footer id="copyFooterFooter">
            
            <div id="footer-floats" class="footer-page">
                <div class="maybe-copyright" style="display:block">
                    <p class="text-muted"><?php
                    $year  = date_i18n(__( 'Y', 'relation' ));
                    esc_html_e( 'Copyright ', 'relation' ); 
                    echo esc_attr( ' ' . $year . ' ' );
                    printf( esc_attr( bloginfo( 'name' ) ) ); ?></p>
                </div>
        </footer>    
</div>

    <?php wp_footer(); ?>
    
</body>
</html> 