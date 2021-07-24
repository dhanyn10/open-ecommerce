<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RajaOngkir extends Controller
{
    
    public static function getApi($url)
    {
        
        // Read JSON file
        $json_data = file_get_contents($url);
        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);
        $rajaongkir = $response_data->rajaongkir;

        return $rajaongkir;
    }
}
