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
                'created_at' => date('Y-m-d'),
            ]
        );
        return 200;
    }

}
