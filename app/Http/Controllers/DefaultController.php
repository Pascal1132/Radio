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
        $squelch = Setting::get ('squelch');
        $gain = Setting::get ('gain');
        if(!($gain >=0 )) $gain = 49.6;
        if(!($squelch >=0)) $squelch = 30;
        $command = Setting::get ('command');
        $command = $this->replaceParamsCommand ($command, ['F'=>$freq, 'S'=>$squelch, 'G'=>$gain]);


        Setting::set ('freq_in_use', $freq);
        if(!is_null ($command) && !blank ($command)){
            $output = shell_exec ($command);
        }else{
            $output = 'La commande est vide';
        }

        $arr= [];
        $arr['output'] = $output;
        $arr['freq_in_use'] = $freq;
        $arr['radio_name'] = (Setting::get ('channels')[$freq]['name'] ?? '');

        return json_encode ($arr);
    }
    public function executeCommandKill(Request $request){
        $output = '';
        if(!is_null (Setting::get ('kill_command')) && !blank (Setting::get ('kill_command'))){
            $return = exec (Setting::get ('kill_command'), $output);
            if ($return != 0)
            {
                $output = 'Erreur dans la commande de suppression de processus';
            }
        }
        Setting::set ('freq_in_use', null);
        return $output;
    }
    public function saveCommandOptions(Request $request){
        $squelch = $request->input ('squelch') ?? null;
        $gain = $request->input ('gain') ?? null;
        if($gain) Setting::set ('gain', $gain);
        if($squelch) Setting::set ('squelch', $squelch);
        return back()->with(['succes'=>'Enregistrement effectué']);
    }
    public function getOptions(Request $request){
        return json_encode ([
            'squelch' => Setting::get ('squelch'),
            'gain' => Setting::get ('gain')
        ]);
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
