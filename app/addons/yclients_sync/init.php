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
use Tygh\Tygh;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

$service_provider = new ServiceProvider();
Tygh::$app->register($service_provider);

fn_register_hooks();