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
        <span style="font-weight: bolder; font-size: 18px;">รายงานสรุปยอดสั่งซื้อรายเดือน</span>
    </div>
    <div style="width: 100%;">
        <span style="display: inline-block;">พิมพ์เมื่อวันที่: {{\Carbon\Carbon::now()->thaidate('j F Y')}}</span>

        @if (isset($input['startDate']) && isset($input['endDate'])
        && \Carbon\Carbon::createFromFormat('Y-m-d', $input['startDate']) !== false
        && \Carbon\Carbon::createFromFormat('Y-m-d', $input['endDate']) !== false)
            <span style="display: inline-block; float: right;">รายงาน {{ $input['startDate'] }} ถึง {{ $input['endDate'] }}</span>
        @else
        <span style="display: inline-block; float: right;">รายงานปี {{ $input['year'] }}</span>
        @endif
    </div>

    <div style="width: 100%; overflow-x: auto; margin-top: 12px;">
        <table style="width: 100%; white-space: nowrap;">
            <thead>
                <tr style="font-weight: bold; text-align: center;">
                    <th>ปี</th>
                    <th>เดือน</th>
                    <th>จำนวน</th>
                </tr>
            </thead>

            <tbody style="text-align: center;">

              @if (count($reports) == 0)
              <tr class="text-gray-700 dark:text-gray-400 text-center" id="no-data">
                  <td colspan="4" class="px-4 py-3">
                      ไม่พบข้อมูล...
                  </td>
              </tr>
              @endif

              @php
                  $input['sum_order'] = 0;
                  $input['currentYear'] = 0;
              @endphp

              @foreach ($reports as $report)

              <tr class="text-gray-700 dark:text-gray-400">
                  <td>
                      @php
                          if (isset($report['year']) && $input['currentYear'] != $report['year'])
                          {
                              $input['currentYear'] = $report['year'];
                              echo $report['year'];
                          }
                      @endphp
                  </td>
                  <td>
                    @if(isset($report['datetime']))
                      {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $report['datetime'] )->thaidate('F') }}
                    @endif
                  </td>
                  <td style="text-align: right;">
                    @if(isset($report['order_count']))
                      {{ $report['order_count'] }}
                      @php
                          $input['sum_order'] += $report['order_count'];
                      @endphp
                    @endif
                  </td>
              </tr>
            
              @endforeach

              @if (count($reports) != 0)
              <tr style="text-align: right;">
                  <td colspan="2">
                    รวมทั้งสิ้น
                  </td>
                  <td>
                    @if(isset($input['sum_order']))
                    {{ $input['sum_order'] }}
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
