<?php

namespace App\Http\Controllers\Admin;
use App\Advisor;
use Illuminate\Http\Request;

class AdvisorController extends Controller
{

    public function index()
    {
        dd(12);
        $advisor=Advisor::getList();
        return view('admin.advisor.index');
    }



}
