    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="post-header">
            <?php if( ! is_sticky() ) : ?>
                <p><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rockers' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail(); ?></a></p>
            <?php endif;
            if ( is_single() ) : ?>
                <h1 class="post-title"><?php the_title(); ?></h1>
            <?php else : ?>
                <h1 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rockers' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            <?php endif; ?>
        </header>
        <?php if ( is_search() ) : ?>
            <div class="post-summary">
                <?php the_excerpt(); ?>
            </div>
        <?php else : ?>
        <div class="post-content">
            <?php the_content( __( '<p>Continue reading <span class="meta-nav">&rarr;</span></p>', 'rockers' ) );
            wp_link_pages( 
                array( 
                    'before' => '<div id="numbered-pagination">' . __( 'Pages:', 'rockers' ), 
                    'after' => '</div>',
                    'link_before' => '<span>',
                    'link_after' => '</span>'
                )
            );
            if ( ! is_front_page() || ! is_home() || ! is_tag() && comments_open() ) : ?>
                <div class="comments-link">
                    <?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'rockers' ) . '</span>', __( '1 Reply', 'rockers' ), __( '% Replies', 'rockers' ) ); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <footer class="post-meta">
            <?php rockers_entry_meta();
            edit_post_link( __( 'Edit', 'rockers' ), '<span class="edit-link">', '</span>' );
            if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
                <div class="author-info">
                    <div class="author-avatar">
                        <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'rockers_author_bio_avatar_size', 68 ) ); ?>
                    </div>
                    <div class="author-description">
                        <h2><?php printf( __( 'About %s', 'rockers' ), get_the_author() ); ?></h2>
                        <p><?php the_author_meta( 'description' ); ?></p>
                        <p class="author-link"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'rockers' ), get_the_author() ); ?></a></p>
                    </div>
                </div>
            <?php endif; ?>
        </footer>
    </article>