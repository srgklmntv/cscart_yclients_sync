<?php
/**
 * ┌────────────────────────────────────────────────────────────────┐
 * │ © srgklmntv - Professional development on the CS-Cart platform │
 * ├────────────────────────────────────────────────────────────────┤
 * │ Author   : Sergei Klementev                                    │
 * │ Email    : srgklmntv@gmail.com                                 │
 * │ Telegram : @srgklmntv                                          │
 * └────────────────────────────────────────────────────────────────┘
 */

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

/**
 * @var array $schema - Setting Yclients Sync controller permission
 */
$schema['controllers']['yclients_sync']['permissions'] = true;

return $schema; 