# Painless Analytics Changelog
[Painless Analytics WordPress plugin](https://www.painlessanalytics.com/resources/painless-analytics-wordpress-plugin/).

All notable changes to this project will be documented in this file.

**Keep a Changelog**
The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

Each version section should start with a H2 (`## `), the version number in hard brackets, a space-dash-space (` - `), 
and the release date in ISO date format (ISO 8601), *YYYY-MM-DD*.
The proceeding line may contain 1 or more sentences describing the purpose of the release.
A blank line is added to separate the heading/paragraph from the list of changes.
Changes are listed, each item prefixed with a minus (-) character. Tabs may be used to indent the list.
A blank line is added to separate the list from the next heading/paragraph.

```markdown
## [0.0.0] - 2025-01-02
This is an example changelog entry.

- Fixed this
  - and this,
  - and this
  - and that
- Added that
- Removed other
```

**Semantic Versioning**
This project adheres _somewhat_ to [Semantic Versioning](https://semver.org/spec/v2.0.0.html). 
The first version of a MAJOR or MINOR release will exclude the second dot followed by zero (`.0`).
For example `2.0` will be used rather than `2.0.0`. Otherwise Semantic Versioning is strictly followed.

## [Unreleased]
TBD

## [0.9.14] - 2025-04-21

- Updated CHANGELOG.md (follow up after 0.9.13 release)
- This version does not need released to WordPress.org

## [0.9.13] - 2025-04-21

- Tested with WordPress 6.8
- Added CHANGELOG.md

## [0.9.12] - 2025-02-09

- Tested with 6.7.1

## [0.9.9] - 2024-11-07

- Setup GitHub to deploy to svn

## [0.9.5] - 2024-11-06

- Added banner and icon images for the assets folder.

## [0.9.4] - 2024-10-03

- Added `wp_unslash()` when sanitizing `HTTP_HOST` per instruction from the official Plugin Check plugin

## [0.9.3] - 2024-10-03

- Added documentation of use of a 3rd Party or external service (Painless Analytics)
- Moved API url to be a private member variable of the Painless Analytics class
- Fixed Internationalization issue: text domain not set in the header.php
- Made `sanitizeSettings()` a member function (no longer static) to reference member variables of object
- Added `sanitize_text_field()` to `$_SERVER['HTTP_HOST']`
- Standardized on `painlessanalytics_` prefix for functions and global object names
- For security, all files now `exit()` if they are accessed directly
- Confirmed the settings page form is using appropriate nonce code
- Replaced `dirname(__FILE__)` calls to use defines `PAINLESSANALYTICS_PLUGIN_PATH` and `PAINLESSANALYTICS_PLUGIN_URL` in the core plugin file

## [0.9.2] - 2024-08-26

- Updated the text-domain to match new slug name _painless-analytics_

## [0.9.1] - 2024-08-26

- Added new logic to setup embed code by using a Link Code available from Painless Analytics

