@extends('layouts.default')

@section('content')

    <div class="w-100 text-center">
        <br>
        <div class="progress" style="background: none; ">
            <div class="progress-bar bg-info " role="progressbar" style="width: 0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br>

            <h1><span class="freq_in_use frequence" >{{\App\Setting::get('freq_in_use') ?? '0'}}</span><input class="input-hide-toggle frequence_input" type="number" style="display: none"/> MHz</h1>


            <input type="range" min="80" max="120" value="{{\App\Setting::get('freq_in_use')}}" step="0.1" class="slider" id="slider_frequence"> <button title='Forcestop process' class="btn btn-sm btn-danger rounded-pill mb-2 btn-kill-process"> <i class="fas fa-times-circle"></i></button>

            <br><br>
            <div >
            <audio id="player" controls autoplay="true">
                <source id="src-player" src="{{\App\Setting::get ('audio_url_mount_point')}}" >
                Your browser does not support the audio element.
            </audio>
            <div class="text-danger" id="player-error" style="display: none">Erreur dans le chargement de l'audio: Aucune source détectée <i class="fas fa-exclamation-triangle text-danger mb-5"></i></div>
            </div>
        <div class="text-success" id="player-success" style="display: none">Connecté <i class="fas fa-link"></i>

        </div>
        </div>

        <br>
        <code id="return" class="mt-2"></code>


    </div>
@stop
