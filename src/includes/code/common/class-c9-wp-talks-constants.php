<?php
/**
 * Class to provide common constants.
 *
 * @since      1.0.0
 * @package    C9_Wp_Talks
 * @subpackage C9_Wp_Talks/includes/code/admin/common
 */
class C9_Wp_Talks_Constants {

  ////////////////////////////////////////////////////////////////////////////////
  // Plugin related
  ////////////////////////////////////////////////////////////////////////////////

  /** The slug. */
  public static $SLUG = "c9-wp-talks";


  ////////////////////////////////////////////////////////////////////////////////
  // Request related
  ////////////////////////////////////////////////////////////////////////////////

  /** The update talk action. */
  public static $UPDATE_TALK_ACTION = "c9_wp_talks_update_talk";

  /** The nonce param. */
  public static $NONCE_PARAM = "c9_wp_talks_security";


  ////////////////////////////////////////////////////////////////////////////////
  // Shortcode related
  ////////////////////////////////////////////////////////////////////////////////

  /** The insert talks shortcode. */
  public static $INSERT_TALKS_SHORTCODE = "c9-wpt-insert-talks";

  /** The insert talk shortcode. */
  public static $INSERT_TALK_SHORTCODE = "c9-wpt-insert-talk";

  /** The ID attribute. */
  public static $ID_ATTRIB = "id";


  ////////////////////////////////////////////////////////////////////////////////
  // Data Model related
  ////////////////////////////////////////////////////////////////////////////////

  /** The custom post type. */
  public static $TALK_POST_TYPE = "c9_wp_talks_talk";

  /** The post ID field. */
  public static $POST_ID_FIELD = "post_id";

  /** The post type field. */
  public static $POST_TYPE_FIELD = "post_type";

  /** The presenter name field. */
  public static $PRESENTER_NAME_FIELD = "c9_wp_talks_presenter_name";

  /** The presenter website field. */
  public static $PRESENTER_WEBSITE_FIELD = "c9_wp_talks_presenter_website";

  /** The recording URL field. */
  public static $RECORDING_URL_FIELD = "c9_wp_talks_recording_url";


  ////////////////////////////////////////////////////////////////////////////////
  // Settings related
  ////////////////////////////////////////////////////////////////////////////////

  /** The settings. */
  public static $SETTINGS = "c9-wp-talks-settings";

  /** The settings page. */
  public static $SETTINGS_PAGE = "c9_wp_talks_settings_page";

  /** The debug mode setting. */
  public static $DEBUG_MODE_SETTING = "c9_wp_talks_debug_mode";

  /** The debug mode setting default. */
  public static $DEBUG_MODE_SETTING_DEFAULT = "false";


  ////////////////////////////////////////////////////////////////////////////////
  // UI related
  ////////////////////////////////////////////////////////////////////////////////

  /** The menu slug. */
  public static $MENU_SLUG = "c9_wp_talks_menu";

  /** The additional data meta box ID. */
  public static $ADDITIONAL_DATA_META_BOX_ID = "c9_wp_talks_additional_data_meta_box";
}
