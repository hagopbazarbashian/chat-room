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

                if(resp.fst == 0){
                    var fst = 0;
                }else{
                     var fst = 1;
                }

                new_msg_load(chat_id, 1 ,fst);
            }

        }).fail(function(jqXHR) {

        });

        var textarea = $("#msg");
        var typingStatus = $("#typing_on");
        var lasttypedTime = new Date(0);
        var typingDelayMillis = 4000;

        function refreshTypingStatus() {
            if (!textarea.attr("disabled") && textarea.is(':focus')) {
                if (textarea.val() == '' || new Date().getTime() - lasttypedTime.getTime() > typingDelayMillis) {
                    set_typing(0);
                } else {
                    set_typing(1);
                }
            }
        }

        function updateLastTypedTime(){
            lasttypedTime = new Date();
        }

        setInterval(refreshTypingStatus , 2000);
        textarea.keypress(updateLastTypedTime);
        textarea.blur(function(){
            set_typing(0);
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

                        // if(fst == 0){
                        //     $("#msg-body").append(resp.txt);
                        // }else{
                        //     $("#msg-body").html(resp.txt);
                        // }
                        $("#msg-body").append(resp.txt);
                        var objDiv = document.getElementById("msg-body");
                        if ((Math.ceil($("#msg-body").scrollTop() + $("#msg-body").innerHeight())) >= (objDiv.scrollHeight - 110) || first == true) {
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }
                        make_active(c_id);


                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    };

    var msg_load = function(c_id=null , tk=null , limit=10 ,first=false, el=null){
        var first = true; // Declare the 'first' variable here
        if(c_id == null || c_id == ''){
            var c_id = $("#chat-id").val();
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
            }).success(function(resp){
                if(resp.status == 1){

                    $("#msg-body").empty().html(resp.txt);
                    var objDiv = document.getElementById("msg-body");

                    if ((Math.ceil($("#msg-body").scrollTop() + $("#msg-body").innerHeight())) >= (objDiv.scrollHeight - 110) || first == true) {
                        console.log("Auto-scrolling to the bottom of the message list...");
                        objDiv.scrollTop = objDiv.scrollHeight;
                    } else {
                        console.log("Not auto-scrolling to the bottom of the message list...");
                        console.log("scrollTop: " + $("#msg-body").scrollTop());
                        console.log("innerHeight: " + $("#msg-body").innerHeight());
                        console.log("scrollHeight: " + objDiv.scrollHeight);
                    }
                    $("#create-msg-form").find("#msg").prop("disabled" ,false);
                    $("#create-msg-form").find("#msg-send").prop("disabled" ,false);
                    msg_seen(c_id);
                    make_active(c_id);

                }

            }).error(function(jqXHR){

            })

        }
    }



    var msg_seen = function (c_id , el=null) {

        $.ajax({
            url: '/message-seen',
            type: 'POST',
            data: {
                "_token":$('meta[name="csrf-token"]').attr('content'),
                'c_id': c_id
            },

        }).success(function(resp){
            if(resp.status == 1){
                if(el != null){
                    el.removeClass('new-msg');
                    el.find(".new-msg-count").remove()
                }


            }

        }).error(function(jqXHR){

        })


    }

    var  make_active = function (c_id) {
        if(c_id != null && c_id != '' && !$("#msg").attr('disabled')){

            $.ajax({
                url: '/active',
                type: 'POST',
                data: {
                    "_token":$('meta[name="csrf-token"]').attr('content'),
                    'c_id': c_id
                },

            }).success(function(resp){
                if(resp.status == 1){


                }

            }).error(function(jqXHR){

            })
        }

    }

    var set_typing = function(con){
         var c_id = $("#chat-id").attr("id");

         if(c_id != null && c_id != '' && !$("#msg").attr("disabled")){

            $.ajax({
                url: '/set-active',
                type: 'POST',
                data: {
                    "_token":$('meta[name="csrf-token"]').attr('content'),
                    'c_id': c_id,
                    'con':con
                },

            }).success(function(resp){
                if(resp.status == 1){


                }

            }).error(function(jqXHR){

            })

         }

    }















});


