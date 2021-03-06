<?php

namespace App\Http\Controllers\Admin;
use App\Advisor;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
class AdvisorController extends Controller
{

    public function index()
    {
        $advisor=Advisor::getList();
        $category=Category::getList();
        return view('admin.advisor.index',['advisor'=>$advisor,'category'=>$category]);
    }

    public function postCreate(Request $request)
    {
        try {
            $res = Advisor::postCreate($request);
            if ($res == 200) {
                return back()
                    ->with('success','You have successfully create advisor');
            } else {
                return back()
                    ->with('fail','You have create failed advisor');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function postEdit(Request $request)
    {
        try {
            $res = Advisor::postEdit($request);
            if ($res == 200) {
                return back()
                    ->with('success','You have successfully edit advisor');
            } else {
                return back()
                    ->with('fail','You have edit failed advisor');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function postDelete(Request $request)
    {
        try {
            $res = Advisor::postDelete($request);
            if ($res == 200) {
                return back()
                    ->with('success','You have successfully delete advisor');
            } else {
                return back()
                    ->with('fail','You have delete failed advisor');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
