<?php get_header(); ?>
    <div id="content">
        <?php if ( have_posts() ) : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'rockers' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>
                <?php if ( category_description() ) : ?>
                    <div class="archive-meta"><?php echo category_description(); ?></div>
                <?php endif; ?>
            </header>
            <?php while ( have_posts() ) : the_post();
                get_template_part( 'content', get_post_format() );
            endwhile;
            rockers_content_nav( 'pagination-bottom' );
            else : 
                get_template_part( 'content', 'none' );
        endif; ?>
    </div>
<?php get_sidebar();
get_footer(); ?>