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
    protected static $baseUrl = 'https://rajaongkir.komerce.id/api/v1';

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

        if ($response->successful() && $response->json('meta.code') == 200) {
            return collect($response->json('data'));
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
        return self::sendRequest('/destination/province');
    }

    /**
     * Search for a domestic destination (city/subdistrict) by name.
     *
     * @param string $searchQuery
     * @param int $limit
     * @param int $offset
     * @return \Illuminate\Support\Collection|null
     */
    public static function searchCities($searchQuery, $limit = 10, $offset = 0)
    {
        $params = [
            'search' => $searchQuery,
            'limit' => $limit,
            'offset' => $offset,
        ];
        return self::sendRequest('/destination/domestic-destination', $params);
    }

    /**
     * Get shipping cost from RajaOngkir.
     *
     * @param int $origin
     * @param int $destination
     * @param int $weight in grams
     * @param string $courier
     * @param string $price ('lowest' or 'highest')
     * @return \Illuminate\Support\Collection|null
     */
    public static function costRajaOngkir($origin, $destination, $weight, $courier = 'jne', $price = 'lowest')
    {
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
            'price' => $price,
        ];

        return self::sendRequest('/calculate/domestic-cost', $params, 'POST');
    }
}
