<?php

/**
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require_once 'rewrite-bases-i18n.php';

$instance = new RewriteBasesI18n();
$instance->uninstall();
