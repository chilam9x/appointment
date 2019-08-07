<?php

namespace App\Http\Controllers\Admin;
use App\Advisor;
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
        return view('admin.advisor.index',['advisor'=>$advisor]);
    }

    public function postCreate(Request $request)
    {
        try {
            $res = Advisor::postCreate($request);
            if ($res == 200) {
                return back()
                    ->with('success','You have successfully sent us contact information');
            } else {
                return back()
                    ->with('fail','You have sent us contact information failed');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }


}
