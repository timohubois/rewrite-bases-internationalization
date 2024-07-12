<?php

namespace RewriteBasesI18n\Features;

defined('ABSPATH') || exit;

final class PluginActionLinks
{
    public function __construct()
    {
        add_filter('plugin_action_links_' . plugin_basename(REWRITE_BASES_I18N_PLUGIN_FILE), [$this, 'addActionLinks']);
    }

    /**
     * Add settings link to plugin page.
     *
     * @param array $links Existing plugin action links.
     * @return array Modified plugin action links.
     */
    public function addActionLinks(array $links): array
    {
        array_unshift($links, '<a href="options-permalink.php">' . __('Permalinks Settings', 'rewrite-bases-internationalization') . '</a>');
        return $links;
    }
}
