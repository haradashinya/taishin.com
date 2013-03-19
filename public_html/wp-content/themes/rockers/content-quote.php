    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="post-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rockers' ) ); ?>
        </div>
        <footer class="post-meta">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rockers' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a>
            <?php edit_post_link( __( 'Edit', 'rockers' ), '<span class="edit-link">', '</span>' ); ?>
        </footer>
    </article>