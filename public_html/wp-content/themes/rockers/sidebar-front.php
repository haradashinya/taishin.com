<?php if ( ! is_active_sidebar( 'sidebar-2' ) && ! is_active_sidebar( 'sidebar-3' ) )
    return; ?>
<div id="sidebar" class="aside">
    <?php if (is_active_sidebar( 'sidebar-2' ) ) : ?>
    <div class="first front-widgets">
        <?php dynamic_sidebar( 'sidebar-2' ); ?>
    </div>
    <?php endif;
    if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
    <div class="second front-widgets">
        <?php dynamic_sidebar( 'sidebar-3' ); ?>
    </div>
    <?php endif; ?>
</div>