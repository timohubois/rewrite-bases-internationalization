<?php

/**
 * Plugin Name:       Rewrite Bases Internationalization
 * Plugin URI:        https://github.com/timohubois/rewrite-bases-i18n/
 * Description:       Internationalization of rewrite bases for author, search, comments and page slugs.
 * Version:           1.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Timo Hubois
 * Author URI:        https://pixelsaft.wtf
 * Text Domain:       rewrite-bases-internationalization
 * Domain Path:       /languages
 * License:           GPLv3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace RewriteBasesI18n;

defined('ABSPATH') || exit;

if (!defined('REWRITE_BASES_INTERNATIONALIZATION_PLUGIN_FILE')) {
    define('REWRITE_BASES_INTERNATIONALIZATION_PLUGIN_FILE', __FILE__);
}

// Autoloader via Composer if available.
if (file_exists(plugin_dir_path(REWRITE_BASES_INTERNATIONALIZATION_PLUGIN_FILE) . 'vendor/autoload.php')) {
    require plugin_dir_path(REWRITE_BASES_INTERNATIONALIZATION_PLUGIN_FILE) . 'vendor/autoload.php';
}

// Custom autoloader if Composer is not available.
if (!file_exists(plugin_dir_path(REWRITE_BASES_INTERNATIONALIZATION_PLUGIN_FILE) . 'vendor/autoload.php')) {
    spl_autoload_register(static function ($className): void {
        $prefix = 'RewriteBasesI18n\\';
        $baseDir = plugin_dir_path(REWRITE_BASES_INTERNATIONALIZATION_PLUGIN_FILE) . 'classes/';
        $length = strlen($prefix);
        if (strncmp($prefix, $className, $length) !== 0) {
            return;
        }

        $relativeClass = substr($className, $length);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    });
}

load_plugin_textdomain(REWRITE_BASES_INTERNATIONALIZATION_PLUGIN_FILE);

register_activation_hook(REWRITE_BASES_INTERNATIONALIZATION_PLUGIN_FILE, [Plugin::class, 'activate']);
register_deactivation_hook(REWRITE_BASES_INTERNATIONALIZATION_PLUGIN_FILE, [Plugin::class, 'deactivate']);

Plugin::init();
