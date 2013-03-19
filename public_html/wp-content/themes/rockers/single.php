<?php get_header(); ?>
    <div id="content">
        <?php while ( have_posts() ) : the_post();
            get_template_part( 'content', get_post_format() ); ?>
            <nav class="single-pagination">
                <h3 class="accessibility"><?php _e( 'Post navigation', 'rockers' ); ?></h3>
                <ul>
                    <li class="prev-link"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'rockers' ) . '</span> %title' ); ?></li>
                    <li class="next-link"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'rockers' ) . '</span>' ); ?></li>
                </ul>
            </nav>
            <?php if ( comments_open() || '0' != get_comments_number() )
                comments_template( '', true );
        endwhile; ?>
    </div>
<?php get_sidebar();
get_footer(); ?>