// $(document).ready(function() {
//   // Enable the "Create" button when at least one option is selected
//   $('#create-data').on('changed.bs.select', function() {
//       var selectedOptions = $('#create-data').val();
//       $('#create').prop('disabled', !selectedOptions || !selectedOptions.length);
//   });

//    // Show loading animation
//    var $loading = $('<div class="loading-spinner"></div>');
//    $(this).after($loading);

//   // Send selected options to the server when the "Create" button is clicked
//   $('#create').click(function() {
//       var selectedOptions = $('#create-data').val();
//       if (selectedOptions && selectedOptions.length > 0) {
//           $.ajax({
//               url: '/create',
//               method: 'POST',
//               data: {
//                 users: selectedOptions 
//               }, 
//               success: function(response) {
//                  alert('ok')
//               },
//               error: function(xhr, status, error) {
//                   // Handle error response
//               }
//           });
//       }
//   });
// });



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
            url: 'create',
            type: 'POST',
            data: { users: selectedOptions },
            success: function(response) {
                // Hide the loading spinner
                $('#loading-spinner').hide();

                // Handle the response
                alert(response);
            },
            error: function(xhr) {
                // Hide the loading spinner
                $('#loading-spinner').hide();

                // Handle the error
                alert(xhr.responseText);
            }
        });
    });
});