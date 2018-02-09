<?php

/**
 * Plugin Name: Chaport Live Chat
 * Description: Modern Live Chat plugin for your WordPress site. Powerful features: group chats, file sending, etc. Free for 5 agents. Unlimited chats & history.
 * Version: 1.0.1
 * Author: Chaport
 * Author URI: https://www.chaport.com/
 * Text Domain: chaport
 * Domain Path: /languages
 * License: MIT
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once(dirname(__FILE__) . '/includes/chaport_app_id.php');
require_once(dirname(__FILE__) . '/includes/chaport_installation_code_renderer.php');

return ChaportPlugin::bootstrap();

final class ChaportPlugin {

    // Minimum required version of Wordpress for this plugin to work
    const WP_MAJOR = 2;
    const WP_MINOR = 8;

    private static $instance; // singleton
    public static function bootstrap() {
        if (self::$instance === NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() { // constructable via ChaportPlugin::bootstrap()
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('admin_enqueue_scripts', array($this, 'handle_admin_enqueue_scripts') );
        add_action('admin_menu', array($this, 'handle_admin_menu'));
        add_action('admin_init', array($this, 'handle_admin_init'));
        add_action('wp_footer', array($this, 'render_chaport_code'));
    }

    public function wp_version_is_compatible() {
        global $wp_version;
        $version = array_map('intval', explode('.', $wp_version));
        return $version[0] > self::WP_MAJOR || ($version[0] === self::WP_MAJOR && $version[1] >= self::WP_MINOR);
    }

    public function load_textdomain() {
        load_plugin_textdomain('chaport', false, basename(dirname(__FILE__)) . '/languages');
    }

    public function handle_admin_enqueue_scripts($hook) {
        // Include styles _only_ on Chaport Settings page
        if ($hook === 'settings_page_chaport') {
            wp_enqueue_style('chaport', plugin_dir_url(__FILE__) . 'assets/style.css');
        }
    }

    public function handle_admin_menu() {

        add_options_page(
            __('Chaport Settings', 'chaport'), // $page_title
            __('Chaport', 'chaport'), // $menu_title
            'manage_options', // $capability
            'chaport', // $menu_slug
            array($this, 'render_settings_page') // $function (callback)
        );
            
    }

    public function handle_admin_init() {

        register_setting('chaport_options', 'chaport_options', array($this, 'sanitize_options'));
        
        add_settings_section(
            'chaport_general_settings', // $id
            __('Chaport Settings', 'chaport'), // $title
            array($this, 'render_chaport_general_settings'), // $callback
            'chaport' // $page
        );

        add_settings_field(
            'chaport_app_id_field', // $id
            __('App ID', 'chaport'), // $title
            array($this, 'render_app_id_field'), // $callback
            'chaport', // $page
            'chaport_general_settings' //$section
        );
        
    }

    public function sanitize_options($options) {
        $sanitized['app_id'] = trim($options['app_id']);
        return $sanitized;
    }

    public function render_chaport_general_settings() {

        $statusMessage = __('Not configured.', 'chaport'); // Default status message
        $statusClass = 'chaport-status-warning'; // Default status class

        $options = get_option('chaport_options');
        $appId = $options['app_id'];

        if(!empty($appId)) {
            if (ChaportAppId::isValid($appId)) {
                $statusMessage = __('Configured.', 'chaport');
                $statusClass = 'chaport-status-ok';
            } else {
                $statusMessage = __('Error. Invalid App ID.', 'chaport');
                $statusClass = 'chaport-status-error';
            }
        }

        require(dirname(__FILE__) . '/includes/chaport_status_snippet.php');

    }

    public function render_app_id_field() {

        $options = get_option('chaport_options');

        echo "<input id='chaport_app_id_field' name='chaport_options[app_id]' size='40' type='text' value='" . esc_attr($options['app_id']) . "' />";

    }

    public function render_settings_page() {

        if (!current_user_can('manage_options')) {
            wp_die(__("You don't have access to this page"));
        }

        require(dirname(__FILE__) . '/includes/chaport_settings_snippet.php');

    }

    public function render_chaport_code() {

        if ( !$this->wp_version_is_compatible() || is_feed() || is_robots() || is_trackback() ) {
          return;
        }

        $options = get_option('chaport_options');
        $appId = $options['app_id'];

        if (!empty($appId) && ChaportAppId::isValid($appId)) {
            
            // Construct installation code renderer
            $renderer = new ChaportInstallationCodeRenderer(ChaportAppId::fromString($appId));

            // Try to get user email & name
            $user = wp_get_current_user();
            if (!empty($user->user_email)) {
                $renderer->setUserEmail($user->user_email);
            }
            if (!empty($user->display_name)) {
                $renderer->setUserName($user->display_name);
            }
    
            // Render installation code
            $renderer->render();

        }

    }

}
