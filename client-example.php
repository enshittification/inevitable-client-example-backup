<?php

use Automattic\Jetpack\Config;
use Automattic\Jetpack\Connection\Manager;
use Automattic\Jetpack\Connection\Rest_Authentication as Connection_Rest_Authentication;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://automattic.com
 * @since             1.0.0
 * @package           Client_Example
 *
 * @wordpress-plugin
 * Plugin Name:       Jetpack Client Example
 * Plugin URI:        https://jetpack.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Automattic
 * Author URI:        https://automattic.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       client-example
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CLIENT_EXAMPLE_VERSION', '1.0.0' );

/**
 * The plugin name.
 */
define( 'CLIENT_EXAMPLE_NAME', 'Jetpack Client Example' );

/**
 * The plugin slug.
 */
define( 'CLIENT_EXAMPLE_SLUG', 'client-example' );

require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload_packages.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-client-example-activator.php
 */
function activate_client_example() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-client-example-activator.php';
	Client_Example_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-client-example-deactivator.php
 */
function deactivate_client_example() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-client-example-deactivator.php';
	Client_Example_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_client_example' );
register_deactivation_hook( __FILE__, 'deactivate_client_example' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-client-example.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_client_example() {

	// Here we enable the Jetpack packages.
	$config = new Config();
	$config->setup(
		array(
			'connection' => array(
				'deactivate_disconnect' => true,
				'tos_link'              => true,
			)
		),
		array(
			'slug'        => CLIENT_EXAMPLE_SLUG,
			'name'        => CLIENT_EXAMPLE_NAME,
			'url_info'    => 'https://github.com/Automattic/client-example',
			'plugin_file' => __FILE__,
		)
	);

	$jetpack_connection_manager = new Manager( CLIENT_EXAMPLE_SLUG );
	$plugin = new Client_Example( $jetpack_connection_manager );

	$plugin->run();
}

add_action( 'plugins_loaded', 'run_client_example', 1 );

// Set up the REST authentication hooks.
Connection_Rest_Authentication::init();
