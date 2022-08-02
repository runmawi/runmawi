<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminLandingPage;
use \Redirect as Redirect;


class AdminLandingpageController extends Controller
{

    public function create_edit(Request $request)
    {
        $landing_page_details = AdminLandingPage::latest()->first();

        $data = [
            'post_route' => $landing_page_details == null ? 'landing_page_store' : 'landing_page_update' ,
            'button_text' => $landing_page_details == null ? 'Add New' : 'Update' ,
            'landing_page_details' => $landing_page_details ,
            'Header_title' => $landing_page_details == null ? 'Add New Landing Page' : 'Edit Landing Page' ,
        ];

        return view('admin.Landing_page.create_edit',$data);
    }

    public function store(Request $request)
    {
        AdminLandingPage::create([
            'content_1' => $request->content_1 ,
            'content_2' => $request->content_2 ,
            'content_3' => $request->content_3 ,
            'content_4' => $request->content_4 ,
        ]);

        return Redirect::back()->with('message', 'Successfully! Created Landing Page');
    }

    public function update(Request $request)
    {
        AdminLandingPage::first()->update([
            'content_1' => $request->content_1 ,
            'content_2' => $request->content_2 ,
            'content_3' => $request->content_3 ,
            'content_4' => $request->content_4 ,
        ]);


        return Redirect::back()->with('message', 'Successfully! Updated Landing Page');
    }
}
