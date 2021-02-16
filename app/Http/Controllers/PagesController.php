<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Redirect as Redirect;
use App\Setting;
use App\Page as Page;
use App\User as User;
use App\VideoCategory as VideoCategory;
use App\Menu as Menu;
use Auth;
use View;

class PagesController extends Controller{
 
  public function index($slug){
 
         // Read value from Model method
         $dynamic_page = Page::where('slug', '=', $slug)->first();
            if($dynamic_page->active){
               // $author = User::find($dynamic_page->user_id);
                $data = array(
                                'pager' => $dynamic_page, 
                                'author' => '',
                                'menu' => Menu::orderBy('order', 'ASC')->get(),
                                'pages' => Page::where('active', '=', 1)->get(),
                 );
                return View('page', $data);
            }      
        else {
            return Redirect::to('pages')->with(array('note' => 'Sorry, this page is no longer active.', 'note_type' => 'error'));
        }
  }

}