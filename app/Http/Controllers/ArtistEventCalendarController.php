<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting as Setting;
use \Redirect as Redirect;
use App\Audioartist;
use App\Audio as Audio;
use App\Artist as Artist;
use App\Adsurge as Adsurge;
use App\HomeSetting as HomeSetting;
use URL;
use Auth;
use View;
use Hash;
use Mail;
use Theme;
use Nexmo;

class ArtistEventCalendarController extends Controller
{

    public function __construct()
    {
        $settings = Setting::first();
        $this->audios_per_page = $settings->audios_per_page;
        $this->movies_per_page = $settings->audios_per_page;
        $this->series_per_page = $settings->audios_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses(  $this->Theme );
    }

    public function index(Request $request, $slug)
    {

        
        try {

            if ($request->ajax()) {
                $data = Adsurge::whereDate('start', '>=', $request->start)
                    ->whereDate('end', '<=', $request->end)
                    ->get(['id', 'title', 'start', 'end']);
                return response()->json($data);
            }

        } catch (\Throwable $th) {
            throw $th;
        }    

        return Theme::view('ArtistCalendarEvent');

    }

    public function getEvents()
    {
        $events = Adsurge::all();

        $formattedEvents = [];

        foreach ($events as $event) {
            // Check if start_datetime and end_datetime are not null
            if ($event->start_datetime && $event->end_datetime) {
                $formattedEvents[] = [
                    'title' => $event->title,
                    'start' => $event->start_datetime->toDateTimeString(),
                    'end' => $event->end_datetime->toDateTimeString(),
                ];
            }
        }
        dd(response()->json($formattedEvents));
        
        return response()->json($formattedEvents);
    }
}
