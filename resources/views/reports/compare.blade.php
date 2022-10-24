<x-app-layout title="รายงานสรุปเปรียบเทียบยอดการขาย">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            รายงานสรุปเปรียบเทียบยอดการขาย
        </h2>

        <form action="{{ route('reports.compare') }}" method="GET" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-1 gap-4 mb-4 text-sm font-normal">
                <div class="w-1/3 mb-4">
                    <p class="text-lg font-bold">ระบุเดือนที่ต้องการเปรียบเทียบ</p>
                    <div>
                        <label for="text-gray-700 dark:text-gray-400 my-2">เดือนที่ 1
                            <input name="startDate" type="date" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </label>
                        <label for="text-gray-700 dark:text-gray-400 my-2">เดือนที่ 2
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
                    <tr class="font-semibold tracking-wide text-gray-500 uppercase dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <td colspan="5"></td>
                        <th colspan="2" scope="colgroup">เพิ่มขึ้น / ลดลง<hr></th>
                    </tr>

                    <tr
                        class="font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">รหัสสินค้า</th>
                        <th class="px-4 py-3">ชื่อสินค้า</th>
                        <th class="px-4 py-3">ประเภทสินค้า</th>
                        <th class="px-4 py-3">{{ \Carbon\Carbon::createFromFormat('Y-m', $input['startDate'] )->thaidate('F') }}({{ \Carbon\Carbon::createFromFormat('Y-m', $input['startDate'] )->thaidate('Y') }})</th>
                        <th class="px-4 py-3">{{ \Carbon\Carbon::createFromFormat('Y-m', $input['endDate'] )->thaidate('F') }}({{ \Carbon\Carbon::createFromFormat('Y-m', $input['endDate'] )->thaidate('Y') }})</th>
                        <th class="px-4 py-3 text-left">จำนวนเงิน</th>
                        <th class="px-4 py-3 text-right">%</th>
                    </tr>
                </thead>
    
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
    
                @if (count($reports) == 0)

                    <tr class="text-gray-700 dark:text-gray-400 text-center" id="no-data">
                        <td colspan="7" class="px-4 py-3">
                            ไม่พบข้อมูล...
                        </td>
                    </tr>
                @else

                @php

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
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            {{ $data["id"] }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $data["prod_name"] }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $data["prod_name"] }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{ number_format((float)$start[$key]["salAmount"], 2, '.', '') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{ number_format((float)$end[$key]["salAmount"], 2, '.', '') }}
                        </td>
                        <td class="px-4 py-3">
                           @php
                            $dataArray[$key]["sumAmount"] = $end[$key]["salAmount"] - $start[$key]["salAmount"];
                            echo number_format((float)$dataArray[$key]["sumAmount"], 2, '.', '');
                           @endphp
                        </td>
                        <td class="px-4 py-3 text-right">
                            @php
                            $endAmount = floatval($end[$key]["salAmount"]);
                            $startAmount = floatval($start[$key]["salAmount"]);
                            echo number_format((float)($endAmount - $startAmount) / ($startAmount ? $startAmount : 10) * 100.0, 2, '.', '');
                           @endphp
                        </td>
                    </tr>
                @endforeach

                @endif
            
                </tbody>
    
            </table>
        </div>

    </div>
</x-app-layout>