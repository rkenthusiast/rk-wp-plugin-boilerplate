<?php

namespace rk_wp_plugin_boilerplate\Tests\WPUnit;
use Inpsyde\WpContext;

class InitializeTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @var string
	 */
	protected $root_dir;

	public function setUp(): void {
		parent::setUp();

		// your set up methods here
		$this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );

		wp_set_current_user(0);
		wp_logout();
		wp_safe_redirect(wp_login_url());
	}

	public function tearDown(): void {
		parent::tearDown();
	}

	/**
	 * @test
	 * it should be front
	 */
	public function it_should_be_front() {
		do_action('plugins_loaded');

		$classes   = array();
		$classes[] = 'rk_wp_plugin_boilerplate\Internals\PostTypes';
		$classes[] = 'rk_wp_plugin_boilerplate\Internals\Shortcode';
		$classes[] = 'rk_wp_plugin_boilerplate\Internals\Transient';
		$classes[] = 'rk_wp_plugin_boilerplate\Integrations\CMB';
		$classes[] = 'rk_wp_plugin_boilerplate\Integrations\Cron';
		$classes[] = 'rk_wp_plugin_boilerplate\Integrations\Template';
		$classes[] = 'rk_wp_plugin_boilerplate\Integrations\Widgets\My_Recent_Posts_Widget';
		$classes[] = 'rk_wp_plugin_boilerplate\Frontend\Enqueue';
		$classes[] = 'rk_wp_plugin_boilerplate\Frontend\Extras\Body_Class';

		$all_classes = get_declared_classes();
		foreach( $classes as $class ) {
			$this->assertTrue( in_array( $class, $all_classes ) );
		}
	}

	/**
	 * @test
	 * it should be ajax
	 */
	public function it_should_be_ajax() {
		add_filter( 'wp_doing_ajax', '__return_true' );
		do_action('plugins_loaded');

		$classes   = array();
		$classes[] = 'rk_wp_plugin_boilerplate\Ajax\Ajax';
		$classes[] = 'rk_wp_plugin_boilerplate\Ajax\Ajax_Admin';

		$all_classes = get_declared_classes();
		foreach( $classes as $class ) {
			$this->assertTrue( in_array( $class, $all_classes ) );
		}
	}
}
