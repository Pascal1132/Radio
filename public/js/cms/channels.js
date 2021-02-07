$( document ).ready(function() {
    $('#btn-add-channel').on('click', function(){
        $.post(
            POST_CHANNEL_URL,
            {
                "_token": CSRF_TOKEN,
                channel: {
                    frequency: $('.frequency-input').val(),
                    name: $('.name-input').val(),
                }
            },
            function(data){
                reloadTable();
            }
        )
    });

    reloadTable();
    function reloadTable(){
        $.get(
            GET_TABLE_URL,
            {
                "_token": CSRF_TOKEN
            },
            function(data){
                if(data==''){
                    $('#no-channel').show(0);
                }else {
                    $('#no-channel').hide(0);
                }
                $('#channels-list').html(data);
                $('.btn-remove-channel').on('click',function (){
                    removeChannel($(this).data('frequency'));
                });
            },
            'text'
        );
    }
    function removeChannel(frequency){
        $.ajax({
            url: DELETE_CHANNEL_URL,
            type: 'DELETE',
            data: {
                "_token": CSRF_TOKEN,
                "frequency": frequency
            },
            success: function(data){
                reloadTable();
            }
        });
    }
});
