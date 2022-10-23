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
    <span style="display: inline-block; float: right;">หน้า 1/1</span>
    <div style="text-align: left;">
        <div><span>ร้าน ป้อฮ์ไอติมกะทิสด</span></div>
        <div><span>162 หมู่ 13 ตำบลหนองกะท้าว อำเภอนครไทย จังหวัดพิษณุโลก 65120</span></div>
        <div><span>โทร: 093-873-3956</span></div>        
    </div>
    <div style="text-align: center;">
        <div><span style="font-weight: bolder; font-size: 28px;">รายงานสรุปเปรียบเทียบยอดการขาย</span></div>
    </div>
    <div style="width: 100%; text-align: right;">
        <div><span>ผู้พิมพ์:  {{ \Illuminate\Support\Facades\Auth::user()->name }} </span></div>
        <span style="display: inline-block;">วันที่พิมพ์: {{\Carbon\Carbon::now()->thaidate('j F Y')}} </span>
    </div>

    <div style="width: 100%; overflow-x: auto; margin-top: 12px;">
        <table style="width: 100%; white-space: nowrap;">
            <thead>
                <tr style="font-weight: bold; text-align: center;">
                    <th>ปี</th>
                    <th>เดือน</th>
                    <th>จำนวน (บาท)</th>
                </tr>
            </thead>

            <tbody style="text-align: center;">

              @if (count($reports) == 0)
              <tr class="text-gray-700 dark:text-gray-400 text-center" id="no-data">
                  <td colspan="4" class="px-4 py-3">
                      ไม่พบข้อมูล...
                  </td>
              </tr>
              @else
              @php
                  $input['sum_sale'] = 0;
                  $input['currentYear'] = 0;
              @endphp

              <tr class="text-gray-700 dark:text-gray-400">

                  <td>
                     {{ \Carbon\Carbon::createFromFormat('Y-m', $input['startDate'] )->format('Y') }}
                  </td>
                  <td>
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $input['startDate'] )->thaidate('F') }}
                  </td>
                  <td style="text-align: right;">
                  
                    @foreach ($reports as $report)
                        @if ($report['month'] == \Carbon\Carbon::createFromFormat('Y-m', $input['startDate'])->format('m'))

                              {{ number_format((float)$report->sale, 2, '.', '') }}

                            @php
                              $hasStart = true;
                              $input['sum_sale'] += $report->sale;
                            @endphp
                        @endif
                    @endforeach
                    
                    @if (!isset($hasStart))
                    0.00
                    @endif

                  </td>
              </tr>
            
              <tr class="text-gray-700 dark:text-gray-400">
                <td>
                   {{ \Carbon\Carbon::createFromFormat('Y-m', $input['endDate'] )->format('Y') }}
                </td>
                <td>
                  {{ \Carbon\Carbon::createFromFormat('Y-m', $input['endDate'] )->thaidate('F') }}
                </td>
                <td style="text-align: right;">
                  
                  @foreach ($reports as $report)
                      @if ($report['month'] == \Carbon\Carbon::createFromFormat('Y-m', $input['endDate'])->format('m'))

                            {{ number_format((float)$report->sale, 2, '.', '') }}

                          @php
                            $hasEnd = true;
                            $input['sum_sale'] += $report->sale;
                          @endphp
                      @endif
                  @endforeach
                  
                  @if (!isset($hasEnd))
                  0.00
                  @endif

                </td>
            </tr>
            <tr style="text-align: right;">
                <td colspan="2">
                  รวมทั้งสิ้น
                </td>
                <td>
                  @if(isset($input['sum_sale']))

                  {{ number_format((float)$input['sum_sale'], 2, '.', '') }}

                  @endif
                </td>
            </tr>
              @endif


            </tbody>

        </table>
    </div>

</div>

</body>
</html>

