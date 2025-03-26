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

namespace Tygh\Addons\YclientsSync\Services;

use Tygh\Addons\YclientsSync\ServiceProvider;
use Tygh\Registry;

/**
 * Class YclientsSync
 *
 * @package Tygh\Addons\YclientsSync\Services
 */
class YclientsSync
{
    /**
     * Sync bookings
     * 
     * @return void
     */
    public function syncBookings()
    {
        $yclients_api_service = ServiceProvider::getYclientsApiService();
        $yclients_sync_settings = Registry::get('addons.yclients_sync');

        $user_data = 
            !empty($yclients_sync_settings['yclients_user_login'])
            && !empty($yclients_sync_settings['yclients_user_password'])

            ? $yclients_api_service->getAuth(
                $yclients_sync_settings['yclients_user_login'],
                $yclients_sync_settings['yclients_user_password']
            ) : [];

        $user_token = $user_data['user_token'] ?? '';
        $bookings = !empty($user_token) && !empty($yclients_sync_settings['yclients_company_id'])
            ? $yclients_api_service->getBookings($yclients_sync_settings['yclients_company_id'], $user_token)
            : [];

        foreach ($bookings as $booking) {
            $_data = [
                'phone'     => $booking['client']['phone'] ?? '',
                'timestamp' => strtotime($booking['datetime']),
                'data'      => json_encode($booking)
            ];

            db_query('REPLACE INTO ?:yclients_bookings ?e', $_data);
        }
    }

    /**
     * Getting Bookings
     * 
     * @param array $params Bookings search params
     * @param int   $items_per_page Items per page
     * 
     * @return array Bookings list
     */
    public function getBookings($params, $items_per_page = 0): array
    {
        $condition = $join = $group = '';

        $sortings = [
            'phone' => 'yclients_bookings.phone',
            'timestamp' => 'yclients_bookings.timestamp'
        ];

        $join .= db_quote('LEFT JOIN ?:users as users ON users.phone = yclients_bookings.phone');
        
        /* Make search and sortings */
        $search = $params;
        $search['items_per_page'] = $items_per_page;
        $sorting = db_sort($search, $sortings);

        /* Getting total items count */
        $search['total_items'] = db_get_field(
            'SELECT COUNT(*) FROM ?:yclients_bookings AS yclients_bookings ?p WHERE 1 ?p ?p',
            $join, $condition, $group
        );
        
        /* Setting items limit */
        $limit = db_paginate($search['page'], $search['items_per_page']);

        $bookings = db_get_array(
            'SELECT yclients_bookings.*, users.user_id, users.firstname, users.lastname, users.user_type FROM ?:yclients_bookings AS yclients_bookings ?p WHERE 1 ?p ?p ?p ?p',
            $join, $condition, $sorting, $group, $limit
        );

        foreach ($bookings as &$booking) {
            $booking['data'] = json_decode($booking['data'], true);
        }

        return [$bookings, $search];
    }
}