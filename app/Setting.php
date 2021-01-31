<?php


namespace App;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Boolean;

class Setting
{
    public static function get($param){
        if(config('app.settings') == null){
            return null;
        }else if (isset(config('app.settings')[$param])){
            return config('app.settings')[$param];
        }else {
            return null;
        }
    }
    public static function set($param, $value){
        if(config('app.settings') == null){
            $settings = [];
            $settings[$param] = $value;

        }else {
            $settings = config('app.settings');
            $settings[$param] = $value;
        }
        $text = json_encode ($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents (config_path ('config.json'), $text);
    }
}
