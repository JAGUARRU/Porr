$(document).ready(function() {

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.widget( "custom.catcomplete", $.ui.autocomplete, {
    _create: function() {
      this._super();
      this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
    },
    _renderMenu: function( ul, items ) {
      var that = this,
        currentCategory = "";
      $.each( items, function( index, item ) {
        var li;
        if ( item.category != currentCategory ) {
          ul.append( "<li class='ui-autocomplete-category font-bold p-2 mt-4 mb-2 leading-4'>" + item.category + "</li>" );
          currentCategory = item.category;
        }
        li = that._renderItemData( ul, item );
        if ( item.category ) {
          li.attr( "aria-label", item.category + " : " + item.label );
        }
      });
    }
  });

    $("#auto-search").catcomplete(
        {
            source: function(request, response) 
            {
                $.ajax({
                    url: siteUrl + "/api/search",
                    data: {
                        term : request.term
                    },
                    dataType: "json",
                    success: function(data)
                    {

                      var resp = $.map(data, function(obj){
                        return { label: obj.title, value: obj.url, category: obj.category };
                      }); 

                      response(resp);
                      /*
                        response([
                            { label: 'EMP-001', value: 'test', category: "พนักงาน" }, 
                            { label: 'EMP-002', value: 'test', category: "พนักงาน" },
                            { label: 'PROD-00001', value: 'test', category: "สินค้า" }, 
                            { label: 'RETAIL-001', value: 'test', category: "ร้านค้า" },
                            { label: 'T-0003', value: 'test', category: "รถยนต์" }, 
                            { label: 'ORDER-0002', value: 'test', category: "ออเดอร์" }
                        ]);*/
                    }
                });
            },
            minLength: 1,
            select: function( event, ui ) 
            {
                event.preventDefault();

                var url = ui.item.value;
                if (url != '') 
                {
                  location.href = siteUrl + '/' + url;
                }
            }
        },
        
    );

   /* (function() {

        var availableTags = [
            "employee"];

        var originalCloseMethod = $input.data("ui-autocomplete").close;
         $input.data("ui-autocomplete").close = function(event) {
             if (!selected){
                 //close requested by someone else, let it pass
                 originalCloseMethod.apply( this, arguments );
             }
             selected = false;
         };
     })();*/

});