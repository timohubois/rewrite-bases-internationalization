<?php

namespace RewriteBasesI18n;

defined('ABSPATH') || exit;
class Plugin
{
    public static function init(): void
    {
        $directories = [
            'Features',
        ];

        foreach ($directories as $directory) {
            self::createInstances($directory);
        }
    }

    private static function createInstances(string $directory): array
    {
        $baseFolder = __DIR__;
        $baseNamespace = __NAMESPACE__;

        $folderPath = $baseFolder . '/' . $directory;
        $namespace = $baseNamespace . '\\' . $directory;

        $instances = [];
        $files = glob($folderPath . '/*.php');

        foreach ($files as $filename) {
            $className = $namespace . '\\' . basename($filename, '.php');

            if (class_exists($className)) {
                $instances[] = new $className();
            } else {
                error_log('Class ' . $className . ' does not exist.');
            }
        }

        return $instances;
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
