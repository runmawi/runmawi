<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\Menu as Menu;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\Setting as Setting;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of videos
     *
     * @return Response
     */
    public function index()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        // $menu = json_decode(Menu::orderBy('order', 'ASC')->get()->toJson());
        $menu = Menu::orderBy('order', 'asc')->get();
        // dd($menu);
        $user = Auth::user();

        $data = array(
            'menu' => $menu,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return View::make('admin.menu.index', $data);
        }
    }

    public function store(Request $request){
        
        $input = $request->all();
        
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'url' => 'required|max:255'
        ]);
        
        
        $last_menu_item = Menu::orderBy('order', 'DESC')->first();
        
        if(isset($last_menu_item->order)){
            $new_menu_order = intval($last_menu_item->order) + 1;
        } else {
            $new_menu_order = 1;
        }
        $request['order'] = $new_menu_order;
        $menu= Menu::create($input);
        if(isset($menu->id)){
            return Redirect::to('admin/menu')->with(array('note' => 'Successfully Added New Menu Item', 'note_type' => 'success') );
        }
    }

    public function edit($id){
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        return View::make('admin.menu.edit', array('menu' => Menu::find($id)));
        }
    }


    public function destroy($id){
        Menu::destroy($id);
        $child_menu_items = Menu::where('parent_id', '=', $id)->get();
        foreach($child_menu_items as $menu_items){
            $menu_items->parent_id = NULL;
            $menu_items->save();
        }
        return Redirect::to('admin/menu')->with(array('note' => 'Successfully Deleted Menu Item', 'note_type' => 'success') );
    }

    public function update(Request $request){
        $input = $request->all();
        $menu = Menu::find($input['id'])->update($input);
        if(isset($menu)){
            return Redirect::to('admin/menu')->with(array('note' => 'Successfully Updated Category', 'note_type' => 'success') );
        }
    }

    public function order(){
        $menu_item_order = json_decode(Input::get('order'));
        // echo "<pre>";print_r($menu_item_order);exit;
        $post_categories = Menu::all();
        $order = 1;
        
        foreach($menu_item_order as $menu_level_1):
            
            $level1 = Menu::find($menu_level_1->id);
            if($level1->id){
                $level1->order = $order;
                $level1->parent_id = NULL;
                $level1->save();
                $order += 1;
            }
            
            if(isset($menu_level_1->children)):
            
                $children_level_1 = $menu_level_1->children;

                foreach($children_level_1 as $menu_level_2):

                    $level2 = Menu::find($menu_level_2->id);
                    if($level2->id){
                        $level2->order = $order;
                        $level2->parent_id = $level1->id;
                        $level2->save();
                        $order += 1;
                    }

                    if(isset($menu_level_2->children)):

                        $children_level_2 = $menu_level_2->children;


                        foreach($children_level_2 as $menu_level_3):

                            $level3 = Menu::find($menu_level_3->id);
                            if($level3->id){
                                $level3->order = $order;
                                $level3->parent_id = $level2->id;
                                $level3->save();
                                $order += 1;
                            }

                        endforeach;

                    endif;

                endforeach;

            endif;


        endforeach;

        return 1;
    }
    public function updateOrder(Request $request){

        $post_categories = Menu::all();


        foreach ($post_categories as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['order' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);
    

    }
}
