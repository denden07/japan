<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Classes\ApiRecieverController;

class ApiController extends Controller
{

    private function getApi(Request $request)
    {


        if ($request->city == '35.6762,139.6503') {
            $city = 'Tokyo';
        } elseif ($request->city == '35.4437,139.6380') {
            $city = 'Yokohama';
        } elseif($request->city == '35.0116,135.7681') {
            $city= 'Kyoto';
        } elseif ($request->city == '34.6937,135.5023') {
            $city = 'Osaka';
        } elseif ($request->city == '43.0618,141.3545') {
            $city = 'Sapporo';
        } else {
            $city = 'Nagoya';
        }



        $foursquare_key = env("FOURSQUARE_KEY");
        $openweather_key = env("OPENWEATHER_KEY");


        $client = new \GuzzleHttp\Client();

        $places = $client->request('GET', 'https://api.foursquare.com/v3/places/search', [

            'query'=>[
                'll' => $request->city,
                'radius'=>$request->radius,
                'query'=>$request->places,
                'limit'=>50,
                'fields'=>'name,photos,location,rating,fsq_id'
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' =>$foursquare_key ,
            ],
        ]);

        $weather = $client->request('GET','https://api.openweathermap.org/data/2.5/weather',[
            'query'=>[
                'q'=>$city,
                'appid' => $openweather_key,
            ]
        ]);

        return ['places'=>$places,'weather'=>$weather];
    }



    public function redirect(Request $request)
    {

        $api_result =  $this->getApi($request);

        return view('pages.places')->with(
            [
                'places_data' => $api_result['places']->getBody(),
                'places_info_data'=> json_encode($request->places),
                'radius_data'=> $request->radius,
                'll_data'=> json_encode($request->city),
                'weather_data'=> $api_result['weather']->getBody(),
            ]
        );

    }

    public function fetchPlaces(Request $request)
    {

        $api_result =  $this->getApi($request);

        return response()->json(

            [
                'places_data'=> json_decode($api_result['places']->getBody()),
                'weather_data'=> json_decode($api_result['weather']->getBody()),
            ]);
    }

    public function fetchPlaceDescription(Request $request)
    {

        $client = new \GuzzleHttp\Client();

        $places_description = $client->request('GET', 'https://api.foursquare.com/v3/places/' . $request->fsq_id , [

            'query'=>[
                'fields'=>'tips,location,stats,rating,description,hours,website,email,photos,name,categories,hours_popular,tastes'
            ],

            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'fsq3wPFDerX5lWK/7gIhncipauFdKbk5DAXuyfaU0kIaPm4=',
            ],
        ]);

        return $places_description->getBody();
    }
}
