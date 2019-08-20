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
        $appointments = Appointment::getListAll();
        $category = Category::getList();
        $advisor = Advisor::getList();
        $category_id = '';
        $advisor_id = '';
        return view('appointment', compact('appointments', 'category', 'advisor', 'category_id', 'advisor_id'));
    }
    public function searchAppointment(Request $request)
    {
        try {
            $appointments = Appointment::searchAppointment($request);
            $category = Category::getList();
            $advisor = Advisor::getList();
            $category_id = $request->category_id;
            $advisor_id = $request->advisor_id;
            return view('appointment', compact('appointments', 'category', 'advisor', 'category_id', 'advisor_id'));
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function postAddStudent(Request $request)
    {
        try {
            $res = Appointment::postAddStudent($request);
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
        $error_code=0;
        return view('cancel-appointment', compact('student','error_code'));
    }
    public function checkStudent(Request $request)
    {
        try {
            $student = Student::checkStudent($request);
            if ($student->count() == 0) {
                $error_code=5;
                return view('cancel-appointment', compact('student','error_code'));
            } else {
                $error_code=0;
                return view('cancel-appointment', compact('student','error_code'));
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function postCancelAppointment(Request $request)
    {
        try {
            $res = Appointment::cancel($request);

            if ($res == 200) {
                $student = null;
                return view('cancel-appointment', compact('student'));
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
