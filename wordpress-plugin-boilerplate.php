<?php

/**
 * Plugin Name:       Wordpress Plugin Boilerplate
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       This is a boilerplate for a plugin that has an admin page and multiple blocks, all created with React.
 * Version:           1.0.0
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       wordpress-plugin-boilerplate
 * Domain Path:       /languages
 */


// Stop Direct Access 
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Plugin_Boilerplate{

    public function __construct() {
        // Register activation hook
        if ( function_exists( 'register_activation_hook' ) ) {
			register_activation_hook( __FILE__, [ $this, 'activationHook' ] );
		}

        // Register deactivation hook
        if ( function_exists( 'register_deactivation_hook' ) ) {
			register_deactivation_hook( __FILE__, [ $this, 'deactivationHook' ] );
		}

        // Register uninstall hook
        if ( function_exists( 'register_uninstall_hook' ) ) {
            register_uninstall_hook( __FILE__, 'uninstallHook' );
        }

        // Action to add admin page
        add_action( 'admin_menu', [ $this, 'adminPage' ] );

        // Action to enqueue scripts and stylesheets
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAdminScriptsAndStylesheets' ] );

        // Action to register and initialize blocks
        add_action( 'init', [ $this, 'initializeBlocks' ] );
    }

    /**
	* Initialize the plugin
	*/
	public static function init(){
		static $instance = false; 
		if( !$instance ) {
			$instance = new self();
		}
		return $instance;
	}

    /**
	* Adds an admin page
	*/
    public function adminPage() {
        add_menu_page(
            'Wordpress Plugin Boilerplate',
            'Wordpress Plugin Boilerplate',
            'manage_options',
            'wordpress-plugin-boilerplate',
            [ $this, 'adminPageMarkup' ],
            'dashicons-schedule',
            3
        );
    }

    /**
	* Admin page markup for React components.
    * Add your content in admin directory as components.
	*/
    public function adminPageMarkup() {
		echo '
            <h2>Admin Page</h2>
            <div id="wordpress-plugin-boilerplate"></div>
        ';
    }

    /**
	* Activation hook callback.
	*/
    public function activationHook() {}

    /**
	* Deactivation hook callback.
	*/
    public function deactivationHook() {}

    /**
	* Uninstall hook callback.
	*/
    public function uninstallHook() {}

    /**
    * Enqueue admin scripts and stylesheets
    */
    public function enqueueAdminScriptsAndStylesheets( $hook ) {
        // Load only on ?page=wordpress-plugin-boilerplate
        if ( 'toplevel_page_wordpress-plugin-boilerplate' !== $hook ) {
            return;
        }

        // Automatically load imported dependencies and assets version.
        $asset_file = include plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

        // Enqueue CSS dependencies.
        foreach ( $asset_file[ 'dependencies' ] as $style ) {
            wp_enqueue_style( $style );
        }

        // Enqueue scripts.
        wp_register_script(
            'wordpress-plugin-boilerplate',
            plugins_url( 'build/index.js', __FILE__ ),
            $asset_file[ 'dependencies' ],
            $asset_file[ 'version' ]
        );
        wp_enqueue_script( 'wordpress-plugin-boilerplate' );

        // Enqueue stylesheets.
        wp_register_style(
            'wordpress-plugin-boilerplate',
            plugins_url( 'src/admin/stylesheet/style.css', __FILE__ ),
            array(),
            $asset_file[ 'version' ]
        );
        wp_enqueue_style( 'wordpress-plugin-boilerplate' );
    }

    /**
	* Initializes Blocks
	*/
	public function initializeBlocks() {
        $this->registerBlocks( 'block-1' );
        $this->registerBlocks( 'block-2' );
    }

    /**
    * Registers each block.
    */
    public function registerBlocks( $name ) {
        register_block_type( __DIR__ . '/build/blocks/' . $name );
    }
}

WP_Plugin_Boilerplate::init();