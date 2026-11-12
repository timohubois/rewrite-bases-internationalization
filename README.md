# Rewrite Bases Internationalization

Rewrite Bases Internationalization lets you choose custom URL bases for author archives, search results, site-wide comment feeds and pagination in **Settings > Permalinks**. Blank fields use URL-friendly versions of translated WordPress Core labels from the Site Language setting and its installed WordPress translations, except comment pagination, which keeps WordPress's native `comment-page` base.

For example, change `/author/alex/` to `/autor/alex/` by choosing `autor` as the author base. Author names, post slugs and content are unchanged.

## Requirements

- WordPress 6.0 or later.
- PHP 8.0 or later.
- A non-Plain permalink structure with working server routing.

No other plugin, external account or Composer installation is required to run the plugin.

## Installation

1. Clone this repository into `wp-content/plugins/rewrite-bases-internationalization/`.
2. Activate **Rewrite Bases Internationalization**. Review your URLs afterwards: blank fields apply translation-based defaults rather than necessarily retaining the original bases.
3. Open **Settings > Permalinks** with an account allowed to manage the site's settings.
4. In **Rewrite Bases**, enter base words or slugs, not full URLs. Leave a field blank to use its translation-based default.
5. Click **Save Changes**, then check author archives, search links, comment feed links and pagination. If old rules remain, save the screen once more to rebuild them.

## Limitations

- Custom values are shared across languages. This is not a multilingual content or translation plugin; WPML, Polylang and other multilingual plugins are not supported or verified for compatibility.
- Blank-field defaults follow **Settings > General > Site Language**, not the administrator's profile language. After changing Site Language, save **Settings > Permalinks** to rebuild the rules.
- Comment pagination must be enabled in **Settings > Discussion**. A Comment-page Base of `replies` produces URLs such as `/my-post/replies-2/`; blank uses WordPress's native `comment-page` in every language. WordPress controls page numbers, comment anchors and which page uses the bare post URL. Previously ignored custom values now take effect, so review existing comment links when updating.
- URL changes can break existing links or conflict with other routes. Test on staging, record the old paths and configure redirects separately where needed. The plugin does not create redirects for previous values or configure your web server.
- On deactivation, saved values remain but stop being applied; WordPress rebuilds its rewrite rules as needed. Uninstalling removes the saved values. Review links and redirects.

## Development

Use PHP 8.3 for the Composer development tools, as CI does. Keep plugin code compatible with the PHP 8.0 runtime minimum.

```sh
composer install
composer check-platform-reqs
composer validate --strict
composer php:lint
```

Composer dependencies are development tools, not runtime requirements. To inspect Rector suggestions without applying them, run `composer rector:run -- --dry-run`.

For background on rewrite bases, see [Core ticket #1762](https://core.trac.wordpress.org/ticket/1762).

## License

GPLv3 or later. See [LICENSE](LICENSE).
