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
            sendAjax($("#slider_volume").val(),$("#slider_frequence").val());
        });
        $(".slider").on('input', function(){
            // Si trop demandant à enlever
            //sendAjax($("#slider_volume").val(),$("#slider_frequence").val());
        })
        $('#src-player').on('error', function(){
            if($('#player-error:visible').length == 0){
                $('#player-error').delay(400).fadeIn(600);
            }
            if($('#player-success:visible').length == 1){
                $('#player-success').fadeOut(600);
            }
            var myInterval = setInterval(function(){
                document.getElementById("player").load();
                if($('#player-success').error == null) clearInterval(myInterval);
            },1500);

        });
        $('#player').on('canplay', function(){
            if($('#player-error:visible').length == 1){
                $('#player-error').fadeOut(600);
            }
            if($('#player-success:visible').length == 0){
                $('#player-success').delay(400).fadeIn(600);
            }

        });
        $('.btn-kill-process').on('click', function(){
            $.post(
                'execute/command-kill',
                {
                    "_token": "{{csrf_token ()}}",
                },
                function(data){

                },
                'text'
            );
        });
        $('#player').on('ended', function(){
            document.getElementById("player").load();
        });

        $("#volume").click(function(e){
            e.preventDefault();
        });
        setInputListener("#volume", "#slider_volume");
        setInputListener(".frequence", "#slider_frequence");

        function sendAjax(volume, frequence){
            $(".progress").show();
            $("#slider_frequence").prop( "disabled", true );
            $(".progress-bar").addClass('pb-fill');
            setTimeout(function(){ $(".progress-bar").removeClass('pb-fill');  $("#slider_frequence").prop( "disabled", false );}, 2000);
            $.post(
                'execute/command',
                {
                    "_token": "{{csrf_token ()}}",
                    volume : volume,
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

                sendAjax($("#slider_volume").val(),$("#slider_frequence").val());
            });
        }
    });

</script>
<footer class="footer">
    @include('includes.default.footer')
</footer>
</body>

</html>
