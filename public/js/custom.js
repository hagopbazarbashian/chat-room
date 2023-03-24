
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

            }

        });
    });
});
