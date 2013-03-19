    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="aside">
            <h1 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rockers' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            <div class="post-content">
                <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rockers' ) ); ?>
            </div>
        </div>
        <footer class="post-meta">
            <p><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rockers' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a></p>
            <p><?php edit_post_link( __( 'Edit', 'rockers' ), '<span class="edit-link">', '</span>' ); ?></p>
        </footer>
    </article>