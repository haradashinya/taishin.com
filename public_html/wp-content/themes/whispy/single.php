<?php

$whispyOptions = get_option('whispy_theme_settings' );

if( $whispyOptions['colspost-post'] == '3' && get_post_type() == 'post' && !is_front_page() ) get_template_part( 'threecolumn-page' );

else
{

get_header();?>

		<div id="container">
			<div id="content" role="main">

			<?php
			 get_template_part( 'loop', 'index' );
			?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer();

}?>
