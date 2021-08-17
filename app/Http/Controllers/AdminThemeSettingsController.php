<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
//use Request;
use URL;
use Auth;
use App\Setting as Setting;
use App\Slider as Slider;
use App\MobileSlider as MobileSlider;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\ThemeSetting as ThemeSetting;
use App\SiteTheme as SiteTheme;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;

class AdminThemeSettingsController extends Controller
{
    
	public function theme_settings(){
		$settings = SiteTheme::first();
		$user = Auth::user();
		$data = array(
			'settings' => $settings,
			'admin_user'	=> $user,
			);
		return View::make('admin.settings.theme_settings', $data);
	}

	public function theme_settings_form(){
		$settings = Setting::first();
		$user = Auth::user();
		
		$data = array(
			'settings' => $settings,
			'admin_user'	=> $user,
			'theme_settings' => ThemeHelper::getThemeSettings(),
			);
		return View::make('Theme::includes.settings', $data);
	}

	public function update_theme_settings(Request $request){
		// Get the Active Theme
		$active_theme = Setting::first()->theme;

		$input = Input::all();
		/*Move banner image file to folder*/
		$validator = Validator::make($data = Input::all(), Video::$rules);
		if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $image = (isset($data['homepage_banner'])) ? $data['homepage_banner'] : '';
        if(!empty($image)){
        	unset($input['homepage_banner']);
        	$files = $request->file('homepage_banner');
        	if(!empty($files) && $files[0] != ''){
	        	$destinationPath_home = 'content/themes/default/assets/img/home';
	        	foreach ($files as $key => $file) {
	        		$data['homepage_banner'] = $file->move($destinationPath_home, $file->getClientOriginalName());
	        		$img_name[] = '"'.THEME_URL.'/assets/img/home/'.$file->getClientOriginalName().'"';
	        	}
        	


        	if (isset(ThemeHelper::getThemeSettings()->homepage_banner)) {
	        	$olderbaner = ThemeHelper::getThemeSettings()->homepage_banner;
	        	$exploded_baners = explode(",", $olderbaner);

	        	$bannerarray = implode(",",array_merge($exploded_baners,$img_name));
           

        	}else{

        		$bannerarray = implode(",", $img_name);
        	}

        	
        	
           		$input['homepage_banner'] =  $bannerarray;
           	}
        } 

        $image1 = (isset($data['footer_banner'])) ? $data['footer_banner'] : '';
        if(!empty($image1)){
			unset($input['footer_banner']);
			$footer_file = $request->file('footer_banner');
			if($footer_file){
				$destinationPath = 'content/themes/default/assets/img/footer';
				$data['footer_banner'] = $footer_file->move($destinationPath, $footer_file->getClientOriginalName());
				$input['footer_banner'] = '"'.THEME_URL.'/assets/img/footer/'.$footer_file->getClientOriginalName().'"';
			}

		}
        
        
		/*Move banner image file to folder*/

		foreach($input as $key => $value){
			$this->createOrUpdateThemeSetting($active_theme, $key, $value);
		}

		return Redirect::to('/admin/theme_settings');
	}
    
