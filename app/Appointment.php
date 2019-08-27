<?php

namespace App;

use App\Mail\SendMail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mail;

class Appointment extends Model
{

    public static function getListCalendar()
    {
        $res = DB::table('appointments as a')
            ->leftJoin('category as c', 'c.id', '=', 'a.category_id')
            ->leftJoin('advisor as ad', 'ad.id', '=', 'a.advisor_id')
            ->select('a.*', 'c.name', 'ad.first_name', 'ad.last_name')
            ->where('c.deleted_at', null)
            ->where('ad.deleted_at', null)
            ->get();
        return $res;
    }
    public static function getAppointment($id)
    {
        $res = DB::table('appointments as a')
            ->leftJoin('student_appointment as sa', 'a.id', '=', 'sa.appointment_id')
            ->leftJoin('student as s', 's.id', '=', 'sa.student_id')
            ->join('category as c', 'c.id', '=', 'a.category_id')
            ->join('advisor as as', 'as.id', '=', 'a.advisor_id')
            ->where('a.id', $id)
            ->select("a.id as apm_id", 's.*', 'a.id as ap_id', 'a.date', 'a.start_time', 'a.finish_time', 'a.created_at as ap_created_at', 'c.name as category_name', 'as.first_name as advisor_first_name', 'as.last_name as advisor_last_name')
            ->orderBy('a.id', 'desc')
            ->get();
        return $res;
    }
    public static function getListAll()
    {
        $res = DB::table('appointments as a')
            ->leftJoin('student_appointment as sa', 'a.id', '=', 'sa.appointment_id')
            ->leftJoin('student as s', 's.id', '=', 'sa.student_id')
            ->join('category as c', 'c.id', '=', 'a.category_id')
            ->join('advisor as as', 'as.id', '=', 'a.advisor_id')
            ->select("a.id as apm_id", 's.*', 'a.id as ap_id', 'a.date', 'a.start_time', 'a.finish_time', 'a.created_at as ap_created_at', 'c.name as category_name', 'as.first_name as advisor_first_name', 'as.last_name as advisor_last_name')
            ->get();
        return $res;
    }
    public static function searchAppointment($request)
    {
        $category_id=$request->category_id;
        $advisor_id=$request->advisor_id;

        $res = DB::table('appointments as a')
            ->leftJoin('category as c', 'c.id', '=', 'a.category_id')
            ->leftJoin('advisor as ad', 'ad.id', '=', 'a.advisor_id')
            ->select('a.*', 'c.name', 'ad.first_name', 'ad.last_name')
            ->where('c.deleted_at', null)
            ->where('ad.deleted_at', null);
        if($category_id!=0)
        {
            $res->where('c.id',$category_id);
        }
        if($advisor_id!=0)
        {
            $res->where('ad.id',$advisor_id);
        }
        return $res->get();
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
                'status' => 0, //
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
                    'status' => 1, //apm new
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]
            );
        $student_id = DB::table('student')->insertGetId(
            [
                'asu_id' => $request->asu_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'reason' => $request->reason,
                'cancel' => 0,
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

        // Mail::to($student_email)->send(new SendMail($subject, $message));
        //  Mail::to($advisor_email)->send(new SendMail($subject, $message));

        return 200;
    }
    public static function cancel($request)
    {
        $res = DB::table('appointments as a')
            ->where('a.id', $request->appointment_id)
            ->update(
                [
                    'status' => 0,
                ]
            );
        DB::table('student')
            ->where('id', $request->student_id)
            ->update(
                [
                    'reason_cancel' => $request->reason_cancel,
                    'cancel' => 1,
                    'cancel_at' => date('Y-m-d h:i:s'),
                ]
            );

        // self::findEmailCancel($request->student_id, $request->reason_cancel);
        return 200;
    }
    public static function findEmailCancel($id, $reason_cancel)
    {

        $res = DB::table('student as s')
            ->where('s.id', $id)
            ->join('student_appointment as sa', 's.id', '=', 'sa.student_id')
            ->join('appointments as a', 'a.id', '=', 'sa.appointment_id')
            ->join('advisor as ad', 'ad.id', '=', 'a.advisor_id')
            ->select('s.email as student_email', 'ad.email as advisor_email', 's.*', 'a.date', 'a.start_time', 'a.finish_time')
            ->get();
        if ($res) {
            $student_email = $res[0]->student_email;

            $advisor_email = $res[0]->advisor_email;
            $subject = "Cancel an appointment";
            $message = 'Student name: ' . $res[0]->first_name . ' ' . $res[0]->last_name . ', ASU ID: ' . $res[0]->asu_id . ', Email: ' . $res[0]->email . ' reason cancel' . $reason_cancel . ', day ' . $res[0]->date . ' from : ' . $res[0]->start_time . ' to: ' . $res[0]->finish_time;

            Mail::to($student_email)->send(new SendMail($subject, $message));
            Mail::to($advisor_email)->send(new SendMail($subject, $message));
        }

        return 200;
    }
}
