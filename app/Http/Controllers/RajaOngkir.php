<?php

namespace App\Http\Controllers;

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
        $statusCode = $rajaongkir->status->code;
        if($statusCode == 200)  //kuota masih cukup
            return $rajaongkir;
        else                    //kuota habis
            return null;
    }
    public static function costRajaOngkir($origin, $destination, $weight)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$origin."&destination=".$destination."&weight=".$weight."&courier=jne",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: ".config('app.RajaOngkir')
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return "cURL Error #:" . $err;
        }
        else
        {
            $response_data = json_decode($response);
            $rajaongkir = $response_data->rajaongkir;
            $statusCode = $rajaongkir->status->code;
            if($statusCode == 200)
            {
                $results = $rajaongkir->results;
                $costs = $results[0]->costs;
                return $costs;
            }
            else
            {
                return null;
            }
        }
    }
}
