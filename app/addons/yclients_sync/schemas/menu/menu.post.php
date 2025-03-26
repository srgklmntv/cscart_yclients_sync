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
 * @var array $schema - Adding Yclients Sync menu item
 */
$schema['central']['orders']['items']['yclients_sync.bookings'] = [
    'href' => 'yclients_sync.bookings',
    'position' => 10,
    'attrs'    => [
        'class' => 'is-addon',
    ],
];

return $schema;