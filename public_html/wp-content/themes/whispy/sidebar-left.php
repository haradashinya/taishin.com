<?php
/**
 * The Left sidbar on a three column template

 */
?>
		<div id="left-column">
    		<div id="left-primary" class="widget-area" role="complementary">
    			<ul class="xoxo">
    
    <?php
    	if ( ! dynamic_sidebar( 'left-primary-widget-area' ) ) : ?>
    
    			<li id="recentposts" class="widget-container">
    				<h3 class="widget-title"><?php _e( 'Recent Posts', 'whispy' ); ?></h3>
    				<ul>
    					<?php
    					$args = array( 'numberposts' => '5' );
    					$recent_posts = wp_get_recent_posts( $args );
    					foreach( $recent_posts as $recent ){
    						print '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
    					} ?>
    				</ul>
    			</li>
    
    			<li id="calendar" class="widget-container">
    				<h3 class="widget-title"><?php _e( 'Calendar', 'whispy' ); ?></h3>
    					<?php get_calendar(); ?>
    			</li>
    
    		<?php endif; // end primary widget area ?>
    			</ul>
    		</div><!-- #primary .widget-area -->
    
    <?php
    	// Second widget area
    	if ( is_active_sidebar( 'left-secondary-widget-area' ) ) : ?>
    
    		<div id="left-secondary" class="widget-area" role="complementary">
    			<ul class="xoxo">
    				<?php dynamic_sidebar( 'left-secondary-widget-area' ); ?>
    			</ul>
    		</div><!-- #secondary .widget-area -->

<?php endif; ?>
		</div>
