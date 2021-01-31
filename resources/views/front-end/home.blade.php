@extends('layouts.default')

@section('content')

    <div class="w-100 text-center">

        <br>
            <h2>Petite radio</h2>
            <p>Vous pouvez définir les paramètres</p>
            <input type="range" min="0" max="100" value="50" class="slider" id="slider_volume">
            <p>Volume: <span id="volume"></span><input class="input-hide-toggle" id="volume_input" type="number" style="display: none"/> %</p>
            <input type="range" min="80000" max="120000" value="100000" step="100" class="slider" id="slider_frequence">
            <p>Frequence: <span id="frequence"></span><input class="input-hide-toggle" id="frequence_input" type="number" style="display: none"/> Hz</p>

            <audio controls>
                <source src="{{\App\Setting::get ('audio_url_mount_point')}}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        <br>
        <code id="return" class="mt-2"></code>


    </div>

@stop
