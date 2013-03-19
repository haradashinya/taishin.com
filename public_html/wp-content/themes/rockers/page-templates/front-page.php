<?php 
/* 
Template Name: Front Page Template 
*/
get_header(); ?>
    <div id="content">
        <?php while ( have_posts() ) : the_post();
            if (has_post_thumbnail() ) : ?>
                <div class="post-page-image">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif;
            get_template_part( 'content', 'page' );
        endwhile; ?>
    </div>
<?php get_sidebar( 'front' );
get_footer(); ?>