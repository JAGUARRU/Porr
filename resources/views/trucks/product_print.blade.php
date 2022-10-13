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


    </style>
</head>
<body>

<div>
    <div style="text-align: right;">
        <span>ผู้พิมพ์: {{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
    </div>
    <div style="text-align: center;">
        <span style="font-weight: bolder; font-size: 18px;">รายการสินค้าที่บรรทุกไว้</span>
    </div>
    <div style="width: 100%;">
        <span style="display: inline-block;">พิมพ์เมื่อวันที่: {{\Carbon\Carbon::now()->thaidate('j F Y')}}</span>
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

              @if (count($truck->routes()->where('status', '=', 0)->get()) == 0)
              <tr class="text-gray-700 dark:text-gray-400 text-center" id="no-data">
                  <td colspan="4" class="px-4 py-3">
                      ไม่พบข้อมูล...
                  </td>
              </tr>
              @endif

              @foreach($truck->routes()->where('status', '=', 0)->get() as $routes)
                @foreach($routes->order()->get() as $order)

                    @php
                        $products = $order->products()->get()->toArray();
                    @endphp

                    @foreach($products as $key=>$product)

                    <tr class="text-gray-700 dark:text-gray-400" id="{{ $product['product_id'] }}">
                        <td style="{{ ($key == 0 && $key +1 != count($products)) ? ('border-bottom: none !important;') : ('')}}">
                            @php
                            if (!isset($currentOrder) || $currentOrder != $order->id)
                            {
                                echo $order->id;
                            }
                            @endphp
                        </td>

                        <td>
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

            </tbody>

        </table>
    </div>
</div>

</body>
</html>

