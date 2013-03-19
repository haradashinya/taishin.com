<?php get_header(); ?>
    <div id="content">
        <?php while ( have_posts() ) : the_post();
            get_template_part( 'content', 'page' );
            comments_template( '', TRUE);
        endwhile; ?>
    </div>
<?php get_sidebar();
get_footer(); ?>