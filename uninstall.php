<?php

/**
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require_once 'classes/Plugin.php';

RewriteBasesI18n\Plugin::uninstall();
