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
 * Install function
 * 
 * Create tables
 * - yclients_bookings
 * 
 * @return void
 */
function fn_yclients_sync_install(): void
{
    db_query("CREATE TABLE IF NOT EXISTS `?:yclients_bookings` (
        `booking_id` int(11) UNSIGNED NOT NULL auto_increment,
        `phone`     varchar(32) NOT NULL DEFAULT '',
        `data`      text NOT NULL DEFAULT '',
        `timestamp` int(11) UNSIGNED NOT NULL DEFAULT '0',
        PRIMARY KEY (`booking_id`),
        KEY `phone` (`phone`),
        UNIQUE KEY `phone_timestamp` (`phone`,`timestamp`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
}

/**
 * Uninstall function
 * 
 * Remove tables
 * - yclients_bookings
 * 
 * @return void
 */
function fn_yclients_sync_uninstall(): void
{
    db_query("DROP TABLE IF EXISTS ?:yclients_bookings");
}

/* HOOKS */

/* HOOKS END */