    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="post-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rockers' ) ); ?>
        </div>
        <footer class="post-meta">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rockers' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                <h1><?php the_title(); ?></h1>
                <h2><time class="post-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" pubdate><?php echo get_the_date(); ?></time></h2>
                <?php edit_post_link( __( 'Edit', 'rockers' ), '<span class="edit-link">', '</span>' ); ?></a>
        </footer>
    </article>