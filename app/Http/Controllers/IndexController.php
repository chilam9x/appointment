<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Appointment;

class IndexController extends Controller
{

    public function index()
    {
        $appointments = Appointment::all();
        return view('index', compact('appointments'));
    }

}
