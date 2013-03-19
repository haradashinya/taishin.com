<?php get_header(); ?>
    <div id="wrapper" class="content">
        <div id="content">
            <article id="post-0" class="post error404 no-results not-found">
                <header class="post-header">
                    <h1 class="post-title"><?php _e( 'Error: page not found.', 'rockers' ); ?></h1>
                </header>
                <div class="post-content">
                    <p><?php _e( 'Sorry, but nothing is found. Please try again using a different search term.', 'rockers' ); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </article>
        </div>
    </div>
<?php get_footer(); ?>