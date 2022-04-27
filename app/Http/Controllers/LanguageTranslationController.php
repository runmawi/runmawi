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
   	  $languages = Language::get();


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


   	  return view('admin.languages', compact('languages','columns','columnsCount'));
    }   
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


		$data = $this->openJSONFile('english');
        $data[$request->key] = $request->value;


        $this->saveJSONFile('english', $data);


        return redirect()->route('languages');
    }


    /**
     * Remove the specified resource from storage.
     * @return Response
    */
    public function destroy($key)
    {
        $languages = Language::get();


        if($languages->count() > 0){
            foreach ($languages as $language){
                $data = $this->openJSONFile($language->code);
                unset($data[$key]);
                $this->saveJSONFile($language->code, $data);
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
        if(File::exists(base_path('resources/lang/'.$code.'.json'))){
            $jsonString = file_get_contents(base_path('resources/lang/'.$code.'.json'));
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
        $data = $this->openJSONFile($request->code);
        $data[$request->pk] = $request->value;


        $this->saveJSONFile($request->code, $data);
        return response()->json(['success'=>'Done!']);
    }


    /**
     * Remove the specified resource from storage.
     * @return Response
    */
    public function transUpdateKey(Request $request){
        $languages = Language::get();


        if($languages->count() > 0){
            foreach ($languages as $language){
                $data = $this->openJSONFile($language->code);
                if (isset($data[$request->pk])){
                    $data[$request->value] = $data[$request->pk];
                    unset($data[$request->pk]);
                    $this->saveJSONFile($language->code, $data);
                }
            }
        }


        return response()->json(['success'=>'Done!']);
    }
}