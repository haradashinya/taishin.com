<?php
/**
 * Whispy functions and definitions, based on ye olde twenty ten
 *
 * whispy_setup(), sets up the theme by registering support for various features in WordPress,
 * such as post thumbnails, navigation menus, and the like.
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

add_action( 'customize_register', 'whispy_customize_register' );

function whispy_customize_register( $wp_customize )
{
	// Header text colors
	$wp_customize->add_setting( 'whispy_theme_settings[whispy_description_colour]', array(
		'default'					=> 'FFF',
		'type' 						=> 'option',
		'sanitize_callback'		=> 'whispy_sanitize_color',
		'sanitize_js_callback'	=> 'maybe_hash_hex_color',
	) );

	$wp_customize->add_control(  new WP_Customize_Color_Control( $wp_customize, 'whispy_theme_settings[whispy_description_colour]',
		array(
			'label'		=> __( 'Site Tagline Color', 'whispy' ),
			'section'	=> 'colors',
			'settings'	=> 'whispy_theme_settings[whispy_description_colour]'
			)
	));

	// Add three columns to blog index and posts
	$wp_customize->add_section( 'whispy_custom_post_layout' , array(
		'title'      => __('Whispy Custom Layout','whispy'),
		'priority'   => 40,
	) );

	$wp_customize->add_setting( 'whispy_theme_settings[colspost-index]', array(
		'default'					=> '2',
		'type' 						=> 'option'
	) );
	$wp_customize->add_setting( 'whispy_theme_settings[colspost-post]', array(
		'default'					=> '2',
		'type' 						=> 'option'
	) );

	$wp_customize->add_control(  'whispy_theme_settings[colspost-index]', array(
		'label'		=> 'Columns on Blog Index',
		'section'	=> 'whispy_custom_post_layout',
		'type'		=> 'radio',
		'choices'	=> array(
			'2' => '2 Columns',
			'3' => '3 Columns'
			)
	) );

	$wp_customize->add_control(  'whispy_theme_settings[colspost-post]', array(
		'label'		=> 'Columns on Posts',
		'section'	=> 'whispy_custom_post_layout',
		'type'		=> 'radio',
		'choices'	=> array(
			'2' => '2 Columns',
			'3' => '3 Columns'
			)
	) );

	// Hook to ajax update
	$wp_customize->get_setting('header_textcolor')->transport='postMessage';
	$wp_customize->get_setting('blogname')->transport='postMessage';
	$wp_customize->get_setting('blogdescription')->transport='postMessage';

	if ( $wp_customize->is_preview() && ! is_admin() )
		add_action( 'wp_footer', 'whispy_customize_preview', 21);

}

function whispy_customize_preview() {
	?>
	<script type="text/javascript">
		( function( $ ) {
			wp.customize('header_textcolor',function( value ) {
				value.bind (function( to ) {
					if( 'blank' == to )
					{
						$('.site-title').hide();
						$('#site-description').hide();
					}
					else
					{
						$('.site-title').show();
						$('#site-description').show();
						$('.site-title').find('a').css('color', to ? to : '' );
					}
				});
			});
			wp.customize('blogname',function( value ) {
				value.bind (function( to ) {
					$('.site-title').find('a').text(to);
				});
			});
			wp.customize('blogdescription',function( value ) {
				value.bind (function( to ) {
					$('#site-description').text(to);
				});
			});
		} )( jQuery )
	</script>
	<?php 
} 

function whispy_sanitize_color( $color ) {
	return ( 'blank' === $color ) ? 'blank' : sanitize_hex_color_no_hash( $color );
}

/** Tell WordPress to run whispy_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'whispy_setup' );

if ( ! function_exists( 'whispy_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Whispy 1.0.1
 */
