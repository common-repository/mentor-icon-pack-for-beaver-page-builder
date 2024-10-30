<?php
/**
 * Plugin Name: Mentor Icon Pack for Beaver Page Builder
 * Description: This is a icon pack addon for beaver page builder. 
 * Plugin URI:  https://github.com/twinkletheme/mentor-icon-pack-for-beaver-page-builder
 * Version:     1.0.0
 * Author:      TwinkleTheme
 * Author URI:  https://codecanyon.net/user/twinkletheme
 * Text Domain: mentor-icon-pack
 */

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'MENTOR_ICON_PACK_VERSION', '1.0.0' );
define( 'MENTOR_ICON_PACK_ROOT', __FILE__ );
define( 'MENTOR_ICON_PACK_PATH', plugin_dir_path( MENTOR_ICON_PACK_ROOT ) );
define( 'MENTOR_ICON_PACK_URL', plugin_dir_url( MENTOR_ICON_PACK_ROOT ) );
define( 'MENTOR_ICON_PACK_ASSETS', trailingslashit( MENTOR_ICON_PACK_URL . 'assets/' ) );
define( 'MENTOR_ICON_PACK_PLUGIN_BASE', plugin_basename( MENTOR_ICON_PACK_ROOT ) );

final class Mentor_Icon_Pack {

    public function __construct() {
        add_action( 'plugins_loaded', [$this, 'init'] );
    }

    public function init() {
        $this->include_files();
        add_action( 'wp_enqueue_scripts', array( $this, 'mentor_assets' ), 5 );
        add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
    }

    function mentor_assets() {
        wp_enqueue_style( 'materialdesignicons', MENTOR_ICON_PACK_URL . 'assets/css/materialdesignicons.min.css', array(), '1.0.0' );
    }

    public function admin_notice_missing_main_plugin() {
        if ( !is_admin() ) {
            return;
        } elseif ( !is_user_logged_in() ) {
            return;
        } elseif ( !current_user_can( 'update_core' ) ) {
            return;
        }

        if ( !is_plugin_active( 'bb-plugin/fl-builder.php' ) ) {
            if ( !is_plugin_active( 'beaver-builder-lite-version/fl-builder.php' ) ) {
                echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html__( 'Mentor Icon Pack For Beaver Builder requires "Beaver Builder" to be installed and activated.', 'mentor-icon-pack' ) );
            }
        }
    }

	public function include_files() {
        include_once( MENTOR_ICON_PACK_PATH . ('includes/material-design.php') );
    }

}
new Mentor_Icon_Pack();