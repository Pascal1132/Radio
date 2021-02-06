@extends('layouts.default')

@section('content')

    <div class="w-100 text-center">
        <br>
        <div class="progress" style="background: none; ">
            <div class="progress-bar bg-info " role="progressbar" style="width: 0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br>

            <h1><span class="freq_in_use frequence" >{{\App\Setting::get('freq_in_use') ?? '0'}}</span><input class="input-hide-toggle frequence_input" type="number" style="display: none"/> MHz</h1>


            <input type="range" min="{{\App\Setting::get ('freq_min') ?? 80}}" max="{{\App\Setting::get ('freq_max') ?? 120}}" value="{{\App\Setting::get('freq_in_use')}}" step="0.1" class="slider" id="slider_frequence">

            <br><br>
            <div >
            <audio id="player" autoplay="true">
                <source id="src-player" src="{{\App\Setting::get ('audio_url_mount_point')}}" >
                Your browser does not support the audio element.
            </audio>

                <div id="custom-player">
                    <div> <i class="fas fa-times-circle btn-kill-process player-custom-control" title='Forcestop process'></i><i class="fas fa-play player-custom-control play" title="Play"></i><i title='Pause' class="fas fa-pause player-custom-control pause" style="display: none"></i><span class="audio-progress-time">00:00:00</span><i class="fas fa-undo player-custom-control"></i><i class="fas fa-redo player-custom-control"></i><i class="fas fa-sliders-h player-custom-control" type="button" data-toggle="modal" data-target="#modalOptions"></i></div>
                </div>
            <div class="text-danger" id="player-error" style="display: none">Erreur dans le chargement de l'audio: Aucune source détectée <i class="fas fa-exclamation-triangle text-danger mb-5"></i></div>
            </div>
        <div class="text-success" id="player-success" style="display: none">Connecté <i class="fas fa-link"></i>

        </div>
        </div>
        <br>
        <code id="return" class="mt-2"></code>



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
                        <input class="form-control squelch-input" step="5" type="number" min="0" placeholder="Squelch" name="squelch" value="{{\App\Setting::get('squelch') ?? '0'}}">
                        <br>
                        <label for="">Gain :</label>
                        <input class="form-control gain-input" step="5" type="number" min="0" placeholder="Squelch" name="gain" value="{{\App\Setting::get('gain') ?? '0'}}">

                    </form>
                </div>


            </div>
        </div>
    </div>
    <script>
        $( document ).ready(function() {
            var connected = false;
            $('#play').on('click',function(){
                $('#pause').show();
                $(this).hide();
            });
            $('#pause').on('click',function(){
                $('#play').show();
                $(this).hide();
            });
            $('#volume').html($("#slider_volume").val() );

            $("#slider_volume").on('input', function(){
                $('#volume').html($(this).val());
            });
            $("#slider_frequence").on('input', function(){
                $('.frequence').html($(this).val());


            });
            $(".slider").on('change', function(){
                sendAjaxKillCommand();
                setTimeout(() => {  sendAjaxCommand($("#slider_frequence").val()); }, 500);
            });
            $('#src-player').on('error', function(){
                if($('#player-error:visible').length == 0){
                    $('#player-error').delay(400).slideDown(600);
                }
                if($('#player-success:visible').length == 1){
                    $('#player-success').slideUp(600);
                }
                connected = false;
                var myInterval = setInterval(function(){
                    connected = false;
                    document.getElementById("player").load();
                    if($('#player-success').error == null) clearInterval(myInterval);
                },1500);

            });
            $('.save-options').on('click', function(event){

                event.preventDefault();
                $.ajax({
                    url: $('#form-options').attr("action"),
                    type: $('#form-options').attr("method"),
                    dataType: "JSON",
                    data: new FormData(document.getElementById('form-options')),
                    processData: false,
                    contentType: false,
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {


                    }
                });
            });

            $('#player').on('loadeddata', function(){
                if($('#player-error:visible').length == 1){
                    $('#player-error').slideUp(600);
                }
                if($('#player-success:visible').length == 0){
                    $('#player-success').delay(400).slideDown(600);
                }

            });
            $('#player').on('play', function(){
                $('.player-custom-control.play').hide();
                $('.player-custom-control.pause').show();
            });
            $('#player').on('pause', function(){
                $('.player-custom-control.play').show();
                $('.player-custom-control.pause').hide();
            });
            $('.player-custom-control.play').on('click', function(){
                document.getElementById('player').play();
            });
            $('.player-custom-control.pause').on('click', function(){
                document.getElementById('player').pause();
            });
            $('#player').on('progress', function(){
                time= Math.floor(document.getElementById('player').currentTime);
                date = new Date(time * 1000).toISOString().substr(11, 8);
                $('.audio-progress-time').text(date);
            });
            $('.btn-kill-process').on('click', function(){
                sendAjaxKillCommand();
            });
            $('#player').on('ended', function(){
                document.getElementById("player").load();
            });

            $("#volume").click(function(e){
                e.preventDefault();
            });
            setInputListener("#volume", "#slider_volume");
            setInputListener(".frequence", "#slider_frequence");

            function sendOptions(options){

            }
            function sendAjaxKillCommand(callback = function(){}){
                $.post(
                    'execute/command-kill',
                    {
                        "_token": "{{csrf_token ()}}",
                    },
                    callback,
                    'text'
                );
            }

            function sendAjaxCommand(frequence){
                $(".progress").show();
                $("#slider_frequence").prop( "disabled", true );
                $(".progress-bar").addClass('pb-fill');
                setTimeout(function(){ $(".progress-bar").removeClass('pb-fill');  $("#slider_frequence").prop( "disabled", false );}, 2000);
                $.post(
                    'execute/command',
                    {
                        "_token": "{{csrf_token ()}}",
                        frequence : frequence
                    },
                    function(data){
                        data = JSON.parse(data);
                        $("#return").html(data);
                        $(".freq_in_use").text(data.freq_in_use);

                    },
                    'text'
                );


            }
            // #name and #name_input
            function setInputListener(name, slider){
                $(name).click(function(e){
                    e.preventDefault();
                    var txt = $(this).text();
                    $(name+"_input").val(txt);

                    $(this).fadeOut(100, function () {
                        $(name+"_input").fadeIn(100);
                        $(name+"_input").focus();
                    });
                });
                $(name+"_input").focusout(function(e) {
                    var txt = $(this).val();
                    $(slider).val(txt);
                    $(name).text($(slider).val());
                    $(this).fadeOut(100, function(){
                        $(name).fadeIn(100);
                    });
                    sendAjaxKillCommand();
                    setTimeout(() => {  sendAjaxCommand($("#slider_frequence").val()); }, 500);



                });
            }

            function UrlExists(url)
            {
                var http = new XMLHttpRequest();
                http.open('HEAD', url, false);
                http.send();
                return http.status!=404;
            }
        });

    </script>
@stop
