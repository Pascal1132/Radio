<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DefaultController extends Controller
{
    public function executeCommand(Request $request){
        $freq = $request->input ('frequence');
        $command = Setting::get ('command');
        $kill_command = Setting::get ('kill_command');

        $command = $this->replaceParamsCommand ($command, ['F'=>$freq]);
        if(!is_null ($kill_command) && !blank ($kill_command)){
            exec ($kill_command, $output);
        }
        $arr['output_kill'] = $output;
        if(!is_null ($command) && !blank ($command)){
            exec ($command , $output, $result);
        }


        Setting::set ('freq_in_use', $freq);
        $arr= [];
        $arr['output'] = $output;
        $arr['result'] = $result;
        $arr['freq_in_use'] = $freq;
        echo json_encode ($arr);
    }
    private function replaceParamsCommand($raw, array $params) {
        $command = $raw;
        preg_match_all("/\\#(.*?)\\#/", $raw, $match_arr);
        $params_pre_defined = $match_arr[1];
        if (!empty($params_pre_defined)) {
            $params_keys = array_keys($params);

            foreach ($params_keys as $param_key) {
                if (in_array($param_key, $params_pre_defined)) {
                    $command = str_replace('#' . $param_key . '#', $params[$param_key], $raw);
                }
            }
        }
        return  $command;
    }
}
