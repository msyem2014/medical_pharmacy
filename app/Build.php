<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Build extends Model
{
    protected $table = 'buildings';

    public static function add($request){
      $build = new Build;
      $build->city_id = $request->city_id;
      $build->category_id = $request->category_id;
      $build->build_name = $request->build_name;
      $build->desc = $request->desc;
      $build->lat =$request->lat;
      $build->lng = $request->lng;
      $build->save();
      return $build;
    }

    public static function edit($request, $id){
      $build = Build::findOrFail($id);
      $build->city_id = $request->city_id;
      $build->build_name = $request->build_name;
      $build->desc = $request->desc;
      $build->lat =$request->lat;
      $build->lng = $request->lng;
      $build->save();
      return $build;
    }
}
