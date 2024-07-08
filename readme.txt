=== Rewrite Bases Internationalization ===
Contributors: timohubois
Tags: permalinks, author, search, comments, pagination
Requires at least: 6.0
Tested up to: 6.4
Requires PHP: 8.0
Stable tag: 1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Internationalize rewrite bases for author, search, comments, and pagination in WordPress.

== Description ==

This plugin allows you to customize and internationalize the rewrite bases for author archives, search results, comments, and pagination in WordPress. It provides an easy-to-use interface in the Permalinks Settings page to set custom values for these bases.

Key features:

* Customize rewrite bases for author, search, comments, and pagination
* Automatically uses WordPress's language-specific terms as defaults
* Integrates seamlessly with the WordPress Permalinks Settings page

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/rewrite-bases-i18n` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to Settings > Permalinks to configure the rewrite bases.

== Frequently Asked Questions ==

= How do I set custom rewrite bases? =

After activating the plugin, go to Settings > Permalinks. You'll find a new section called "Rewrite Bases" where you can enter custom values for author, search, comments, and pagination bases.

= What happens if I leave a field blank? =

If you leave a field blank, the plugin will use WordPress's default language-specific term for that base.

= Does this plugin with WMPL or other translation plugins =

This plugins is currently not tested with WMPL or other translation plugins or support them.

== Changelog ==

= 1.0 =
* Initial release

== Additional Info ==

For more information about the WordPress Rewrite API, please visit the [WordPress Rewrite API documentation](https://developer.wordpress.org/reference/classes/wp_rewrite/).

This plugin is maintained on GitHub. You can find the repository at: https://github.com/timohubois/rewrite-bases-i18n/
