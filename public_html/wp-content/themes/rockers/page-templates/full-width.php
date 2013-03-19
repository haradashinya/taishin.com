<?php 
/* 
Template Name: Full-width Page Template, No Sidebar 
*/
get_header(); ?>
    <div id="content">
        <?php while ( have_posts() ) : the_post();
            get_template_part( 'content', 'page' );
            if ( ! is_front_page() || ! is_home() || ! is_tag() && comments_open() ) : 
                comments_template( '', true );
            endif;
        endwhile; ?>
    </div>
<?php get_footer(); ?>