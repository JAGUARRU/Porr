

$(document).ready(function() {

    $("input[name=orderItem]").on('input', function(event){

        $.ajax({
            url: '/orders/create',
            method: 'GET',
            data: 'action_method=onchange&prod_id=' + event.target.id + '&v=' + event.target.value,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(response)
            {
                if (!event.target.value || event.target.value == "0")
                    $('table#productOrder tr#' + event.target.id).remove();
            },
            error: function(response) {
                console.log(response);
            }
        });
    });

    function onChangeProduct(event)
    {
        $.ajax({
            url: '/orders/' + $(this).attr('data-orderId') + '/edit',
            method: 'GET',
            data: 'action_method=onchange&prod_id=' + event.target.id + '&v=' + event.target.value,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(res)
            {

                if (res.statusCode == 200)
                {

                    $('table#productOrder > tbody > tr').each(function(index, tr) 
                    { 
                        if (res.data.product_id == tr.id)
                        {
                            $('td', this).each(function(index, td) {
                                if (index == 4) // คอลัมผลรวม
                                {
                                    $(this).html(event.target.value * res.data.price);
                                }
                            });       
                        }
                    });


                    $("#orderItems").removeClass("opacity-0");
                    //$("#orderItems").addClass("opacity-100");
  
                    setTimeout(function() {
                        //$("#orderItems").removeClass("opacity-100");
                        $("#orderItems").addClass("opacity-0");
                    }, 800);
                }

                if (!event.target.value || event.target.value == "0")
                    $('table#productOrder tr#' + event.target.id).remove();
            },
            error: function(response) {
                console.log(response);
            }
        });
    }
    // $('input[name^="editItem"]').on('input', onChangeProduct);

    $(document).on("input", 'input[name^="editItem"]', onChangeProduct);

    $('button[id^="addToOrder"]').click(function(event) {

        let orderId = $(this).attr('data-id');
        $.ajax({
            url: '/orders/' + orderId + '/edit',
            method: 'GET',
            data: 'action_method=add&prod_id=' + $(this).attr('data-productId') + '&prod_name=' + $(this).attr('data-productName')+ '&prod_price=' + $(this).attr('data-productPrice'),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(res)
            {
                if (res.statusCode == 200)
                {

                    let created = false;

                    $("#orderItems").removeClass("opacity-0");

                    setTimeout(function() {
                        $("#orderItems").addClass("opacity-0");
                    }, 800);

                    $('tr#no-data').remove();
    
                    $('table#productOrder > tbody > tr').each(function(index, tr) 
                    { 
                        if (res.data.id == tr.id)
                        {
                            $('td', this).each(function(index, td) {
                                if (index == 4) // คอลัมผลรวม
                                {
                                    $(this).html(res.data.price * res.data.qty);
                                }
                            }); 

                            $(this).find("input").each(function() 
                            {
                                this.value = res.data.qty;
                                created = true;
                            });           
                        }
                    });

                    if (created)
                        return;

                    let newRow = '<tr class="text-gray-700 dark:text-gray-400" id="' + res.data.id + '">';
                    // let newInput = '<input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" type="number" name="editItem" data-orderId="' + $(this).attr('data-id') + '" id="'+ res.data.id +'" value="'+ res.data.qty +'"/>';
                
                    let newInput = $('<input>', {
                        class: 'block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input',
                        type: 'number',
                        id: res.data.id,
                        name: 'editItem',
                        value: res.data.qty
                    });

                    newInput.attr('data-orderId', orderId);
                    
                    newRow += '<td class="px-4 py-3">' + res.data.id + '</td>';
                    newRow += '<td class="px-4 py-3">' + res.data.name + '</td>';
                    newRow += '<td class="px-4 py-3">' + res.data.price + '</td>';
                    newRow += '<td class="px-4 py-3">' + newInput.get(0).outerHTML + '</td>';
                    newRow += '<td class="px-4 py-3">' + res.data.price * res.data.qty + '</td>';

                    let newDeleteBtn = '<div class="flex items-center space-x-4 text-sm"><button id="removeFromOrder" data-id="' + orderId +'" data-productId="'+ res.data.id +'" type="button" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></button></div>';

                    newRow += '<td class="px-4 py-3">' + newDeleteBtn + '</td>';
                    newRow += '</tr>';

                    $('table#productOrder > tbody').append(newRow);
                
        
                }

            },
            error: function(response) {
                console.log(response);
            }
        });

    });


    $(document).on("click", 'button[id^="removeFromOrder"]', function(event) {

        let orderId = $(this).attr('data-id');

        $.ajax({
            url: '/orders/' + orderId + '/edit',
            method: 'GET',
            data: 'action_method=remove&prod_id=' + $(this).attr('data-productId'),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(res)
            {
                if (res.statusCode == 200)
                {
                    if (res.data.result)
                    {
                        $("#orderItems").removeClass("opacity-0");
      
                        setTimeout(function() {
                            $("#orderItems").addClass("opacity-0");
                        }, 800);
    
                        $('table#productOrder tr#' + res.data.id).remove();
                    }
                }

            },
            error: function(response) {
                console.log(response);
            }
        });

    });

    $("#auto-retails").autocomplete(
        {
            source: function(request, response) 
            {
                $.ajax({
                    url: siteUrl + '/' +"orders/create",
                    data: {
                        type : 'retails',
                        term : request.term
                    },
                    dataType: "json",
                    success: function(data){
        
                    var resp = $.map(data,function(obj){
                            return { label: obj.retail_name + " #" + obj.id, value: obj };
                    }); 

                    response(resp);
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {

                /*const retailId = ui.item.label.match(/\(([^)]+)\)/)[1];
                console.log(retailId, ui);*/
                
                $("#retail_id").val(ui.item.value.id);
                
                $("#input_province").val(ui.item.value.retail_province);

                $("#input_amphoe").val(ui.item.value.retail_district);

                if (ui.item.value.retail_district.length > 0)
                {
                    console.log("update related (onchange)");
                }
                
                $("#input_tambon").val(ui.item.value.retail_sub_district);
                $("#input_zipcode").val(ui.item.value.retail_postcode);
                $("#auto-retails").val(ui.item.value.retail_name); 
                
                
                return false;

            }
        },
        
    );

    $("#auto-trucks").autocomplete(
        {
            source: function(request, response) 
            {
                $.ajax({
                    url: siteUrl + '/' +"orders/create",
                    data: {
                        type : 'trucks',
                        term : request.term,
                        orderId : $("input[name=order_id]").val()
                    },
                    dataType: "json",
                    success: function(data)
                    {
        
                    var amphoe = $("#input_amphoe").val();

                    var resp = $.map(data,function(obj)
                    {

                        if (obj.retail_district && obj.retail_district == amphoe && $("input[name=order_id]").val() != obj.order_id)
                        {
                            return { label: (obj.name ? obj.name : ("ไม่พบคนขับ")) + " (" + obj.plateNumber + ")" + " - จัดส่งอยู่ในอำเภอ" + obj.retail_district, value: obj };
                        }
                        return { label: (obj.name ? obj.name : ("ไม่พบคนขับ")) + " (" + obj.plateNumber + ")" + "อำเภอ" + obj.truck_district, value: obj };
                    }); 

                    response(resp);
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {

                /*const retailId = ui.item.label.match(/\(([^)]+)\)/)[1];
                console.log(retailId, ui);*/

                $("input[name=truck_id]").val(ui.item.value.truck_id);
                $("input[name=truck_driver]").val(ui.item.value.name);
                $("#auto-trucks").val(ui.item.value.plateNumber); 

                return false;

            }
        },
        
    );


    $('.cancel-order-button').on('click', function () {
        $('#cancel-order-form').attr('action', $(this).data('target'));
        $('#order-id').html($(this).data('id'));
    });
});