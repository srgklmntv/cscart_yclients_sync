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

namespace Tygh\Addons\YclientsSync;

use Tygh\Addons\YclientsSync\Services\YclientsSync;
use Tygh\Addons\YclientsSync\Services\YclientsApi;
use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Tygh\Tygh;

/**
 * Class ServiceProvider is intended to register services and components of the "YClients Sync" add-on to the
 * application container.
 *
 * @package Tygh\Addons\YclientsSync
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     *
     * @return void
     */
    public function register(Container $app): void
    {
        $app['addons.yclient_sync.services.yclient_sync'] = function (): YclientsSync {
            $yclients_sync = new YclientsSync();
            return $yclients_sync;
        };

        $app['addons.yclient_sync.services.yclient_api'] = function (): YclientsApi {
            $yclients_api = new YclientsApi();
            return $yclients_api;
        };
    }

    /**
     * @return \Tygh\Addons\YclientsSync\Services\YclientsSync
     */
    public static function getYclientsSyncService(): YclientsSync
    {
        return Tygh::$app['addons.yclient_sync.services.yclient_sync'];
    }

    /**
     * @return \Tygh\Addons\YclientsSync\Services\YclientsApi
     */
    public static function getYclientsApiService(): YclientsApi
    {
        return Tygh::$app['addons.yclient_sync.services.yclient_api'];
    }
}