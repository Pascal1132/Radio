@extends('layouts.default')

@section('content')

    <div class="w-100 text-center">
        <br>
        <div class="progress" style="background: none; ">
            <div class="progress-bar bg-info " role="progressbar" style="width: 0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br>
            <h2>Petite radio</h2>
            <p>Vous pouvez définir les paramètres</p>

            <input type="range" min="80000" max="120000" value="100000" step="100" class="slider" id="slider_frequence">
            <p>Fréquence: <span id="frequence"></span><input class="input-hide-toggle" id="frequence_input" type="number" style="display: none"/> Hz</p>

            <audio id="player">
                <source src="{{\App\Setting::get ('audio_url_mount_point')}}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        <div>
            <button class="btn" id="play" onclick="document.getElementById('player').play()"><i class="fas fa-play"></i>

            </button>
            <button class="btn" id="pause" onclick="document.getElementById('player').pause()" style="display: none"><i class="fas fa-pause"></i></button>
            <button class="btn" id="volume-up" onclick="document.getElementById('player').volume+=0.1"><i class="fas fa-volume-up"></i></button>
            <button class="btn" id="volume-down" onclick="document.getElementById('player').volume-=0.1"><i class="fas fa-volume-down"></i></button>
        </div>

        @if(\App\Setting::get('freq_in_use'))
            <span>Fréquence actuelle: <span id="freq_in_use">{{\App\Setting::get('freq_in_use')}}</span> hz</span>
        @endif
        <br>
        <code id="return" class="mt-2"></code>


    </div>
@stop
