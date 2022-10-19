@foreach ($orderRoute as $route)

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
            font-family: "THSarabunNew"
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
            border:1px solid;

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

    <div style="text-align: center;">
        <span style="font-weight: bolder; font-size: 32px;">ใบส่งของ</span>
    </div>

    <div style="width: 100%; margin-bottom: 12px;">
        <div style="margin-right: 20px; text-align: right;">เลขที่ {{ $route->id }}</div>
    </div>

    <div class="flex-container" style="margin: auto; display:table; margin-bottom: 12px; border-spacing: 10px;">
        
        <div class="flex-item" style="padding: 12px; display: table-cell">
            <div><label>รหัสลูกค้า</label> {{ $route->order->retail_id }}</div> 
            <div><label>ชื่อลูกค้า</label> {{ $route->order->retail_name }}</div> 
            <div><label>ที่อยู่</label> {{ $route->order->retail_address }} ตำบล{{ $route->order->retail_sub_district }} อำเภอ{{ $route->order->retail_district }} จังหวัด{{ $route->order->retail_province }} {{ $route->order->retail_postcode }}</div> 
        </div>
        
        <div class="flex-item"  style=" padding: 12px; display:table-cell">
            <div><label>วันที่</label> {{ \Carbon\Carbon::now()->thaidate('j F Y') }}</div> 
            <div><label>เลขที่ใบกับกำ</label> {{ $route->order->id }}</div> 
            <div><label>พนักงานส่งของ</label> {{ $route->truck_route->truck_driver }}</div> 
        </div>                    
    </div> 

    <div style="width: 100%; overflow-x: auto; margin-bottom: 12px;">
        <table style="width: 100%; white-space: nowrap;">
            <thead>
                <tr style="font-weight: bold; text-align: center; line-height: .75rem;">
                    <th>รหัสสินค้า<div style="font-weight: normal;">ITEM CODE</div></th>
                    <th>รายละเอียด<div style="font-weight: normal;">DESCRIPTION</div></th>
                    <th>จำนวน<div style="font-weight: normal;">QUANTITY</div></th>
                    <th>หน่วยละ<div style="font-weight: normal;">UNIT</div></th>
                    <th>จำนวนเงิน<div style="font-weight: normal;">AMOUNT</div></th>
                </tr>
            </thead>

            <tbody style="text-align: center;">

                @php
                    $sumTotal = 0;
                @endphp

                @foreach($route->order->products as $product)
                <tr>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->qty }}</td>
                    <td style="text-align: right;">{{ number_format((float)$product->price, 2, '.', '') }}</td>
                    <td style="text-align: right;">{{ number_format((float)$product->total, 2, '.', '') }}</td>
                </tr>
                @php
                    $sumTotal += $product->total;
                @endphp
                @endforeach

                <tr style="text-align: right;">
                    <td colspan="3" style="border: none; border-right: 1px solid;">

                    </td>
                    <td>
                      รวมทั้งสิ้น
                    </td>
                    <td>
                      @if(isset($sumTotal))
                      {{ number_format((float)$sumTotal, 2, '.', '') }}
                      @endif
                    </td>
                </tr>

            </tbody>

        </table>

        <div>
            <div>
                <label>ชำระโดย</label>
                <div>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="">เงินสด
                    </label>
                </div>
                
                <div>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="">โอนผ่าน e-Banking
                    </label>
                </div>
            </div>

        </div>
        <div class="flex-container" style="margin: auto; display:table; margin-bottom: 12px; margin-top: 12px;">
        
            <div class="flex-item" style="padding: 12px; display: table-cell">
                <div style="text-align: center; line-height: .75rem;"><label>ผู้รับของ</label><div>ได้รับสินค้าตามรายการถูกต้องแล้ว</div></div>
                <br> 
                <div style="text-align: center;"><label>ลงชื่อ</label> ............................................</div>
                <div style="text-align: center;"><label>วันที่</label> .....................................................</div> 
            </div>
            
            <div class="flex-item"  style=" padding: 12px; display:table-cell">
                <div style="text-align: center;"><label>ผู้ส่งของ</label></div>
                <br>
                <div style="text-align: center;"><label>ลงชื่อ</label> ............................................</div>
                <div style="text-align: center;"><label>วันที่</label> .....................................................</div> 
            </div>  
            
            <div class="flex-item"  style=" padding: 12px; display:table-cell">
                <div style="text-align: center;"><label>ผู้รับเงิน</label></div>
                <br> 
                <div style="text-align: center;"><label>ลงชื่อ</label> ............................................</div>
                <div style="text-align: center;"><label>วันที่</label> .....................................................</div> 
            </div>  

        </div> 

    </div>

</body>
</html>

@endforeach