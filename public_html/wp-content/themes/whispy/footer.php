<?php
/**
 * Calls sidebar-footer.php for bottom widgets.
 */
?>
	</div><!-- #main -->

	<div id="footer" role="contentinfo">
		<div id="colophon">

<?php
	// Call forth the footer widgets in sidebar-footer.php
	get_sidebar( 'footer' );
?>

			<div id="site-info">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			</div><!-- #site-info -->

			<div id="site-generator">
				<?php
				// Only showing credit link on front page of sites
				if( is_home() || is_front_page() )
				{?>
				<br/>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'whispy' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'whispy' ); ?>" rel="nofollow"><?php printf( __( 'Proudly powered by %s.', 'whispy' ), 'WordPress' ); ?></a>
			Whispy created by <a href="http://clashmedia.com">Clash Media</a>.
				<?php
				}
				?>
			</div><!-- #site-generator -->
			

		</div><!-- #colophon -->
	</div><!-- #footer -->

</div><!-- #wrapper -->

<?php

	wp_footer();
?>
</body>
</html>
