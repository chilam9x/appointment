<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
    use SoftDeletes;

    protected $fillable = ['start_time', 'finish_time', 'comments', 'client_id', 'employee_id'];

    /**
     * Set to null if empty
     * @param $input
     */
    public function setClientIdAttribute($input)
    {
        $this->attributes['client_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setEmployeeIdAttribute($input)
    {
        $this->attributes['employee_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartTimeAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['start_time'] = Carbon::createFromFormat(config('app.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');
        } else {
            $this->attributes['start_time'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartTimeAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i:s');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i:s');
        } else {
            return '';
        }
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setFinishTimeAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['finish_time'] = Carbon::createFromFormat(config('app.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');
        } else {
            $this->attributes['finish_time'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getFinishTimeAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i:s');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i:s');
        } else {
            return '';
        }
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id')->withTrashed();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id')->withTrashed();
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id')->withTrashed();
    }
    //raymond
    public static function getList()
    {
        $res = DB::table('appointments')->where('deleted_at',null)->get();
        return $res;
    }
    public static function postCreate($request)
    {
        $appointment_id = DB::table('appointments')->insertGetID(
            [
                'category_id' => isset($request->category_id)
                && $request->category_id !== "undefined"
                && $request->category_id !== null ? $request->category_id : '',
                'advisor_id' => isset($request->advisor_id)
                && $request->advisor_id !== "undefined"
                && $request->advisor_id !== null ? $request->advisor_id : '',
                'reason' => isset($request->reason)
                && $request->reason !== "undefined"
                && $request->reason !== null ? $request->reason : '',
                'phone_call' => isset($request->phone_call)
                && $request->phone_call !== "undefined"
                && $request->phone_call !== null ? $request->phone_call : 0,
                'date' => isset($request->date)
                && $request->date !== "undefined"
                && $request->date !== null ? $request->date : '',
                'start_time' => isset($request->start_time)
                && $request->start_time !== "undefined"
                && $request->start_time !== null ? $request->start_time : '',
                'finish_time' => isset($request->finish_time)
                && $request->finish_time !== "undefined"
                && $request->finish_time !== null ? $request->finish_time : '',
                'created_at' => date('Y-m-d h:i:s'),
            ]
        );
        $student_id = DB::table('student')->insertGetID(
            [
                'first_name' => isset($request->first_name)
                && $request->first_name !== "undefined"
                && $request->first_name !== null ? $request->first_name : '',
                'last_name' => isset($request->last_name)
                && $request->last_name !== "undefined"
                && $request->last_name !== null ? $request->last_name : '',
                'asu_id' => isset($request->asu_id)
                && $request->asu_id !== "undefined"
                && $request->asu_id !== null ? $request->asu_id : '',
                'email' => isset($request->email)
                && $request->email !== "undefined"
                && $request->email !== null ? $request->email : '',
                'phone' => isset($request->phone)
                && $request->phone !== "undefined"
                && $request->phone !== null ? $request->phone : '',
                'created_at' => date('Y-m-d h:i:s'),
            ]
        );
        $student_appointment = DB::table('student_appointment')->insert(
            [
                'student_id' => $student_id,
                'appointment_id' => $appointment_id,
            ]
        );
        return 200;
    }
    public static function cancel($id)
    {
        DB::table('appointments')
            ->where('id', $id)
            ->update([
                'reason_cancel' => date('Y-m-d h:i:s'),
                'deleted_at' => date('Y-m-d h:i:s'),
            ]
            );
        return 200;
    }
}
