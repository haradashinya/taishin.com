<?php 
if ( ! isset( $content_width ) )
    $content_width = 625;
function rockers_setup() {
    load_theme_textdomain( 'rockers', get_template_directory() . '/langs' );
    add_editor_style();
    add_theme_support( 'automatic-feed-links' );
    add_theme_support(
        'post-formats', array(
            'aside',
            'image',
            'link',
            'quote',
            'status'
        )
    );
    register_nav_menu( 'menu', __( 'Navigation Menu', 'rockers' ) );
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size(624, 9999);
}
add_action( 'after_setup_theme', 'rockers_setup' );

function rockers_scripts_styles() {
    if (is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );
    wp_enqueue_script( 'rockers-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );
    if ( 'off' !== _x( 'on', 'Source Sans Pro font: on or off', 'rockers' ) ) {
        $subsets = 'latin,latin-ext';
        $subset = _x( 'no-subset', 'Source Sans Pro font: add new subset (greek, cyrillic, vietnamese)', 'rockers' );

        if ( 'cyrillic' == $subset )
            $subsets .= ',cyrillic,cyrillic-ext';
        elseif ( 'greek' == $subset )
            $subsets .= ',greek,greek-ext';
        elseif ( 'vietnamese' == $subset )
            $subsets .= ',vietnamese';
        $protocol = is_ssl() ? 'https' : 'http';
        $query_args = array(
            'family' => 'Source+Sans+Pro:400italic,700italic,400,700',
            'subset' => $subsets,
        );
        wp_enqueue_style( 'rockers-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
    }
    wp_enqueue_style( 'rockers-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'rockers_scripts_styles' );

function rockers_wp_title( $title, $sep ) {
    global $paged, $page;
    if( is_feed() )
        return $title;
    $title .= get_bloginfo( 'name' );
    $site_description = get_bloginfo( 'description', 'display' );
    if( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";
    if( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'rockers' ), max( $paged, $page ) );
    return $title;
}
add_filter( 'wp_title', 'rockers_wp_title', 10, 2 );

function rockers_page_menu_args($args) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'rockers_page_menu_args' );

function rockers_excerpt_length($length) {
    return 35;
}
add_filter( 'excerpt_length', 'rockers_excerpt_length' );

function rockers_continue_reading_link() {
    return ' <p>' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rockers' ) . '</p>';
}

function rockers_auto_excerpt_more( $more ) {
    return ' &hellip;' . rockers_continue_reading_link();
}
add_filter( 'excerpt_more', 'rockers_auto_excerpt_more' );

function rockers_custom_excerpt_more($output) {
    if (has_excerpt() && ! is_attachment() ) {
        $output .= rockers_continue_reading_link();
    }
    return $output;
}
add_filter( 'get_the_excerpt', 'rockers_custom_excerpt_more' );

function rockers_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'rockers' ),
        'id' => 'sidebar-1',
        'description' => __( 'This widget will appears on posts and pages except on our optional Front page template.', 'rockers' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'First Front Page Widget Area', 'rockers' ),
        'id' => 'sidebar-2',
        'description' => __( 'This widget will appears when using the optional Front page template with a page set as Static Front page.', 'rockers' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Second Front Page Widget Area', 'rockers' ),
        'id' => 'sidebar-3',
        'description' => __( 'This widget will appears when using the optional Front Page template with a page set as Static Front Page.', 'rockers' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'rockers_widgets_init' );

if ( ! function_exists( 'rockers_content_nav' ) ) :
    function rockers_content_nav($nav_id) {
        global $wp_query;
        if ( $wp_query->max_num_pages > 1 ) : ?>
            <nav id="<?php echo $nav_id; ?>" class="navigation">
                <h3 class="accessibility"><?php _e( 'Post navigation', 'rockers' ); ?></h3>
                <div class="prev-link alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'rockers' ) ); ?></div>
                <div class="next-link alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'rockers' ) ); ?></div>
            </nav>
        <?php endif;
    }
endif;

if ( ! function_exists( 'rockers_comment' ) ) : 
    function rockers_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) : 
            case 'pingback' :
            case 'trackback' : ?>
                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <p><?php _e( 'Pingback:', 'rockers' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'rockers' ), '<span class="edit-link">', '</span>' ); ?></p>
                <?php break;
            default : 
                global $post; ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment">
                <header class="comment-meta comment-author vcard">
                    <?php echo get_avatar( $comment, 44 );
                        printf( '<cite class="fn">%1$s %2$s</cite>',
                            get_comment_author_link(),
                            ( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'rockers' ) . '</span>' : ''
                        );
                        printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                            esc_url( get_comment_link( $comment->comment_ID ) ),
                            get_comment_time( 'c' ),
                            sprintf( __( '%1$s at %2$s', 'rockers' ), get_comment_date(), get_comment_time() )
                        ); ?>
                </header>
                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'rockers' ); ?></p>
                <?php endif; ?>
                <section class="comment-content comment">
                    <?php comment_text();
                    edit_comment_link( __( 'Edit', 'rockers' ), '<p class="edit-link">', '</p>' ); ?>
                </section>
                <div class="reply">
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'rockers' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div>
                </article>
            <?php break;
        endswitch;
    }
endif;

if ( ! function_exists( 'rockers_entry_meta' ) ) : 
    function rockers_entry_meta() {
        $categories_list = get_the_category_list( __( ', ', 'rockers' ) );
        $tag_list = get_the_tag_list( '', __( ', ', 'rockers' ) );
        $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="post-date" datetime="%3$s" pubdate>%4$s</time></a>',
            esc_url( get_permalink() ),
            esc_attr( get_the_time() ),
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() )
        );
        $author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'rockers' ), get_the_author() ) ),
            get_the_author()
        );
        if ($tag_list) {
            $utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'rockers' );
        } elseif ($categories_list) {
            $utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'rockers' );
        } else {
            $utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'rockers' );
        }
        printf(
            $utility_text,
            $categories_list,
            $tag_list,
            $date,
            $author
        );
    }
endif;

function rockers_body_class($classes) {
    if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
        $classes[] = 'full-width';
    if (is_page_template( 'page-templates/front-page.php' ) ) {
        $classes[] = 'template-front-page';
        if (has_post_thumbnail() )
            $classes[] = 'has-post-thumbnail';
        if (is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
            $classes[] = 'two-sidebars';
    }
    if (wp_style_is( 'rockers-fonts', 'queue' ) )
        $classes[] = 'custom-font-enabled';
    if ( ! is_multi_author() )
        $classes[] = 'single-author';
    return $classes;
}
add_filter( 'body_class', 'rockers_body_class' );

function rockers_content_width() {
    if (is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
        global $content_width;
        $content_width = 960;
    }
}
add_action( 'template_redirect', 'rockers_content_width' );

function rockers_customize_register($wp_customize) {
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'rockers_customize_register' );

function rockers_customize_preview_js() {
    wp_enqueue_script( 'rockers-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', TRUE);
}
add_action( 'customize_preview_init', 'rockers_customize_preview_js' );