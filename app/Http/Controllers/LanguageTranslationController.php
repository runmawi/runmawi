<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use File;
use App\Language;
use App\Setting;
use App\User;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class LanguageTranslationController extends Controller
{
    /**
     * Remove the specified resource from storage.
     * @return Response
    */
    public function index()
    {
   	  $languages = DB::table('translation_languages')->get();

         $Setting_website_name =  Setting::pluck('website_name')->first();

   	  $columns = [];
	  $columnsCount = $languages->count();


	    if($languages->count() > 0){
	        foreach ($languages as $key => $language){
	            if ($key == 0) {
	                $columns[$key] = $this->openJSONFile($language->code);
	            }
	            $columns[++$key] = ['data'=>$this->openJSONFile($language->code), 'lang'=>$language->code];
	        }
	    }
        
        return view('admin.languages.translation.translation_languages', compact('languages','columns','columnsCount'));
    }   
    /**
     * Remove the specified resource from storage.
     * @return Response
    */
    public function store(Request $request)
    {
   	    $request->validate([
		    'key' => 'required',
		    'value' => 'required',
		]);

        $filename = GetWebsiteName().'en';
        if (!file_exists($filename)) {
            // If the file doesn't exist, create it with an empty array
            $this->saveJSONFile($filename, []);
        }
    
		$data = $this->openJSONFile(GetWebsiteName().'en');
        $data[$request->key] = $request->value;


        $this->saveJSONFile(GetWebsiteName().'en', $data);


        return redirect()->route('languages');
    }


    /**
     * Remove the specified resource from storage.
     * @return Response
    */
    public function destroy($key)
    {
        $languages = DB::table('translation_languages')->get();


        if($languages->count() > 0){
            foreach ($languages as $language){
                $data = $this->openJSONFile(GetWebsiteName().$language->code);
                unset($data[$key]);
                $this->saveJSONFile(GetWebsiteName().$language->code, $data);
            }
        }
        return response()->json(['success' => $key]);
    }


    /**
     * Open Translation File
     * @return Response
    */
    private function openJSONFile($code){
        $jsonString = [];
        if(File::exists(base_path('resources/lang/'.GetWebsiteName().$code.'.json'))){
            $jsonString = file_get_contents(base_path('resources/lang/'.GetWebsiteName().$code.'.json'));
            $jsonString = json_decode($jsonString, true);
        }
        return $jsonString;
    }


    /**
     * Save JSON File
     * @return Response
    */
    private function saveJSONFile($code, $data){
        ksort($data);
        $jsonData = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        file_put_contents(base_path('resources/lang/'.$code.'.json'), stripslashes($jsonData));
    }


    /**
     * Save JSON File
     * @return Response
    */
    public function transUpdate(Request $request){
        $data = $this->openJSONFile(GetWebsiteName().$request->code);
        $data[$request->pk] = $request->value;


        $this->saveJSONFile(GetWebsiteName().$request->code, $data);
        return response()->json(['success'=>'Done!']);
    }


    /**
     * Remove the specified resource from storage.
     * @return Response
    */
    public function transUpdateKey(Request $request){
        $languages = DB::table('translation_languages')->get();


        if($languages->count() > 0){
            foreach ($languages as $language){
                $data = $this->openJSONFile(GetWebsiteName().$language->code);
                if (isset($data[$request->pk])){
                    $data[$request->value] = $data[$request->pk];
                    unset($data[$request->pk]);
                    $this->saveJSONFile(GetWebsiteName().$language->code, $data);
                }
            }
        }


        return response()->json(['success'=>'Done!']);
    }
}