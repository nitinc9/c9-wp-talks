<?php
/**
 * Class to provide the core admin logic.
 *
 * @since      1.0.0
 * @package    C9_Wp_Talks
 * @subpackage C9_Wp_Talks/includes/code/admin/core
 */
class C9_Wp_Talks_Admin_Delegate {

  /** The logger. */
  private $logger;


  public function __construct($logger) {
    $this->logger = $logger;
  }

  /** Initialize. */
  public function init() {
    add_action('init', [$this, 'register_cpt']);
    add_action('init', [$this, 'register_settings']);
    add_action(sprintf('save_post_%s', C9_Wp_Talks_Constants::$TALK_POST_TYPE), [$this, 'save_custom_fields']);
    $this->logger->debug("C9_Wp_Talks_Admin_Delegate::init(): Initialization completed.");
  }

  /**
   * Registers the custom post type.
   */
  public function register_cpt() {
    $labels = array(
      'name'               => __('Talks', 'c9-wp-talks'),
      'menu_name'          => __('Talks', 'c9-wp-talks'),
      'singular_name'      => __('Talk', 'c9-wp-talks'),
      'all_items'          => __('All Talks', 'c9-wp-talks'),
      'add_new_item'       => __('Add New Talk', 'c9-wp-talks'),
      'new_item'           => __('New Talk', 'c9-wp-talks'),
      'search_items'       => __('Search Talks', 'c9-wp-talks'),
      'edit_item'          => __('Edit Talk', 'c9-wp-talks'),
      'not_found'          => __('No talks found.', 'c9-wp-talks'),
      'not_found_in_trash' => __('No talks found in Trash.', 'c9-wp-talks')
    );
    $attribs = [
      'labels'              => $labels,
      'description'         => __('A custom post type for WordPress talks.', 'c9-wp-talks'),
      'public'              => false,
      'show_ui'             => true,
      'has_archive'         => true,
      'exclude_from_search' => true,
      'supports'            => ['title', 'editor', 'author', 'revisions'],
      'show_in_menu'        => C9_Wp_Talks_Constants::$MENU_SLUG,
      'parent_item'         => null,
      'menu_icon'           => null,
      'rewrite'             => ['slug'  => C9_Wp_Talks_Constants::$SLUG]
    ];
    $this->logger->debug("C9_Wp_Talks_Admin_Delegate::register_cpt(): Registering custom post type...");
    register_post_type(C9_Wp_Talks_Constants::$TALK_POST_TYPE, $attribs);
  }

  /**
   * Registers the settings.
   */
  public function register_settings() {
    $this->logger->debug("C9_Wp_Talks_Admin_Delegate::register_settings(): Registering settings...");
    register_setting(C9_Wp_Talks_Constants::$SETTINGS, C9_Wp_Talks_Constants::$DEBUG_MODE_SETTING);
  }

  /**
   * Saves the custom fields after save of the post.
   *
   * @param post_id: The post ID.
   * @param post: The post.
   */
  public function save_custom_fields() {
    global $post;

    wp_verify_nonce(C9_Wp_Talks_Constants::$NONCE_PARAM, C9_Wp_Talks_Constants::$UPDATE_TALK_ACTION);
    if ($post) {
      $post_id = $post->ID;
      $this->logger->debug("C9_Wp_Talks_Admin_Delegate::save_custom_fields(): Saving custom fields...");
      $presenter_name = isset($_POST[C9_Wp_Talks_Constants::$PRESENTER_NAME_FIELD]) ? $_POST[C9_Wp_Talks_Constants::$PRESENTER_NAME_FIELD] : '';
      $presenter_website = isset($_POST[C9_Wp_Talks_Constants::$PRESENTER_WEBSITE_FIELD]) ? $_POST[C9_Wp_Talks_Constants::$PRESENTER_WEBSITE_FIELD] : '';
      $recording_url = isset($_POST[C9_Wp_Talks_Constants::$RECORDING_URL_FIELD]) ? $_POST[C9_Wp_Talks_Constants::$RECORDING_URL_FIELD] : '';
      $this->logger->debug("C9_Wp_Talks_Admin_Delegate::save_custom_fields(): Presenter name: $presenter_name, website: $presenter_website, recording_url: $recording_url");
  
      // Save fields now
      update_post_meta($post_id, C9_Wp_Talks_Constants::$PRESENTER_NAME_FIELD, $presenter_name);
      update_post_meta($post_id, C9_Wp_Talks_Constants::$PRESENTER_WEBSITE_FIELD, $presenter_website);
      update_post_meta($post_id, C9_Wp_Talks_Constants::$RECORDING_URL_FIELD, $recording_url);
    }
  }
}
