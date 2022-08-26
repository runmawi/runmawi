<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HomeSetting;
use App\ModeratorsUser;
use Theme;

class ChannelPartnerController extends Controller
{
    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    public function channelparnter(Request $request)
    {
       $channel_partner = array(
            'channel_partner_list' => ModeratorsUser::where('status',1)->get() ,
       );
       return Theme::view('ChannelPartner.Channelpartners',$channel_partner);
    }

    public function unique_channelparnter( Request $request,$username )
    {
        try {

            $content_partner_id = ModeratorsUser::where('username',$username)->pluck('id')->first();

            $content_partner = array(
                'ModeratorUsers_list' => ModeratorsUser::where('status',1)->where('id',$content_partner_id)->get() ,
            );

            return Theme::view('ContentPartner.content_partners',$content_partner);

        } catch (\Throwable $th) {

            return abort(404);
        }
    }
}
