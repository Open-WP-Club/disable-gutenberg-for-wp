<?php
/**
 * Plugin Name: Disable Gutenberg for WP
 * Plugin URI: https://github.com/Open-WP-Club/disable-gutenberg-for-wp
 * Description: Enable or disable Gutenberg editor for specific post types in WordPress. Perfect for sites where you want to use Classic Editor for selected content while keeping Gutenberg for others.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Open WP Club
 * Author URI: https://github.com/Open-WP-Club
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: disable-gutenberg-for-wp
 * Domain Path: /languages
 *
 * @package DisableGutenbergForWP
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants.
define( 'DGWP_VERSION', '1.0.0' );
define( 'DGWP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DGWP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'DGWP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Main plugin class.
 */
class Disable_Gutenberg_For_WP {

	/**
	 * Plugin instance.
	 *
	 * @var Disable_Gutenberg_For_WP
	 */
	private static $instance = null;

	/**
	 * Option name for storing settings.
	 *
	 * @var string
	 */
	private $option_name = 'dgwp_disabled_post_types';

	/**
	 * Get plugin instance.
	 *
	 * @return Disable_Gutenberg_For_WP
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_init', array( $this, 'handle_reset_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'admin_notices', array( $this, 'display_admin_notices' ) );
		add_filter( 'plugin_action_links_' . DGWP_PLUGIN_BASENAME, array( $this, 'add_action_links' ) );
		add_filter( 'use_block_editor_for_post_type', array( $this, 'disable_gutenberg_for_post_types' ), 10, 2 );
	}

	/**
	 * Load plugin textdomain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'disable-gutenberg-for-wp',
			false,
			dirname( DGWP_PLUGIN_BASENAME ) . '/languages'
		);
	}

	/**
	 * Add admin menu.
	 */
	public function add_admin_menu() {
		add_submenu_page(
			'tools.php',
			__( 'Disable Gutenberg', 'disable-gutenberg-for-wp' ),
			__( 'Disable Gutenberg', 'disable-gutenberg-for-wp' ),
			'manage_options',
			'disable-gutenberg-for-wp',
			array( $this, 'render_admin_page' )
		);
	}

	/**
	 * Register plugin settings.
	 */
	public function register_settings() {
		register_setting(
			'dgwp_settings_group',
			$this->option_name,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_settings' ),
				'default'           => array(),
			)
		);
	}

	/**
	 * Sanitize settings.
	 *
	 * @param array $input Input data.
	 * @return array Sanitized data.
	 */
	public function sanitize_settings( $input ) {
		if ( ! is_array( $input ) ) {
			return array();
		}

		$sanitized = array();
		foreach ( $input as $post_type ) {
			$sanitized[] = sanitize_key( $post_type );
		}

		return $sanitized;
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_styles( $hook ) {
		if ( 'tools_page_disable-gutenberg-for-wp' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'dgwp-admin-styles',
			DGWP_PLUGIN_URL . 'assets/css/admin-style.css',
			array(),
			DGWP_VERSION
		);
	}

	/**
	 * Render admin page.
	 */
	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'disable-gutenberg-for-wp' ) );
		}

		// Get all public post types.
		$post_types = get_post_types(
			array(
				'public' => true,
			),
			'objects'
		);

		// Exclude attachment post type.
		unset( $post_types['attachment'] );

		// Get current settings.
		$disabled_post_types = get_option( $this->option_name, array() );

		include DGWP_PLUGIN_DIR . 'includes/admin-page.php';
	}

	/**
	 * Disable Gutenberg for selected post types.
	 *
	 * @param bool   $use_block_editor Whether to use block editor.
	 * @param string $post_type Post type.
	 * @return bool
	 */
	public function disable_gutenberg_for_post_types( $use_block_editor, $post_type ) {
		$disabled_post_types = get_option( $this->option_name, array() );

		if ( in_array( $post_type, $disabled_post_types, true ) ) {
			return false;
		}

		return $use_block_editor;
	}

	/**
	 * Get disabled post types.
	 *
	 * @return array
	 */
	public function get_disabled_post_types() {
		return get_option( $this->option_name, array() );
	}

	/**
	 * Add plugin action links.
	 *
	 * @param array $links Existing links.
	 * @return array Modified links.
	 */
	public function add_action_links( $links ) {
		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'tools.php?page=disable-gutenberg-for-wp' ) ),
			esc_html__( 'Settings', 'disable-gutenberg-for-wp' )
		);

		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Display admin notices.
	 */
	public function display_admin_notices() {
		if ( ! isset( $_GET['page'] ) || 'disable-gutenberg-for-wp' !== $_GET['page'] ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) && 'true' === $_GET['settings-updated'] ) {
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Settings saved successfully.', 'disable-gutenberg-for-wp' ); ?></p>
			</div>
			<?php
		}

		if ( isset( $_GET['reset'] ) && 'success' === $_GET['reset'] ) {
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Settings reset to defaults.', 'disable-gutenberg-for-wp' ); ?></p>
			</div>
			<?php
		}
	}

	/**
	 * Handle reset settings action.
	 */
	public function handle_reset_settings() {
		if ( ! isset( $_POST['dgwp_reset_settings'] ) ) {
			return;
		}

		if ( ! isset( $_POST['dgwp_reset_nonce'] ) || ! wp_verify_nonce( $_POST['dgwp_reset_nonce'], 'dgwp_reset_settings' ) ) {
			wp_die( esc_html__( 'Security check failed.', 'disable-gutenberg-for-wp' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions.', 'disable-gutenberg-for-wp' ) );
		}

		delete_option( $this->option_name );

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'  => 'disable-gutenberg-for-wp',
					'reset' => 'success',
				),
				admin_url( 'tools.php' )
			)
		);
		exit;
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_scripts( $hook ) {
		if ( 'tools_page_disable-gutenberg-for-wp' !== $hook ) {
			return;
		}

		wp_enqueue_script(
			'dgwp-admin-scripts',
			DGWP_PLUGIN_URL . 'assets/js/admin-script.js',
			array( 'jquery' ),
			DGWP_VERSION,
			true
		);
	}
}

/**
 * Initialize the plugin.
 */
function dgwp_init() {
	return Disable_Gutenberg_For_WP::get_instance();
}

// Start the plugin.
dgwp_init();
