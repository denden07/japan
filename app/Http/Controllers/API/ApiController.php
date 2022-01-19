<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Classes\ApiRecieverController;

class ApiController extends Controller
{
    public function variables(Request $request)
    {
        $city = $request->city;
        $places = $request->places;
        $radius = $request->radius;

        $api_receiver = new ApiRecieverController();
        $api_result_response = $api_receiver->getApi($city, $places, $radius);

        return
            [
                'city' => $city,
                'places' => $places,
                'radius' => $radius,
                'places_api' => $api_result_response['places_api']->getBody(),
                'weather_api' => $api_result_response['weather_api']->getBody(),
            ];
    }

    public function redirectFetchPlaces(Request $request)
    {

        $api_variables = $this->variables($request);

        return view('pages.places')->with(
            [
                'places_data' => $api_variables['places_api'],
                'places_description'=> json_encode($api_variables['places']),
                'radius_data'=> $api_variables['radius'],
                'll_data'=> json_encode($api_variables['city']),
                'weather_data'=> $api_variables['weather_api'],
            ]);

    }

    public function fetchPlaces(Request $request)
    {

        $api_variables = $this->variables($request);

        return response()->json(
            [
                'places_data' => json_decode($api_variables['places_api']),
                'weather_data'=> json_decode($api_variables['weather_api']),
            ]);

    }

    public function fetchPlaceDescription(Request $request)
    {

        $client = new \GuzzleHttp\Client();

        $foursquare_key = env("FOURSQUARE_KEY");

        $places_description = $client->request('GET', 'https://api.foursquare.com/v3/places/' . $request->fsq_id , [

            'query'=>[
                'fields'=>'tips,location,stats,rating,description,hours,website,email,photos,name,categories,hours_popular,tastes'
            ],

            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $foursquare_key,
            ],
        ]);

        return $places_description->getBody();
    }
}
