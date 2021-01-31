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
        $command = $this->replaceParamsCommand ($command, ['F'=>$freq]);
        $arr= [];
        $arr['command'] = $command;
        exec ('kill ' . Setting::get ('pid'));
        $arr['output']=shell_exec ($command . " 2>&1; echo $?");
        $arr['pid'] = $process->getPid ();
        $output = $process->getOutput();


        Setting::set ('pid', $arr['pid']);
        $arr['status'] = 'success';
        echo var_dump ($arr);
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
