
@php
$itemPerPage = 15;

$dataArray = array();

$start = array();
$end = array();

foreach ($reports as $report)
{
    $exists = false;
    foreach ($dataArray as $key=>$value)
    {
        if ($value["id"] == $report->id)
        {
            $exists = true;
        }
    }

    if (!$exists)
    {
        array_push($dataArray, array("id"=>$report->id, "prod_name"=>$report->prod_name, "prod_type_name"=>$report->prod_type_name, "sumQty" => 0, "sumAmount" => 0));
    }
}

@endphp


@php
$currentPage = 1;
new_page:

@endphp

@php
$count = 0;
$itemCount = count($dataArray);
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
    <span style="display: inline-block; float: right;">หน้า {{ $currentPage }}/{{ $numPage ? $numPage : 1 }}</span>
    <div style="text-align: left;">
        <div><span>ร้าน ป้อฮ์ไอติมกะทิสด</span></div>
        <div><span>162 หมู่ 13 ตำบลหนองกะท้าว อำเภอนครไทย จังหวัดพิษณุโลก 65120</span></div>
        <div><span>โทร: 093-873-3956</span></div>        
    </div>
    <div style="text-align: center;">
        <div><span style="font-weight: bolder; font-size: 28px;">รายงานสรุปเปรียบเทียบยอดการขาย</span></div>
        <div>
            <span style="font-weight: bold; font-size: 24px;">
                @if (isset($input['startDate']) && isset($input['endDate'])
                && \Carbon\Carbon::createFromFormat('Y-m', $input['startDate']) !== false
                && \Carbon\Carbon::createFromFormat('Y-m', $input['endDate']) !== false)
                  ระหว่างเดือน {{\Carbon\Carbon::now()->startOfYear()->thaidate('F Y')}} และเดือน {{\Carbon\Carbon::now()->thaidate('F Y')}}
                @endif
            </span>
        </div>
    </div>
    <div style="width: 100%; text-align: right;">
        <div><span>ผู้พิมพ์:  {{ \Illuminate\Support\Facades\Auth::user()->name }} </span></div>
        <span style="display: inline-block;">วันที่พิมพ์: {{\Carbon\Carbon::now()->thaidate('j F Y')}} </span>
    </div>

    <div style="width: 100%; overflow-x: auto; margin-top: 12px;">
        <table style="width: 100%; white-space: nowrap;">
            <thead>

                <tr class="font-weight: bold; text-align: center;">
                    <th colspan="5"></th>
                    <th colspan="2" scope="colgroup">เพิ่มขึ้น / ลดลง</th>
                </tr>

                <tr
                    class="font-weight: bold; text-align: center;">
                    <th style="padding-left: 1rem; padding-right: 1rem; padding-top: 0.75rem; padding-bottom: 0.75rem;">รหัสสินค้า</th>
                    <th style="padding-left: 1rem; padding-right: 1rem; padding-top: 0.75rem; padding-bottom: 0.75rem;">ชื่อสินค้า</th>
                    <th style="padding-left: 1rem; padding-right: 1rem; padding-top: 0.75rem; padding-bottom: 0.75rem;">ประเภทสินค้า</th>
                    <th style="padding-left: 1rem; padding-right: 1rem; padding-top: 0.75rem; padding-bottom: 0.75rem;">{{ \Carbon\Carbon::createFromFormat('Y-m', $input['startDate'] )->thaidate('F') }}({{ \Carbon\Carbon::createFromFormat('Y-m', $input['startDate'] )->thaidate('Y') }})</th>
                    <th style="padding-left: 1rem; padding-right: 1rem; padding-top: 0.75rem; padding-bottom: 0.75rem;">{{ \Carbon\Carbon::createFromFormat('Y-m', $input['endDate'] )->thaidate('F') }}({{ \Carbon\Carbon::createFromFormat('Y-m', $input['endDate'] )->thaidate('Y') }})</th>
                    <th style="padding-left: 1rem; padding-right: 1rem; padding-top: 0.75rem; padding-bottom: 0.75rem; text-align: left;">จำนวนเงิน</th>
                    <th style="padding-left: 1rem; padding-right: 1rem; padding-top: 0.75rem; padding-bottom: 0.75rem; text-align: right;">%</th>
                </tr>
            </thead>

            <tbody style="text-align: center;">

              @if (count($reports) == 0)
              <tr class="text-gray-700 dark:text-gray-400 text-center" id="no-data">
                  <td colspan="7" class="px-4 py-3">
                      ไม่พบข้อมูล...
                  </td>
              </tr>
              @else

              @php

                foreach ($dataArray as $data)
                {
                    $startSalAmount = 0;
                    $endSalAmount = 0;
                    $startSalQty = 0;
                    $endSalQty = 0;

                    foreach ($reports as $report)
                    {
                        if ($report->id == $data["id"])
                        {
                            if($report->year == intval(\Carbon\Carbon::createFromFormat('Y-m', $input['startDate'] )->format('Y')) && $report->month == intval(\Carbon\Carbon::createFromFormat('Y-m', $input['startDate'] )->format('m')))
                            {
                                $startSalAmount = $report->salAmount;
                            }
                            if($report->year == intval(\Carbon\Carbon::createFromFormat('Y-m', $input['endDate'] )->format('Y')) && $report->month == intval(\Carbon\Carbon::createFromFormat('Y-m', $input['endDate'] )->format('m')))
                            {
                                $endSalAmount = $report->salAmount;
                            }
                        }
                    }

                    array_push($start, array("id"=>$data["id"], "salQty"=> $startSalQty, "salAmount"=> $startSalAmount));
                    array_push($end, array("id"=>$data["id"], "salQty"=> $endSalQty, "salAmount"=> $endSalAmount));
                }

                @endphp

                @foreach ($dataArray as $key=>$data)

                    @php
                        if ($count >= $itemPerPage)
                            break;

                        if ($skippedItem-- > 0)
                            continue;
                    @endphp
                    
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td>
                            {{ $data["id"] }}
                        </td>
                        <td>
                            {{ $data["prod_name"] }}
                        </td>
                        <td>
                            {{ $data["prod_name"] }}
                        </td>
                        <td style="text-align: center;">
                            {{ number_format((float)$start[$key]["salAmount"], 2, '.', '') }}
                        </td>
                        <td style="text-align: center;">
                            {{ number_format((float)$end[$key]["salAmount"], 2, '.', '') }}
                        </td>
                        <td>
                           @php
                            $dataArray[$key]["sumAmount"] = $end[$key]["salAmount"] - $start[$key]["salAmount"];
                            echo number_format((float)$dataArray[$key]["sumAmount"], 2, '.', '');
                           @endphp
                        </td>
                        <td style="text-align: right;">
                            @php
                            $endAmount = floatval($end[$key]["salAmount"]);
                            $startAmount = floatval($start[$key]["salAmount"]);
                            echo number_format((float)($endAmount - $startAmount) / ($startAmount ? $startAmount : 10) * 100.0, 2, '.', '');

                            $count++;
                           @endphp
                        </td>
                    </tr>
                @endforeach

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