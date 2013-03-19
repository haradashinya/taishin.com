<?php 
get_header(); ?>
    <div id="content">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
                <header class="post-header">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    <footer class="post-meta">
                        <?php $metadata = wp_get_attachment_metadata();
                            printf( __( '<span class="meta-prep meta-prep-post-date">Published </span> <span class="post-date"><time class="post-date" datetime="%1$s" pubdate>%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>.', 'rockers' ),
                                esc_attr( get_the_date( 'c' ) ),
                                esc_html( get_the_date() ),
                                esc_url( wp_get_attachment_url() ),
                                $metadata['width'],
                                $metadata['height'],
                                esc_url( get_permalink( $post->post_parent ) ),
                                esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
                                get_the_title( $post->post_parent )
                            );
                        edit_post_link( __( 'Edit', 'rockers' ), '<span class="edit-link">', '</span>' ); ?>
                    </footer>
                    <nav id="image-navigation" class="navigation">
                        <ul>
                            <li class="previous-image"><?php previous_image_link( false, __( '&larr; Previous', 'rockers' ) ); ?></li>
                            <li class="next-image"><?php next_image_link( false, __( 'Next &rarr;', 'rockers' ) ); ?></li>
                        </ul>
                    </nav>
                </header>
                <div class="post-content">
                    <div class="post-attachment">
                        <div class="attachment">
                            <?php $attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
                            foreach ( $attachments as $k => $attachment ) : 
                                if ( $attachment->ID == $post->ID )
                                break;
                            endforeach;
                            $k++;
                            if ( count( $attachments ) > 1 ) : 
                                if (isset( $attachments[ $k ] ) ) : 
                                    $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
                                else : 
                                    $next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
                                endif;
                                else : 
                                    $next_attachment_url = wp_get_attachment_url();
                            endif; ?>
                            <a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
                            <?php $attachment_size = apply_filters( 'rockers_attachment_size', array( 960, 960 ) );
                            echo wp_get_attachment_image( $post->ID, $attachment_size ); ?></a>
                            <?php if ( ! empty( $post->post_excerpt ) ) : ?>
                                <div class="post-caption">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="post-description">
                        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rockers' ) );
                        wp_link_pages( 
                            array( 
                                'before' => '<div id="numbered-pagination">' . __( 'Pages:', 'rockers' ), 
                                'after' => '</div>', 
                                'link_before' => '<span>', 
                                'link_after' => '</span>'
                            )
                        ); ?>
                    </div>
                </div>
            </article>
            <?php comments_template();
        endwhile; ?>
    </div>
<?php get_footer(); ?>