<?php

namespace App\Http\Controllers;

use App\ContactUs;
use App\Category;
use App\Advisor;
use App\Appointment;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index()
    {
        return view('index');
    }
    public function appointment()
    {
        $category=Category::getList();
        $advisor=Advisor::getList();
        $appointments = Appointment::all();
        return view('appointment', compact('appointments','category','advisor'));
    }
    public function postAppointment(Request $request)
    {
        try {
            $res = Appointment::postCreate($request);
            if ($res == 200) {
                return back()
                    ->with('success','You have added a successful appointment');
            } else {
                return back()
                    ->with('fail','You have added a failed appointment');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function cancelAppointment()
    {
        return view('cancel-appointment');
    }

}