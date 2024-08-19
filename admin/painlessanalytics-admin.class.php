<?php
/**
 * Painless Analytics wp-admin
 */

 class painlessAnalyticsAdmin {

    /*
    * init()
    */
    public function init() {
        $this->initHooks();
    }

    /*
    * admin_init()
    */
    public function admin_init() {
        // Initialize plugin
        if ( get_option( 'activated_painlessanalytics' ) ) {
			delete_option( 'activated_painlessanalytics' );
			if ( !headers_sent() ) {
                $url = $this->getSettingsPageUrl();
				wp_redirect( $url );
                return;
			}
		}

        // Future proofing (Only do this if we can confirm user data is already loaded into memory)
        if( get_user_meta( get_current_user_id(), 'activated_painlessanalytics',  true) ) {
            delete_user_meta( get_current_user_id(), 'activated_painlessanalytics');
			if ( !headers_sent() ) {
                $url = $this->getSettingsPageUrl();
				wp_redirect( $url );
                return;
			}
        }

        register_setting('painlessanalytics_settings_group', 'painlessanalytics', array('painlessAnalyticsAdmin', 'sanitizeSettings') ); // multiple settings in Array
    }

    public static function getTrackUrlFromEmbed($embed) {

        if( preg_match('/(https?\:\/\/[^\/]*)\/t/im', $embed, $matches) ) {
            return $matches[1]; // Found it!
        }

        return false;
    }

    /*
    * testTrackUrl($url)
    *
    * Returns true if test successful, false otherwise
    */
    public static function testTrackUrl($url) {
        // Make an HTTP connection to the track Url  with a /t.js, it should return valid JS within 3 seconds
        $args = ['timeout'=> 3];
        $response = wp_remote_get( $url . '/t.js', $args);

        if ( !is_array( $response ) || is_wp_error( $response ) ) {
            if( !is_wp_error($response)) {
                $response = new WP_Error( 'http_error', __('Unknown HTTP error occurred', 'painlessanalytics') );
            }
    
            return $response; // return WP_Error
        }

        $body = ( !empty($response['body']) ? $response['body'] : '');
        if( preg_match('/painlessanalytics\.com/im', $body) ) { // Should have hostname in the js file
            return true;
        }

        return false;
    }

    /*
    * sanitizeSettings($value)
    */
    public static function sanitizeSettings($value) {
        $errorMessage = '';
        if( empty($value['embed'])) $value['embed'] = ''; // Initialize value
        //$value['embed'] = sanitize_textarea_field($value['embed']); // We do not want to do this, but we will not use this except to parse the URL out of it

        $trackUrl = self::getTrackUrlFromEmbed($value['embed']);

        if( $trackUrl ) {
            // Test the tracking URL, if it is valid then save it, otherwise let them know it is not valid and clear the track_url value
            $testResults = self::testTrackUrl($trackUrl);
            if( is_wp_error($testResults) ) {
                $errorMessage = sprintf(__('An error occurred. %s', 'painlessanalytics'), $testResults->get_error_message() );
            } else if( $testResults === false ) {
                $errorMessage = __('The provided Painless Analytics embed code is invalid.', 'painlessanalytics');
            } else {
                $value['track_url'] = $trackUrl; // Track URL is good!
            }
        } else {
            $errorMessage = __('The provided Painless Analytics embed code is invalid.', 'painlessanalytics');
        }

        // If there are no errors, sweet!
        if( empty($errorMessage) ) {
            add_settings_error(
                'painlessanalytics_message',
                esc_attr( 'settings_updated' ),
                __('Painless Analytics is now enabled on your website. Please clear your site cache now if applicable.', 'painlessanalytics'),
                'updated'
            );
        } else {
            add_settings_error(
                'painlessanalytics_message',
                esc_attr( 'settings_updated' ),
                $errorMessage,
                'error'
            );
        }

        return $value;
    }

    /*
    * initHooks()
    */
    private function initHooks() {
        $pluginDir = painlessAnalytics::getInstance()->pluginDir();
        add_action('admin_init', array($this, 'admin_init'));
        register_activation_hook( $pluginDir . 'painlessanalytics.php', array( $this, 'register_activation_hook'));
        add_action('admin_menu', array( $this, 'admin_menu'));
        add_action('admin_head', array( $this, 'admin_head'));
        add_action('admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_filter('plugin_action_links_'.plugin_basename( $pluginDir . 'painlessanalytics.php'), array( $this, 'plugin_action_links' ) ); // WP 2.7+
        add_filter('admin_body_class', array($this, 'admin_body_class') );
    }

    /*
    * Singleton
    */
    public static function getInstance() {
        if( isset($GLOBALS['plugin_painlessanalyticsadmin']) && is_object($GLOBALS['plugin_painlessanalyticsadmin']) )
            return $GLOBALS['plugin_painlessanalyticsadmin'];

        $GLOBALS['plugin_painlessanalyticsadmin'] = new painlessAnalyticsAdmin();
        return $GLOBALS['plugin_painlessanalyticsadmin'];
    }

    /*
    * getSettingsPageUrl($args=array())
    */
    private function getSettingsPageUrl( $args = array() ) {
        if( !empty($args) ) {
            return add_query_arg( $args, menu_page_url( 'painlessanalytics', false ) );
        }
            
        return menu_page_url( 'painlessanalytics', false );
    }

    /*
    * register_activation_hook()
    */
    public function register_activation_hook() {
        add_user_meta( get_current_user_id(), 'activated_painlessanalytics', true, true); // Next page load, we will redirect to the settings page
        //add_option( 'activated_painlessanalytics', true, true ); // Next page load, we will redirect to the settings page
    }

    /*
    * admin_menu()
    */
    public function admin_menu() {
        add_options_page(__('Simplified web metrics', 'painlessanalytics'), __('Painless Analytics', 'painlessanalytics'), 'manage_options', 'painlessanalytics', array($this, 'painlessanalytics_settings'));
    }

    /*
    * admin_enqueue_scripts()
    */
    public function admin_enqueue_scripts() {

        if ( in_array( $GLOBALS['hook_suffix'], array(
			'settings_page_painlessanalytics' // settings page
		) ) ) {

            $cssPath = 'css/styles.css';
            if( defined('PAINLESSANALYTICS_VIEWS_BETA') && file_exists( dirname(__FILE__). '/css/styles-beta.css') ) {
                $cssPath = 'css/styles-beta.css';
            }
            wp_register_style( 'painlessanalytics-admin', plugin_dir_url( __FILE__ ) . $cssPath, array(), filemtime( dirname( __FILE__ ) . '/' . $cssPath ) );
            wp_enqueue_style( 'painlessanalytics-admin' );
        }
    }

    /*
    * plugin_action_links( $links )
    */
    public function plugin_action_links( $links ) {
        $url = $this->getSettingsPageUrl();
        $settings_link = '<a href="'.esc_url( $url ).'">'.__('Settings', 'painlessanalytics').'</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    /*
    * admin_head()
    */
    public function admin_head() {
        if( painlessAnalytics::getInstance()->getAdminTrackUrl() ) {
            $args = array(
                'track_url'=>painlessAnalytics::getInstance()->getAdminTrackUrl()
            );
            painlessAnalytics::getInstance()->view('wp_head', $args);
        }
    }

    /*
    * admin_body_class($value)
    */
    public function admin_body_class($value) {
        if ( in_array( $GLOBALS['hook_suffix'], array(
			'settings_page_painlessanalytics' // settings page
		) ) ) {

            $value .= ' painlessanalytics-page';
        }
        return $value;
    }

    /*
    * painlessanalytics_settings()
    */
    public function painlessanalytics_settings() {
        painlessAnalyticsAdmin::view('page');
    }

    /*
    * plugin_action_links_no( $links, $file ) 
    */
    public function plugin_action_links_no( $links, $file ) {
        $pluginUrl = painlessAnalytics::getInstance()->pluginUrl();
		if ( $file == plugin_basename( $pluginUrl . '/painlessanalytics.php' ) ) {
            $url = $this->getSettingsPageUrl();
			$links[] = '<a href="' . esc_url( $url ) . '">'.esc_html__( 'Settings' , 'painlessanalytics').'</a>';
		}

		return $links;
	}

    /*
    * plugin_action_links_no( $name, $args = array() ) 
    */
    public static function view( $name, $args = array() ) {
        if( defined('PAINLESSANALYTICS_VIEWS_BETA') ) {
            $file = dirname(__FILE__) . '/views-beta/'. $name . '.php';
        } else {
            $file = dirname(__FILE__) . '/views/'. $name . '.php';
        }
		
        if( file_exists($file) ) {
            include( $file );
        }
	}
};

painlessAnalyticsAdmin::getInstance()->init();

// eof