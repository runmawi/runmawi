<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Socialite;
use App\User;
use Session;
use Hash;

class GoogleLoginController extends Controller
{
 
public function redirect($provider)
{
    return Socialite::driver($provider)->redirect();
}
 
public function callback(Request $request ,$provider)
{
           
    if (!$request->has('code') || $request->has('denied')) {
        return redirect('/');
    }

    $getInfo = Socialite::driver($provider)->user();

    // $findUser = User::where('email', $getInfo->email)->first();

    $saveUser = User::updateOrCreate([
        'email' => $getInfo->getEmail(),
    ],[
        'name' => $getInfo->getName(),
        'username'     => $getInfo->name,
        'email' => $getInfo->getEmail(),
        'password' => Hash::make($getInfo->getName().'@'.$getInfo->getId()),
        'provider' => $provider,
        'role'    =>'registered',
        'active'    =>'1',
        'provider_id' => $getInfo->id
         ]);

    Auth::loginUsingId($saveUser->id);


    // if($findUser){
    //     // Auth::login($findUser);
    //     auth()->login($findUser);
    //    $user = $findUser;
    // }else{
    //      $user = User::updateOrcreate([
    //         'name'     => $getInfo->name,
    //         'username'     => $getInfo->name,
    //         'active'    =>'1',
    //         'role'    =>'registered',
    //         'email'    => $getInfo->email,
    //         'provider' => $provider,
    //         'provider_id' => $getInfo->id
    //     ]);
    //     auth()->login($user);
    // }


    // $user = $this->createUser($getInfo,$provider);
 
    // auth()->login($user);
    $user = $saveUser;
    session()->put('user', $user);
    session()->put('expiresIn', $getInfo->expiresIn);
    session()->put('providertoken', $getInfo->token);

    return redirect('/home');

}
function createUser($getInfo,$provider){
 
 $user = User::where('provider_id', $getInfo->id)->first();

 $user_exits = User::where('email', $getInfo->email)->first();

 
 if (!$user && empty($user_exits)) {
     $user = User::create([
        'name'     => $getInfo->name,
        'active'    =>'1',
        'role'    =>'registered',
        'email'    => $getInfo->email,
        'provider' => $provider,
        'provider_id' => $getInfo->id
    ]);

    return $user;

  }elseif($user_exits){

    $user_exits->name = $getInfo->name;
    $user_exits->active = 1;
    $user_exits->provider_id = $getInfo->id;
    $user_exits->provider =  $provider;
    $user_exits->active = 1;
    $user_exits->save();

    $user = array(
        'name'     => $getInfo->name,
        'email'    => $getInfo->email,
        'provider' => $provider,
        'provider_id' => $getInfo->id
    );

    return $user;

  }
}
}



