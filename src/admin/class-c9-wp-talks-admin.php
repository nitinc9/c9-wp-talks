<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cloudnineapps.com/
 * @since      1.0.0
 *
 * @package    C9_Wp_Talks
 * @subpackage C9_Wp_Talks/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    C9_Wp_Talks
 * @subpackage C9_Wp_Talks/admin
 * @author     Nitin Patil <support@cloudnineapps.com>
 */
class C9_Wp_Talks_Admin {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;


  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   * @param      string    $delegate    The delegate.
   */
  public function __construct( $plugin_name, $version ) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * Performs initialization.
   */
  public function init() {
    $this->delegate->register_cpt();
    $this->delegate->register_settings();
  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in C9_Wp_Talks_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The C9_Wp_Talks_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/c9-wp-talks-admin.css', array(), $this->version, 'all' );

  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in C9_Wp_Talks_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The C9_Wp_Talks_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/c9-wp-talks-admin.js', array( 'jquery' ), $this->version, false );

  }

}
