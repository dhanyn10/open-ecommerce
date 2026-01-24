<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class RajaOngkir extends Controller
{
    /**
     * Base URL for the RajaOngkir API.
     *
     * @var string
     */
    protected static $baseUrl = 'https://api.rajaongkir.com/starter';

    /**
     * Send a request to the RajaOngkir API.
     *
     * @param string $endpoint
     * @param array $params
     * @param string $method
     * @return \Illuminate\Support\Collection|null
     */
    private static function sendRequest($endpoint, $params = [], $method = 'GET')
    {
        $response = Http::withHeaders([
            'key' => config('app.RajaOngkir')
        ]);

        if ($method === 'POST') {
            $response = $response->asForm()->post(self::$baseUrl . $endpoint, $params);
        } else {
            $response = $response->get(self::$baseUrl . $endpoint, $params);
        }

        if ($response->successful() && $response->json('rajaongkir.status.code') == 200) {
            return collect($response->json('rajaongkir.results'));
        }

        return null;
    }

    /**
     * Get all provinces from RajaOngkir.
     *
     * @return \Illuminate\Support\Collection|null
     */
    public static function getProvinces()
    {
        return self::sendRequest('/province');
    }

    /**
     * Get cities by province ID from RajaOngkir.
     *
     * @param string $provinceId
     * @return \Illuminate\Support\Collection|null
     */
    public static function getCities($provinceId)
    {
        return self::sendRequest('/city', ['province' => $provinceId]);
    }

    /**
     * Get shipping cost from RajaOngkir.
     *
     * @param int $origin
     * @param int $destination
     * @param int $weight
     * @param string $courier
     * @return \Illuminate\Support\Collection|null
     */
    public static function getCost($origin, $destination, $weight, $courier = 'jne')
    {
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ];

        $results = self::sendRequest('/cost', $params, 'POST');

        // The cost API returns a nested array, so we extract the 'costs' part.
        if ($results && isset($results[0]['costs'])) {
            return collect($results[0]['costs']);
        }

        return null;
    }
}
