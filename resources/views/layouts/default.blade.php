<!doctype html>

<html>

<head>

    @include('includes.default.head')

</head>

<body>

<header>
    @include('includes.default.header')
</header>

    <div class="container-fluid">


            @yield('content')


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
            sendAjaxKillCommand(function(){
                sendAjaxCommand($("#slider_frequence").val());
            });
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

        function sendAjaxKillCommand(callback = function(){}){
            $.post(
                '{{(str_ends_with(\App\Setting::get ('url_server'), '/') || empty(\App\Setting::get ('url_server'))) ? \App\Setting::get ('url_server') : \App\Setting::get ('url_server') . '/'}}execute/command-kill',
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
                '{{(str_ends_with(\App\Setting::get ('url_server'), '/') || empty(\App\Setting::get ('url_server'))) ? \App\Setting::get ('url_server') : \App\Setting::get ('url_server') . '/'}}execute/command',
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

                sendAjaxKillCommand(function(){
                    sendAjaxCommand($("#slider_frequence").val());
                });

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
<footer class="footer">
    @include('includes.default.footer')
</footer>
</body>

</html>
