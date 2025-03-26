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

use Tygh\Addons\YclientsSync\ServiceProvider;
use Tygh\Registry;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

$params = $_REQUEST;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $suffix = '';

    return [CONTROLLER_STATUS_OK, 'yclients_sync' . $suffix];
}

if ($mode === 'bookings') {
    $yclients_sync_service = ServiceProvider::getYclientsSyncService();

    if (
        !empty($action)
        && $action == 'sync'
    ) {
        $yclients_sync_service->syncBookings();
    }

    [$bookings, $search] = $yclients_sync_service->getBookings(
        $params, Registry::get('settings.Appearance.admin_elements_per_page')
    );

    Tygh::$app['view']->assign([
        'bookings' => $bookings,
        'search'   => $search
    ]);
}