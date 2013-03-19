<?php

$whispyOptions = get_option('whispy_theme_settings' );

if( $whispyOptions['colspost-index'] == '3' && is_home() ) get_template_part( 'threecolumn-page' );

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
