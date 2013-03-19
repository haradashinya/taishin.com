<?php get_header(); ?>
    <div id="content">
        <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'rockers' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </header>
            <?php rockers_content_nav( 'pagination-top' );
            while ( have_posts() ) : the_post();
                get_template_part( 'content', get_post_format() );
            endwhile;
            rockers_content_nav( 'pagination-bottom' );
            else : ?>
            <article id="post-0" class="post no-results not-found">
                <header class="post-header">
                    <h1 class="post-title"><?php _e( 'Nothing Found', 'rockers' ); ?></h1>
                </header>
                <div class="post-content">
                    <p><?php _e( 'Sorry, but nothing is found. Please try again using a different search term.', 'rockers' ); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </article>
        <?php endif; ?>
    </div>
<?php get_sidebar();
get_footer(); ?>