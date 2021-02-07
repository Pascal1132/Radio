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

    $("#slider_frequence").on('input', function(){
        $('.frequence').html($(this).val());
    });
    $(".slider").on('change', function(){
        sendAjaxCommand($("#slider_frequence").val());
    });
    $('#src-player').on('error', function(){
        showError('Aucune source détectée');
        connected = false;
        var myInterval = setInterval(function(){
            connected = false;
            document.getElementById("player").load();
            if($('#player-success').error == null) clearInterval(myInterval);
        },INTERVAL_TIME_RELOAD);

    });

    $('.player-custom-control.options').on('click', function(){
        getOptions();
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

    if(AUDIO_SRC == null || AUDIO_SRC == ''){
        showError('Erreur dans la configuration : <em> Aucune source définie</em>');
    }

    //////////////////////////////
    /*     Events for #player   */
    //////////////////////////////
    $('#player').on('loadeddata', function(){
        showSuccess('Connecté');
    });
    $('#player').on('play', function(){
        $('.player-custom-control.play').hide();
        $('.player-custom-control.pause').show();
    });
    $('#player').on('pause', function(){
        $('.player-custom-control.play').show();
        $('.player-custom-control.pause').hide();
    });
    $('#player').on('progress', function(){
        time= Math.floor(document.getElementById('player').currentTime);
        date = new Date(time * 1000).toISOString().substr(11, 8);
        $('.audio-progress-time').text(date);
    });
    $('#player').on('ended', function(){
        document.getElementById("player").load();
    });

    $('.player-custom-control.play').on('click', function(){
        document.getElementById('player').play();
    });
    $('.player-custom-control.pause').on('click', function(){
        document.getElementById('player').pause();
    });

    $('.btn-kill-process').on('click', function(){
        sendAjaxKillCommand();
    });
    setInputListener(".frequence", "#slider_frequence");

    function showError(msg){
        $('#player-error-text').html(msg);
        if($('#player-error:visible').length == 0){
            $('#player-error').delay(400).slideDown(600);
        }
        if($('#player-success:visible').length == 1){
            $('#player-success').slideUp(600);
        }
    }
    function showSuccess(msg){
        $('#player-success-text').html(msg);
        if($('#player-error:visible').length == 1){
            $('#player-error').slideUp(600);
        }
        if($('#player-success:visible').length == 0){
            $('#player-success').delay(400).slideDown(600);
        }

    }
    function getOptions(){
        $.get(
            'options',
            {
                "_token": CSRF_TOKEN,
            },
            function(data){
                console.debug(JSON.parse(data).squelch);
                $('.squelch-input').val(JSON.parse(data).squelch);
                $('.gain-input').val(JSON.parse(data).gain);
            },
            'text'
        );
    }

    function sendAjaxKillCommand(callback = function(){}){
        $.post(
            'execute/command-kill',
            {
                "_token": CSRF_TOKEN,
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
                "_token": CSRF_TOKEN,
                frequence : frequence
            },
            function(data){
                data = JSON.parse(data);
                $("#return").html(data);
                $(".freq_in_use").text(data.freq_in_use);
                $('.radio-name').text(data.radio_name);
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
            sendAjaxCommand($("#slider_frequence").val());
        });
    }
});
