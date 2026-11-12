<?php

namespace RewriteBasesI18n;

defined('ABSPATH') || exit;
class Plugin
{
    public static function init(): void
    {
        new Features\PluginActionLinks();
        Features\RewriteBaseLocalizer::init();
    }

    /**
     * Activation hook callback.
     */
    public static function activate(): void
    {
        Features\RewriteBaseLocalizer::getInstance()->updateRewriteBases();
        flush_rewrite_rules(true);
    }

    /**
     * Deactivation hook callback.
     */
    public static function deactivate(): void
    {
        // Let WordPress rebuild rules after this plugin stops applying its bases.
        delete_option('rewrite_rules');
    }

    public static function uninstall(): void
    {
        $rewriteBaseLocalizer = Features\RewriteBaseLocalizer::getInstance();
        $rewriteBaseLocalizer->deleteOptions();
        self::deactivate();
    }
}
