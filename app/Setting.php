<?php


namespace App;


use http\Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Boolean;
use Whoops\Exception\ErrorException;

class Setting
{
    public static function get($param){
        if(json_decode(file_get_contents(config_path('config.json')), true) == null){
            return null;
        }else if (isset(json_decode(file_get_contents(config_path('config.json')), true)[$param])){
            return json_decode(file_get_contents(config_path('config.json')), true)[$param];
        }else {
            return null;
        }
    }
    public static function set($param, $value){
        if(json_decode(file_get_contents(config_path('config.json')), true) == null){
            $settings = [];
            $settings[$param] = $value;

        }else {

            $settings = json_decode(file_get_contents(config_path('config.json')), true);
            $settings[$param] = $value;
        }
        config(['app.settings' => $settings]);
        try {
            while(Setting::get ($param) !== $value){
                $text = json_encode ($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                file_put_contents (config_path ('config.json'), $text);
            }
        }catch(Exception $e){
            throw new ErrorException($e->getMessage (), 0);
        }

    }
}
