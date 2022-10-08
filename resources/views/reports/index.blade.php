<x-app-layout title="รายงานสรุปยอดขายและสั่งซื้อต่อเดือน">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            รายงานสรุปยอดขายและสั่งซื้อต่อเดือน
        </h2>

        <form action="{{ route('reports.index') }}" method="GET" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf

            <div class="grid grid-cols-2 sm:grid-cols-2 gap-4 mb-4">
                <div class="grid grid-cols-3 sm:grid-cols-2 gap-4 mb-4">
                    <div class="flex justify-center">
                        <select class="inline-block w-full text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="year" name="year">
                            @php
                            for($i = date('Y') ; $i >= 1970; $i--)
                            {
                                echo "<option>$i</option>";
                            }
                            @endphp
                        </select>
                    </div>
                    <div class="flex justify-items-center place-content-start">
                        <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            แสดง
                        </button>
                    </div>
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
                    @endphp

                    @foreach ($reports as $report)
    
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-left">
                            {{ $report->month }}
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