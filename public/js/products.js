$(document).ready(function(){

    var productCategory = '#productCategory';
    var form = '#add-category-form';

    $(form).on('submit', function(event)
    {
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

                $(productCategory).val(response.name).change();

                let newRow = '<tr class="text-gray-700 dark:text-gray-400" id="' + element.id + '">';
                let newInput = $('<input>', {
                    class: 'block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input',
                    id: element.id,
                    name: 'editItem',
                    value: element.name
                });
                let updateBtn = '<div class="flex items-center space-x-4 text-sm"><button id="updateCategory" data-categoryId="'+ element.id +'" type="button" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">อัปเดตข้อมูล</button></div>';
                newRow += '<td class="px-4 py-3 text-sm">' + newInput.get(0).outerHTML + '</td>';
                newRow += '<td class="px-4 py-3">' + updateBtn + '</td>';
                newRow += '</tr>';
                $('table#category > tbody').append(newRow);

                $(form).trigger("reset");
            },
            error: function(response) {
            }
        });
    });

    var wto;
    $(document).on("input", 'input[name^="search-category"]', function(e) {
        clearTimeout(wto);
        wto = setTimeout(function() 
        {
          $.ajax({
            url: '/categories',
            method: 'GET',
            data: 'term=' + e.target.value,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(res)
            {
                $("table#category > tbody").html("");

                if (res.statusCode == 200 && res.data.length)
                {
                    res.data.forEach(element => {

                        let newRow = '<tr class="text-gray-700 dark:text-gray-400" id="' + element.id + '">';
          
                        let newInput = $('<input>', {
                            class: 'block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input',
                            id: element.id,
                            name: 'editItem',
                            value: element.name
                        });
    
                        let updateBtn = '<div class="flex items-center space-x-4 text-sm"><button id="updateCategory" data-categoryId="'+ element.id +'" type="button" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">อัปเดตข้อมูล</button></div>';
    
                        newRow += '<td class="px-4 py-3 text-sm">' + newInput.get(0).outerHTML + '</td>';
                        newRow += '<td class="px-4 py-3">' + updateBtn + '</td>';
                        newRow += '</tr>';
    
                        $('table#category > tbody').append(newRow);
                    });
                }
            },
            error: function(response) {
                console.log(response);
            }
        });

        }, 300);
    });


    /*function onChangeProductCategory(event)
    {
        console.log(event);
    }

    $(document).on("input", 'input[name^="editItem"]', onChangeProductCategory);*/


    $(document).on("click", 'button[id^="updateCategory"]', function(event) {

        $.ajax({
            url: siteUrl + '/categories/' + $(this).attr('data-categoryId'),
            method: 'GET',

            data: 'id=' + $(this).attr('data-categoryId') + '&value=' + $('input#' + $(this).attr('data-categoryId')).val() + '&search=' + $('input#search-category').val(),

            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(res)
            {
                $("table#category > tbody").html("");

                let searchText = $('select#productCategory').find(":selected").text();
                $("select#productCategory").html("");

                if (res.statusCode == 200)
                {
                    if (res.change.length)
                    {
                        res.change.forEach(element => {
                            let newRow = '<tr class="text-gray-700 dark:text-gray-400" id="' + element.id + '">';
              
                            let newInput = $('<input>', {
                                class: 'block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input',
                                id: element.id,
                                name: 'editItem',
                                value: element.name
                            });
        
                            let updateBtn = '<div class="flex items-center space-x-4 text-sm"><button id="updateCategory" data-categoryId="'+ element.id +'" type="button" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">อัปเดตข้อมูล</button></div>';
        
                            newRow += '<td class="px-4 py-3 text-sm">' + newInput.get(0).outerHTML + '</td>';
                            newRow += '<td class="px-4 py-3">' + updateBtn + '</td>';
                            newRow += '</tr>';
        
                            $('table#category > tbody').append(newRow);
                        });
                    }
                    if (res.current_data.length)
                    {
                        let newRow = "<option value=''>- เลือก -</option>";

                        res.current_data.forEach(element => {
                            newRow += '<option value="' + element.name + '" '+ (searchText == element.name ? ("selected") : ("")) +'>' + element.name + '</option>';
                        });

                        $("select#productCategory").append(newRow);
                    }

                    $("#updateItems").removeClass("opacity-0");

                    setTimeout(function() {
                        $("#updateItems").addClass("opacity-0");
                    }, 800);
                }
            },
            error: function(response) {
                console.log(response);
            }
        });

    });

});