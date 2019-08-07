<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ContactUs extends Model
{
    public static function getContactUs()
    {
        $res = DB::table('contact_us')->get();
        return $res;
    }
    public static function postCreate($request)
    {
        DB::table('contact_us')->insert(
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
