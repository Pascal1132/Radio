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
        Setting::set ('freq_in_use', $freq);
        $command = Setting::get ('command');
        $kill_command = Setting::get ('kill_command');
        $output = '';

        $command = $this->replaceParamsCommand ($command, ['F'=>$freq]);
        if(!is_null ($kill_command) && !blank ($kill_command)){
            $return = exec ($kill_command, $output);
            if ($return != 0)
            {
                $output = 'Erreur dans la commande de suppression de processus';
            }else{
                if(!is_null ($command) && !blank ($command)){
                    $output = var_dump(shell_exec ($command));
                }else{
                    $output = 'La commande est vide';
                }
            }
        }
        $arr['output'] = $output;

        $arr= [];
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
