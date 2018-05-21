<?php
/**
 * Class to provide the admin UI logic.
 *
 * @since      1.0.0
 * @package    C9_Wp_Talks
 * @subpackage C9_Wp_Talks/includes/code/admin/ui
 */
class C9_Wp_Talks_Admin_UI {

  /** The logger. */
  private $logger;

  /** The delegate. */
  private $delegate;


  public function __construct($logger, $delegate) {
    $this->logger = $logger;
    $this->delegate = $delegate;
  }

  /** Initialize. */
  public function init() {
    add_action('admin_menu', [$this, 'register_menu']);
    add_action('add_meta_boxes', [$this, 'add_presenter_info_meta_box']);
    $this->logger->debug("C9_Wp_Talks_Admin_UI::init(): Initialization completed.");
  }

  /**
   * Registers the menu.
   */
  public function register_menu() {
    $menu_slug = C9_Wp_Talks_Constants::$MENU_SLUG;
    add_menu_page(__('Talks', 'c9-wp-talks'), __('Talks', 'c9-wp-talks'), 'manage_options', $menu_slug, '', 'dashicons-welcome-view-site');
    add_submenu_page($menu_slug, __('Settings', 'c9-wp-talks'), __('Settings', 'c9-wp-talks'), 'manage_options', C9_Wp_Talks_Constants::$SETTINGS_PAGE, [$this, 'show_settings_page']);
  }

  /**
   * Shows the settings page.
   */
  public function show_settings_page() {
    if ( !current_user_can( 'manage_options' ) )  {
      wp_die(__('You do not have sufficient permissions to access this page.'));
    }
?>
<div class="wrap">
  <h1><?php _e('C9 WordPress Talks Settings', 'c9-wp-talks'); ?></h1>
  <?php settings_errors(); ?>
  <h2 class="nav-tab-wrapper">
    <a href="#" class="nav-tab nav-tab-active"><?php _e('General', 'c9-wp-talks'); ?></a>
  </h2>
  <form method="post" action="options.php">
    <?php settings_fields(C9_Wp_Talks_Constants::$SETTINGS); ?>
    <?php do_settings_sections(C9_Wp_Talks_Constants::$SETTINGS); ?>
    <table>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <?php $this->show_settings_fields(); ?>
      <tr>
        <td colspan="2" align="center"><?php submit_button(); ?></td>
      </tr>
    </table>
  </form>
</div>
<?php
  }
    
  /**
   * Shows settings fields.
   */
  public function show_settings_fields() {
?>
      <tr>
        <th><?php _e('Enable Debug Mode', 'c9-wp-talks'); ?></th>
        <td><input type="checkbox" name="<?php echo C9_Wp_Talks_Constants::$DEBUG_MODE_SETTING; ?>" value="true" <?php echo esc_attr(get_option(C9_Wp_Talks_Constants::$DEBUG_MODE_SETTING, C9_Wp_Talks_Constants::$DEBUG_MODE_SETTING_DEFAULT)) == 'true' ? 'checked="checked"' : ''; ?>/></td>
      </tr>
<?php
  }

  /** Adds the presenter information meta box. */
  public function add_presenter_info_meta_box() {
    add_meta_box(C9_Wp_Talks_Constants::$ADDITIONAL_DATA_META_BOX_ID, __('Presenter Information', 'c9-wp-talks'), [$this, 'add_presenter_info_meta_box_content'], C9_Wp_Talks_Constants::$TALK_POST_TYPE, 'side');
  }
    
  /** Adds the presenter information meta box content. */
  public function add_presenter_info_meta_box_content() {
    global $post;
        
    // Add the security field
    wp_nonce_field(C9_Wp_Talks_Constants::$UPDATE_TALK_ACTION, C9_Wp_Talks_Constants::$NONCE_PARAM);
    // meta data fields
    $presenter_name = get_post_meta($post->ID, C9_Wp_Talks_Constants::$PRESENTER_NAME_FIELD, true);
    $presenter_website = get_post_meta($post->ID, C9_Wp_Talks_Constants::$PRESENTER_WEBSITE_FIELD, true);
    $recording_url = get_post_meta($post->ID, C9_Wp_Talks_Constants::$RECORDING_URL_FIELD, true);
    $this->logger->debug("C9_Wp_Talks_Admin_UI::add_presenter_info_meta_box_content(): Presenter name: $presenter_name, website: $presenter_websit, recording_url: $recording_urle");
?>
<table>
  <tr>
    <th><?php _e('Name', 'c9-wp-talks'); ?></th>
    <td>
      <input type="text" id="<?php echo C9_Wp_Talks_Constants::$PRESENTER_NAME_FIELD; ?>" name="<?php echo C9_Wp_Talks_Constants::$PRESENTER_NAME_FIELD; ?>" value="<?php echo esc_attr($presenter_name); ?>" size="15"/>
    </td>
  </tr>
  <tr>
    <th><?php _e('Website', 'c9-wp-talks'); ?></th>
    <td>
      <input type="text" id="<?php echo C9_Wp_Talks_Constants::$PRESENTER_WEBSITE_FIELD; ?>" name="<?php echo C9_Wp_Talks_Constants::$PRESENTER_WEBSITE_FIELD; ?>" value="<?php echo esc_attr($presenter_website); ?>" size="15"/>
    </td>
  </tr>
  <tr>
    <th><?php _e('Recording URL', 'c9-wp-talks'); ?></th>
    <td>
      <input type="text" id="<?php echo C9_Wp_Talks_Constants::$RECORDING_URL_FIELD; ?>" name="<?php echo C9_Wp_Talks_Constants::$RECORDING_URL_FIELD; ?>" value="<?php echo esc_attr($recording_url); ?>" size="15"/>
    </td>
  </tr>
</table>
<?php
  }
}
