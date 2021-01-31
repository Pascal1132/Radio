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
            $settings = [];
            $settings['credentials'] = [
                'name' => $user,
                'password' => $password_hashed
            ];
            $text = json_encode ($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            file_put_contents (config_path ('config.json'), $text);
        }else if (isset(config('app.settings')['credentials'])){
            if(Hash::check($password, config('app.settings')['credentials']['password'])){
                session(['user'=>$user]);
                return \redirect (route('cms.home'));
            }else{
                return Redirect::back()->withErrors(['Connexion refusée']);
            }
        }
    }
    public function command(){
        $command = Setting::get ('command');


        return view('cms.command', ['command'=>$command]);
    }
    public function commandPost(Request $request){
        $command = $request->input('command');
        if($request->input('command') == null) $command = '';
        Setting::set ('command', $command);
        return back()->with(['succes'=>'Enregistrement effectué']);
    }
    public function mountPointIcecast(Request $request){
        $mount_point = $request->input('mount_point');
        if($request->input('mount_point') == null) $mount_point = '';
        Setting::set ('audio_url_mount_point', $mount_point);
        return back()->with(['succes'=>'Enregistrement effectué']);
    }
}
