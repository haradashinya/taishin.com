    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="post-header">
            <h1 class="post-title"><?php the_title(); ?></h1>
            <?php the_post_thumbnail(); ?>
        </header>
        <div class="post-content">
        <?php the_content( __( ' <p>Continue reading <span class="meta-nav">&rarr;</span></p>', 'rockers' ) );
         wp_link_pages( 
            array( 
                'before' => '<div id="numbered-pagination">' . __( 'Pages:', 'rockers' ), 
                'after' => '</div>',
                'link_before' => '<span>',
                'link_after' => '</span>'
            )
        ); ?>
        </div>
        <footer class="post-meta">
            <?php edit_post_link( __( 'Edit', 'rockers' ), '<p><span class="edit-link">', '</span></p>' ); ?>
        </footer>
    </article>