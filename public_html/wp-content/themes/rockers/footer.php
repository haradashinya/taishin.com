    </div>
    <footer id="footer" role="contentinfo">
        <p class="footer-notes"><?php do_action( 'rockers_credits' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> <?php printf( __( 'is based on', 'rockers' ) ); ?> <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'rockers' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'rockers' ); ?>" rel="generator"><?php printf( __( '%s', 'rockers' ), 'WordPress' ); ?></a>.</p>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>