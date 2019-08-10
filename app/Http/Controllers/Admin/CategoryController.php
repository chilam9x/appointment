<?php

namespace App\Http\Controllers\Admin;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
class CategoryController extends Controller
{

    public function index()
    {
        $category=Category::getList();
        return view('admin.category.index',['category'=>$category]);
    }

    public function postCreate(Request $request)
    {
        try {
            $res = Category::postCreate($request);
            if ($res == 200) {
                return back()
                    ->with('success','You have successfully create category');
            } else {
                return back()
                    ->with('fail','You have create failed category');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function postEdit(Request $request)
    {
        try {
            $res = Category::postEdit($request);
            if ($res == 200) {
                return back()
                    ->with('success','You have successfully edit category');
            } else {
                return back()
                    ->with('fail','You have edit failed category');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function postDelete(Request $request)
    {
        try {
            $res = Category::postDelete($request);
            if ($res == 200) {
                return back()
                    ->with('success','You have successfully delete category');
            } else {
                return back()
                    ->with('fail','You have delete failed category');
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}
