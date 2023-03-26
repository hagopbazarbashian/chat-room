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

    var msg_load = function(c_id=null , tk=null , limit=10 ,first=false, el=null){
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
            }).done(function(){

            });

        }
    }













});


