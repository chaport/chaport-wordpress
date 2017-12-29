<?php

/**
 * Plugin Name: Chaport
 * Version: 1.0.0
 * Description: Description here...
 * Author: Chaport
 * Author URI: https://www.chaport.com/
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

return ChaportPlugin::bootstrap();

class ChaportPlugin {

    private static $instance; // singleton
    public static function bootstrap() {
        if (self::$instance === NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() { // constructable via ChaportPlugin::bootstrap()

        add_action('admin_menu', array($this, 'plugin_admin_menu'));
        add_action('admin_init', array($this, 'plugin_admin_init'));
        add_action('wp_head', array($this, 'embed_chaport'));

    }

    public function plugin_admin_menu() {

        add_options_page(
            'Chaport Settings', // $page_title
            'Chaport', // $menu_title
            'manage_options', // $capability
            'chaport-settings', // $menu_slug
            array($this, 'render_settings_page') // $function (callback)
        );
            
    }

    public function plugin_admin_init() {

        register_setting('chaport-settings', 'chaport-code', array(
            'type' => 'string',
            'description' => 'Chaport embedded code',
            'default' => NULL
        ));

        add_settings_section(
            'chaport-settings-section', // $id
            'Chaport Settings', // $title
            array($this, 'render_settings_section'), // $callback
            'chaport-settings' // $page
        );

        add_settings_field(
            'chaport-code-field', // $id
            'Chaport code', // $title
            array($this, 'render_code_field'), // $callback
            'chaport-settings', // $page
            'chaport-settings-section' //$section
        );

    }

    public function render_settings_section() {
        echo '<p>Please paste you Chaport code here</p>';
    }

    public function render_code_field() {
        echo "<textarea cols=\"80\" rows=\"14\" name=\"chaport-code\">" . esc_attr(get_option('chaport-code')) . "</textarea>";
    }

    public function render_settings_page() {

        echo "<form action=\"options.php\" method=\"POST\">";
        do_settings_sections('chaport-settings');
        submit_button();
        echo "</form>";
    
    }

    public function embed_chaport() {

        if ( is_feed() || is_robots() || is_trackback() ) {
          return;
        }

        $code = get_option('chaport-code');

        if (isset($code) && trim($code) !== '') {
            echo $code;
        }

    }

}
