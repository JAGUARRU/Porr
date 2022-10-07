<x-app-layout title="รายละเอียดร้านค้า">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            รายละเอียดร้านค้า
        </h2>
    </x-slot>

    <div>
        <div class="max-w-6xl mx-auto py-4 sm:px-6 lg:px-8">
            <div class="flex">
                <a href="{{ route('retails.index') }}" class="flex items-center justify-between px-6 py-3 text-sm leading-5 mx-2 transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-lg">
                    <span class="text-base">กลับหน้าแรก</span>
                </a>

                <a href="{{ url('retails/'.$retail->id.'/edit') }}" class="flex items-center justify-between px-6 py-3 text-sm leading-5 mx-2  transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-lg">
                    <span class="text-base">แก้ไข</span>
                </a>
            </div>
           
            <div class="flex flex-col mt-6">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-100 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full text-left text-sm">
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        รหัสร้านค้า
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $retail->id }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        ชื่อร้านค้า
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $retail->retail_name }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        ที่อยู่
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" readonly>{{ $retail->retail_address }} ตำบล{{ $retail->retail_sub_district }} อำเภอ{{ $retail->retail_district }} จังหวัด{{ $retail->retail_province }} {{ $retail->retail_postcode }}</textarea><br>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        ติดต่อ
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        <div><span>เบอร์โทรศัพท์:</span> {{ $retail->retail_phone }}</div>
                                        <div><span>ช่องทางติดต่ออื่น:</span> {{ $retail->retail_contact }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        วันที่สร้าง
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $retail->created_at }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto py-4 sm:px-6 lg:px-8">
        
        <h2 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
            ออเดอร์ 3 รายการล่าสุด
        </h2>

        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">รหัสออเดอร์</th>
                        <th class="px-4 py-3">สถานะ</th>
                        <th class="px-4 py-3">ยอดชำระ (บาท)</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                  
                    @if (count($retail->orders) == 0)
                    <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                        <td colspan="6" class="px-4 py-3">
                            ยังไม่มีข้อมูลรายการสั่งซื้อ...
                        </td>
                    </tr>
                    @endif

                    @foreach ($retail->orders as $order)
                    
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">


                            @if ($order->order_cancelled)
                                <span class="line-through">{{ $order->id }}</span>
                            @else
                                {{ $order->id }}
                            @endif
    
                        </td>
                        <td class="px-4 py-3">
                            {{ $order->order_status }}
                        </td>
                        <td class="px-4 py-3">
                            {{ number_format((float)$order->order_total, 2, '.', '') }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-4 text-sm">

                                <a href="{{ url('orders/'.$order->id) }}">
                                    <button
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="View">
                                        แสดง
                                    </button>
                                </a>

                                <a href="{{ url('orders/'.$order->id.'/edit') }}">
                                    <button
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Edit">
                                        แก้ไข
                                    </button>
                                </a>

                            </div>
                        </td>
                    </tr>
                  
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
