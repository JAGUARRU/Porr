

@php
$itemPerPage = 15;

$currentPage = 1;


$reportCount = count($reports);
$reports->sumQty = 0;
$reports->sumAmount = 0;

new_page:

@endphp

@php
$count = 0;
$itemCount = $reportCount;
$numPage = ceil($itemCount / $itemPerPage);
$skippedIndex = ($currentPage - 1) * $itemPerPage;
$skippedItem = $skippedIndex;

@endphp

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
            font-size: 20px;
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

            font-size: 24px;
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
    <span style="display: inline-block; float: right;">หน้า {{ $currentPage }}/{{ $numPage }}</span>
    <div style="text-align: left;">
        <!--<span>ผู้พิมพ์: {{ \Illuminate\Support\Facades\Auth::user()->name }}</span>-->
        <div><span>ร้าน ป้อฮ์ไอติมกะทิสด</span></div>
        <div><span>162 หมู่ 13 ตำบลหนองกะท้าว อำเภอนครไทย จังหวัดพิษณุโลก 65120</span></div>
        <div><span>โทร: 093-873-3956</span></div>
    </div>
    <div style="text-align: center;">
        <!--<div style="font-weight: bolder; font-size: 28px;">ป้อฮ์ไอติมกะทิสด</div>-->
        <div><span style="font-weight: bolder; font-size: 28px;">รายงานสรุปยอดขาย</span></div>
        <div>
            @if (isset($input['startDate']) && isset($input['endDate'])
            && \Carbon\Carbon::createFromFormat('Y-m-d', $input['startDate']) !== false
            && \Carbon\Carbon::createFromFormat('Y-m-d', $input['endDate']) !== false)
               
            @else
            <!--<span style="font-weight: bold; font-size: 24px;">
                //รายงานปี {{\Carbon\Carbon::parse($input['year'])->thaidate('Y')}}
                {{\Carbon\Carbon::now()->startOfYear()->thaidate('j F Y')}} ถึง {{\Carbon\Carbon::now()->thaidate('j F Y')}}
            </span>-->
            @endif
        </div>
    </div>
    <div style="width: 100%; text-align: right;">
        <div><span>ผู้พิมพ์:  {{ \Illuminate\Support\Facades\Auth::user()->name }} </span></div>
        <span style="display: inline-block;">วันที่พิมพ์: {{\Carbon\Carbon::now()->thaidate('j F Y')}} </span>

        <!--<span style="display: inline-block; float: right;">1/1</span>-->
    </div>

    <div style="width: 100%; overflow-x: auto; margin-top: 12px;">
        <table style="width: 100%; white-space: nowrap;">
            <thead>
                <tr style="font-weight: bold; text-align: center;">
                    <th class="px-4 py-3">รหัสสินค้า</th>
                    <th class="px-4 py-3">ชื่อสินค้า</th>
                    <th class="px-4 py-3">ประเภทสินค้า</th>
                    <th class="px-4 py-3 text-right">จำนวน</th>
                    <th class="px-4 py-3 text-right">รวมเงิน (บาท)</th>
                </tr>
            </thead>

            <tbody style="text-align: center;">

            @if (count($reports) == 0)
              <tr class="text-gray-700 dark:text-gray-400 text-center" id="no-data">
                  <td colspan="5" class="px-4 py-3">
                      ไม่พบข้อมูล...
                  </td>
              </tr>
            @endif

            @foreach ($reports as $report)

              @php
                if ($count >= $itemPerPage)
                    break;

                if ($skippedItem-- > 0)
                    continue;
            @endphp
            
              <tr class="text-gray-700 dark:text-gray-400">
                <td>
                    {{ $report->id }}
                  </td>
                  <td>
                    {{ $report->prod_name }}
                  </td>
                  <td>
                    {{ $report->prod_type_name }}
                  </td>
                  <td style="text-align: right;">
                    {{ number_format((float)$report->salQty, 2, '.', '') }}

                    @php
                        $reports->sumQty += $report->salQty;
                    @endphp
                  </td>
                  <td style="text-align: right;">
                    {{ number_format((float)$report->salAmount, 2, '.', '') }}

                    @php
                        $reports->sumAmount += $report->salAmount;

                        $count++;
                    @endphp
                  </td>
              </tr>
            
              @endforeach

              @if ($numPage == $currentPage)
              <tr >
                  <td  style="text-align: center;" colspan="3">
                    รวมทั้งสิ้น
                  </td>
                  <td style="text-align: right;">
                    {{ number_format((float)$reports->sumQty, 2, '.', '') }}
                  </td>
                  <td style="text-align: right;">
                    {{ number_format((float)$reports->sumAmount, 2, '.', '') }}
                  </td>
              </tr>
              @endif

            </tbody>

        </table>
    </div>
</div>

</body>
</html>


@php
    if ($currentPage++ < $numPage)
    {
        goto new_page;
    }
@endphp