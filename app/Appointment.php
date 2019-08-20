<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\SendMail;

class Appointment extends Model
{

    //raymond
    public static function getListAll()
    {
        $res = DB::table('student as s')
            ->rightJoin('student_appointment as sa', 's.id', '=', 'sa.student_id')
            ->rightJoin('appointments as a', 'a.id', '=', 'sa.appointment_id')
            ->join('category as c', 'c.id', '=', 'a.category_id')
            ->join('advisor as as', 'as.id', '=', 'a.advisor_id')
            ->select("a.id as apm_id",'s.*', 'a.id as ap_id', 'a.date', 'a.start_time', 'a.finish_time',  'a.created_at as ap_created_at', 'c.name as category_name', 'as.first_name as advisor_first_name', 'as.last_name as advisor_last_name')
            ->where('a.cancel',0)
            ->orderBy('a.id', 'desc')
            ->get();
        return $res;
    }
    public static function searchAppointment($request)
    {
        $res = DB::table('appointments as a')
            ->join('category as c', 'c.id', '=', 'a.category_id')
            ->join('advisor as as', 'as.id', '=', 'a.advisor_id')
            ->select("a.*", "c.name as category_name", 'as.first_name as first_name', "as.last_name as last_name")
            ->where('a.category_id', $request->category_id)
            ->where('a.advisor_id', $request->advisor_id)
            ->get();
        return $res;
    }
    public static function postCreate($request)
    {
        $finish_time = strtotime("+30 minutes", strtotime($request->start_time));
        DB::table('appointments')->insert(
            [
                'category_id' => $request->category_id,
                'advisor_id' => $request->advisor_id,
                'date' => date("Y-m-d", strtotime($request->date)),
                'start_time' => $request->start_time,
                'finish_time' => date('H:i', $finish_time),
                'created_at' => Carbon::now()->format('Y-m-d'),
            ]
        );
        return 200;
    }
    public static function postAddStudent($request)
    {
        $appointment = DB::table('appointments')->where('id', $request->id)->first();
        $advisor = DB::table('advisor')->where('id', $appointment->advisor_id)->first();
        DB::table('appointments')
            ->where('id', $appointment->id)
            ->update(
                [
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]
            );
        $student_id = DB::table('student')->insertGetId(
            [
                'asu_id' => $request->asu_id,
                'first_name' => $request->first_name,
                'last_name' =>  $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'reason' => $request->reason,
                'phone_call' => $request->phone_call,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );
        DB::table('student_appointment')->insert(
            [
                'student_id' => $student_id,
                'appointment_id' => $request->id,
            ]
        );

        $student_email = $request->email;
        $advisor_email = $advisor->email;
        $subject = "Request an appointment";
        $message = 'Student name: ' . $request->first_name . ' ' . $request->last_name . ', ASU ID: ' . $request->asu_id . ', Email: ' . $request->email . ', reason ' . $request->reason . ', day ' . $appointment->date . ' from : ' . $appointment->start_time . ' to: ' . $appointment->finish_time;

        Mail::to($student_email)->send(new SendMail($subject, $message));
        Mail::to($advisor_email)->send(new SendMail($subject, $message));

        return 200;
    }
    public static function cancel($request)
    {
        // DB::table('student')
        //     ->where('id', $request->student_id)
        //     ->update(
        //         [
        //             'reason_cancel' => $request->reason_cancel,
        //             'cancel_at' => date('Y-m-d h:i:s'),
        //         ]
        //     );
        self::findEmailCancel($request->id, $request->reason_cancel);
        return 200;
    }
    public static function findEmailCancel($id, $reason_cancel)
    {
        $res = DB::table('appointments as a')
            ->where('a.id', $id)
            ->join('student_appointment as sa', 'a.id', '=', 'sa.appointment_id')
            ->join('student as s', 's.id', '=', 'sa.student_id')
            ->join('advisor as ad', 'ad.id', '=', 'a.advisor_id')
            ->select('s.email as student_email', 'ad.email as advisor_email', 's.*', 'a.date', 'a.start_time', 'a.finish_time')
            ->get();
        if ($res) {
            $student_email = $res[0]->student_email;

            $advisor_email = $res[0]->advisor_email;
            $subject = "Cancel an appointment";
            $message = 'Student name: ' . $res[0]->first_name . ' ' . $res[0]->last_name . ', ASU ID: ' . $res[0]->asu_id . ', Email: ' . $res[0]->email . ' reason cancel' .  $reason_cancel . ', day ' . $res[0]->date . ' from : ' . $res[0]->start_time . ' to: ' . $res[0]->finish_time;

            Mail::to($student_email)->send(new SendMail($subject, $message));
            Mail::to($advisor_email)->send(new SendMail($subject, $message));
        }

        return 200;
    }
}
