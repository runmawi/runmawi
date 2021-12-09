<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use File;
use App\Test as Test;
use App\Video as Video;
use App\MoviesSubtitles as MoviesSubtitles;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use App\Artist;
use App\Videoartist;
use App\EmailSetting;
use App\EmailTemplate;
use GifCreator\GifCreator;
use DB;

class AdminEmailTemplateController extends Controller
{
    public function index()
    {
        $email_template = EmailTemplate::get();
        
        $data = array(
            'email_template' => $email_template,
            );

        return View('template.email_template', $data);
    }
    
    public function View($id)
    {
        $email_template = EmailTemplate::find($id);
        
        $data = array(
            'email_template' => $email_template,
            );

        return View('template.view_template', $data);
    }
    public function Edit($id)
    {
        $email_template = EmailTemplate::find($id);
        $data = array(
            'email_template' => $email_template,
            );

        return View('template.update_template', $data);
    }
    public function Update(Request $request)
    {
        $data = $request->all();      
        // dd($data);
        $id = $data['id'];
        $email_template = EmailTemplate::find($id);
        $email_template['template_type'] = $data['template_type'];
        $email_template['heading'] = $data['heading'];
        $email_template['description'] = $data['description'];
        $email_template->save();

        return back()->with('message', 'Successfully Template Updated!.');

    }

    public function Template_search(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');
         $view = URL::to('admin/template/view');
         $edit = URL::to('admin/template/edit');
      if($query != '')
      {
       $data = EmailTemplate::where('template_type', 'like', '%'.$query.'%')
         ->orderBy('created_at', 'desc')
         ->paginate(9);
         
      }
      else
      {

      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
        <td>'.$row->id.'</td>
        <td>'.$row->template_type.'</td>
        <td>'.$row->heading.'</td>
         <td> '."<a class='iq-bg-warning' data-toggle='tooltip' data-placement='top' title='' data-original-title='View' href=' $view/$row->id'><i class='lar la-eye'></i>
        </a>".'
        '."<a class='iq-bg-success' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit' href=' $edit/$row->id'><i class='ri-pencil-line'></i>
        </a>".'
        </td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
}
}