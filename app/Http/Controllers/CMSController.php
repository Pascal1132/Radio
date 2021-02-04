<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class CMSController extends Controller
{
    public function __construct (){
        $this->middleware('notauth')->except('login');

    }

    public function login(Request $request){
        $user = $request->input ('name');
        $password = $request->input ('password');
        $password_hashed = Hash::make($password);

        if(config('app.settings') == null){

            Setting::set ('credentials', [
                'name' => $user,
                'password' => $password_hashed
            ]);
            session(['user'=>$user]);
            return redirect('/cms/home');
        }else if (isset(config('app.settings')['credentials'])){
            if(Hash::check($password, config('app.settings')['credentials']['password'])){
                session(['user'=>$user]);
                return redirect('/cms/home');
            }else{
                return Redirect::back()->withErrors(['Connexion refusée']);
            }
        }else{
            Setting::set ('credentials', [
                'name' => $user,
                'password' => $password_hashed
            ]);
            session(['user'=>$user]);
            return redirect('/cms/home');

        }
    }

    public function logout(Request $request){
        $request->session()->forget('user');
        return redirect('/cms/');
    }
    public function range(){
        return view ('cms.range');
    }
    public function rangePost(Request $request){
        $min = $request->input('freq_min');
        $max = $request->input('freq_max');
        Setting::set ('freq_min', $min);
        Setting::set ('freq_max', $max);
        return back()->with(['succes'=>'Enregistrement effectué']);
    }
    public function command(){
        $command = Setting::get ('command');
        return view('cms.command', ['command'=>$command]);
    }
    public function channels(){
        $channels = Setting::get ('channels');
        return view('cms.channels', ['channels'=>$channels]);
    }
    public function commandPost(Request $request){
        $command = $request->input('command');
        $kill_command = $request->input('kill_command');
        Setting::set ('command', $command);
        Setting::set ('kill_command', $kill_command);

        return back()->with(['succes'=>'Enregistrement effectué']);
    }
    public function mountPointIcecast(Request $request){
        $url_server = $request->input('url_server');
        $mount_point = $request->input('mount_point');
        Setting::set ('url_server', $url_server);
        Setting::set ('audio_url_mount_point', $mount_point);
        return back()->with(['succes'=>'Enregistrement effectué']);
    }
}
