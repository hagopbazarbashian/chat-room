$(document).ready(function(){
    $('#create-data').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        $('#create').prop('disabled', $(this).val() == null);
    });

    $('#create').click(function() {
        var selectedOptions = $('#create-data').val();

        // Show the loading spinner
        $('#loading-spinner').show();

        // Send the AJAX request
        $.ajax({
            url: '/store',
            type: 'POST',

            data:{
                "_token":$('meta[name="csrf-token"]').attr('content'),
                 "users":selectedOptions
              },
              success: function(resp) {
                // Hide the loading spinner
                $('#loading-spinner').hide();

                try {
                    // Try to parse the response as JSON
                    var responseObj = JSON.parse(resp);

                    if (responseObj.status === 1) {
                        // Do something with the response data
                        console.log(responseObj.obj);

                        // Display a success message in a Bootstrap alert
                        $('#alert').html('<div class="alert alert-success">' + responseObj.txt + '</div>');
                         location.reload();
                    } else if (responseObj.status === 0) {
                        // Display an error message in a Bootstrap alert
                        $('#alert').html('<div class="alert alert-danger">' + responseObj.txt + '</div>');
                    } else {
                        // Invalid response received from server
                        $('#alert').html('<div class="alert alert-danger">Invalid response received from server.</div>');
                    }
                } catch (e) {
                    // An error occurred while parsing the response as JSON
                    $('#alert').html('<div class="alert alert-danger">An error occurred while parsing the response.</div>');
                }
            }
        });
    });

    // Delete Chat list
    $('.chat-item-delete').on('click', function() {
        var chatitem = $(".chat-item-delete").attr('value');
        // Send the AJAX request
        $.ajax({
          url: '/deletechatlist',
          type: 'POST',
          data: {
            "_token":$('meta[name="csrf-token"]').attr('content'),
              "chatitem": chatitem
          },
          success: function(resp) {
            // Handle the response
            console.log(resp);
          }
        });
    });

    $('.chat-item').on('click', function() {
        $(this).addClass("chat-select").siblings().removeClass('chat-select')
        var c_id = $(".chat-item").attr("id")
        $("#create-msg-form").find("#chat-id").val(c_id);


        var el = $(this);
        msg_load(c_id ,10 ,true,el)


    });

    

    $('.chat-item').on('click', function() {
        $(this).addClass("chat-select").siblings().removeClass('chat-select')
        var c_id = $(this).attr("id")
        $("#create-msg-form").find("#chat-id").val(c_id);
    
        var el = $(this);
        msg_load(c_id, 10, true, el);
    });
    
    $('#msg-send').on('click', function() {
        var msg = $("#msg").val()
        var chat_id = $("#chat-id").val()
    
        $.ajax({
            url: '/message',
            type: 'POST',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'msg': msg,
                'chat_id': chat_id,
            },
            success: function(resp) {
                // Handle the response
                console.log(resp);
            }
        }).done(function(resp) {
            try {
                resp = $.parseJSON(resp)
            } catch (e) {
                window.location = "/chat/public/login";
            }
            if (resp.status = 1) {
                $("#msg").val('');
                new_msg_load(chat_id, 1);
            }
    
        }).fail(function(jqXHR) {
    
        });
    });
    
    var new_msg_load = function(c_id = null, tk = null, me = 0) {
        if (c_id == null || c_id == '') {
            c_id = $("#chat-id").val();
        }
    
        if (c_id != null && c_id != '') {
            $.ajax({
                url: '/new-message-list',
                type: 'POST',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    'c_id': c_id,
                    'me': me
                },
                
    
                success: function(resp) {
                    if (resp.status == 1) {
                        $("#msg-body").append(resp.txt);
                        var objDiv = document.getElementById("msg-body");
                        if ((Math.ceil($("#msg-body").scrollTop() + $("#msg-body").innerHeight())) >= (objDiv.scrollHeight - 110) || first == true) {
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    };
    
    var msg_load = function(c_id=null , tk=null , limit=10 ,first=false, el=null){
        if(c_id == null || c_id == ''){
            var c_id = $("#chat-id").vall();
        }

        if(c_id != null && c_id != ''){

            $.ajax({
                url: '/message-list',
                type: 'POST',
                data: {
                  "_token":$('meta[name="csrf-token"]').attr('content'),
                    'c_id': c_id,
                    'limit':limit,

                },
                success: function(resp) {
                  // Handle the response
                  console.log(resp);
                }
            }).done(function(resp){
                try{
                    resp = $.parseJSON(resp)
                } catch(e){
                    window.location = "/chat/public/login";
                }
                if(resp.status = 1){
                    $("#msg-body").empty().html(resp.txt);
                    var objDiv = document.getElementById("msg-body");

                    if((Math.ceil($("#msg-body").scrollTop() + $("#msg-body").innerHeight() ) ) >= (objDiv.scrollHeight - 110) || first == true){
                        objDiv.scrollTop = objDiv.scrollHeight;
                    }
                    $("#create-msg-form").find("#msg").prop("disabled" ,false);
                    $("#create-msg-form").find("#msg-send").prop("disabled" ,false);

                }

            }).fail(function(jqXHR){

            })

        }
    }















});


