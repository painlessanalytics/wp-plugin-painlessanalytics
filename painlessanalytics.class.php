<?php
/*
 * painlessAnalytics class
 */

class painlessAnalytics {

    private $settings = null;

    /*
    * init()
    * 
    * Initialize plugin
    */
    public function init() {
        load_plugin_textdomain( 'painlessanalytics' ); // Support translation
        
        // See if we have a tracking code in the settings...
        $this->settings = get_option('painlessanalytics');
        $this->initHooks();
    }

    /*
    * initHooks()
    */
    private function initHooks() {
        $headPriority = isset($this->settings['head_priority']) && is_numeric($this->settings['head_priority']) ? intval($this->settings['head_priority']) : 0 ; // Future advanced setting
        add_action('wp_head', array($this, 'wp_head'), $headPriority );
    }

    /*
    * wp_head()
    */
    function wp_head() {
        if( $this->getTrackUrl() ) {
            $args = array(
                'track_url'=>$this->getTrackUrl()
            );
            $this->view('wp_head', $args);
        }
    }
    
    /*
    * Load a view to display on the public side of site
    */
    public function view( $name, array $args = array() ) {
        $file = dirname(__FILE__) . '/views/'. $name . '.php';
        if( file_exists($file) ) {
		    include( $file ); }
	}

    /*
    * Singleton
    */
    public static function getInstance() {
        if( isset($GLOBALS['plugin_painlessanalytics']) && is_object($GLOBALS['plugin_painlessanalytics']) )
            return $GLOBALS['plugin_painlessanalytics'];

        $GLOBALS['plugin_painlessanalytics'] = new painlessAnalytics();
        return $GLOBALS['plugin_painlessanalytics'];
    }

    /*
    * pluginUrl()
    */
    public function pluginUrl() {
        return plugin_dir_url(__FILE__);
    }

    /*
    * pluginDir()
    */
    public function pluginDir() {
        return plugin_dir_path(__FILE__);
    }

    /*
    * getTrackUrl()
    */
    public function getTrackUrl() {

        if( !empty($this->settings['track_url'])) {
            return $this->settings['track_url'];
        }
        
        return false;
    }

    /*
    * getAdminTrackUrl()
    */
    public function getAdminTrackUrl() {

        if( empty($this->settings['track_admin']) ) {
            return false; // Default, if not set then don't track the admin area
        }

        if( !empty($this->settings['track_url']) && empty($this->settings['track_admin_separately']) ) {
            return $this->settings['track_url'];
        }

        if( !empty($this->settings['admin_track_url']) && !empty($this->settings['track_admin_separately']) ) {
            return $this->settings['admin_track_url'];
        }
        
        return false;
    }
};

// eof