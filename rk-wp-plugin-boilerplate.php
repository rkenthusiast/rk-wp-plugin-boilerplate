<?php

/**
 * @package   rk_wp_plugin_boilerplate
 * @author    Rk Enthusiast <rkenthusiast@gmail.com>
 * @copyright 2024 RK
 * @license   GPL 2.0+
 * @link      https://rkenthusiast.com
 *
 * Plugin Name:     rk-wp-plugin-boilerplate
 * Plugin URI:      @TODO
 * Description:     @TODO
 * Version:         1.0.0
 * Author:          Rk Enthusiast
 * Author URI:      https://rkenthusiast.com
 * Text Domain:     rk-wp-plugin-boilerplate
 * License:         GPL 2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:     /languages
 * Requires PHP:    7.4
 * WordPress-Plugin-Boilerplate-Powered: v3.3.0
 */

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

define( 'R_VERSION', '1.0.0' );
define( 'R_TEXTDOMAIN', 'rk-wp-plugin-boilerplate' );
define( 'R_NAME', 'rk-wp-plugin-boilerplate' );
define( 'R_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'R_PLUGIN_ABSOLUTE', __FILE__ );
define( 'R_MIN_PHP_VERSION', '7.4' );
define( 'R_WP_VERSION', '5.3' );

add_action(
	'init',
	static function () {
		load_plugin_textdomain( R_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	);


$rk_wp_plugin_boilerplate_libraries = require R_PLUGIN_ROOT . 'vendor/autoload.php'; //phpcs:ignore

require_once R_PLUGIN_ROOT . 'functions/functions.php';
require_once R_PLUGIN_ROOT . 'functions/debug.php';

// Add your new plugin on the wiki: https://github.com/WPBP/WordPress-Plugin-Boilerplate-Powered/wiki/Plugin-made-with-this-Boilerplate

$requirements = new \Micropackage\Requirements\Requirements(
	'rk-wp-plugin-boilerplate',
	array(
		'php'            => R_MIN_PHP_VERSION,
		'php_extensions' => array( 'mbstring' ),
		'wp'             => R_WP_VERSION,
		// 'plugins'            => array(
		// array( 'file' => 'hello-dolly/hello.php', 'name' => 'Hello Dolly', 'version' => '1.5' )
		// ),
	)
);

if ( ! $requirements->satisfied() ) {
	$requirements->print_notice();

	return;
}


/**
 * Create a helper function for easy SDK access.
 *
 * @global type $r_fs
 * @return object
 */
function r_fs() {
	global $r_fs;

	if ( !isset( $r_fs ) ) {
		require_once R_PLUGIN_ROOT . 'vendor/freemius/wordpress-sdk/start.php';
		$r_fs = fs_dynamic_init(
			array(
				'id'             => '',
				'slug'           => 'rk-wp-plugin-boilerplate',
				'public_key'     => '',
				'is_live'        => false,
				'is_premium'     => true,
				'has_addons'     => false,
				'has_paid_plans' => true,
				'menu'           => array(
					'slug' => 'rk-wp-plugin-boilerplate',
				),
			)
		);

		if ( $r_fs->is_premium() ) {
			$r_fs->add_filter(
				'support_forum_url',
				static function ( $wp_org_support_forum_url ) { //phpcs:ignore
					return 'https://your-url.test';
				}
			);
		}
	}

	return $r_fs;
}

// r_fs();

// Documentation to integrate GitHub, GitLab or BitBucket https://github.com/YahnisElsts/plugin-update-checker/blob/master/README.md
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

PucFactory::buildUpdateChecker( 'https://github.com/user-name/repo-name/', __FILE__, 'unique-plugin-or-theme-slug' );

if ( ! wp_installing() ) {
	register_activation_hook( R_TEXTDOMAIN . '/' . R_TEXTDOMAIN . '.php', array( new \rk_wp_plugin_boilerplate\Backend\ActDeact, 'activate' ) );
	register_deactivation_hook( R_TEXTDOMAIN . '/' . R_TEXTDOMAIN . '.php', array( new \rk_wp_plugin_boilerplate\Backend\ActDeact, 'deactivate' ) );
	add_action(
		'plugins_loaded',
		static function () use ( $rk_wp_plugin_boilerplate_libraries ) {
			new \rk_wp_plugin_boilerplate\Engine\Initialize( $rk_wp_plugin_boilerplate_libraries );
		}
	);
}
