=== Rewrite Bases Internationalization ===
Contributors: timohubois
Tags: permalinks, author, search, comments, pagination
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 8.0
Stable tag: 1.0.1
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Choose custom URL bases for author archives, search, comment feeds and pagination, with defaults from WordPress translations.

== Description ==

Make WordPress URL paths fit your site's language. Rewrite Bases Internationalization lets you choose the words used in author archive, search, comment feed and pagination URLs, directly in **Settings > Permalinks**.

For example, replace the author base in /author/alex/ with your own word, such as /autor/alex/. The plugin changes shared URL bases, not author names or content.

**Features**

* Customize author archive and search URL bases.
* Customize the base used for site-wide comment feeds.
* Customize general pagination URLs, such as /page/2/.
* Customize comment-pagination URLs, such as /my-post/replies-2/.
* Use defaults derived from WordPress translations or enter your own values.
* Manage the settings in the existing Permalinks screen.

**Before you start**

Changing URL bases can break existing links or conflict with other routes. Activation can also change URLs when blank fields use translated defaults. Test on staging and plan any necessary redirects before changing a public site.

**Technical background**

WordPress manages these URL bases through its Rewrite API. The plugin exposes settings for them and derives blank-field defaults from translated Core labels.

For background, see the [WordPress Rewrite API](https://developer.wordpress.org/reference/classes/wp_rewrite/) and [Core ticket #1762](https://core.trac.wordpress.org/ticket/1762).

== Installation ==

1. Install the plugin through **Plugins > Add New**, or upload the plugin folder to /wp-content/plugins/rewrite-bases-internationalization/.
2. Activate the plugin.
3. Open **Settings > Permalinks** with an account allowed to manage the site's settings. Use a non-Plain permalink structure and ensure pretty permalinks already work on your server.
4. In **Rewrite Bases**, enter the words you want to use, or leave fields blank for the defaults described below. Enter a base word or slug, not a full URL.
5. Click **Save Changes**, then check author archives, search links, comment feeds and pagination. If old rules remain, save the Permalinks screen once more to rebuild them.

Requires WordPress 6.0 or later and PHP 8.0 or later.

== Frequently Asked Questions ==

= What is a rewrite base? =

It is a fixed part of a WordPress URL. In /author/alex/, the base is author; in /page/2/, it is page.

The Comments Base setting concerns site-wide comment feed URLs, such as /comments/feed/. It does not rename a post's comments section or its comment anchor links.

= What happens if I leave a field blank? =

For author archives, search, comment feeds and general pagination, the plugin takes the corresponding WordPress Core label, translates it using the configured Site Language, and converts it to a URL-friendly slug with `sanitize_title()`.

Available defaults depend on the site's installed WordPress translations. Without a translation, the English label is used.

Comment-page Base is the exception: a blank field keeps WordPress's literal `comment-page` base in every language.

The administrator's profile language does not affect these defaults. After changing **Settings > General > Site Language**, save **Settings > Permalinks** to rebuild the rules.

Enter a custom value if you want a different term or a fixed base that does not follow translation defaults.

= Does it translate my site or provide per-language URL bases? =

No. It does not translate posts, pages, author names or search terms, and it does not add language prefixes.

There is one custom value per base across the site, not separate values for each language. The plugin does not provide WPML, Polylang or other multilingual routing integrations.

= How does Comment-page Base change comment pagination URLs? =

Enable comment pagination in **Settings > Discussion**. A Comment-page Base of replies changes /my-post/comment-page-2/ to /my-post/replies-2/.

WordPress handles page numbers, anchors and default-page behavior. It may use the bare post URL for the default comment page. Individual comment links keep their #comment-ID anchors.

Save **Settings > Permalinks** after changing the base. Plain permalinks continue to use the `cpage` query parameter rather than a custom URL base.

= What if my new URLs return 404 errors? =

Open **Settings > Permalinks** and click **Save Changes** again to rebuild rewrite rules. Clear relevant site caches and check for conflicting page slugs, plugin routes or server rules.

Use distinct, URL-friendly base values. The plugin does not resolve routing conflicts or configure your web server.

The Plain permalink structure uses query parameters, so these URL bases are not useful with it.

= Will old URLs redirect to the new ones? =

The plugin does not create redirect rules for previous base values. Record the old paths, test the new ones and configure redirects separately where needed.

Review menus, cached pages and external links as well.

Changing an author base is a URL customization, not an access restriction. It does not make public author archives or other public content private.

= What happens when I deactivate the plugin? =

The plugin stops applying its custom or translated bases, and WordPress returns to its own bases unless another plugin changes them.

WordPress rebuilds its rewrite rules as needed after deactivation; review links and redirects again.

Saved custom values are retained on deactivation and removed when the plugin is uninstalled.

== Screenshots ==

1. The Rewrite Bases section in Settings > Permalinks, showing five fields and a custom Comment-page Base of replies with WordPress's native -2/ URL format.

== Want to contribute? ==

Report issues or contribute on [GitHub](https://github.com/timohubois/rewrite-bases-internationalization/).

== Changelog ==

= 1.0.1 =
* Fix Comment-page Base to use the /base-2/ URL format.
* Keep the native comment-page default in every language when the field is blank. Previously ignored saved custom values now take effect and can change existing comment URLs.
* Keep translated default bases tied to Site Language so an administrator's profile language cannot break frontend URLs.
* Use saved bases consistently when WordPress rebuilds permalink rules.
* Apply saved bases during activation and let WordPress rebuild rules without the plugin after deactivation.
* Remove saved settings correctly on uninstall.
* Correct URL previews and form markup in the Permalinks screen.

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.1 =
The option name and saved values are unchanged; no migration is needed. Previously ignored custom Comment-page Base values now take effect and can change comment URLs. Blank defaults now follow Site Language, not the administrator's language. After updating, save Settings > Permalinks to rebuild rules and review links. No redirects are added.
