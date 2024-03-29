
let productOrderArray = [];
let historyProductArray = [];
let loadProductArray = [];

function calcProductLoad()
{
    $('table#loadProduct > tbody').html("");

    if (loadProductArray.length == 0)
    {
        $('table#loadProduct > tbody').append('<tr class="text-gray-700 dark:text-gray-400"><td colspan="6" class="px-4 py-3">ยังไม่มีข้อมูลรายการสินค้า...</td></tr>');
        return;
    }

    loadProductArray.forEach(v => {

        let amountLoad = historyProductArray.find(load => load.id == v.id) ?? { amount: 0 };
        let amountOrder = productOrderArray.find(load => load.id == v.id);

        {
            let max = amountOrder.amount - amountLoad.amount;

            if (v.amount == 0)
            {
                loadProductArray = loadProductArray.filter(item => item != v);
                return;
            }

            let newRow = '<tr class="text-gray-700 dark:text-gray-400" id="' + v.id + '">';

            newRow += '<td class="px-4 py-3">' + v.id + '<input type="hidden" class="hidden" name="productId[]" id="productId" value="' + v.id + '" /></td>';

            let newInput = $('<input>', 
            {
                class: 'block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input',
                type: 'number',
                id: v.id,
                name: 'productLists[]',
                value: v.amount > max ? max : v.amount,
                min: 0,
                max: max
            });
        
            newRow += '<td class="px-4 py-3">' + newInput.get(0).outerHTML + '</td>';

            newRow += '</tr>';

            $('table#loadProduct > tbody').append(newRow);
        }
    });
}

function calcRemainingProduct()
{
    productOrderArray = [];
    $('table#productOrder > tbody > tr').each(function(rIndex, tr) 
    {
        let id = $(this).find(`td:eq(${1})`).html();
        let amount = parseInt($(this).find(`td:eq(${3})`).html());

        productOrderArray.push({ id, amount, rowIndex: rIndex });
    });

    historyProductArray = [];
    $('table#routeProduct > tbody > tr').each(function(rIndex, tr) 
    {
        let id = $(this).find(`td:eq(${5})`).html();
        let amountText = $(this).find(`td:eq(${7})`).html();

        let amount = 0;

        if (amountText && amountText.length > 0)
        {
            let [ positiveAmount, negativeAmount ] = amountText.split(' ');

            if (negativeAmount)
            {
                let bracket = negativeAmount.match(/\((.*?)\)/);
                if (bracket.length)
                {
                    negativeAmount = bracket[1];
                }
                else
                {
                    negativeAmount = "0";
                }
    
                negativeAmount = parseInt(negativeAmount);
            }

            amount = parseInt(positiveAmount);

            if (negativeAmount)
            {
                amount += negativeAmount;
            }

        }

        let existHistory = historyProductArray.find(item => item.id == id);
        console.log({ id, amount, rowIndex: rIndex }, id);
        if (!existHistory)
        {
            historyProductArray.push({ id, amount, rowIndex: rIndex });
        }
        else
        {
            existHistory.amount += amount;
        }
    });

    // bind value
    productOrderArray.forEach(v => {

        let amountLoad = historyProductArray.find(load => load.id == v.id) ?? { amount: 0 };
        let amountAdd = loadProductArray.find(load => load.id == v.id) ?? { amount: 0 };

        let row = $(`table#productOrder > tbody > tr:eq(${v.rowIndex})`);

        if (amountLoad.amount > 0 || amountAdd.amount > 0)
        {
            let decressed = amountLoad.amount + amountAdd.amount;
            let needMore = v.amount - decressed;

            if (needMore > 0)
            {
                $(row).find(`td:eq(3)`).html(`${v.amount} <span class="text-red-400">(-${decressed})</span>`);
                $(row).find(`td:eq(4)`).html(`${v.amount - decressed}`);
                $(row).find(`td:eq(0)`).html('<button type="button" name="loadProductOrder" id="loadProductOrder" data-id="' + v.id + '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" aria-label="Like"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg></button>');
            }
            else
            {
                $(row).find(`td:eq(3)`).html(`${v.amount} (-${decressed})`);
                $(row).find(`td:eq(4)`).html(v.amount - decressed);
                $(row).find(`td:eq(0)`).html("");
            }
        }
        else
        {
            $(row).find(`td:eq(${4})`).html(v.amount);
        }
    });
}

