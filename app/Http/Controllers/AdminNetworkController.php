<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\SeriesNetwork;

class AdminNetworkController extends Controller
{
    public function Network_index()
    {
        try {

            $SeriesNetwork =  SeriesNetwork::orderBy('order')->get()->map(function ($item) {
                $item['image_url'] = $item->image != null ? URL::to('public/uploads/seriesNetwork/'.$item->image ) : default_vertical_image_url() ;
                $item['banner_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/seriesNetwork/'.$item->banner_image ) : default_horizontal_image_url();
                return $item;
            });
    
            $data = array ( 'Series_Network'=> $SeriesNetwork );
    
            return view('admin.network.index',$data);
        
        } catch (\Throwable $th) {
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
    
                    $filename   = 'series-Newwork-'.time().'.'.compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename ,compress_image_resolution() );
    
                }else{
    
                    $filename   = 'series-Newwork-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename );
                }
    
                $inputs +=  ['image' => $filename ];
            }
    
            if($request->hasFile('banner_image')){
    
                $file = $request->banner_image;
    
                if(compress_image_enable() == 1){
    
                    $filename   = 'series-Newwork-'.time().'.'.compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename ,compress_image_resolution() );
    
                }else{
    
                    $filename   = 'series-Newwork-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename );
                }
    
                $inputs +=  ['banner_image' => $filename ];
            }
    
            $SeriesNetwork = SeriesNetwork::create($inputs);
    
            return back()->with('message', 'New Network added successfully.');
        
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
    
            $SeriesNetwork =  SeriesNetwork::orderBy('order')->get()->map(function ($item) {
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
    
                    $filename   = 'series-Newwork-'.time().'.'.compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename ,compress_image_resolution() );
    
                }else{
    
                    $filename   = 'series-Newwork-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename );
                }
    
                $inputs +=  ['image' => $filename ];
            }
    
            if($request->hasFile('banner_image')){
    
                $file = $request->banner_image;
    
                if(compress_image_enable() == 1){
    
                    $filename   = 'series-Newwork-'.time().'.'.compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename ,compress_image_resolution() );
    
                }else{
    
                    $filename   = 'series-Newwork-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/seriesNetwork/'.$filename );
                }
    
                $inputs +=  ['banner_image' => $filename ];
            }
    
            $SeriesNetwork = SeriesNetwork::find($id)->update($inputs);
    
            return back()->with('message', 'New Network added successfully.');
        
        } catch (\Throwable $th) {

            return abort(404);

        }
    }

    public function Network_delete($id)
    {
        try {
            SeriesNetwork::destroy($id);

            return redirect()->route('admin.Network_index');
        
        } catch (\Throwable $th) {

            return abort(404);

        }
    }
}