function whispy_setup() {
    
    if(is_admin()) require_once('whispy_theme_menu.php');

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'large', 600, 9999 );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'whispy', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'whispy' ),
	) );

	// Allow users to set a custom background
	add_theme_support('custom-background');

	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/images/headers/greeny.png' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to whispy_header_image_width and whispy_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'whispy_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'whispy_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );


	add_theme_support('custom-header', array( 'uploads' => true ));
	
	// Options for theme customization
	if( !get_option( 'whispy_theme_settings[whispy_description_colour]' ) )


	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'greeny' => array(
			'url' => '%s/images/headers/greeny.png',
			'thumbnail_url' => '%s/images/headers/greeny-thumbnail.png',
			'description' => __( 'Greeny', 'whispy' )
		),
		'greeny2' => array(
			'url' => '%s/images/headers/greeny2.png',
			'thumbnail_url' => '%s/images/headers/greeny2-thumbnail.png',
			'description' => __( 'Greeny 2', 'whispy' )
		),
		'greeny3' => array(
			'url' => '%s/images/headers/greeny3.png',
			'thumbnail_url' => '%s/images/headers/greeny3-thumbnail.png',
			'description' => __( 'Greeny 3', 'whispy' )
		)
	) );
}
endif;

if ( ! function_exists( 'whispy_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in whispy_setup().
 *
 * @since Whispy 1.0.1
 */
function whispy_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Whispy 1.0.1
 */
function whispy_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'whispy_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Whispy 1.0.1
 * @return int
 */
function whispy_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'whispy_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Whispy 1.0.1
 * @return string "Continue Reading" link
 */
function whispy_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'whispy' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and whispy_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Whispy 1.0.1
 * @return string An ellipsis
 */
function whispy_auto_excerpt_more( $more ) {
	return ' &hellip;' . whispy_continue_reading_link();
}
add_filter( 'excerpt_more', 'whispy_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Whispy 1.0.1
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function whispy_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= whispy_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'whispy_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Whispy's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Whispy 1.0.1
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Whispy 1.0.1
 * @deprecated Deprecated in Whispy 1.0.1 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function whispy_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'whispy_remove_gallery_css' );

if ( ! function_exists( 'whispy_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own whispy_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Whispy 1.0.1
 */
function whispy_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'whispy' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'whispy' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'whispy' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'whispy' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'whispy' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'whispy' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override whispy_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Whispy 1.0.1
 * @uses register_sidebar
 */
function whispy_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'whispy' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'whispy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'whispy' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'whispy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'whispy' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'whispy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'whispy' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'whispy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'whispy' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'whispy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'whispy' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'whispy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 7, top right - above the header image
	register_sidebar( array(
		'name' => __( 'Above Header Widget Area', 'whispy' ),
		'id' => 'above-header-widget-area',
		'description' => __( 'Top right, above the header image', 'whispy' ),
		'before_widget' => '<div id="%1$s" class="alignright">',
		'after_widget' => '</div>',
		'before_title' => '<span class="hidden">',
		'after_title' => '</span>',
	) );

	// Area 8, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Primary Left Widget Area', 'whispy' ),
		'id' => 'left-primary-widget-area',
		'description' => __( 'First widget in the left column', 'whispy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 9, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Left Widget Area', 'whispy' ),
		'id' => 'left-secondary-widget-area',
		'description' => __( 'Second widget in the left column', 'whispy' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running whispy_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'whispy_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Whispy 1.0.1 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Whispy styling.
 *
 * @since Whispy 1.0.1
 */
function whispy_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'whispy_remove_recent_comments_style' );

if ( ! function_exists( 'whispy_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Whispy 1.0.1
 */
function whispy_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'whispy' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'whispy' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'whispy_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Whispy 1.0.1
 */
function whispy_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'whispy' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'whispy' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'whispy' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

if ( ! function_exists( 'whispy_title_filter' ) ) :
	function whispy_title_filter( $title, $sep ) {
		global $paged, $page, $pagename;

		if ( is_feed() )
			return $title;

		if( is_front_page() )
			return $title . get_bloginfo( 'name' );

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );
		return $title;
	}
endif;

add_filter( 'wp_title', 'whispy_title_filter', 1, 2 );