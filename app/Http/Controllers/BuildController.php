<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Build;
use App\Build_Category;
use Illuminate\Support\Facades\DB;

class BuildController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    public function search(Request $request)
    {
        $lat = $request->lat;
        $lng = $request->lng;
        if ( isset($request->q ) && isset($request->build_type)) {
            $search_name = $request->q;
            $build_type = $request->build_type;
            $query = 'SELECT id, build_name, lat, lng, category_id, 111.045 * DEGREES(ACOS(COS(RADIANS(' . $lat . '))
                                 * COS(RADIANS(lat))
                                 * COS(RADIANS(lng) - RADIANS(' . $lng . '))
                                 + SIN(RADIANS(' . $lat . '))
                                 * SIN(RADIANS(lat))))
                                 AS distance_in_km
                                FROM buildings
                                where build_name like \'%' . $search_name . '%\'
                                AND category_id='.$build_type.'
                                ORDER BY distance_in_km ASC
                                LIMIT 0,7;';
            $places = DB::select($query);
        }else if($request->q  == '' && isset($request->build_type)){
            $build_type = $request->build_type;
            $query = 'SELECT id, build_name, lat, lng, category_id ,111.045 * DEGREES(ACOS(COS(RADIANS(' . $lat . '))
                                 * COS(RADIANS(lat))
                                 * COS(RADIANS(lng) - RADIANS(' . $lng . '))
                                 + SIN(RADIANS(' . $lat . '))
                                 * SIN(RADIANS(lat))))
                                 AS distance_in_km
                                FROM buildings
                                where category_id ='. $build_type.'
                                ORDER BY distance_in_km ASC
                                LIMIT 0,7;';
            $places = DB::select($query);
        }else {
            $query = 'SELECT id, build_name, lat, lng, category_id ,111.045 * DEGREES(ACOS(COS(RADIANS(' . $lat . '))
                                 * COS(RADIANS(lat))
                                 * COS(RADIANS(lng) - RADIANS(' . $lng . '))
                                 + SIN(RADIANS(' . $lat . '))
                                 * SIN(RADIANS(lat))))
                                 AS distance_in_km
                                FROM buildings
                                ORDER BY distance_in_km ASC
                                LIMIT 0,7;';
            $places = DB::select($query);
        }
        return response($places,200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Build_Category::all();
        return response($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $build = Build::add($request);
        return response($build, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $build = Build::join('category_buildings', 'builds.category_id', 'category_buildings.id')->where('builds.id', $id)->first();
        return response($build, 202);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $build = Build::findOrFail($id);
        return response($build, 202);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $build = Build::edit($request, $id);
        return response($build, 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $build = Build::findOrFail($id);
        $build->delete();
        return response($build, 204);
    }
}
