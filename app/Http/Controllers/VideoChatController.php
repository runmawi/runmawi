<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\StartVideoChat;
use Pusher\Pusher;

class VideoChatController extends Controller
{

    public function index(Request $request) {

    $user = $request->user();
    $others = \App\User::where('id', '!=', $user->id)->pluck('name', 'id');
    return view('video_chat.index')->with([
        'user' => collect($request->user()->only(['id', 'name'])),
        'others' => $others
            ]);
        }

            public function auth(Request $request) {
                $user = $request->user();
                $socket_id = $request->socket_id;
                $channel_name = $request->channel_name;
                $pusher = new Pusher(
                    config('broadcasting.connections.pusher.key'),
                    config('broadcasting.connections.pusher.secret'),
                    config('broadcasting.connections.pusher.app_id'),
                    [
                        'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                        'encrypted' => true
                    ]
                );
                return response(
                    $pusher->presence_auth($channel_name, $socket_id, $user->id)
                );
            }

    public function callUser(Request $request)
    {
        $data['userToCall'] = $request->user_to_call;
        $data['signalData'] = $request->signal_data;
        $data['from'] = Auth::id();
        $data['type'] = 'incomingCall';

        broadcast(new StartVideoChat($data))->toOthers();
    }
    public function acceptCall(Request $request)
    {
        $data['signal'] = $request->signal;
        $data['to'] = $request->to;
        $data['type'] = 'callAccepted';
        broadcast(new StartVideoChat($data))->toOthers();
    }
}
