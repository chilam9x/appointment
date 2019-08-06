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
    public static function insert($request)
    {
        $res = DB::table('contact_us')->insert(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'comment' => $request->comment,
                'created_at' => date('Y-m-d'),
            ]
        );
        return 200;
    }

}
