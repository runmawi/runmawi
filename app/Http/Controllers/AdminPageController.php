<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Page as Page;
use App\Plan as Plan;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Response;
use App\Setting as Setting;
use GuzzleHttp\Client;

class AdminPageController extends Controller
{
    /**
     * Display a listing of videos
     *
     * @return Response
     */
    public function index()
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }

        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];

            return View::make('admin.expired_dashboard', $data);
        } elseif (check_storage_exist() == 0) {
            $settings = Setting::first();

            $data = [
                'settings' => $settings,
            ];

            return View::make('admin.expired_storage', $data);
        } else {
            $pages = Page::orderBy('created_at', 'DESC')->paginate(10);
            $user = Auth::user();

            $data = [
                'pages' => $pages,
                'user' => $user,
                'admin_user' => Auth::user(),
            ];

            return View::make('admin.pages.index', $data);
        }
    }

    /**
     * Show the form for creating a new video
     *
     * @return Response
     */
    public function create()
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }

        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        } elseif (check_storage_exist() == 0) {
            
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
            ];

            return View::make('admin.expired_storage', $data);
        } else {
            $data = [
                'post_route' => URL::to('admin/pages/store'),
                'button_text' => 'Add New Page',
                'admin_user' => Auth::user(),
            ];
            return View::make('admin.pages.create_edit', $data);
        }
    }

    /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), Page::$rules);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'body' => 'required',
        ]);

        $path = public_path() . '/uploads/settings/';

        $logo = $request['banner'];

        /* logo upload */

        if ($logo != '') {
            //code for remove old file
            if ($logo != '' && $logo != null) {
                $file_old = $path . $logo;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $logo;
            $data['banner'] = $file->getClientOriginalName();
            $file->move($path, $data['banner']);
        }

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withRequest();
        }

        $page = Page::create($data);

        return Redirect::to('admin/pages')->with(['note' => 'New Page Successfully Added!', 'note_type' => 'success']);
    }

    /**
     * Show the form for editing the specified video.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        } elseif (check_storage_exist() == 0) {
            $settings = Setting::first();

            $data = [
                'settings' => $settings,
            ];

            return View::make('admin.expired_storage', $data);
        } else {
            $page = Page::find($id);

            $data = [
                'headline' => '<i class="fa fa-edit"></i> Edit Page',
                'page' => $page,
                'post_route' => URL::to('admin/pages/update'),
                'button_text' => 'Update Page',
                'admin_user' => Auth::user(),
            ];

            return View::make('admin.pages.create_edit', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'body' => 'required',
        ]);

        $id = $data['id'];
        // if(!empty($data['active']) && $data['active'] == "on"){
        //     $data['active'] == 1 ;
        // }else{
        //     $data['active'] == 0 ;
        // }
        $page = Page::findOrFail($id);

        $validator = Validator::make($data, Page::$rules);

        $path = public_path() . '/uploads/settings/';

        $logo = $request['banner'];

        /* logo upload */

        if ($logo != '') {
            //code for remove old file
            if ($logo != '' && $logo != null) {
                $file_old = $path . $logo;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $logo;
            $data['banner'] = $file->getClientOriginalName();
            $file->move($path, $data['banner']);
        }

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withRequest();
        }

        if (!isset($data['active']) || $data['active'] == 0) {
            $data['active'] = 0;
        }

        if (!isset($data['footer_active']) || $data['footer_active'] == 0) {
            $data['footer_active'] = 0;
        }

        $page->update($data);

        return Redirect::to('admin/pages/edit' . '/' . $id)->with(['note' => 'Successfully Updated Page!', 'note_type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);

        Page::destroy($id);

        return Redirect::to('admin/pages')->with(['note' => 'Successfully Deleted Page', 'note_type' => 'success']);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            //Upload File
            $request->file('upload')->storeAs('public/uploads', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/' . $filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>
                window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')
            </script>";

            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }

    public function page_status(Request $request)
    {
        try {
            Page::where('id', $request->page_id)->update([
                'active' => $request->page_status,
            ]);

            return response()->json(['message' => 'true']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'false']);
        }
    }
}
