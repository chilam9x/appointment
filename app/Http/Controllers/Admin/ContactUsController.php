<?php

namespace App\Http\Controllers\Admin;

use App\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ContactUsController extends Controller
{

    //get
    public function index()
    {
        return view('contact-us');
    }
    public function getContactUs()
    {
        $contact=ContactUs::getContactUs();
        return view('admin.contact_us.index',['contact'=>$contact]);
    }
    //post
    public function postCreate(Request $request)
    {
        try {
            $res = ContactUs::postCreate($request);
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