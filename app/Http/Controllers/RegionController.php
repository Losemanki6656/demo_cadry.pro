<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Region;
use App\Models\City;
use App\Models\Cadry;
use App\Http\Resources\RegionCollection;
use App\Http\Resources\CityCollection;

class RegionController extends Controller
{
    public function api_regions()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $regions = Region::paginate($per_page);

        return response()->json([
            'regions' => new RegionCollection($regions)
        ]);
    }

    public function region_create(Request $request)
    {
        $region = new Region();
        $region->name = $request->name;
        $region->save();

        return response()->json([
            'message' => 'successfully created'
        ]);
    }

    public function region_update($region_id, Request $request)
    {
        $region = Region::find($region_id);
        $region->name = $request->name;
        $region->save();

        return response()->json([
            'message' => 'successfully updated'
        ]);
    }

    public function region_delete($region_id)
    {
            $region = Region::find($region_id)->delete();

            return response()->json([
                'message' => 'successfully deleted'
            ]);
    }


    public function api_cities()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $cities = City::with('region')->paginate($per_page);

        return response()->json([
            'cities' => new CityCollection($cities)
        ]);
    }

    public function city_create(Request $request)
    {
        $city = new City();
        $city->region_id = $request->region_id;
        $city->name = $request->name;
        $city->save();

        return response()->json([
            'message' => 'successfully created'
        ]);
    }

    public function city_update($city_id, Request $request)
    {
        $city = City::find($city_id);
        $city->region_id = $request->region_id;
        $city->name = $request->name;
        $city->save();

        return response()->json([
            'message' => 'successfully updated'
        ]);
    }

    public function city_delete($city_id)
    {
        $city = City::find($city_id)->delete();

        return response()->json([
            'message' => 'successfully deleted'
        ]);
    }


}
