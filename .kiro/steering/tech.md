# Technology Stack

## Platform
- **WordPress Plugin** (5.5+ required, tested up to 6.9)
- **PHP**: 5.4+ minimum
- **License**: GPL v2 or later

## Architecture
- Object-oriented PHP with singleton pattern
- Separate frontend and admin classes
- View-based template system (PHP includes)

## Key Libraries & APIs
- WordPress Plugin API (hooks, actions, filters)
- WordPress HTTP API (`wp_remote_get`, `wp_remote_post`)
- WordPress Settings API
- WordPress Options API

## External Dependencies
- Painless Analytics API (api.painlessanalytics.com)
- Tracking script loaded from configured API URL

## File Organization
- Main plugin file: `painless-analytics.php`
- Core class: `painlessanalytics.class.php`
- Admin class: `admin/painlessanalytics-admin.class.php`
- Views: `views/` (frontend), `admin/views/` (admin)
- Assets: `admin/css/`

## Common Commands
No build process required - standard WordPress plugin deployment:
- Install via WordPress admin or manual upload to `wp-content/plugins/`
- Activate through WordPress Plugins screen
- Configure at Settings > Painless Analytics

## Testing
- Manual testing in WordPress environment
- Test with WordPress versions 5.5 through 6.9
- Verify PHP 5.4+ compatibility
