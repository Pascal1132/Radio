@extends('layouts.default')

@section('content')

    <div class="w-100 text-center overflow-auto">
        <br>
        <div class="progress" style="background: none; ">
            <div class="progress-bar bg-info " role="progressbar" style="width: 0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br>
            <h4 class="text-secondary radio-name" style="min-height: 30px">{{\App\Setting::get ('channels')[\App\Setting::get('freq_in_use')]['name'] ?? ''}}</h4>

            <h1><span class="freq_in_use frequence" >{{\App\Setting::get('freq_in_use') ?? '0'}}</span><input class="input-hide-toggle frequence_input" type="number" style="display: none"/> MHz <i class="far fa-list-alt btn-show-modal-channel btn d-inline-block" type="button" data-toggle="modal" data-target="#modalChannels"></i></h1>

            <input type="hidden" class="live_freq">

            <input type="range" min="{{\App\Setting::get ('freq_min') ?? 80}}" max="{{\App\Setting::get ('freq_max') ?? 120}}" value="{{\App\Setting::get('freq_in_use')}}" step="0.1" class="slider" id="slider_frequence">

            <br><br>
            <div >
                <br>
            <audio id="player" autoplay="true">
                <source id="src-player" src="{{\App\Setting::get ('audio_url_mount_point')}}" >
                Your browser does not support the audio element.
            </audio>

                <div id="custom-player">
                    <div> <i class="fas fa-times-circle btn-kill-process player-custom-control" title='Forcestop process'></i>
                        <i class="fas fa-play player-custom-control play" title="Play"></i>
                        <i title='Pause' class="fas fa-pause player-custom-control pause" style="display: none"></i>
                        <span class="audio-progress-time">00:00:00</span>
                        <i class="fas fa-undo player-custom-control"></i>
                        <i class="fas fa-redo player-custom-control"></i>
                        <i class="fas fa-sliders-h player-custom-control options" type="button" data-toggle="modal" data-target="#modalOptions"></i>
                    </div>
                </div>
                <div class="text-danger" id="player-error" style="display: none"><span id="player-error-text"></span> <i class="fas fa-exclamation-triangle text-danger mb-1"></i></div>
            </div>
        <div class="text-success" id="player-success" style="display: none"><span id="player-success-text"></span> <i class="fas fa-link"></i>
        </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="modalOptions" tabindex="-1" role="dialog" aria-labelledby="modalOptionsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <form method="post" action="{{route ('command_options')}}" id="form-options">
                        {{csrf_field ()}}
                        <button type="button" class="float-right btn-modal save-options" data-dismiss="modal"><i class="fas fa-save"></i></button>
                        <label for="">Squelch :</label>
                        <input class="form-control squelch-input" type="number" min="0" placeholder="Squelch" name="squelch" value="{{\App\Setting::get('squelch') ?? '0'}}">
                        <br>
                        <label for="">Gain :</label>
                        <input class="form-control gain-input" type="number" min="0" placeholder="Squelch" name="gain" value="{{\App\Setting::get('gain') ?? '0'}}">
                    </form>
                </div>


            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="modalChannels" tabindex="-1" role="dialog" aria-labelledby="modalChannelsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Liste des chaînes</h6>
                </div>
                <div class="modal-body">

                    @forelse(\App\Setting::get('channels') as $freq => $channel)
                        <button class="btn btn-outline-dark btn-channel" data-freq="{{ $freq }}">{{$channel['name']}} ({{$freq}})</button>
                    @empty
                        Aucune chaine
                    @endforelse
                </div>


            </div>
        </div>
    </div>
    <script>
        var CSRF_TOKEN = '{{csrf_token ()}}';
        var INTERVAL_TIME_RELOAD = {{\App\Setting::get('interval_time_reload') ?? 1500}};
        var AUDIO_SRC = '{{\App\Setting::get ('audio_url_mount_point')}}';
    </script>
    <script type="text/javascript" src="{{ asset('public/js/default/home.js') }}"></script>
@stop
