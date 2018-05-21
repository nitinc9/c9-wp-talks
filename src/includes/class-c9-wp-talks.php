<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://cloudnineapps.com/
 * @since      1.0.0
 *
 * @package    C9_Wp_Talks
 * @subpackage C9_Wp_Talks/includes
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
 * @package    C9_Wp_Talks
 * @subpackage C9_Wp_Talks/includes
 * @author     Nitin Patil <support@cloudnineapps.com>
 */
class C9_Wp_Talks {

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      C9_Wp_Talks_Loader    $loader    Maintains and registers all hooks for the plugin.
   */
  protected $loader;

  /**
   * The unique identifier of this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $plugin_name    The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

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
    if ( defined( 'C9_WP_TALKS_VERSION' ) ) {
      $this->version = C9_WP_TALKS_VERSION;
    } else {
      $this->version = '1.0.0';
    }
    $this->plugin_name = 'c9-wp-talks';

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
   * - C9_Wp_Talks_Loader. Orchestrates the hooks of the plugin.
   * - C9_Wp_Talks_i18n. Defines internationalization functionality.
   * - C9_Wp_Talks_Admin. Defines all hooks for the admin area.
   * - C9_Wp_Talks_Public. Defines all hooks for the public side of the site.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function load_dependencies() {

    // Load utility classes
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/code/utils/class-c9-log-writer.php';

    // Load custom classes
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/code/common/class-c9-wp-talks-constants.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/code/admin/core/class-c9-wp-talks-admin-delegate.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/code/admin/ui/class-c9-wp-talks-admin-ui.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/code/public/core/class-c9-wp-talks-public-delegate.php';

    /**
     * The class responsible for orchestrating the actions and filters of the
     * core plugin.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-c9-wp-talks-loader.php';

    /**
     * The class responsible for defining internationalization functionality
     * of the plugin.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-c9-wp-talks-i18n.php';

    /**
     * The class responsible for defining all actions that occur in the admin area.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-c9-wp-talks-admin.php';

    /**
     * The class responsible for defining all actions that occur in the public-facing
     * side of the site.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-c9-wp-talks-public.php';

    $this->loader = new C9_Wp_Talks_Loader();

  }

  /**
   * Define the locale for this plugin for internationalization.
   *
   * Uses the C9_Wp_Talks_i18n class in order to set the domain and to register the hook
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function set_locale() {

    $plugin_i18n = new C9_Wp_Talks_i18n();

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
    $debug_enabled = get_option(C9_Wp_Talks_Constants::$DEBUG_MODE_SETTING, C9_Wp_Talks_Constants::$DEBUG_MODE_SETTING_DEFAULT);
    $logger = new C9_Log_Writer($debug_enabled);
    $delegate = new C9_Wp_Talks_Admin_Delegate($logger);
    $ui = new C9_Wp_Talks_Admin_UI($logger, $delegate);
    $plugin_admin = new C9_Wp_Talks_Admin( $this->get_plugin_name(), $this->get_version() );

    // Initialize
    $delegate->init();
    $ui->init();

    $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
    $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
  }

  /**
   * Register all of the hooks related to the public-facing functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_public_hooks() {
    $debug_enabled = get_option(C9_Wp_Talks_Constants::$DEBUG_MODE_SETTING, C9_Wp_Talks_Constants::$DEBUG_MODE_SETTING_DEFAULT);
    $logger = new C9_Log_Writer($debug_enabled);
    $delegate = new C9_Wp_Talks_Public_Delegate($logger);
    $plugin_public = new C9_Wp_Talks_Public( $this->get_plugin_name(), $this->get_version() );

    // Initialize
    $delegate->init();

    $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
    $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
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
  public function get_plugin_name() {
    return $this->plugin_name;
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @since     1.0.0
   * @return    C9_Wp_Talks_Loader    Orchestrates the hooks of the plugin.
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
