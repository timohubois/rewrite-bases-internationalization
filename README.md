# Rewrite Bases Internationalization for WordPress

This plugin allows you to customize and internationalize the rewrite bases for author archives, search results, comments, and page slugs in WordPress. It provides an easy-to-use interface in the Permalinks Settings page to set custom values for these bases.

## Motivation

Internationalized rewrite bases for author, search, comments, and page (pagination) in WordPress are not part of the WordPress Core. This is because the [WP_Rewrite](https://github.com/WordPress/wordpress-develop/blob/6.5/src/wp-includes/class-wp-rewrite.php) class uses [hardcoded strings](https://github.com/WordPress/wordpress-develop/blob/c26d2a30d5fbff5bc8fd613f9862a2bcc9c3e62b/src/wp-includes/class-wp-rewrite.php#L49) which were never translated until 2024.
There is an old ticket ([#1762](https://core.trac.wordpress.org/ticket/1762)) that discusses this issue, including the idea of modifying the `WP_Rewrite` property with a plugin. This plugin implements that solution. It extends the native Permalinks settings page and adds a section to change the rewrite bases for author, search, comments, and page (pagination). By default, these are based on the current language of your site.

If you notice that your permalink changes aren't reflecting on your site, try the following steps:

1. Go to Settings > Permalinks in your WordPress admin panel.
2. Without making any changes, click the "Save Changes" button at the bottom of the page.

## Requirements

* PHP >= 8.0

## Installation

1. Make sure you have the correct [requirements](#requirements).
2. Clone the repository and place it in `wp-content/plugins/` folder.

## Development

1. Make sure you have the correct [requirements](#requirements).
2. Perform [Installation](#installation).
3. Run `composer i` to install composer dependency.

## License

GPLv3
