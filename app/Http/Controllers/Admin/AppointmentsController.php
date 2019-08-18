<?php

namespace App\Http\Controllers\Admin;

use App\Advisor;
use App\Appointment;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAppointmentsRequest;
use App\Http\Requests\Admin\UpdateAppointmentsRequest;

class AppointmentsController extends Controller
{

    public function index()
    {

        $category = Category::getList();
        $advisor = Advisor::getList();
        $appointments = Appointment::getListAll();
        $apm = Appointment::getList();
        return view('admin.appointments.index', compact('apm','appointments', 'category', 'advisor'));
    }
    public function postCreate(Request $request)
    {
        try {
            $res = Appointment::postCreate($request);
            if ($res == 200) {
                return back()
                    ->with('success', 'You have successfully create appointment');
            } else {
                return back()
                    ->with('fail', 'You have create failed appointment');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function postAddStudent(Request $request)
    {
        try {
            $res = Appointment::postCreate($request);
            if ($res == 200) {
                return back()
                    ->with('success', 'You have successfully create appointment');
            } else {
                return back()
                    ->with('fail', 'You have create failed appointment');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
