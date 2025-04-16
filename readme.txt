=== Rewrite Bases Internationalization ===
Contributors: timohubois
Tags: permalinks, author, search, comments, pagination
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 8.0
Stable tag: 1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Internationalize rewrite bases for author, search, comments and page (pagination) slugs in WordPress.

== Description ==

This plugin allows you to customize and internationalize the rewrite bases for author archives, search results, comments and page slugs in WordPress. It provides an easy-to-use interface in the Permalinks Settings page to set custom values for these bases.

If you notice that your permalink changes aren't reflecting on your site, try the following steps:

1. Go to Settings > Permalinks in your WordPress admin panel.
2. Without making any changes, click the "Save Changes" button at the bottom of the page.

== Key Features ==

* Customize rewrite bases for author, search, comments and page (pagination) slugs
* Automatically uses WordPress's language-specific terms as defaults, if available
* Integrates seamlessly with the WordPress Permalinks Settings page

== Motivation ==
Internationalized rewrite bases for author, search, comments and page (pagination) in WordPress are not part of the WordPress Core. This is because the [WP_Rewrite](https://github.com/WordPress/wordpress-develop/blob/6.5/src/wp-includes/class-wp-rewrite.php) class uses [hardcoded strings](https://github.com/WordPress/wordpress-develop/blob/c26d2a30d5fbff5bc8fd613f9862a2bcc9c3e62b/src/wp-includes/class-wp-rewrite.php#L49) which were never translated until 2024. There is an old ticket ([#1762](https://core.trac.wordpress.org/ticket/1762)) that discusses this issue, including the idea of modifying the `WP_Rewrite` property with a plugin. This plugin implements that solution. It extends the native Permalinks settings page and adds a section to change the rewrite bases for author, search, comments and page (pagination). By default, these are based on the current language of your site.

== Want to contribute? ==
Check out the Plugin [GitHub Repository](https://github.com/timohubois/rewrite-bases-internationalization/).

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/rewrite-bases-internationalization` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to Settings > Permalinks to configure the rewrite bases.

== Frequently Asked Questions ==

= How do I set custom rewrite bases? =

After activating the plugin, go to Settings > Permalinks. You'll find a new section called "Rewrite Bases" where you can enter custom values for author, search, comments and pagination bases.

= What happens if I leave a field blank? =

If you leave a field blank, the plugin will use WordPress's default language-specific term for that base.

= Does this plugin work with WMPL or other translation plugins? =

This plugins is currently not tested with WMPL or other translation plugins and does not support them.

== Changelog ==

= 1.0 =
* Initial release

== Additional Info ==

For more information about the WordPress Rewrite API, please visit the [WordPress Rewrite API documentation](https://developer.wordpress.org/reference/classes/wp_rewrite/).
