$(document).ready(function() {

    $("#auto-drivers").click(function () {
        $("#auto-drivers").autocomplete('search', '');
    });

    $("#auto-drivers").on("input", function(event) {
        $("#validDriver").html('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>');
        $("input[name=user_id]").val("");
        $("input[name=emp_id]").val("");
    
    });

    $("#auto-drivers").autocomplete(
        {
            source: function(request, response) 
            {
                $.ajax({
                    url: siteUrl + "/api/drivers",
                    data: {
                        term : request.term
                    },
                    dataType: "json",
                    success: function(data)
                    {
                        var resp = $.map(data,function(obj){
                            return { label: "รหัสพนักงาน: " + obj.empId + " ชื่อ: " + obj.name, value: obj };
                        }); 

                        response(resp);
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) 
            {
 
                $("input[name=user_id]").val(ui.item.value.id);
                $("input[name=emp_id]").val(ui.item.value.empId);
                $("#auto-drivers").val(ui.item.value.name);

                $("#validDriver").html('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>');

                return false;
            }
        },
        
    );

});