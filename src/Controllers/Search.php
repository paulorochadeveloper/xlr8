<?php


namespace Rocha\Xlr8\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Search
{
    public function getNearbyHotels(Request $request)
    {

        //Controller with validation and trait params
        $latitude = $request->lat;
        $longitude = $request->long;
        $range = isset($request->range) ? $request->range : 100;
        $sort = isset($request->sort) ? $request->sort : 'distance';

        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric|between:-90,90',
            'long' => 'required|numeric|between:-180,180',
        ],
        [
            'lat.required' => 'latitude is required',
            'long.required' => 'longitude is required'
        ]);

        if ($validator->fails()) {
            return view('hotels::index', ["fails" => "Latitude and longitude is required"]);
        }

        //Helper to get hotels from service
        $hotelsList = getHotels($latitude, $longitude, $sort, $range);

        if (count($hotelsList) === 0) {
            return view('hotels::index', ["fails" => "Nothing to show, look for hotels in another location"]);
        }

        return view('hotels::index', compact('hotelsList'));
    }
}

