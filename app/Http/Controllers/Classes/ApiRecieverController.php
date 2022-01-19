<?php

namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ApiRecieverController extends Controller
{

    public function getApi($city_var,$places_var,$radius_var)
    {

        if ($city_var == '35.6762,139.6503') {
            $city = 'Tokyo';
        } elseif ($city_var == '35.4437,139.6380') {
            $city = 'Yokohama';
        } elseif($city_var == '35.0116,135.7681') {
            $city= 'Kyoto';
        } elseif ($city_var == '34.6937,135.5023') {
            $city = 'Osaka';
        } elseif ($city_var == '43.0618,141.3545') {
            $city = 'Sapporo';
        } else {
            $city = 'Nagoya';
        }

        $foursquare_key = env("FOURSQUARE_KEY");
        $openweather_key = env("OPENWEATHER_KEY");

        $client = new \GuzzleHttp\Client();

        $places_api = $client->request('GET', 'https://api.foursquare.com/v3/places/search', [

            'query'=>[
                'll' => $city_var,
                'radius'=>$radius_var,
                'query'=>$places_var,
                'limit'=>50,
                'fields'=>'name,photos,location,rating,fsq_id'
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' =>$foursquare_key ,
            ],
        ]);

        $weather_api = $client->request('GET','https://api.openweathermap.org/data/2.5/weather',[
            'query'=>[
                'q'=>$city,
                'appid' => $openweather_key,
            ]
        ]);

        return
            [
                'places_api'=>$places_api,
                'weather_api'=>$weather_api
            ];
    }

}
