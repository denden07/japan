<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ApiController extends Controller
{



    public function redirect(Request $request)
    {




        if($request->city == '35.6762,139.6503')
        {
            $city = 'Tokyo';
        }elseif ($request->city == '35.4437,139.6380')
        {
            $city = 'Yokohama';
        }elseif($request->city == '35.0116,135.7681')
        {
            $city= 'Kyoto';
        }elseif ($request->city == '34.6937,135.5023')
        {
            $city = 'Osaka';
        }elseif ($request->city == '43.0618,141.3545')
        {
            $city = 'Sapporo';
        }else
        {
            $city = 'Nagoya';
        }


        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.foursquare.com/v3/places/search', [

               'query'=>[
                   'll' => $request->city,
                   'radius'=>$request->radius,
                   'query'=>$request->places,
                   'limit'=>50,
                   'fields'=>'name,photos,location,rating,fsq_id'
               ],

            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'fsq3wPFDerX5lWK/7gIhncipauFdKbk5DAXuyfaU0kIaPm4=',
            ],
        ]);


        $weather = $client->request('GET','https://api.openweathermap.org/data/2.5/weather',[
            'query'=>[
                'q'=>$city,
                'appid' =>'7ec167be9a9025a5f820c881278a83e0',
            ]
        ]);





        return view('pages.places')->with(
            [
                'api_data' =>$response->getBody(),
                'places'=> json_encode($request->places),
                'radius'=> $request->radius,
                'll'=> json_encode($request->city),
                'weather'=> $weather->getBody(),
            ]



        );
    }

    public function fetchPlaces(Request $request)
    {

        if($request->city == '35.6762,139.6503')
        {
            $city = 'Tokyo';
        }elseif ($request->city == '35.4437,139.6380')
        {
            $city = 'Yokohama';
        }elseif($request->city == '35.0116,135.7681')
        {
            $city= 'Kyoto';
        }elseif ($request->city == '34.6937,135.5023')
        {
            $city = 'Osaka';
        }elseif ($request->city == '43.0618,141.3545')
        {
            $city = 'Sapporo';
        }else
        {
            $city = 'Nagoya';
        }

        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.foursquare.com/v3/places/search', [

            'query'=>[
                'll' => $request->city,
                'radius'=>$request->radius,
                'query'=>$request->places,
                'limit'=>50,
                'fields'=>'name,photos,location,rating,fsq_id'
            ],

            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'fsq3wPFDerX5lWK/7gIhncipauFdKbk5DAXuyfaU0kIaPm4=',
            ],
        ]);

        $weather = $client->request('GET','https://api.openweathermap.org/data/2.5/weather',[
            'query'=>[
                'q'=>$city,
                'appid' =>'7ec167be9a9025a5f820c881278a83e0',
            ]
        ]);


        return response()->json(

            [
               'places'=> json_decode($response->getBody()),
                'weather'=> json_decode($weather->getBody()),


            ]);
    }

    public function fetchPlaceDescription(Request $request)
    {


        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.foursquare.com/v3/places/' . $request->fsq_id , [

            'query'=>[
                'fields'=>'tips,location,stats,rating,description,hours,website,email,photos,name,categories,hours_popular,tastes'
            ],

            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'fsq3wPFDerX5lWK/7gIhncipauFdKbk5DAXuyfaU0kIaPm4=',
            ],
        ]);

        return $response->getBody();
    }
}
