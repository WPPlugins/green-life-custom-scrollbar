<?php
/**
 * @package Green_Life_Custom_Scrollbar
 * @author Md. Asiqur Rahman
 * @version 1.1
 */
/**
  Plugin Name: Green Life Custom Scrollbar
  Plugin URI: http://greenlifeit.com/plugins
  Description: Modern and sexy scrollbar for desktop and mobile browsers from Green Life IT. You can customize the scrollbar as you want.
  Author: Md. Asiqur Rahman
  Version: 1.1
  Author URI: http://asique.greenlifeit.com
  License: GPLv2 or later
  License URI: http://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: glcs
 */
defined('ABSPATH') or die('<h1 style="text-align: center">Ha Ha Ha!<h1>');

/**
 * Load plugin textdomain.
 * @since 1.0
 */
function gl_cs_load_textdomain() {
    load_plugin_textdomain('glcs', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

add_action('plugins_loaded', 'gl_cs_load_textdomain');

/*
 * Add default setting values on Plugin Activation  
 */

function gl_scrollbar_default_options() {
    add_option('gl_scrollbar_show', 'show');
    add_option('gl_scrollbar_width', '8px');
    add_option('gl_scrollbar_bgcolor', '#d6d6d6');
    add_option('gl_scrollbar_cursor_color', '#000');
    add_option('gl_scrollbar_cursor_radius', '4px');
    add_option('gl_scrollbar_speed', '60');
    add_option('gl_scrollbar_opacity', '.8');
    add_option('gl_scrollbar_autohide', 'false');
    add_option('gl_scrollbar_autohide_delay', '2000');
    add_option('gl_scrollbar_show_admin', 'hide');
    add_option('gl_scrollbar_force_default', 'false');
}

register_activation_hook(__FILE__, 'gl_scrollbar_default_options');

/*
 * Delete setting and values on Plugin Deactivation
 */

function gl_scrollbar_remove_options() {
    delete_option('gl_scrollbar_show');
    delete_option('gl_scrollbar_width');
    delete_option('gl_scrollbar_bgcolor');
    delete_option('gl_scrollbar_cursor_color');
    delete_option('gl_scrollbar_cursor_radius');
    delete_option('gl_scrollbar_speed');
    delete_option('gl_scrollbar_opacity');
    delete_option('gl_scrollbar_autohide');
    delete_option('gl_scrollbar_autohide_delay');
    delete_option('gl_scrollbar_show_admin');
    delete_option('gl_scrollbar_force_default');
}

register_deactivation_hook(__FILE__, 'gl_scrollbar_remove_options');

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links');

function add_action_links($links) {
    $mylinks = array('<a href="' . admin_url('options-general.php?page=gl-cs') . '" title="Green Life Custom Scrollbar Options">' . __('Options') . '</a>',);
    return array_merge($links, $mylinks);
}

/*
 * Register settings for this Plugin
 */

function gl_scrollbar_register_options() {
    register_setting('gl-scrollbar-options', 'gl_scrollbar_show');
    register_setting('gl-scrollbar-options', 'gl_scrollbar_width');
    register_setting('gl-scrollbar-options', 'gl_scrollbar_bgcolor');
    register_setting('gl-scrollbar-options', 'gl_scrollbar_cursor_color');
    register_setting('gl-scrollbar-options', 'gl_scrollbar_cursor_radius');
    register_setting('gl-scrollbar-options', 'gl_scrollbar_speed');
    register_setting('gl-scrollbar-options', 'gl_scrollbar_opacity');
    register_setting('gl-scrollbar-options', 'gl_scrollbar_autohide');
    register_setting('gl-scrollbar-options', 'gl_scrollbar_autohide_delay');
    register_setting('gl-scrollbar-options', 'gl_scrollbar_show_admin');
    register_setting('gl-scrollbar-options', 'gl_scrollbar_force_default');
}

add_action('admin_init', 'gl_scrollbar_register_options');

/*
 * Add Options Page to admin area
 */

function gl_scrollbar_admin_menu_page() {
    add_options_page(__('Green Life Custom Scrollbar', 'glcs'), __('Gl Scrollbar', 'glcs'), 'manage_options', 'gl-cs', 'gl_scrollbar_options_display');
}

add_action('admin_menu', 'gl_scrollbar_admin_menu_page');

/*
 * Add script and stylesheet to admin area for this Plugin
 */

function gl_scrollbar_admin_color_picker() {
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('wp-admin-activation', plugins_url('js/admin-options-active.js', __FILE__), array('jquery', 'wp-color-picker'), false, true);
    wp_enqueue_style('wp-color-picker');
    if (get_option('gl_scrollbar_show_admin') == "show") {
        wp_enqueue_script('gl-cs', plugins_url('/js/jquery.nicescroll.min.js', __FILE__), array('jquery'), '3.4', true);
    }
}

add_action('admin_enqueue_scripts', 'gl_scrollbar_admin_color_picker', 20);

/*
 * Display options to admin area
 */

function gl_scrollbar_options_display() {
    $gl_o1 = $gl_o2 = $gl_o3 = $gl_o4 = $gl_o11 = $gl_o22 = $gl_o33 = $gl_o44 = '';
    ?>
    <div class="wrap" style="min-height: 800px;">
        <h2><?php _e('Green Life Custom Scrollbar Options', 'glcs'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('gl-scrollbar-options'); ?>
            <?php do_settings_sections('gl-scrollbar-options'); ?>
            <table class="form-table scrollbar-option-table">
                <tr class="show">
                    <th><label for="gl_scrollbar_show"><?php _e('Show Custom Scrollbar', 'glcs'); ?></label></th>
                    <?php 'show' == get_option('gl_scrollbar_show') ? $gl_o1 = 'checked="checked"' : $gl_o11 = 'checked="checked"'; ?>
                    <td>
                        <fieldset>
                            <label title="Show"><input type="radio" name="gl_scrollbar_show" value="show" <?php echo $gl_o1; ?>><?php _e('Show', 'glcs'); ?></label><br />
                            <label title="Hide"><input type="radio" name="gl_scrollbar_show" value="hide" <?php echo $gl_o11; ?>><?php _e('Hide', 'glcs'); ?></label>
                        </fieldset>
                        <p class="description"><?php _e('Check Show or Hide to Enable or Disable Custom Scrollbar.', 'glcs'); ?></p>
                    </td>
                </tr>
                <tr  class="show">
                    <th><label for="gl_scrollbar_show_admin"><?php _e('Show Custom Scrollbar in Admin Area', 'glcs'); ?></label></th>
                    <?php 'show' == get_option('gl_scrollbar_show_admin') ? $gl_o3 = 'checked="checked"' : $gl_o33 = 'checked="checked"'; ?>
                    <td>
                        <fieldset>
                            <label title="Show"><input type="radio" name="gl_scrollbar_show_admin" value="show" <?php echo $gl_o3; ?>><?php _e('Show', 'glcs'); ?></label><br />
                            <label title="Hide"><input type="radio" name="gl_scrollbar_show_admin" value="hide" <?php echo $gl_o33; ?>><?php _e('Hide', 'glcs'); ?></label>
                        </fieldset>
                        <p class="description"><?php _e('Check Show or Hide to Enable or Disable Custom Scrollbar in Admin Area.', 'glcs'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="gl_scrollbar_width"><?php _e('Scrollbar Width', 'glcs'); ?></label></th>
                    <td>
                        <input type="text" name="gl_scrollbar_width"  id="gl_scrollbar_width" value="<?php echo get_option('gl_scrollbar_width'); ?>" />
                        <p class="description"><?php _e('Change Scrollbar Width in Pixel, Default Value is', 'glcs'); echo ' <strong>8px</strong>.'; ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="gl_scrollbar_bgcolor"><?php _e('Scrollbar Background Color', 'glcs'); ?></label></th>
                    <td>
                        <input type="text" name="gl_scrollbar_bgcolor"  id="gl_scrollbar_bgcolor" value="<?php echo stripslashes(get_option('gl_scrollbar_bgcolor')); ?>"  />
                        <p class="description"><?php _e('Pick scrollbar background color. Default color is', 'glcs');  echo ' <strong>#d6d6d6</strong>.' ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="gl_scrollbar_cursor_color"><?php _e('Scrollbar Cursor Color', 'glcs'); ?></label></th>
                    <td>
                        <input type="text" name="gl_scrollbar_cursor_color"  id="gl_scrollbar_cursor_color" value="<?php echo stripslashes(get_option('gl_scrollbar_cursor_color')); ?>" />
                        <p class="description"><?php _e('Pick scrollbar Cursor color. Default color is', 'glcs');  echo ' <strong>#000</strong>.'; ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="gl_scrollbar_cursor_radius"><?php _e('Cursor Border Radius', 'glcs'); ?></label></th>
                    <td>
                        <input type="text" name="gl_scrollbar_cursor_radius"  id="gl_scrollbar_cursor_radius" value="<?php echo get_option('gl_scrollbar_cursor_radius'); ?>" />
                        <p class="description"><?php _e('Change Scrollbar Cursor Border Radius in pixel. Default Value is', 'glcs');  echo ' <strong>4px</strong>.'; ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="gl_scrollbar_speed"><?php _e('Scrolling Speed', 'glcs'); ?></label></th>
                    <td>
                        <input type="text" name="gl_scrollbar_speed"  id="gl_scrollbar_speed" value="<?php echo get_option('gl_scrollbar_speed'); ?>" />
                        <p class="description"><?php _e('Change Scrolling Speed. Default Value is', 'glcs');  echo ' <strong>60</strong>.'; ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="gl_scrollbar_opacity"><?php _e('Scrollbar Opacity', 'glcs'); ?></label></th>
                    <td>
                        <input type="text" name="gl_scrollbar_opacity"  id="gl_scrollbar_opacity" value="<?php echo get_option('gl_scrollbar_opacity'); ?>" />
                        <p class="description"><?php _e('Change Scrollbar Opacity. Range from 0 to 1, Default Value is', 'glcs');  echo ' <strong>.8</strong>'; ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="gl_scrollbar_autohide"><?php _e('Auto Hide Scrollbar', 'glcs'); ?></label></th>
                    <?php 'true' == get_option('gl_scrollbar_autohide') ? $gl_o2 = 'checked="checked"' : $gl_o22 = 'checked="checked"'; ?>
                    <td>
                        <fieldset>
                            <label title="enable"><input type="radio" name="gl_scrollbar_autohide" value="true" <?php echo $gl_o2; ?>><?php _e('Enable', 'glcs'); ?></label><br />
                            <label title="disable"><input type="radio" name="gl_scrollbar_autohide" value="false" <?php echo $gl_o22; ?>><?php _e('Disable', 'glcs'); ?></label>
                        </fieldset>
                    </td>
                </tr>
                <tr class="auto-hide-delay">
                    <th><label for="gl_scrollbar_autohide_delay"><?php _e('Auto Hide Delay', 'glcs'); ?></label></th>
                    <td>
                        <input type="text" name="gl_scrollbar_autohide_delay"  id="gl_scrollbar_autohide_delay" value="<?php echo get_option('gl_scrollbar_autohide_delay'); ?>" />
                        <p class="description"><?php _e('Change Auto Hide Delay time in Microseconds to Fading out Scrollbar. Default value is', 'glcs');  echo ' <strong>2000</strong>.'; ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="gl_scrollbar_force_default"><?php _e('Force to Hide Default Scrollbar', 'green-life-custom-scrollbar'); ?></label></th>
                    <?php 'true' == get_option('gl_scrollbar_force_default') ? $gl_o4 = 'checked="checked"' : $gl_o44 = 'checked="checked"'; ?>
                    <td>
                        <fieldset>
                            <label title="enable"><input type="radio" name="gl_scrollbar_force_default" value="true" <?php echo $gl_o4; ?>><?php _e('Enable', 'green-life-custom-scrollbar'); ?></label><br />
                            <label title="disable"><input type="radio" name="gl_scrollbar_force_default" value="false" <?php echo $gl_o44; ?>><?php _e('Disable', 'green-life-custom-scrollbar'); ?></label>
                        </fieldset>
                        <p class="description"><?php _e('if normally default scrollbar didn\'t hide then Enable it. Default Value is', 'glcs');  echo '<strong>Disable</strong>.'; ?></p>
                    </td>
                </tr>
                <tr  class="show">
                    <td colspan="2"><?php submit_button(); ?></td>
                </tr>
            </table>
        </form>
    </div>
    <?php
}

/*
 * Add Js to site
 */

function gl_scrollbar_scripts() {
    wp_enqueue_script('gl-cs', plugins_url('/js/jquery.nicescroll.min.js', __FILE__), array('jquery'), '3.4', true);
}

/*
 * Update user options and add them to page footer
 */

function gl_scrollbar_activation_script() {
    if (get_option("gl_scrollbar_autohide") == "true") {
        $hidecursordelay = 'hidecursordelay: ' . get_option("gl_scrollbar_autohide_delay");
    } else {
        $hidecursordelay = "";
    }
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var nice = jQuery("body").niceScroll({
                cursorwidth: "<?php echo get_option("gl_scrollbar_width"); ?>",
                background: "<?php echo get_option("gl_scrollbar_bgcolor"); ?>",
                cursorcolor: "<?php echo get_option("gl_scrollbar_cursor_color"); ?>",
                cursorborderradius: "<?php echo get_option("gl_scrollbar_cursor_radius"); ?>",
                scrollspeed: "<?php echo get_option("gl_scrollbar_speed"); ?>",
                cursoropacitymax: <?php echo get_option("gl_scrollbar_opacity") ?>,
                autohidemode: <?php echo get_option("gl_scrollbar_autohide"); ?>,
                cursorborder: "none",
                bouncescroll: true,
                smoothscroll: true,
                <?php echo $hidecursordelay . "\n"; ?>
            });
            jQuery('#ascrail2000').css('zIndex', '99999');
        });
    </script>
    <?php
}

function gl_scrollbar_activation_script2() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('html, body').css('overflowY', 'hidden', 'important');
        });
    </script>
    <?php
}

/*
 * Add scripts to footer 
 */

if (get_option('gl_scrollbar_show') == "show") {
    add_action('wp_enqueue_scripts', 'gl_scrollbar_scripts', 20);
    add_action('wp_footer', 'gl_scrollbar_activation_script', 100);
}

if (get_option("gl_scrollbar_force_default") == "true") {
    add_action('wp_footer', 'gl_scrollbar_activation_script2', 100);
}

/*
 * Active Plugin in admin area
 */
if (get_option('gl_scrollbar_show_admin') == "show") {
    add_action('in_admin_footer', 'gl_scrollbar_activation_script', 100);
}
