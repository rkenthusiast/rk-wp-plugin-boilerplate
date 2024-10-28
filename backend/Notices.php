<?php
/**
 * rk_wp_plugin_boilerplate
 *
 * @package   rk_wp_plugin_boilerplate
 * @author    Rk Enthusiast <rkenthusiast@gmail.com>
 * @copyright 2024 RK
 * @license   GPL 2.0+
 * @link      https://rkenthusiast.com
 */

namespace rk_wp_plugin_boilerplate\Backend;

use I18n_Notice_WordPressOrg;
use rk_wp_plugin_boilerplate\Engine\Base;

/**
 * Everything that involves notification on the WordPress dashboard
 */
class Notices extends Base {

	/**
	 * Initialize the class
	 *
	 * @return void|bool
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
			return;
		}

		\wpdesk_wp_notice( \__( 'Updated Messages', R_TEXTDOMAIN ), 'updated' );

		$builder = new \Page_Madness_Detector(); // phpcs:ignore

		if ( $builder->has_entropy() ) {
			\wpdesk_wp_notice( \__( 'A Page Builder/Visual Composer was found on this website!', R_TEXTDOMAIN ), 'error', true );
		}

		/*
		 * Review plugin notice.
		 */
		new \WP_Review_Me(
			array(
				'days_after' => 15,
				'type'       => 'plugin',
				'slug'       => R_TEXTDOMAIN,
				'rating'     => 5,
				'message'    => \__( 'Review me!', R_TEXTDOMAIN ),
				'link_label' => \__( 'Click here to review', R_TEXTDOMAIN ),
			)
		);

		/*
		 * Alert after few days to suggest to contribute to the localization if it is incomplete
		 * on translate.wordpress.org, the filter enables to remove globally.
		 */
		if ( \apply_filters( 'rk_wp_plugin_boilerplate_alert_localization', true ) ) {
			new I18n_Notice_WordPressOrg(
			array(
				'textdomain'  => R_TEXTDOMAIN,
				'rk_wp_plugin_boilerplate' => R_NAME,
				'hook'        => 'admin_notices',
			),
			true
			);
		}

	}

}
