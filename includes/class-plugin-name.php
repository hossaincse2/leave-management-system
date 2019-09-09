<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    leave_management
 * @subpackage leave_management/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    leave_management
 * @subpackage leave_management/includes
 * @author     Your Name <email@example.com>
 */
class leave_management {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      leave_management_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $leave_management    The string used to uniquely identify this plugin.
	 */
	protected $leave_management;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'leave_management_VERSION' ) ) {
			$this->version = leave_management_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->leave_management = 'leave-managemente';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - leave_management_Loader. Orchestrates the hooks of the plugin.
	 * - leave_management_i18n. Defines internationalization functionality.
	 * - leave_management_Admin. Defines all hooks for the admin area.
	 * - leave_management_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-name-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-name-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-leave-management-admin.php';

		/**
		 * The class responsible for defining Settings
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/leave-management_settings.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-leave-management-public.php';


		/**
		 * The class responsible for defining Page Templete
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/leave-management-template.php';
		
		/**
		 * The class responsible for defining Page Templete
		 * of the plugin.
		 */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-csv_export.php';

		/**
		 * The class responsible for defining Ajax
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-ajax.php';

		 

		/**
		 * The class responsible for defining ShortCode
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/shortcode/leave_list.php';

		

		$this->loader = new leave_management_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the leave_management_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new leave_management_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Leave_Management_Admin( $this->get_leave_management(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'leave_register_my_custom_menu_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'settings_custome_fileld_admin_init' );
		$this->loader->add_action( 'login_enqueue_scripts', $plugin_admin, 'my_login_logo' );
		$this->loader->add_action( 'admin_footer_text', $plugin_admin, 'demo_footer_filter' );
		$this->loader->add_action( 'woocommerce_login_redirect', $plugin_admin, 'wc_custom_user_redirect',10, 2 );
		$this->loader->add_action( 'admin_bar_menu', $plugin_admin, 'remove_wp_logo',999 );
		$this->loader->add_action( 'woocommerce_register_shop_order_post_statuses', $plugin_admin, 'leave_register_custom_order_status',999 );
		$this->loader->add_action( 'wc_order_statuses', $plugin_admin, 'leave_show_custom_order_status',999 );
		$this->loader->add_action( 'bulk_actions-edit-shop_order', $plugin_admin, 'leave_get_custom_order_status_bulk',999 );
		$this->loader->add_action( 'woocommerce_thankyou', $plugin_admin, 'leave_thankyou_change_order_status',999 );
 
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Leave_Management_Public( $this->get_leave_management(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'device_list', $plugin_public, 'get_device_list' );
		$this->loader->add_action( 'sensore_list', $plugin_public, 'get_sensore_list' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'baseUrl' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'pluginUrl' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'leave_user_nav_visibility' );
		$this->loader->add_action( 'admin_init', $plugin_public, 'leave_redirect_users_by_role' );
		$this->loader->add_action( 'init', $plugin_public, 'leave_csv' );

 	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_leave_management() {
		return $this->leave_management;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    leave_management_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
