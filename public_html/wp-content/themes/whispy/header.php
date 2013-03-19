<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(''); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri(); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	// Support for threaded comments
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
	<div id="header">
		<div id="masthead">
			<div id="branding" role="banner">
				<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';
				if ( display_header_text() )
					$headerStyle = ' style="color:#' . get_header_textcolor() . ';"';
				else
					$headerStyle = ' style="display:none;"';
		?>
				<<?php echo $heading_tag; ?> id="site-title" class="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"<?php echo $headerStyle; ?>><?php bloginfo( 'name' ); ?></a>
					</span>
				</<?php echo $heading_tag; ?>>
				<div id="topwidget">
				<?php
				if( !dynamic_sidebar( 'above-header-widget-area' ) ) get_search_form();
				?>
			    </div>
			    <?php
			    $whispyOptions = get_option('whispy_theme_settings' );
			    $descriptionStyle = $whispyOptions['whispy_description_colour'];
			    if( !display_header_text() ) $descriptionStyle .= ' display: none;';
				if ( !get_header_image() ) :
				?>
				<h2 id="site-description" style="color: #<?php echo $descriptionStyle; ?>"><?php bloginfo( 'description' ); ?></div>
				<?php
				endif;
				?><br class="clear">
				<?php
					// Check if this is a post or page, if it has a thumbnail, and if it's a big one
					// if ( is_singular() && current_theme_supports( 'post-thumbnails' ) &&
					// 		has_post_thumbnail( $post->ID ) &&
					// 		( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) ) &&
					// 		$image[1] >= HEADER_IMAGE_WIDTH ) :
						// Houston, we have a new header image!
						// echo get_the_post_thumbnail( $post->ID );
					
					if ( get_header_image() ) : ?>
						<div id="header-image" style="background: url('<?php header_image(); ?>'); width: <?php echo HEADER_IMAGE_WIDTH; ?>px; height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;">
						<div style="color: #<?php echo $descriptionStyle; ?>" id="site-description"><?php bloginfo( 'description' ); ?></div>
						</div>
					<?php endif; ?>
			</div><!-- #branding -->

			<div id="access" role="navigation">
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'whispy' ); ?>"><?php _e( 'Skip to content', 'whispy' ); ?></a></div>
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
			</div><!-- #access -->
		</div><!-- #masthead -->
	</div><!-- #header -->

	<div id="main">
