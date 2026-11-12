=== Rewrite Bases Internationalization ===
Contributors: timohubois
Tags: permalinks, author, search, comments, pagination
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 8.0
Stable tag: 1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Choose custom URL bases for author archives, search, comment feeds and pagination, with defaults from WordPress translations.

== Description ==

Make WordPress URL paths fit your site's language. Rewrite Bases Internationalization lets you choose the words used in author archive, search, comment feed and pagination URLs, directly in **Settings > Permalinks**.

For example, you can replace the author base in /author/alex/ with your own word, such as /autor/alex/. You choose the base; the plugin does not translate names or content.

Leave a field blank to use a URL-friendly version of the corresponding translated WordPress Core label. Available defaults depend on the active WordPress locale and its installed translations. Without a translation, the English label is used. Comment pagination is the exception: a blank field keeps WordPress's native comment-page base in every language.

**Features**

* Customize the author archive and search URL bases.
* Customize the base used for site-wide comment feeds.
* Customize the pagination base used in URLs such as /page/2/.
* Customize comment-pagination URLs, such as /my-post/replies-2/.
* Use translated WordPress Core labels as defaults, or enter your own values.
* Manage the settings in the existing Permalinks screen, with no separate settings page or external service.

**Important limits**

This is not a multilingual content or automatic translation plugin. It stores one custom value per base, not separate values for each language. WPML, Polylang and other multilingual plugins are not supported or verified for compatibility.

Comment-page Base now changes comment-pagination URLs. Previously ignored saved custom values take effect; a blank field keeps the native comment-page base. Review existing comment links when updating, and configure redirects separately where needed.

Changing URL bases can break existing links or conflict with other routes. Test changes on a staging site and plan any necessary redirects before changing a public site.

== Installation ==

1. Install the plugin through **Plugins > Add New**, or upload the plugin folder to /wp-content/plugins/rewrite-bases-internationalization/.
2. Activate the plugin. Review your URLs afterwards: blank fields use the available WordPress translation defaults rather than necessarily retaining the original bases.
3. Open **Settings > Permalinks** with an account allowed to manage the site's settings. Use a non-Plain permalink structure and ensure pretty permalinks already work on your server.
4. In **Rewrite Bases**, enter the words you want to use, or leave fields blank for the translation-based defaults. Enter a base word or slug, not a full URL.
5. Click **Save Changes**, then check author archives, search links, comment feed links and pagination as applicable. If old rules remain, save the Permalinks screen once more to rebuild them.

Requires WordPress 6.0 or later and PHP 8.0 or later. No other plugin, external account or Composer installation is required for normal use. Your web server must already support your chosen WordPress permalink structure; the plugin does not configure it for you.

== Frequently Asked Questions ==

= What is a rewrite base? =

It is a fixed part of a WordPress URL. In /author/alex/, the base is author; in /page/2/, it is page. This plugin changes those shared bases, not individual author names, post slugs or page slugs.

The Comments Base setting concerns site-wide comment feed URLs, such as /comments/feed/. It does not rename a post's comments section or its comment anchor links.

= What happens if I leave a field blank? =

For author, search, comment feeds and general pagination, the plugin takes the matching WordPress Core label, translates it using the active locale, and converts it to a URL-friendly slug using WordPress's sanitize_title() function. If no translation is available, the English label is used. Comment-page Base instead keeps WordPress's literal comment-page default; WordPress does not translate that base.

These are slugs derived from translated interface labels, not a curated list of localized permalink words. Review the result for your language. Enter a custom value if you want a different term or a fixed base that does not follow translation defaults.

= Does it translate my site or work with WPML or Polylang? =

No. It does not translate posts, pages, author names or search terms, and it does not add language prefixes or per-language settings. Custom values are shared across languages. Blank-field defaults follow the active WordPress locale, which multilingual plugins may change.

WPML, Polylang and other translation plugins are not supported or verified for compatibility. Do not assume this plugin will maintain working URL bases for every language on a multilingual site.

= How does Comment-page Base change comment pagination URLs? =

Enable comment pagination in **Settings > Discussion**. A Comment-page Base of replies changes /my-post/comment-page-2/ to /my-post/replies-2/. WordPress may use the bare post URL for the default comment page. Individual comment links keep their #comment-ID anchors.

The option name and saved values are unchanged; no migration is needed. Custom values saved before this fix now affect comment URLs. A blank field keeps WordPress's native comment-page base, including in non-English locales. WordPress handles page numbers, anchors and default-page behavior. Save **Settings > Permalinks** to rebuild the rules. Plain permalinks continue to use the cpage query parameter rather than a custom URL base.

= What if my new URLs return 404 errors? =

Open **Settings > Permalinks** and click **Save Changes** again to rebuild rewrite rules. Clear relevant site caches and check that pretty permalinks work without conflicting page slugs, plugin routes or server rules. Use distinct, URL-friendly base values.

This plugin does not resolve routing conflicts or configure your web server. The Plain permalink structure uses query parameters, so these URL bases are not useful with it.

= Will old URLs redirect to the new ones? =

The plugin does not create redirect rules for previous base values. Before changing a public site's URLs, record the old paths, test the new ones and configure redirects separately where needed. Review menus, cached pages and external links as well.

Changing an author base is a URL customization, not an access restriction. It does not make public author archives or other public content private.

= What happens when I deactivate the plugin? =

The plugin stops applying its custom or translated bases, and WordPress returns to its own bases unless another plugin changes them. WordPress rebuilds its rewrite rules as needed after deactivation; review links and redirects again. Saved custom values are retained on deactivation and removed when the plugin is uninstalled.

== Screenshots ==

1. The Rewrite Bases section in Settings > Permalinks, showing five fields and a custom Comment-page Base of replies with WordPress's native -2/ URL format.

== Want to contribute? ==

Report issues or contribute through the [GitHub repository](https://github.com/timohubois/rewrite-bases-internationalization/). Include your permalink structure, WordPress locale and any other plugins that change URL routing when reporting a problem.

For background, see the [WordPress Rewrite API](https://developer.wordpress.org/reference/classes/wp_rewrite/) and [Core ticket #1762](https://core.trac.wordpress.org/ticket/1762).

== Changelog ==

= 1.0 =
* Initial release
