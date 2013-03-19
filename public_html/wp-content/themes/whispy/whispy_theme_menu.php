<?php

/** Trigger Whispy theme menu at admin_menu hook **/
add_action('admin_menu', 'whispy_theme_menu');
add_action('admin_init', 'whispy_register_settings');

if( ! function_exists( 'whispy_theme_menu' ) ) :

function whispy_theme_menu() {
    add_theme_page( 'Whispy Customization Options', 'Whispy options', 'read', 'whispy-theme-options', 'whispy_theme_options' );
}
endif;

if( ! function_exists( 'whispy_theme_options' ) ) :
/**
 * Theme options page under 'Appearance' menu in dashboard
 * 
 * @since Whispy 1.0.1
 */
function whispy_theme_options() {
    // Check that the user is allowed to update options  
    if (!current_user_can('manage_options')) wp_die('You do not have sufficient permissions to access this page.'); 
    ?>
    <div class="wrap">
    	<?php screen_icon('themes'); ?> <h2>Whispy Theme Settings</h2>
        <div class="postbox" style="padding: 10px;margin-top:20px">
            <b>Note:</b> 
        <?php
        $wpVer = 0 + implode( '', array_slice( explode( '.', get_bloginfo('version') ), 0, 2 ));
        // Check if customize interface is there
        if( $wpVer >= 34 ) {
            ?>Many options for this theme are now configurable through the <a href="<?php echo get_admin_url(); ?>customize.php">theme customizer interface</a>. We suggest that you use that instead.
        <?php
        }
        else echo 'We recommend upgrading your WordPress install to the latest version, to get the most from this theme.'
        ?>
        </div>
        <form method="POST" action="options.php">
        <?php
        settings_fields('whispy_theme_settings');
        $settings = get_option('whispy_theme_settings' );
        ?>
            <table class="form-table">  
            <tr valign="top">  
            	<th scope="row">  
                    <label for="whispy_title_colour">  
                    	Site title text colour:
                    </label>  
                </th>  
                <td>  
                	# <input type="text" name="whispy_theme_settings[whispy_title_colour]" value="<?php echo get_header_textcolor(); ?>" size="6" />  
                </td>  
            </tr>  
            <tr valign="top">  
            	<th scope="row">  
                    <label for="whispy_description_colour">  
                    	Site description text colour:
                    </label>  
                </th>  
                <td>  
                	# <input type="text" id="whispy_description_colour" name="whispy_theme_settings[whispy_description_colour]" value="<?php print get_option( 'whispy_description_colour' ); ?>" size="6" /> 
                </td>  
            </tr>  
            <tr valign="top">  
            	<th scope="row">
                    	Posts index page layout:
                </th>  
                <td>
						<label for="postsIndex2col">
							<input type="radio" name="whispy_theme_settings[colspost-index]" id="postsIndex2col" value="2"<?php if( $settings['colspost-index'] == '2' ) echo ' checked="checked"';?>> 2 columns</label><br>
						<label for="postsIndex3col">
							<input type="radio" name="whispy_theme_settings[colspost-index]" id="postsIndex3col"value="3"<?php if( $settings['colspost-index'] == '3' ) echo ' checked="checked"';?>> 3 columns</label>
                </td>  
            </tr>  
            <tr valign="top">  
            	<th scope="row">
                    	Posts layout:
                </th>  
                <td>
						<label for="postsColsLayout2">
							<input type="radio" name="whispy_theme_settings[colspost-post]" id="postsColsLayout2" value="2"<?php if( $settings['colspost-post'] == '2' ) echo ' checked="checked"';?>> 2 columns</label><br>
						<label for="postsColsLayout3">
							<input type="radio" name="whispy_theme_settings[colspost-post]" id="postsColsLayout3" value="3"<?php if( $settings['colspost-post'] == '3' ) echo ' checked="checked"';?>> 3 columns</label>
                </td>  
            </tr>
            </table>
            <p class="submit">
            <input type="submit" name="save-background-options" id="save-background-options" class="button-primary" value="Save Changes"></p>
        </form>  
    </div>
<?php
}
endif;

/**
 * Register theme options
 * 
 * @since Whispy 1.0.1
 */
function whispy_register_settings() {
    // Serialise the settings
    register_setting( 'whispy_theme_settings', 'whispy_theme_settings', 'whispy_option_validate' );
    $settings = get_option('whispy_theme_settings' );
    if( empty($settings['whispy_description_colour'] ) )
    {
        $settings['whispy_description_colour'] = 'fff';
        update_option( 'whispy_theme_settings', $settings );
    }
    // 2 or 3 columns for posts pages
    if( empty($settings['colspost-index'] ) )
    {
        $settings['colspost-index'] = '2';
        update_option( 'whispy_theme_settings', $settings );
    }
    if( empty($settings['colspost-post'] ) )
    {
        $settings['colspost-post'] = '2';
        update_option( 'whispy_theme_settings', $settings );
    }
}

/**
 * Validate theme options
 * 
 * @since Whispy 1.0.1
 */
function whispy_option_validate( $input ) {
    $validated = array();

    if( isset( $input['whispy_description_colour'] ) )
   {
   	$validated['whispy_description_colour'] = isHexCol( $input['whispy_description_colour'] );
 	}
     
    if( isset( $input['whispy_title_colour'] ) )
        $validated['whispy_title_colour'] = isHexCol( $input['whispy_title_colour'] );
	if( $validated['whispy_title_colour'])
	{
   	$wto = get_option( 'theme_mods_whispy' );
   	$wto['header_textcolor'] = $validated['whispy_title_colour'];
		update_option( 'theme_mods_whispy', $wto );
	}

    if( ($cpi = $input['colspost-index']) )
	    if( $cpi == '2' || $cpi == '3' ) $validated['colspost-index'] = $cpi;

    if( ($cpp = $input['colspost-post']) )
	    if( $cpp == '2' || $cpp == '3' ) $validated['colspost-post'] = $cpp;

    return $validated;
}

function isHexCol( $str )
{
	if( preg_match('/^([A-Fa-f0-9]{3}){1,2}$/', $str ) )
		return $str;
	return null;
}