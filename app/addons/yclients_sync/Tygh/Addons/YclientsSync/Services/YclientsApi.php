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

use Tygh\Http;
use Tygh\Registry;

/**
 * Class YclientsApi
 * Handles synchronization with YClients API
 *
 * @package Tygh\Addons\YclientsSync\Services
 * 
 * @see https://developers.yclients.com/ru/
 */
class YclientsApi
{
    /**
     * Base URL for YClients API
     *
     * @var string
     */
    private string $api_url = 'https://api.yclients.com/api/v1';

    /**
     * Partner token for authentication
     *
     * @var string
     */
    private string $partner_token;

    /**
     * GET api method
     *
     * @var string
     */
    private string $method_get = 'GET';

    /**
     * POST api method
     *
     * @var string
     */
    private string $method_post = 'POST';

    /**
     * PUT api method
     *
     * @var string
     */
    private string $method_put = 'PUT';

    /**
     * DELETE api method
     *
     * @var string
     */
    private string $method_delete = 'DELETE';

    /**
     * YclientsApi constructor
     * 
     * @return void
     */
    public function __construct()
    {

        $this->setPartnerToken(Registry::get('addons.yclients_sync.yclients_partner_token'));
    }

    /**
     * Setting partner token
     *
     * @param string $partner_token - Partner token
     * 
     * @return self
     */
    public function setPartnerToken($partner_token): static
    {
        $this->partner_token = $partner_token;

        return $this;
    }

    /**
     * Getting partner token
     * 
     * @return string Partner token
     */
    public function getPartnerToken(): string
    {
        return $this->partner_token;
    }

    /**
     * Getting user token by login and password
     *
     * @param string $login
     * @param string $password
     * 
     * @return array Auth user data
     */
    public function getAuth($login, $password)
    {
        $response = $this->request('/auth', [
            'login' => $login,
            'password' => $password,
        ], $this->method_post);

        return $response['data'] ?? [];
    }

    /**
     * Fetch bookings from YClients API for a specific company
     *
     * @param int $company_id The ID of the company
     * @param string $user_token User token
     * @param array $params Optional parameters for filtering bookings
     * 
     * @return array List of bookings
     */
    public function getBookings(int $company_id, string $user_token, array $params = []): array
    {
        $endpoint = '/records/' . $company_id;
        $response = $this->request($endpoint, $params, $this->method_get, $user_token);

        return $response['data'] ?? [];
    }

    /**
     * Perform an HTTP GET request to the YClients API
     *
     * @param string $endpoint API endpoint
     * @param array $params Query parameters
     * @param string $method Request method
     * @param string $user_token User token
     * 
     * @return array Decoded JSON response
     */
    private function request(string $endpoint, array $params = [], string $method, string $user_token = ''): array
    {
        $url = $this->api_url . $endpoint;
        $response = false;

        /* Set up headers for the request */
        $headers = [
            'Authorization: Bearer ' . $this->partner_token . (!empty($user_token) ? ', User ' . $user_token : ''),
            'Content-Type: application/json',
            'Accept: application/vnd.api.v2+json'
        ];

        switch ($method) {
            case $this->method_get:
                /* Perform the GET request */
                $response = Http::get($url, $params, [
                    'headers' => $headers,
                ]);
                break;
            case $this->method_post:
                /* Perform the GET request */
                $response = Http::post($url, json_encode($params), [
                    'headers' => $headers,
                ]);
                break;
            default:
                throw new \InvalidArgumentException("Unsupported HTTP method: $method");
        }
        
        /* Decode the JSON response */
        return json_decode($response, true) ?? [];
    }
}