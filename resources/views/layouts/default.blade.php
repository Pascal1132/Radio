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
        $('#volume').html($("#slider_volume").val() );
        $('#frequence').html($("#slider_frequence").val() );
        $("#slider_volume").on('input', function(){
            $('#volume').html($(this).val());
        });
        $("#slider_frequence").on('input', function(){
            $('#frequence').html($(this).val());


        });
        $(".slider").on('change', function(){
            sendAjax($("#slider_volume").val(),$("#slider_frequence").val());
        });
        $(".slider").on('input', function(){
            // Si trop demandant à enlever
            sendAjax($("#slider_volume").val(),$("#slider_frequence").val());
        })



        $("#volume").click(function(e){
            e.preventDefault();

        });
        setInputListener("#volume", "#slider_volume");
        setInputListener("#frequence", "#slider_frequence");

        function sendAjax(volume, frequence){
            $.post(
                'execute/command',
                {
                    "_token": "{{csrf_token ()}}",
                    volume : volume,
                    frequence : frequence
                },
                function(data){
                    $("#return").html(data);
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