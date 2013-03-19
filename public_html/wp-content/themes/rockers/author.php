<?php get_header(); ?>
    <div id="content">
        <?php if ( have_posts() ) : 
            the_post(); ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php printf( __( 'Author Archives: %s', 'rockers' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
            </header>
            <?php rewind_posts();
            rockers_content_nav( 'pagination-top' );
            if ( get_the_author_meta( 'description' ) ) : ?>
            <div class="author-info">
                <div class="author-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'rockers_author_bio_avatar_size', 60 ) ); ?>
                </div>
                <div class="author-description">
                    <h2><?php printf( __( 'About %s', 'rockers' ), get_the_author() ); ?></h2>
                    <p><?php the_author_meta( 'description' ); ?></p>
                </div>
            </div>
            <?php endif;
            while ( have_posts() ) : the_post();
                get_template_part( 'content', get_post_format() );
            endwhile;
            rockers_content_nav( 'pagination-bottom' );
            else : 
                get_template_part( 'content', 'none' );
            endif; ?>
    </div>
<?php get_sidebar();
get_footer(); ?>