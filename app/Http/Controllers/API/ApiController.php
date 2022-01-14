<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ApiController extends Controller
{



    public function redirect(Request $request)
    {



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





        return view('pages.places')->with(
            [
                'api_data' =>$response->getBody(),
                'places'=> json_encode($request->places),
                'radius'=> $request->radius,
                'll'=> json_encode($request->city),
            ]



        );
    }

    public function fetchPlaces(Request $request)
    {
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

        return $response->getBody();


    }

    public function fetchPlaceDescription(Request $request)
    {


        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.foursquare.com/v3/places/' . $request->fsq_id , [

            'query'=>[
                'fields'=>'tips,location,stats,rating,description,hours,website,email,photos'
            ],

            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'fsq3wPFDerX5lWK/7gIhncipauFdKbk5DAXuyfaU0kIaPm4=',
            ],
        ]);

        return $response->getBody();
    }
}
