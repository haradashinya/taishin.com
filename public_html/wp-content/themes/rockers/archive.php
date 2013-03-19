<?php get_header(); ?>
    <section id="wrapper" class="content">
        <div id="content">
        <?php if ( have_posts() ) : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php
                if ( is_day() ) :
                    printf( __( 'Daily Archives: %s', 'rockers' ), '<span>' . get_the_date() . '</span>' );
                elseif ( is_month() ) :
                    printf( __( 'Monthly Archives: %s', 'rockers' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'rockers' ) ) . '</span>' );
                elseif ( is_year() ) :
                    printf( __( 'Yearly Archives: %s', 'rockers' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'rockers' ) ) . '</span>' );
                else :
                    _e( 'Archives', 'rockers' );
                endif; ?></h1>
            </header>
            <?php while ( have_posts() ) : the_post();
                get_template_part( 'content', get_post_format() );
            endwhile;
            rockers_content_nav( 'pagination-bottom' );
            else : 
                get_template_part( 'content', 'none' );
        endif; ?>
        </div>
    </section>
<?php get_sidebar();
get_footer(); ?>