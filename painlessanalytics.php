<?php
/**
 * Painless Analytics
 *
 * @package           Painless Analytics
 * @author            Your Name
 * @copyright         2024 Painless Analytics
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Painless Analytics
 * Plugin URI:        https://www.painlessanalytics.com/painless-analytics-wordpress-plugin/
 * Description:       Simplified web analytics focused on the metrics that matter most.
 * Version:           0.9.0
 * Requires at least: 5.2
 * Requires PHP:      5.4
 * Author:            Painless Analytics
 * Author URI:        https://www.painlessanalytics.com
 * Text Domain:       painlessanalytics
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( !class_exists('painlessAnalytics') ) {
    require_once dirname(__FILE__) . '/painlessanalytics.class.php';

    function painlessanalytics_init() {
        painlessAnalytics::getInstance()->init();
    }
    add_action( 'init', 'painlessanalytics_init' );
}

if ( is_admin() && !class_exists('painlessAnalyticsAdmin') ) { // we are in admin mode
    require_once(dirname(__FILE__) . '/admin/painlessanalytics-admin.class.php'); // Admin page
}

// eof