<?php
/**
 * Class to provide logging functionality.
 *
 * @since      1.0.0
 */
if (!class_exists('C9_Log_Writer')) {
  class C9_Log_Writer {
  
    /** Whether logging is enabled. */
    private $enabled;
  
  
    public function __construct($enabled=false) {
      $this->enabled = $enabled;
    }
  
    /**
     * Logs a debug message.
     *
     * @param msg: The log message.
     */
    public function debug($msg) {
      if ($this->enabled) {
        error_log("[DEBUG] $msg");
      }
    }
  }
}