    public function SaveTheme(Request $request){
        
        $data = $request->all();
        $theme_settings = SiteTheme::first();
        $theme_settings->dark_bg_color = $request->dark_bg_color;
		$theme_settings->light_bg_color = $request->light_bg_color;
        
         $path = public_path().'/uploads/settings/';
         $dark_logo = $request->dark_mode_logo;
         $light_logo = $request->light_mode_logo;
            if($dark_logo != '') {   
              //code for remove old file
              if($dark_logo != ''  && $dark_logo != null){
                   $file_old = $path.$dark_logo;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $dark_logo;
              $theme_settings->dark_mode_logo  = $file->getClientOriginalName();
              $file->move($path, $theme_settings->dark_mode_logo);
            }   
        if($light_logo != '') {   
              //code for remove old file
              if($light_logo != ''  && $light_logo != null){
                   $file_old = $path.$light_logo;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $light_logo;
              $theme_settings->light_mode_logo  = $file->getClientOriginalName();
              $file->move($path, $theme_settings->light_mode_logo);
            }
        $theme_settings->save();       
        
        return Redirect::back()->with(array('note' => 'Successfully Updated Settings', 'note_type' => 'success') );
    }

	private function createOrUpdateThemeSetting($theme_slug, $key, $value){
       	
       	$setting = array(
        		'theme_slug' => $theme_slug,
        		'key' => $key,
        		'value' => $value
        	);

       	$theme_setting = ThemeSetting::where('theme_slug', '=', $theme_slug)->where('key', '=', $key)->first();

        if (isset($theme_setting->id))
        {
            $theme_setting->update($setting);
            $theme_setting->save();
        }
        else
        {
            ThemeSetting::create($setting);
        }

    }
    
 
    
      public function SliderEdit($id){
         
            $categories = Slider::where('id', '=', $id)->get();

            $allCategories = Slider::all();
            return view('admin.sliders.edit',compact('categories','allCategories'));
        }  
    
    public function MobileSliderEdit($id){
            $categories = MobileSlider::where('id', '=', $id)->get();
            $allCategories = MobileSlider::all();
            return view('admin.mobile.edit',compact('categories','allCategories'));
        }
    
    
     public function SliderUpdate(Request $request){           
        $input = $request->all();
        $path = public_path().'/uploads/videocategory/';
           
        $id = $request['id'];
        $in_home = $request['active']; 
        $link = $request['link']; 
        $title = $request['title']; 
        $category = Slider::find($id);
             if (isset($request['slider']) && !empty($request['slider'])){
                    $image = $request['slider']; 
                 } else {
                     $request['slider'] = $category->slider;
              }

             // $slug = $request['slug']; 
              if ( $in_home != '') {
                  $input['active']  = $request['active'];
              } else {
                   $input['active']  = $request['active'];
              }
            if( isset($image) && $image!= '') {   
                    //code for remove old file
                    if ($image != ''  && $image != null) {
                        $file_old = $path.$image;
                        if (file_exists($file_old)){
                               unlink($file_old);
                        }
                    }
                    $file = $image;
                    $category->slider  = $file->getClientOriginalName();
                    $file->move($path,$category->slider);
              } 
            $category->link  = $link;
            $category->title  = $title;
            $category->active = $request['active'];
            $category->save();
            
            return Redirect::to('admin/sliders')->with(array('note' => 'Successfully Updated Category', 'note_type' => 'success') );
            
    }   
    
    public function MobileSliderUpdate(Request $request){           
        $input = $request->all();
        $path = public_path().'/uploads/videocategory/';
           
        $id = $request['id'];
        $in_home = $request['active']; 
        $link = $request['link']; 
        $title = $request['title']; 
        $category = MobileSlider::find($id);
             if (isset($request['slider']) && !empty($request['slider'])){
                    $image = $request['slider']; 
                 } else {
                     $request['slider'] = $category->slider;
              }
             // $slug = $request['slug']; 
              if ( $in_home != '') {
                  $input['active']  = $request['active'];
              } else {
                   $input['active']  = $request['active'];
              }
            if( isset($image) && $image!= '') {   
                    //code for remove old file
                    if ($image != ''  && $image != null) {
                        $file_old = $path.$image;
                        if (file_exists($file_old)){
                               unlink($file_old);
                        }
                    }
                    $file = $image;
                    $category->slider  = $file->getClientOriginalName();
                    $file->move($path,$category->slider);
              } 
            $category->link  = $link;
            $category->title  = $title;
            $category->active = $request['active'];
            $category->save();
            
            return Redirect::back()->with(array('note' => 'Successfully Updated Category', 'note_type' => 'success') );
            
    }
    
    
    public function SliderDelete($id){
        Slider::destroy($id);
       
        return Redirect::to('admin/sliders')->with(array('note' => 'Successfully Deleted Category', 'note_type' => 'success') );
    }
    
    public function MobileSliderDelete($id){
         MobileSlider::destroy($id);
        return Redirect::back()->with(array('note' => 'Successfully Deleted Category', 'note_type' => 'success') );
    }
    
 public function SliderIndex(){
          
        //$categories = VideoCategory::where('parent_id', '=', 0)->get();

          $allCategories = Slider::orderBy('order_position','ASC')->get();
          $data = array (
            'allCategories'=>$allCategories
          );
         return view('admin.sliders.index',$data);
      } 
    public function LanguageIndex(){
          
        //$categories = VideoCategory::where('parent_id', '=', 0)->get();

        $allCategories = VideoLanguage::all();
          
          $data = array (
            'allCategories'=>$allCategories
          );
        return view('admin.languages.index',$data);
      }   
    
    public function LanguageTransIndex(){
          
        //$categories = VideoCategory::where('parent_id', '=', 0)->get();

        $allCategories = Language::all();
          
          $data = array (
            'allCategories'=>$allCategories
          );
        return view('admin.languagestrans.index',$data);
      }
    
      public function SliderStore(Request $request){
                $input = $request->all();
                $validatedData = $request->validate([
                    'slider' => 'required|image',
                ]);
            $s = new Slider();
            $slider = new Slider();
            $path = public_path().'/uploads/videocategory/';
            $image = $request['slider'];
            $link = $request['link'];
            $title = $request['title'];
            $acive = $request['acive']; 
          
           if($image != '') {   
          //code for remove old file
              if($image != ''  && $image != null){
                   $file_old = $path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $image;
              $slider->slider  = $file->getClientOriginalName();
              $slider->link  = $link;
              $slider->title  = $title;
              $file->move($path, $slider->slider);
           } 
          
          $input['slider']  = $file->getClientOriginalName();
          $slider->active = $request['active'];
          $slider->save();
            return back()->with('success', 'New Category added successfully.');
    }      
    
           public function MobileSliderStore(Request $request){
               
            $input = $request->all();
            $validatedData = $request->validate([
                    'slider' => 'required|image',
                ]);
            $s = new MobileSlider();
            $slider = new MobileSlider();
            $path = public_path().'/uploads/videocategory/';
            $image = $request['slider'];
            $link = $request['link'];
            $title = $request['title'];
            $acive = $request['acive']; 
          
           if($image != '') {   
          //code for remove old file
              if($image != ''  && $image != null){
                   $file_old = $path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $image;
              $slider->slider  = $file->getClientOriginalName();
              $slider->link  = $link;
              $slider->title  = $title;
              $file->move($path, $slider->slider);
           } 
          
          $input['slider']  = $file->getClientOriginalName();
          $slider->active = $request['active'];
          $slider->save();
            return back()->with('success', 'New Category added successfully.');
    }
    
 
    
    
    public function LanguageDelete($id){
        VideoLanguage::destroy($id);
       
        return Redirect::to('admin/admin-languages')->with(array('note' => 'Successfully Deleted Category', 'note_type' => 'success') );
    }  
    
    public function LanguageTransDelete($id){
        Language::destroy($id);
       
        return Redirect::to('admin/admin-languages-transulates')->with(array('note' => 'Successfully Deleted Category', 'note_type' => 'success') );
    }
    
    
      public function LanguageTransStore(Request $request){
          
            $input = $request->all();
          
              $validatedData = $request->validate([
                'name' => 'required',
            ]);
          
                $s = new Language();
                $slider = new Language();

              $slider->name = $request['name'];
              $slider->code = substr($request['name'],2);
              $file_loc = 'resources/lang/'.$slider->code.'.json';
              fopen($file_loc, "w");
              $myfile = fopen($file_loc, "w") or die("Unable to open file!");
                $txt = "{}";
                fwrite($myfile, $txt);
             
              $slider->save();
          return back()->with('success', 'New Language added successfully.');
    }  
    
    public function LanguageStore(Request $request){
          
            $input = $request->all();
          
              $validatedData = $request->validate([
                'name' => 'required',
            ]);
          
                $s = new VideoLanguage();
                $slider = new VideoLanguage();

              $slider->name = $request['name'];
            
              $slider->save();
          return back()->with('success', 'New Language added successfully.');
    }
    
       public function LanguageTransEdit($id){
         
            $categories = Language::where('id', '=', $id)->get();
            $allCategories = Language::all();
            return view('admin.languagestrans.edit',compact('categories','allCategories'));
        } 
    
        public function LanguageEdit($id){
         
            $categories = VideoLanguage::where('id', '=', $id)->get();
            $allCategories = VideoLanguage::all();
            return view('admin.languages.edit',compact('categories','allCategories'));
        }
    
    
     public function LanguageTransUpdate(Request $request){
           
        $input = $request->all();
        $id = $request['id'];
        $name = $request['name']; 
        $category = Language::find($id);
        $category->name = $request['name'];
        $category->save();
         
        return back()->with('success', 'New Language Updated successfully.');
    } 
    
    public function LanguageUpdate(Request $request){
           
        $input = $request->all();
        $id = $request['id'];
        $name = $request['name']; 
        $category = VideoLanguage::find($id);
        $category->name = $request['name'];
        $category->save();
         
        return back()->with('success', 'New Language Updated successfully.');
    }

    public function slider_order(Request $request){

      $input = $request->all();
      $position = $_POST['position'];
      $i=1;
      foreach($position as $k=>$v){
        $slider = Slider::find($v);
        $slider->order_position = $i;
        $slider->save();
        $i++;
      }
      return 1;

    }

    
    
    
}
