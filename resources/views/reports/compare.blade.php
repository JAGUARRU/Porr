<x-app-layout title="รายงานสรุปเปรียบเทียบยอดการขาย">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            รายงานสรุปเปรียบเทียบยอดการขาย
        </h2>

        <form action="{{ route('reports.compare') }}" method="GET" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-1 gap-4 mb-4 text-sm font-normal">
                <div class="w-1/3 mb-4">
                    <p class="text-lg font-bold">แสดงตามช่วงเวลา</p>
                    <div>
                        <label for="text-gray-700 dark:text-gray-400 my-2">วันที่ 1
                            <input name="startDate" type="date" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </label>
                        <label for="text-gray-700 dark:text-gray-400 my-2">วันที่ 2
                            <input name="endDate" type="date" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-3 sm:grid-cols-3 gap-4 mb-4">
                    <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        แสดง
                    </button>
                </div>
            </div>
        </form>

        <div class="w-full overflow-x-auto mb-12">

            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                ตารางรายงานสรุปเปรียบเทียบยอดการขาย
            </h2>
            
            <div class="w-full mb-12">

                <span class="inline-block text-gray-700 dark:text-gray-200">รายงาน {{ $input['startDate'] }} ถึง {{ $input['endDate'] }}</span>

                <span class="inline-block float-right">
                    <a href="{{ route('reports.compare_pdf', ['startDate'=> isset($input['startDate']) ? $input['startDate'].'-01' : null, 'endDate'=>isset($input['endDate']) ? $input['endDate'].'-01' : null]) }}">
                        <button type="button" class="bg-purple-600 rounded hover:bg-blue-700 text-white font-bold py-2 px-4" value="print">
                            ส่งออกเป็น PDF
                        </button>
                    </a>
                </span>
        
            </div>

            <table class="w-full whitespace-no-wrap mb-12">
                <thead class="text-center">
                    <tr
                        class="font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th>ปี</th>
                        <th>เดือน</th>
                        <th class="text-right">จำนวนเงิน (บาท)</th>
                    </tr>
                </thead>
    
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
    
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
                  <td class="px-4 py-3">
                     {{ \Carbon\Carbon::createFromFormat('Y-m', $input['startDate'] )->format('Y') }}
                  </td>
                  <td class="px-4 py-3">
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $input['startDate'] )->thaidate('F') }}
                  </td>
                  <td class="px-4 py-3 text-right">
                  
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
                <td class="px-4 py-3">
                   {{ \Carbon\Carbon::createFromFormat('Y-m', $input['endDate'] )->format('Y') }}
                </td>
                <td class="px-4 py-3">
                  {{ \Carbon\Carbon::createFromFormat('Y-m', $input['endDate'] )->thaidate('F') }}
                </td>
                <td class="px-4 py-3 text-right">
                  
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
            <tr class="text-gray-100 dark:text-gray-700 bg-gray-600 dark:bg-gray-300 text-right">
                <td colspan="2" class="px-4 py-3">
                  รวมทั้งสิ้น
                </td>
                <td class="px-4 py-3">
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
</x-app-layout>