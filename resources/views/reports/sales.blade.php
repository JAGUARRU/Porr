<x-app-layout title="รายงานสรุปยอดขายรายเดือน">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            รายงานสรุปยอดขายรายเดือน
        </h2>

        <form action="{{ route('reports.sales') }}" method="GET" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf

            <div class="grid grid-cols-2 sm:grid-cols-1 gap-4 mb-4 text-sm font-normal">
                <div class="col-span-1 w-1/3 mb-4">
                    <p class="text-lg font-bold">แสดงตามปีที่เลือก</p>
                    <label for="text-gray-700 dark:text-gray-400">ค้นหาจากปี
                        <select class="inline-block w-full text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="year" name="year">
                            @php
                            for($i = date('Y') ; $i >= 1970; $i--)
                            {
                                echo "<option>$i</option>";
                            }
                            @endphp
                        </select>
                    </label>
                </div>
                <div class="col-span-2 w-1/3 mb-4">
                    <p class="text-lg font-bold">แสดงตามช่วงเวลา</p>
                    <span class="text-xs mb-2 text-purple-500">คำแนะนำ: เว้นว่าง เมื่อต้องการค้นหาตามปีที่เลือก</span>
                    <div>
                        <label for="text-gray-700 dark:text-gray-400 my-2">เริ่ม
                            <input name="startDate" type="date" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </label>
                        <label for="text-gray-700 dark:text-gray-400 my-2">สิ้นสุด
                            <input name="endDate" type="date" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </label>
                    </div>
                </div>
                <div class="w-1/3 mb-4">
                    <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        แสดง
                    </button>
                </div>
            </div>
        </form>

        <div class="w-full overflow-x-auto mb-12">

            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                ตารางรายงานสรุปยอดขายรายเดือน
            </h2>

            <div class="w-full mb-12">

                @if (isset($input['startDate']) && isset($input['endDate'])
                && \Carbon\Carbon::createFromFormat('Y-m-d', $input['startDate']) !== false
                && \Carbon\Carbon::createFromFormat('Y-m-d', $input['endDate']) !== false)
                    <span class="inline-block text-gray-700 dark:text-gray-200">รายงาน {{ $input['startDate'] }} ถึง {{ $input['endDate'] }}</span>
                @else
                <span class="inline-block text-gray-700 dark:text-gray-200">รายงานปี {{ $input['year'] }}</span>
                @endif


                <span class="inline-block float-right">
                    <a href="{{ route('reports.sales_pdf', ['year'=>$input['year'], 'startDate'=> isset($input['startDate']) ? $input['startDate'] : null, 'endDate'=>isset($input['endDate']) ? $input['endDate'] : null]) }}">
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
                        <th class="px-4 py-3">รหัสสินค้า</th>
                        <th class="px-4 py-3">ชื่อสินค้า</th>
                        <th class="px-4 py-3">ประเภทสินค้า</th>
                        <th class="px-4 py-3 text-right">จำนวน</th>
                        <th class="px-4 py-3 text-right">รวมเงิน (บาท)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                  
                    
                    @php
                        $reports->sumQty = 0;
                        $reports->sumAmount = 0;
                        $reports->currentYear = 0;
                        $reports->currentMonth = 0;
                    @endphp

                    @if (count($reports) == 0)
                    <tr class="text-gray-700 dark:text-gray-400 text-center">
                        <td colspan="5" class="px-4 py-3">
                            ไม่พบข้อมูล...
                        </td>
                    </tr>
                    @else

                    @foreach ($reports as $report)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                {{ $report->id }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $report->prod_name }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $report->prod_type_name }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                {{ $report->salQty }}

                                @php
                                    $reports->sumQty += $report->salQty;
                                @endphp
                            </td>
                            <td class="px-4 py-3 text-right">

                                {{ number_format((float)$report->salAmount, 2, '.', '') }}

                                @php
                                    $reports->sumAmount += $report->salAmount;
                                @endphp
                            </td>
                        </tr>
                    @endforeach

                    <tr class="text-gray-100 dark:text-gray-700 bg-gray-600 dark:bg-gray-300">
                        <td colspan="3" class="text-right">
                            รวม
                        </td>
                        <td class="px-4 py-3 text-right">
                            {{ number_format((float)$reports->sumQty, 2, '.', '') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            {{ number_format((float)$reports->sumAmount, 2, '.', '') }}
                        </td>
                    </tr>

                    @endif

                </tbody>
            </table>

        </div>

    </div>
</x-app-layout>