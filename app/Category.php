<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Category extends Model
{
    public static function getList()
    {
        $res = DB::table('category')->get();
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

}
