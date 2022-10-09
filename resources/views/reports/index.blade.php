<x-app-layout title="รายงานสรุปยอดขายและยอดสั่งซื้อรายเดือน">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            รายงานสรุปยอดขายและยอดสั่งซื้อรายเดือน
        </h2>

        <form action="{{ route('reports.index') }}" method="GET" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-1 gap-4 mb-4 text-sm font-normal">
                <div class="w-1/3 mb-4">
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
                <div class="w-1/3 mb-4">
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
                <div class="grid grid-cols-3 sm:grid-cols-3 gap-4 mb-4">
                    <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        แสดง
                    </button>
                </div>
            </div>
        </form>

        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="font-semibold tracking-wide text-right text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3">เดือน</th>
                        <th class="px-4 py-3">ยอดออเดอร์</th>
                        <th class="px-4 py-3">จำนวนเงิน (บาท)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-right">
                  
                    @if (count($reports) == 0)
                    <tr class="text-gray-700 dark:text-gray-400 text-center" id="no-data">
                        <td colspan="4" class="px-4 py-3">
                            ไม่พบข้อมูล...
                        </td>
                    </tr>
                    @endif

                    @php
                        $reports->sum_order = 0;
                        $reports->sum_sale = 0;
                        $reports->currentYear = 0;
                    @endphp

                    @foreach ($reports as $key=>$report)
    
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-left">
                            @php
                                if ($reports->currentYear != $report->year)
                                {
                                    $reports->currentYear = $report->year;
                                    echo $report->year;
                                }
                            @endphp
                        </td>
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $report->datetime )->thaidate('F') }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $report->order_count }}
                            @php
                                $reports->sum_order += $report->order_count;
                            @endphp
                        </td>
                        <td class="px-4 py-3">
                            {{ number_format((float)$report->sale, 2, '.', '') }}
                            @php
                                $reports->sum_sale += $report->sale;
                            @endphp
                        </td>
                    </tr>
                  
                    @endforeach

                    @if (count($reports) != 0)
                    <tr class="text-gray-100 dark:text-gray-700 bg-gray-600 dark:bg-gray-300">
                        <td colspan="2" class="">
                            รวม
                        </td>
                        <td class="px-4 py-3">
                            {{ $reports->sum_order }}
                        </td>
                        <td class="px-4 py-3">
                            {{ number_format((float)$reports->sum_sale, 2, '.', '') }}฿
                        </td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>