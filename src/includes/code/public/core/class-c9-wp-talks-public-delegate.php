<?php
/**
 * Class to provide the core public logic.
 *
 * @since      1.0.0
 * @package    C9_Wp_Talks
 * @subpackage C9_Wp_Talks/includes/code/public/core
 */
class C9_Wp_Talks_Public_Delegate {

  /** The logger. */
  private $logger;


  public function __construct($logger) {
    $this->logger = $logger;
  }

  /** Initialize. */
  public function init() {
    add_shortcode(C9_Wp_Talks_Constants::$INSERT_TALKS_SHORTCODE, [$this, 'get_talks']);
    add_shortcode(C9_Wp_Talks_Constants::$INSERT_TALK_SHORTCODE, [$this, 'get_talk']);
    $this->logger->debug("C9_Wp_Talks_Public_Delegate::init(): Initialization completed.");
  }

  /**
   * Returns the talks.
   *
   * @param attribs: The shortcode attributes.
   * @param content: The shortcode content.
   */
  public function get_talks($attribs=[], $content=null) {
    $id_header = __('ID', 'c9-wp-talks');
    $title_header = __('Title', 'c9-wp-talks');
    $out = <<<EOL
<table>
  <tr>
    <th>$id_header</th>
    <th>$title_header</th>
  </tr>
EOL;
    $results = new WP_Query([C9_Wp_Talks_Constants::$POST_TYPE_FIELD => C9_Wp_Talks_Constants::$TALK_POST_TYPE]);
    if ($results->have_posts()) {
      $talks = $results->posts;
      foreach ($talks as $talk) {
        $id = $talk->ID;
        $title = $talk->post_title;
        $out .= <<<EOL
  <tr>
    <td>$id</td>
    <td>$title</td>
  </tr>
EOL;
      }
            
      // Clean up
      wp_reset_postdata();
    } // if (talks found)
    else {
      $out .= <<<EOL
  <tr>
    <td colspan='2'><?php _e('No talks found.', 'c9-wp-talks'); ?></td>
  </tr>
EOL;
    }
    $out .= <<<EOL
</table>
EOL;
    return $out;
  }

  /**
   * Returns the talk with the specified ID.
   *
   * @param attribs: The shortcode attributes.
   * @param content: The shortcode content.
   */
  public function get_talk($attribs=[], $content=null) {
    $out = "";
    if (isset($attribs[C9_Wp_Talks_Constants::$ID_ATTRIB])) {
      $id = $attribs[C9_Wp_Talks_Constants::$ID_ATTRIB];
      $talk = get_post($id);
      if ($talk) {
        $title = $talk->post_title;
        $description = $talk->post_content;
        $presenter_name = get_post_meta($id, C9_Wp_Talks_Constants::$PRESENTER_NAME_FIELD, true);
        $presenter_website = get_post_meta($id, C9_Wp_Talks_Constants::$PRESENTER_WEBSITE_FIELD, true);
        $recording_url = get_post_meta($id, C9_Wp_Talks_Constants::$RECORDING_URL_FIELD, true);
        $out = <<<EOL
<table>
  <tr>
    <th>Title:</th>
    <td><strong>$title</strong></td>
  </tr>
  <tr>
    <th>Presenter Name:</th>
    <td>$presenter_name</td>
  </tr>
  <tr>
    <th>Presenter Website:</th>
    <td>$presenter_website</td>
  </tr>
  <tr>
    <th>Recording URL:</th>
    <td><a href='$recording_url' target='_blank'>$recording_url</a></td>
  </tr>
</table>
EOL;
      }
    }

    return $out;
  }
}
