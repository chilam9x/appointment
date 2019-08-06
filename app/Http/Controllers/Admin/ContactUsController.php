<?php

namespace App\Http\Controllers\Admin;

use App\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
class ContactUsController extends Controller
{

    //get
    public function contactUs()
    {
        return view('contact-us');
    }
    public function getContactUs()
    {
        $contact=ContactUs::getContactUs();
        return view('admin.contact_us.index',['contact'=>$contact]);
    }
    //post
    public function postContactUs(Request $request)
    {
        try {
         
            $res = ContactUs::insert($request);
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