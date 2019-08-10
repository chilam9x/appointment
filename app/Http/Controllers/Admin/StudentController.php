<?php

namespace App\Http\Controllers\Admin;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
class StudentController extends Controller
{

    public function index()
    {
        $student=Student::getList();
        return view('admin.student.index',['student'=>$student]);
    }
}
