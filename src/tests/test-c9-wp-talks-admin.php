<?php
/**
 * C9_Wp_Talks_Admin Unit Tests.
 *
 * @package C9_Wp_Talks_Admin_Test
 */

/**
 * C9_Wp_Talks_Admin Unit Tests.
 */
class C9_Wp_Talks_Admin_Test extends WP_UnitTestCase {

  /** Initializes the test. */
  public function setUp() {
    parent::setUp();
    $this->admin_user_id = $this->factory->user->create(['role' => 'admin']);
    wp_set_current_user($this->admin_user_id);
  }

  /** Clean up. */
  public function tearDown() {
    parent::tearDown();
  }

  /** Tests successful creation of a talk. */
  public function test_plugin_loaded_success() {
    // Validate
    $this->assertTrue(class_exists('C9_Wp_Talks'), "Main plugin class 'C9_Wp_Talks' not found.");
  }

  /** Tests successful creation of a talk. */
  public function test_create_talk_success() {
    // Initialize
    $presenter_name = 'Nitin Patil';
    $presenter_website = 'https://cloudnineapps.com';
    $recording_url = 'https://cloudnineapps.com/';

    // Execute
    $talk = $this->factory->post->create_and_get([
      'post_type'    => C9_Wp_Talks_Constants::$TALK_POST_TYPE,
      'post_title'   => $this->getName() . ' - Talk',
      'post_content' => $this->getName() . ' - Content'
    ]);
    update_post_meta($talk->ID, C9_Wp_Talks_Constants::$PRESENTER_NAME_FIELD, $presenter_name);
    update_post_meta($talk->ID, C9_Wp_Talks_Constants::$PRESENTER_WEBSITE_FIELD, $presenter_website);
    update_post_meta($talk->ID, C9_Wp_Talks_Constants::$RECORDING_URL_FIELD, $recording_url);

    // Validate
    $this->assertTrue($talk->ID > 0, "Talk did not get created successfully.");
    $fetched_presenter_name = get_post_meta($talk->ID, C9_Wp_Talks_Constants::$PRESENTER_NAME_FIELD, $presenter_name);
    $fetched_presenter_website = get_post_meta($talk->ID, C9_Wp_Talks_Constants::$PRESENTER_WEBSITE_FIELD, $presenter_website);
    $fetched_recording_url = get_post_meta($talk->ID, C9_Wp_Talks_Constants::$RECORDING_URL_FIELD, $recording_url);
    $this->assertEquals($presenter_name, $fetched_presenter_name, "Incorrect presenter name.");
    $this->assertEquals($presenter_website, $fetched_presenter_website, "Incorrect presenter website.");
    $this->assertEquals($recording_url, $fetched_recording_url, "Incorrect recording url.");
  }
}
