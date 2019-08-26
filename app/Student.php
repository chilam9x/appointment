<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    public static function getList()
    {
        $res = DB::table('student')->get();
        return $res;
    }
    public static function checkStudent($request)
    {
        $res = DB::table('student as s')
        ->join('student_appointment as sa','s.id','=','sa.student_id')
        ->join('appointments as a','a.id','=','sa.appointment_id')
        ->join('category as c','c.id','=','a.category_id')
        ->join('advisor as as','as.id','=', 'a.advisor_id')
        ->where('asu_id', $request->asu_id)
        ->select('s.*','a.id as apm_id','a.date','a.start_time','a.finish_time','a.created_at as ap_created_at','c.name as category_name','as.first_name as advisor_first_name','as.last_name as advisor_last_name')
        ->orderBy('a.id','desc')
        ->get();
        return $res;
    }
}
