<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Advisor extends Model
{
    public static function getList()
    {
        $res = DB::table('advisor as a')
        ->join('category as c','c.id','=','a.category_id')
        ->select('a.*','c.name as category_name')
        ->where('a.deleted_at', null)->get();
        return $res;
    }
    public static function postCreate($request)
    {
        DB::table('advisor')->insert(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'category_id'=>$request->category_id,
                'created_at' => date('Y-m-d'),
            ]
        );
        return 200;
    }
    public static function postEdit($request)
    {
        DB::table('advisor')
            ->where('id', $request->id)
            ->update(
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'updated_at' => date('Y-m-d'),
                ]
            );
        return 200;
    }
    public static function postDelete($request)
    {
        DB::table('advisor')
            ->where('id', $request->id)
            ->update(
                [
                    'deleted_at' => date('Y-m-d'),
                ]
            );
        return 200;
    }
    public static function getCategoryAdvisor($id)
    {
        $data = DB::table('advisor')
            ->where('category_id', $id)
            ->get();
        return $data;
    }
}
