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
        return view('user.index');
    }
    //page appointment
    public function appointment()
    {
        $appointments = '';
        $category = Category::getList();
        $advisor = Advisor::getList();
        $category_id = '';
        $advisor_id = '';
        $success = 0;
        return view('user.appointment', compact('appointments', 'success','category', 'advisor', 'category_id', 'advisor_id'));
    }
    public function searchAppointment(Request $request)
    {
        $category_id = $request->category_id;
        $advisor_id = $request->advisor_id;
        $success = 0;
        $category = Category::getList();
        $advisor = Advisor::getList_Category($category_id);
        $appointments = Appointment::searchAppointment($request);
        return view('user.appointment', compact('appointments', 'category','success', 'advisor', 'category_id', 'advisor_id'));
    }
    public function postAddStudent(Request $request)
    {
        try {
            $res = Appointment::postAddStudent($request);
            $appointments = '';
            $category = Category::getList();
            $advisor = Advisor::getList();
            $category_id = '';
            $advisor_id = '';
            $success = 1;
            return view('user.appointment', compact('appointments', 'category','success', 'advisor', 'category_id', 'advisor_id'));
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    //page cancel appointment
    public function cancelAppointment()
    {
        $student = null;
        $error_code = 0;
        $success = 0;
        return view('user.cancel-appointment', compact('student', 'error_code','success'));
    }
    public function checkStudent(Request $request)
    {
        try {
            $student = Student::checkStudent($request);
            $success = 0;
            if ($student->count() == 0) {
                $error_code = 5;
                return view('user.cancel-appointment', compact('student', 'error_code','success'));
            } else {
                $error_code = 0;
                return view('user.cancel-appointment', compact('student', 'error_code','success'));
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function postCancelAppointment(Request $request)
    {
        try {
            $res = Appointment::cancel($request);
            $error_code = 0;
            $success = 1;
            if ($res == 200) {
                $student = null;
                return view('user.cancel-appointment', compact('student', 'error_code','success'));
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    //ajax
    public function searchCategoryAdvisor(Request $request)
    {
        try {
            $res = Advisor::searchCategoryAdvisor($request->id);
            return $res;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function getAppointment(Request $request)
    {
        try {
            $res = Appointment::getAppointment($request->id);
            return $res;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
