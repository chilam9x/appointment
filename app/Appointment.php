<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\SendMail;

/**
 * Class Appointment
 *
 * @package App
 * @property string $client
 * @property string $employee
 * @property string $start_time
 * @property string $finish_time
 * @property text $comments
 */
class Appointment extends Model
{

    //raymond
    public static function getList()
    {
        $res = DB::table('appointments')->get();
        return $res;
    }
    public static function getListAll()
    {
        $res = DB::table('student as s')
            ->join('student_appointment as sa', 's.id', '=', 'sa.student_id')
            ->join('appointments as a', 'a.id', '=', 'sa.appointment_id')
            ->join('category as c', 'c.id', '=', 'a.category_id')
            ->join('advisor as as', 'as.id', '=', 'a.advisor_id')
            ->select('s.*', 'a.id as ap_id', 'a.reason', 'a.date', 'a.start_time', 'a.finish_time', 'a.reason_cancel', 'a.phone_call', 'a.created_at as ap_created_at', 'a.deleted_at as ap_deleted_at', 'c.name as category_name', 'as.first_name as advisor_first_name', 'as.last_name as advisor_last_name')
            ->orderBy('a.id', 'desc')
            ->get();
        return $res;
    }
    public static function postCreate($request)
    {
        $finish_time=strtotime("+30 minutes", strtotime($request->start_time));
        DB::table('appointments')->insert(
            [
                'category_id' => $request->category_id,
                'advisor_id' => $request->advisor_id,
                'date' =>  $request->date ,
                'start_time' => $request->start_time,
                'finish_time' => date('h:i', $finish_time),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );
        return 200;
    }
    public static function cancel($request)
    {
        self::findEmailCancel($request->id, $request->reason_cancel);
        DB::table('appointments')
            ->where('id', $request->id)
            ->update(
                [
                    'reason_cancel' => $request->reason_cancel,
                    'deleted_at' => date('Y-m-d h:i:s'),
                ]
            );
        return 200;
    }
    public static function findEmailCancel($id, $reason)
    {
        $res = DB::table('appointments as a')
            ->where('a.id', $id)
            ->join('student_appointment as sa', 'a.id', '=', 'sa.appointment_id')
            ->join('student as s', 's.id', '=', 'sa.student_id')
            ->join('advisor as ad', 'ad.id', '=', 'a.advisor_id')
            ->select('s.email as student_email', 'ad.email as advisor_email')
            ->get();
        $email = $res[0]->student_email;
        $email2 = $res[0]->advisor_email;
        $subject = "Cancel an appointment";
        $message = $res[0]->student_email . ' ' . $reason;

        Mail::to($email)->send(new SendMail($subject, $message));
        Mail::to($email2)->send(new SendMail($subject, $message));

        return 200;
    }
}
