<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\SeriesNetwork;
use App\Series;
use Illuminate\Support\Facades\DB;

class AdminNetworkController extends Controller
{
    public function __construct()
    {
        if(Series_Networks_Status() == 0 ){

            $Error_msg = "Series Network Restricted";
            $url = URL::to('/admin');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function Network_index()
    {
        try {

            $SeriesNetwork =  SeriesNetwork::orderBy('order')->get()->map(function ($item) {
                $item['image_url'] = $item->image != null ? URL::to('public/uploads/seriesNetwork/'.$item->image ) : default_vertical_image_url() ;
                $item['banner_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/seriesNetwork/'.$item->banner_image ) : default_horizontal_image_url();
                $item['series'] = Series::where('active','1')->get()->filter(function ($series) use ($item) {
                    $networkIds = json_decode($series->network_id, true);

                    if (!is_array($networkIds)) {
                        return false;
                    }
            
                    if (in_array($item->id, $networkIds)) {
                        $order = DB::table('series_network_order')
                            ->where('network_id', $item->id)
                            ->where('series_id', $series->id)
                            ->value('order');
                        $series->order = $order;
            
                        return true;
                    }
            
                    return false;
                });
            
                $item['series'] = $item['series']->sortBy('order'); 
            
                return $item;
            });

            // dd($SeriesNetwork);
            $data = array ( 'Series_Network'=> $SeriesNetwork );
            // dd($data);
    
            return view('admin.network.index',$data);
        
        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }

    }

    public function Network_store(Request $request)
    {
        try {
            $inputs = array(
                'parent_id' => $request->parent_id,
                'name'      => $request->name, 
                'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->name) ,
                'in_home'   => $request->in_home ,
                'footer'    => $request->footer,
                'banner'    => $request->banner,
                'in_menu'   => $request->in_menu ,
                'order'     => SeriesNetwork::max('order') + 1 ,
                'network_list_active' => $request->network_list_active ,
            );
    
            if($request->hasFile('image')){
    
                $file = $request->image;
    
                if(compress_image_enable() == 1){
    
                    $filename   = 'series-Network-'.time().'.'.compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename ,compress_image_resolution() );
    
                }else{
    
                    $filename   = 'series-Network-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename );
                }
    
                $inputs +=  ['image' => $filename ];
            }
    
            if($request->hasFile('banner_image')){
    
                $file = $request->banner_image;
    
                if(compress_image_enable() == 1){
    
                    $filename   = 'series-Network-banner-'.time().'.'.compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename ,compress_image_resolution() );
    
                }else{
    
                    $filename   = 'series-Network-banner-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename );
                }
    
                $inputs +=  ['banner_image' => $filename ];
            }
    
            $SeriesNetwork = SeriesNetwork::create($inputs);
    
            return back()->with('message', 'New TV-Shows Network added successfully.');
        
        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function Network_edit(Request $request)
    {
        try {

            $All_SeriesNetwork =  SeriesNetwork::orderBy('order')->get()->map(function ($item) {
                $item['image_url'] = $item->image != null ? URL::to('public/uploads/seriesNetwork/'.$item->image ) : default_vertical_image_url() ;
                $item['banner_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/seriesNetwork/'.$item->banner_image ) : default_horizontal_image_url();
                return $item;
            });
    
            $SeriesNetwork =  SeriesNetwork::where('id',$request->id)->orderBy('order')->get()->map(function ($item) {
                $item['image_url'] = $item->image != null ? URL::to('public/uploads/seriesNetwork/'.$item->image ) : default_vertical_image_url() ;
                $item['banner_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/seriesNetwork/'.$item->banner_image ) : default_horizontal_image_url();
                return $item;
            })->first();
    
            $data = array (
                'All_SeriesNetwork' => $All_SeriesNetwork,
                'Series_Network'=> $SeriesNetwork , 
            );
    
            return view('admin.network.edit',$data);

            
        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function Network_update(Request $request,$id)
    {
        try {

            $inputs = array(
                'parent_id' => $request->parent_id,
                'name'      => $request->name, 
                'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->name) ,
                'in_home'   => $request->in_home ,
                'footer'    => $request->footer,
                'banner'    => $request->banner,
                'in_menu'   => $request->in_menu ,
                'network_list_active' => $request->network_list_active ,
            );
    
            if($request->hasFile('image')){
    
                $file = $request->image;
    
                if(compress_image_enable() == 1){
    
                    $filename   = 'series-Network-'.time().'.'.compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename ,compress_image_resolution() );
    
                }else{
    
                    $filename   = 'series-Network-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename );
                }
    
                $inputs +=  ['image' => $filename ];
            }
    
            if($request->hasFile('banner_image')){
    
                $file = $request->banner_image;
    
                if(compress_image_enable() == 1){
    
                    $filename   = 'series-Network-banner-'.time().'.'.compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename ,compress_image_resolution() );
    
                }else{
    
                    $filename   = 'series-Network-banner-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename );
                }
    
                $inputs +=  ['banner_image' => $filename ];
            }
    
            $SeriesNetwork = SeriesNetwork::find($id)->update($inputs);
    
            return back()->with('message', 'TV-Shows Network Updated successfully.');
        
        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function Network_delete($id)
    {
        try {
            SeriesNetwork::destroy($id);

            return redirect()->route('admin.Network_index')->with('message', 'TV-Shows Network deleted successfully.');
        
        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function Network_order(Request $request){

        $input = $request->all();
        $positions = $_POST['position'];

        $i=1;
        foreach($positions as $key =>$position){
          $SeriesNetwork = SeriesNetwork::find($position);
          $SeriesNetwork->order = $i;
          $SeriesNetwork->save();
          $i++;
        }
        return 1;
    }

    public function NetworkBased_order(Request $request)
    {
        $data = $request->input('position');
        // dd($data);
        $network_id = $request->input('network_id'); // Retrieve network_id from the request

        if (is_array($data) && $network_id) {
            foreach ($data as $order => $series_id) {
                // Check if the row already exists
                $exists = DB::table('series_network_order')->where('series_id', $series_id)->where('network_id', $network_id)->exists();
                // dd($network_id);
                if ($exists) {
                    // Update the order if it exists
                    DB::table('series_network_order')->where('series_id', $series_id)->where('network_id', $network_id)->update(['order' => $order + 1]);
                } else {
                    // Insert a new row if it does not exist
                    DB::table('series_network_order')->insert([
                        'series_id' => $series_id,
                        'network_id' => $network_id, // Ensure network_id is inserted
                        'order' => $order + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return response()->json(['success' => 'Order updated successfully.']);
        }

        return response()->json(['error' => 'Invalid data or network ID missing.'], 400);
    }


}