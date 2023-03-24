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
});


