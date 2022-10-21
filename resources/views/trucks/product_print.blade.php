<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style type="text/css">      
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ storage_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ storage_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ storage_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ storage_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            font-size: 18px;
        }

        table {
            width: 100%;
            text-align: center;
            border-collapse: separate; /* Don't collapse */
            border-spacing: 0;
        }

        table th {
            /* Apply both top and bottom borders to the <th> */
            border-top: 1px solid;
            border-bottom: 1px solid;
            border-right: 1px solid;
        }

        table td {
            /* For cells, apply the border to one of each side only (right but not left, bottom but not top) */
            border-bottom: 1px solid;
            border-right: 1px solid;

            font-size: 18px;
            padding-top: 0;
            padding-left: 5px;
            padding-right: 5px;
        }

        table th:first-child,
        table td:first-child {
            /* Apply a left border on the first <td> or <th> in a row */
            border-left: 1px solid;
        }

        table thead th {
            position: sticky;
            top: 0;
            background-color: #edecec;
        }


        .flex-container {
            display: flex;
            width: 100%;
            margin-top: 12px;
            margin-bottom: 12px;
        }

        .flex-item {
            width: 100%;

        }

        div label {
            font-weight: bold;
        }

        .checkbox-inline {
            display: block; 
            padding-left: 15px;
        }

        .checkbox-inline input {
            width: 13px;
            height: 13px;
            padding: 0;
            margin-right:8px;
            vertical-align: middle;
            position: relative;
            top: 1px;
            *overflow: hidden;
        }

    </style>
</head>
<body>

<div>
    <div style="text-align: right;">
        <span>ผู้พิมพ์: {{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
    </div>
    <div style="text-align: center;">
        <div style="font-weight: bolder; font-size: 28px;">ป้อฮ์ไอติมกะทิสด</div>
        <div><span style="font-weight: bolder; font-size: 24px;">รายการสินค้าที่บรรทุกไว้</span></div>
    </div>

    <div class="flex-container" style="margin: auto; display:table; margin-bottom: 12px; border-spacing: 10px;">
        
        <div class="flex-item" style="padding: 12px; display: table-cell">
            <div><label>รหัสรถ</label> {{ $truck->id }}</div> 
        </div>         
        <div class="flex-item" style="padding: 12px; display: table-cell">
            <div><label>ป้ายทะเบียน</label> {{ $truck->plateNumber }}</div> 
        </div>   
        <div class="flex-item" style="padding: 12px; display: table-cell">
            <div><label>คนขับ</label> {{ $truck->user ? $truck->user->name : '-' }}</div> 
        </div>           
    </div> 

    <div style="width: 100%;">
        <span style="display: inline-block;">พิมพ์วันที่: {{\Carbon\Carbon::now()->thaidate('j F Y')}} เวลา {{\Carbon\Carbon::now()->thaidate('H:i')}}</span>

        <span style="display: inline-block; float: right;"></span>
    </div>
    <div style="width: 100%; overflow-x: auto; margin-top: 12px;">
        <table style="width: 100%; white-space: nowrap;">
            <thead>
                <tr style="font-weight: bold; text-align: center;">
                    <th>รหัสออเดอร์</th>
                    <th>รายการสินค้า</th>
                    <th>จำนวน</th>
                    <th>หมายเหตุ</th>
                </tr>
            </thead>

            <tbody style="text-align: center;">

            @php
                $count = 0;
            @endphp

              @foreach($truck->routes()->where('route_status', '!=', 2)->get() as $routes)
                @foreach($routes->lists()->get() as $route)

                    @php
                        if($route->route_list_status != Helper::GetRouteListStatus(0))
                            continue;
                    @endphp
                
                  @foreach($route->order()->get() as $order)
                      @foreach($order->products()->get()->toArray() as $key=>$product)

                            <tr class="text-gray-700 dark:text-gray-400" id="{{ $product['product_id'] }}">
                                <td style="{{ ($key == 0 && $key +1 != count($order->products()->get()->toArray())) ? ('border-bottom: none !important;') : ('')}}">
                                    @php
                                    if (!isset($currentOrder) || $currentOrder != $order->id)
                                    {
                                        echo $order->id;
                                    }
                                    @endphp
                                </td>

                                <td style="text-align: left; max-width: 24rem; white-space: nowrap; text-overflow:ellipsis; overflow: hidden;">
                                    {{ $product['product_id'] }}: {{ $product['product_name'] }}
                                </td>

                                <td style="text-align: right;">
                                    {{ $product['qty'] }}
                                </td>

                                <td style="min-width: 32px;">

                                </td>

                            </tr>
            

                        @php
                            $currentOrder = $order->id;
                        @endphp

                        @endforeach
                    @endforeach
                @endforeach
            @endforeach

            @if ($count == 0)
            <tr class="text-gray-700 dark:text-gray-400 text-center" id="no-data">
                <td colspan="4" class="px-4 py-3">
                    ไม่พบข้อมูล...
                </td>
            </tr>
            @endif

            </tbody>

        </table>
    </div>
</div>

</body>
</html>

