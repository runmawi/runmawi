<?php

namespace App\Http\Controllers;

use App\Video;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request){
        
        if($request->ajax()) {
          
            $data = Video::where('name', 'LIKE', $request->country.'%')
                ->get();
           
            $output = '';
           
            if (count($data)>0) {
              
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
              
                foreach ($data as $row){
                   
                    $output .= '<li class="list-group-item">'.$row->name.'</li>';
                }
              
                $output .= '</ul>';
            }
            else {
             
                $output .= '<li class="list-group-item">'.'No results'.'</li>';
            }
           
            return $output;
        }
    }
}