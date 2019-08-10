<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    public static function getList()
    {
        $res = DB::table('category')->where('deleted_at',null)->get();
        return $res;
    }
    public static function postCreate($request)
    {
        DB::table('category')->insert(
            [
                'name' => $request->name,
                'created_at' => date('Y-m-d h:i:s'),
            ]
        );
        return 200;
    }
    public static function postEdit($request)
    {
        DB::table('category')->where('id', $request->id)
            ->update(
                [
                    'name' => $request->name,
                    'updated_at' => date('Y-m-d'),
                ]
            );
        return 200;
    }
    public static function postDelete($request)
    {
        DB::table('category')
        ->where('id',$request->id)
        ->update(
            [
                'deleted_at' => date('Y-m-d'),
            ]
        );
        return 200;
    }
}
