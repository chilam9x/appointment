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
        $category=Category::getList();
        $advisor=Advisor::getList();
        $appointments = Appointment::all();
        return view('index', compact('appointments','category','advisor'));
    }

    public function cancelAppointment()
    {
        return view('cancel-appointment');
    }

}