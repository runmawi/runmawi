<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use URL;
use Auth;

class AdminMultiUserController extends Controller
{
    public function multiuser_limit(Request $request)
    {
        $data = [
            'button_text' => 'Update Setting',
            'post_route' => URL::to('admin/Multi_limit_store'),
            'Setting' => Setting::pluck('multiuser_limit')->first(),
            'enable_choose_profile' => Setting::pluck('enable_choose_profile')->first(),
        ];

        return view('admin.multiuser.index', $data);
    }

    public function Multi_limit_store(Request $request)
    {
        Setting::where('id', 1)->update([
            'multiuser_limit' => $request->multiuser_limit,
            'enable_choose_profile' => !empty($request->enable_choose_profile) ? 1 : 0,
        ]);

        return redirect()
            ->route('multiuser_limit')
            ->with(['message' => 'Successfully Updated!', 'note_type' => 'success']);
    }

}
