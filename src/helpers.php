<?php

use GuzzleHttp\Client;

if (!function_exists('getHotels')) {
    function getHotels($lat, $long, $sort, $range)
    {
        // Get urls services to exercise
        $getServiceList = getServiceList();
        $result = [];

        // Merge services resources
        foreach ($getServiceList as $endPoint) {
            $service = new Client();
            $response =   $service->request('GET', $endPoint);
            $list = json_decode($response->getBody(), true);
            if ($list && isset($list['success']) && $list['success'] == true) {
                foreach ($list['message'] as $key => $hotel) {
                    $hotelLatitude = isset($hotel[1]) ? trim($hotel[1]) : null;
                    $hotelLongitude = isset($hotel[2]) ? trim($hotel[2]) : null;
                    if (is_numeric($hotelLatitude) && is_numeric($hotelLongitude)) {
                        // Calc points
                        $distance = getDistance( $hotelLatitude, $hotelLongitude, $lat, $long, 'K');
                        $result[$key]['hotel'] = $hotel[0];
                        $result[$key]['distance'] = $distance;
                        $result[$key]['unit'] = 'km';
                        $result[$key]['price'] = $hotel[3];
                        $result[$key]['currency'] = '€';

                    }
                }
            }
        }

        // Transform collect to trait sort and conditions
        $collectHotels = collect($result);

        if ($sort == 'price') {
            $sortedHotels= $collectHotels->sortBy('price');
        } else {
            $sortedHotels = $collectHotels->sortBy('distance');
        }

        // set ray
        $sortedHotels = $sortedHotels->where('distance', '<', $range);

        $sortHotels = $sortedHotels->values()->map(function ($hotel) {
            return $hotel;
        });

        return $sortHotels;
    }
}

if (!function_exists('getServiceList')) {
    function getServiceList()
    {
        return [
            'https://xlr8-interview-files.s3.eu-west-2.amazonaws.com/source_1.json',
            'https://xlr8-interview-files.s3.eu-west-2.amazonaws.com/source_2.json'
        ];
    }
}


if (!function_exists('distance')) {
    function getDistance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return number_format($miles * 1.609344, 2, '.', '');
            }else {
                return $miles;
            }
        }
    }
}