function updateTruckRouteDetails(orderId, truckId)
{
    //console.log(orderId, truckId);

    $.ajax({
        url: siteUrl + "/api/trucks/route",
        data: {
            orderId,
            truckId
        },
        dataType: "json",
        success: function(response)
        {

            $('table#routeTable > tbody').html("");

            response.forEach(element => {

                /*if (element.transportDate && element.transportDate.length)
                {
                    element.transportDate = element.transportDate.split(' ')[0] + " 23:59:59";
                }*/

                let transportDate = moment(element.transportDate, 'YYYY-MM-DD HH:mm:ss').endOf('day');

                let statusText;

                if(element.transportDate)
                {
                    statusText = element.route_status + ' กำหนดส่ง (' + transportDate.from(moment().endOf('day')) + ')';
                }
                else
                {
                    statusText = element.routes_count == 0 ? element.truck_status : element.route_status;
                }
  
                $('table#routeTable > tbody').append(`
                    <tr class="text-gray-700 dark:text-gray-400">               
                        <td class="px-4 py-3">
                            <input type="radio" class="w-4 h-4 form-radio text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="route_id" value="${ element.route_id }" />
                        </td>
                        <td class="px-4 py-3">
                        ${element.truck_district}
                        </td>
                        <td class="px-4 py-3">
                        ${element.transportDate ? transportDate.format('Do MMMM') + ' ' + (parseInt(transportDate.format('YYYY')) + 543)  : '-' }
                        </td>
                        <td class="px-4 py-3">
                        ${statusText}
                        </td>
                        <td class="px-4 py-3">
                            <div>${(element.checkMatches.transportDiff != 0 ? ('ออเดอร์จะถูกเปลี่ยนกำหนดส่งเป็นวันที่ ' + transportDate.format('Do MMMM') + ' ' + (parseInt(transportDate.format('YYYY')) + 543))  : '' )}</div>
                            <div>${(element.checkMatches.district == 0 ? 'พื้นที่จัดส่งประจำของรถไม่ตรงกับที่อยู่ของร้านค้า' : '')}</div>
                        </td>
                    </td>`);

            });
           
        },
        error: function(response) {
            console.log(response);
        }
    });
}

$(document).ready(function() {

    $(document).on("click", 'button[id^="selectDriver"]', function(event) 
    {
        let data = JSON.parse($(this).attr('data-id'));
        let driver = JSON.parse($(this).attr('data-driver'));

        $("input[name=truck_id]").val(data.id);
        $("input[name=truck_driver]").val(driver.name ? (driver.name) : ('ไม่ระบุ'));
        $("#auto-trucks").val(data.plateNumber); 

        updateTruckRouteDetails($("#order_id").val(), data.id);
    });

    $(document).on("click", 'button[id^="loadProductOrder"]', function(event) 
    {
        let id = $(this).attr('data-id');
        let amountOrder = productOrderArray.find(item => item.id == id);
        if (!amountOrder)
            return;
            
        let loadProduct = loadProductArray.find(item => item.id == id);
        let amountLoad = historyProductArray.find(item => item.id == id) ?? { amount: 0 };

        if (loadProduct)
        {
            loadProduct.amount++;
        }
        else
        {
            loadProductArray.push({ id, amount: amountOrder.amount - amountLoad.amount });
        }

        calcProductLoad();
        calcRemainingProduct();
    });

    $(document).on("input", 'input[name^="productLists"]', function(e) 
    {
        let id = e.target.id;
        let loadProduct = loadProductArray.find(item => item.id == id);

        if (e.target.value == 0)
        {
            loadProductArray = loadProductArray.filter(item => item != loadProduct);
            $('table#loadProduct tr#' + id).remove();
        }
        else
        {

            let amountLoad = historyProductArray.find(load => load.id == loadProduct.id) ?? { amount: 0 };
            let amountOrder = productOrderArray.find(load => load.id == loadProduct.id);
    
            let max = amountOrder.amount - amountLoad.amount;

            if (loadProduct)
            {
                let amount = parseInt(e.target.value);
                loadProduct.amount = amount > max ? max : amount;

                $(`#${e.target.id}[name^="productLists"]`).val(loadProduct.amount);
            }
        }


        if (loadProductArray.length == 0)
        {
            $('table#loadProduct > tbody').append('<tr class="text-gray-700 dark:text-gray-400"><td colspan="6" class="px-4 py-3">ยังไม่มีข้อมูลรายการสินค้า...</td></tr>');
        }

        calcRemainingProduct();

    });

    calcRemainingProduct();
    calcProductLoad();

    $("#auto-trucks").click(function () {
        $("#auto-trucks").autocomplete('search', $("#input_amphoe").val());
    });

    $("#auto-trucks").autocomplete(
        {
            source: function(request, response) 
            {
                $.ajax({
                    url: siteUrl + "/api/trucks/load",
                    data: {
                        term : request.term,
                        district: $("#input_amphoe").val()
                    },
                    dataType: "json",
                    success: function(data)
                    {
    
                        var amphoe = $("#input_amphoe").val();

                        var resp = $.map(data,function(obj)
                        {
                            if (obj.retail_district && obj.retail_district == amphoe)
                            {
                                return { label: (obj.name ? obj.name : ("ไม่พบชื่อคนขับ")) + " (" + obj.plateNumber + ")" + " - จัดส่งอยู่ในอำเภอ" + obj.retail_district, value: obj };
                            }
                            return { label: (obj.name ? obj.name : ("ไม่พบชื่อคนขับ")) + " (" + obj.plateNumber + ")" + " อำเภอ" + obj.truck_district, value: obj };
                        }); 
    
                        response(resp);
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {

                $("input[name=truck_id]").val(ui.item.value.truck_id);
                $("input[name=truck_driver]").val(ui.item.value.name ? (ui.item.value.name) : ('ไม่ระบุ'));
                $("#auto-trucks").val(ui.item.value.plateNumber);

                updateTruckRouteDetails($("#order_id").val(), ui.item.value.truck_id);
                
                return false;

            }
        },
        
    );

});