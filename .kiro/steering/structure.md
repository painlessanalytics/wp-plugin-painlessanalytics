# Project Structure

## Root Level
```
painless-analytics.php          # Main plugin file, entry point
painlessanalytics.class.php     # Core frontend class (singleton)
uninstall.php                   # Cleanup on plugin uninstall
```

## Admin Area
```
admin/
├── painlessanalytics-admin.class.php  # Admin functionality (singleton)
├── css/
│   └── styles.css                     # Admin page styles
└── views/
    ├── header.php                     # Admin page header
    ├── page.php                       # Main settings page
    └── setup.php                      # Setup/configuration view
```

## Frontend Views
```
views/
└── wp_head.php                 # Tracking script injection template
```

## Documentation & Assets
```
.wordpress-org/                 # WordPress.org plugin assets (banners, icons, screenshots)
README.md                       # GitHub readme
readme.txt                      # WordPress.org readme
CHANGELOG.md                    # Version history
LICENSE                         # GPL v2 license
```

## Configuration Files
```
.htaccess                       # Apache configuration
.gitignore                      # Git exclusions
.gitattributes                  # Git attributes
.distignore                     # Distribution exclusions
```

## Architectural Patterns

### Singleton Pattern
Both main classes use singleton pattern via `getInstance()` stored in `$GLOBALS`

### View Loading
- Views are PHP includes loaded via `view()` methods
- Arguments passed as `$args` array to view files
- Frontend views: `painlessAnalytics::view()`
- Admin views: `painlessAnalyticsAdmin::view()`

### Settings Storage
- Settings stored in WordPress options table as `painlessanalytics` array
- Key settings: `api_url`, `link_code`, `admin_mode`, `admin_api_url`, `admin_separately`

### Security
- All files check `ABSPATH` constant to prevent direct access
- Input sanitization via WordPress functions (`sanitize_text_field`, `sanitize_url`, `esc_url`)
- Settings validation in `sanitizeSettings()` callback
