<?php

namespace rk_wp_plugin_boilerplate\Tests\WPUnit;

class InitializeAdminTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @var string
	 */
	protected $root_dir;

	public function setUp(): void {
		parent::setUp();

		// your set up methods here
		$this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );

		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );
		set_current_screen( 'edit.php' );
	}

	public function tearDown(): void {
		parent::tearDown();
	}

	/**
	 * @test
	 * it should be admin
	 */
	public function it_should_be_admin() {
		add_filter( 'wp_doing_ajax', '__return_false' );
		do_action('plugins_loaded');

		$classes   = array();
		$classes[] = 'rk_wp_plugin_boilerplate\Internals\PostTypes';
		$classes[] = 'rk_wp_plugin_boilerplate\Internals\Shortcode';
		$classes[] = 'rk_wp_plugin_boilerplate\Internals\Transient';
		$classes[] = 'rk_wp_plugin_boilerplate\Integrations\CMB';
		$classes[] = 'rk_wp_plugin_boilerplate\Integrations\Cron';
		$classes[] = 'rk_wp_plugin_boilerplate\Integrations\Template';
		$classes[] = 'rk_wp_plugin_boilerplate\Integrations\Widgets\My_Recent_Posts_Widget';
		$classes[] = 'rk_wp_plugin_boilerplate\Backend\ActDeact';
		$classes[] = 'rk_wp_plugin_boilerplate\Backend\Enqueue';
		$classes[] = 'rk_wp_plugin_boilerplate\Backend\ImpExp';
		$classes[] = 'rk_wp_plugin_boilerplate\Backend\Notices';
		$classes[] = 'rk_wp_plugin_boilerplate\Backend\Pointers';
		$classes[] = 'rk_wp_plugin_boilerplate\Backend\Settings_Page';

		$all_classes = get_declared_classes();
		foreach( $classes as $class ) {
			$this->assertTrue( in_array( $class, $all_classes ) );
		}
	}

	/**
	 * @test
	 * it should be ajax
	 */
	public function it_should_be_admin_ajax() {
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
