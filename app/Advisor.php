<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Advisor extends Model
{
    public static function getList()
    {
        $res = DB::table('advisor')->get();
        return $res;
    }
    public static function postCreate($request)
    {
        DB::table('advisor')->insert(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'created_at' => date('Y-m-d'),
            ]
        );
        return 200;
    }
    public static function postEdit($request)
    {
        DB::table('advisor')
        ->where('id',$request->id)
        ->update(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'created_at' => date('Y-m-d'),
            ]
        );
        return 200;
    }
}
