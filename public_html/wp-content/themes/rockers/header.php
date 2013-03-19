<!DOCTYPE html>
<!--[if IE 7 | IE 8]>
<html class="ie" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!--[if lt IE 9]> <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script> <![endif]-->
    <!--[if IE]> <script src="<?php echo get_template_directory_uri(); ?>/js/css3-mediaqueries.js" type="text/javascript"></script> <![endif]-->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="page" class="hfeed site">
    <header id="header" class="blog-header">
        <hgroup>
            <h1 class="blog-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <h2 class="blog-description"><?php bloginfo( 'description' ); ?> | <a href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php _e( 'Subscribe to the RSS Feed of this site', 'rockers' ); ?>" id="rss">RSS</a></h2>
        </hgroup>
        <nav id="blog-menu" class="menu">
            <h3 class="menu-toggle"><?php _e( 'Menu', 'rockers' ); ?></h3>
            <div class="skip-link accessibility"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'rockers' ); ?>"><?php _e( 'Skip to content', 'rockers' ); ?></a></div>
            <?php wp_nav_menu(
                array( 
                    'container' => '',
                    'theme_location' => 'menu', 
                    'menu_class' => 'nav-menu',
                    'depth' => 1
                )
            ); ?>
        </nav>
    </header>
    <div id="main" class="wrapper">