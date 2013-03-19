<?php
/**
 * Template Name: Three columns, two sidebars
 */

get_header(); ?>

		<div id="container" class="three-column">
			<?php
			get_template_part( 'sidebar', 'left' );
			?>
			 <div id="content" role="main">
			<?php
			 get_template_part( 'loop', 'index' );
			?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>