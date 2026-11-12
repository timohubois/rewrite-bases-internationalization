<?php

namespace RewriteBasesI18n;

defined('ABSPATH') || exit;
class Plugin
{
    public static function init(): void
    {
        new Features\PluginActionLinks();
        new Features\RewriteBaseLocalizer();
    }

    /**
     * Activation hook callback.
     */
    public static function activate(): void
    {
        self::init();
        flush_rewrite_rules(true);
    }

    /**
     * Deactivation hook callback.
     */
    public static function deactivate(): void
    {
        flush_rewrite_rules(true);
    }

    public static function uninstall(): void
    {
        $rewriteBaseLocalizer = Features\RewriteBaseLocalizer::getInstance();
        $rewriteBaseLocalizer->deleteOptions();
        self::deactivate();
    }
}
