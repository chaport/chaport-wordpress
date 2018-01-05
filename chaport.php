<?php

/**
 * Plugin Name: Chaport
 * Version: 1.0.0
 * Description: Description here...
 * Author: Chaport
 * Author URI: https://www.chaport.com/
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once(__DIR__ . '/includes/chaport_app_id.php');
require_once(__DIR__ . '/includes/chaport_installation_code_renderer.php');

return ChaportPlugin::bootstrap();

final class ChaportPlugin {

    private static $instance; // singleton
    public static function bootstrap() {
        if (self::$instance === NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() { // constructable via ChaportPlugin::bootstrap()
        add_action('admin_enqueue_scripts', array($this, 'handle_admin_enqueue_scripts') );
        add_action('admin_menu', array($this, 'handle_admin_menu'));
        add_action('admin_init', array($this, 'handle_admin_init'));
        add_action('wp_head', array($this, 'render_chaport_code'));
    }

    public function handle_admin_enqueue_scripts($hook) {
        // Include styles _only_ on Chaport Settings page
        if ($hook === 'settings_page_chaport-settings') {
            wp_enqueue_style('chaport', plugin_dir_url(__FILE__) . 'assets/style.css');
        }
    }

    public function handle_admin_menu() {

        add_options_page(
            __('Chaport Settings', 'chaport'), // $page_title
            __('Chaport', 'chaport'), // $menu_title
            'manage_options', // $capability
            'chaport-settings', // $menu_slug
            array($this, 'render_settings_page') // $function (callback)
        );
            
    }

    public function handle_admin_init() {

        register_setting('chaport-settings', 'chaport-app-id', array(
            'type' => 'string',
            'description' => __('Chaport App ID', 'chaport'),
        ));

        register_setting('chaport-settings', 'chaport-code', array(
            'type' => 'string',
            'description' => __('Chaport installation code', 'chaport'),
        ));
        
        add_settings_section(
            'chaport-settings', // $id
            __('Chaport Settings', 'chaport'), // $title
            array($this, 'render_settings'), // $callback
            'chaport-settings' // $page
        );

        add_settings_field(
            'chaport-app-id', // $id
            __('Chaport App ID', 'chaport'), // $title
            array($this, 'render_app_id_field'), // $callback
            'chaport-settings', // $page
            'chaport-settings' //$section
        );

        add_settings_field(
            'chaport-code', // $id
            __('Custom Installation Code', 'chaport'), // $title
            array($this, 'render_installation_code_field'), // $callback
            'chaport-settings', // $page
            'chaport-settings' //$section
        );
        
    }

    public function render_settings() {

        $statusMessage = __('Not configured', 'chaport'); // Default status message
        $statusClass = 'chaport-status-warning'; // Default status class

        $appId = get_option('chaport-app-id');
        $code = get_option('chaport-code');

        if (!empty($code)) {
            $statusMessage = __('Configured. Using custom installation code.', 'chaport');
            $statusClass = 'chaport-status-ok';
        } else if(!empty($appId)) {
            if (ChaportAppId::isValid($appId)) {
                $statusMessage = __('Configured. Using Chaport App ID.', 'chaport');
                $statusClass = 'chaport-status-ok';
            } else {
                $statusMessage = __('Error. Invalid Chaport App ID.', 'chaport');
                $statusClass = 'chaport-status-error';
            }
        }

        require(__DIR__ . '/includes/chaport_status_snippet.php');

    }

    public function render_app_id_field() {
        echo "<input id='chaport-app-id' name='chaport-app-id' size='40' type='text' value='" . esc_attr(get_option('chaport-app-id')) . "' />";
    }

    public function render_installation_code_field() {
        echo "<textarea id='chaport-code' name='chaport-code' cols='80' rows='14'>" . esc_attr(get_option('chaport-code')) . "</textarea>";
    }

    public function render_settings_page() {
        echo "<form action='options.php' method='POST'>";
        settings_fields('chaport-settings');
        do_settings_sections('chaport-settings');
        submit_button();
        echo "</form>";
    }

    public function render_chaport_code() {

        if ( is_feed() || is_robots() || is_trackback() ) {
          return;
        }

        $appId = get_option('chaport-app-id');
        $code = get_option('chaport-code');

        if ($code) {

            // User provided custom installation code. Render it as is.
            echo $code;

        } else if (!empty($appId) && ChaportAppId::isValid($appId)) {
            
            // Render standart installation code
            $renderer = new ChaportInstallationCodeRenderer(ChaportAppId::fromString($appId));

            // Try to get user email & name
            $user = wp_get_current_user();
            if (!empty($user->user_email)) {
                $renderer->setUserEmail($user->user_email);
            }
            if (!empty($user->display_name)) {
                $renderer->setUserName($user->display_name);
            }
    
            $renderer->render();

        }

    }

}
