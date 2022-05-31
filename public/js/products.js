$(document).ready(function(){

    var productCategory = '#productCategory';
    var form = '#add-category-form';

    $(form).on('submit', function(event){
        event.preventDefault();

        var url = $(this).attr('data-action');

        $.ajax({
            url: url,
            method: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(response)
            {
                $(productCategory).append($('<option>', { 
                    value: response.name,
                    text : response.name 
                }));

                $(form).trigger("reset");
            },
            error: function(response) {
            }
        });
    });

});