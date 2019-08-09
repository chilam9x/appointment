<?php

namespace App\Http\Controllers;

use App\Advisor;
use App\Appointment;
use App\Category;
use App\Student;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //page index
    public function index()
    {
        return view('index');
    }
    //page appointment
    public function appointment()
    {
        $category = Category::getList();
        $advisor = Advisor::getList();
        $appointments = Appointment::getList();
        return view('appointment', compact('appointments', 'category', 'advisor'));
    }
    public function postAppointment(Request $request)
    {
        try {
            $res = Appointment::postCreate($request);
            if ($res == 200) {
                return back()
                    ->with('success', 'You have added a successful appointment');
            } else {
                return back()
                    ->with('fail', 'You have added a failed appointment');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    //page cancel appointment
    public function cancelAppointment()
    {
        $student = null;
        return view('cancel-appointment', compact('student'));
    }
    public function checkStudent(Request $request)
    {
        try {
            $student = Student::checkStudent($request);
            $count=0;
            return view('cancel-appointment', compact('student'));
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function postCancelAppointment($id)
    {
        try {
            $res = Appointment::cancel($id);
            if ($res == 200) {
                $student = null;
                return view('cancel-appointment', compact('student'));
            } 
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
