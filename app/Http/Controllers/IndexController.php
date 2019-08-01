<?php

namespace App\Http\Controllers;

use App\ContactUs;
use App\Appointment;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index()
    {
        $appointments = Appointment::all();
        return view('index', compact('appointments'));
    }

    public function cancelAppointment()
    {
        return view('cancel-appointment');
    }

}