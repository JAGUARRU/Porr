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

                @if (Gate::check('user_retail_edit_access'))
                <a href="{{ url('retails/'.$retail->id.'/edit') }}" class="flex items-center justify-between px-6 py-3 text-sm leading-5 mx-2  transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-lg">
                    <span class="text-base">แก้ไข</span>
                </a>
                @endif
            </div>
           
            <div class="flex flex-col mt-6">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-100 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full text-left text-sm">
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                        รหัสร้านค้า
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                        {{ $retail->id }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                        ชื่อร้านค้า
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                        {{ $retail->retail_name }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                        ที่อยู่
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                        <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" readonly>{{ $retail->retail_address }} ตำบล{{ $retail->retail_sub_district }} อำเภอ{{ $retail->retail_district }} จังหวัด{{ $retail->retail_province }} {{ $retail->retail_postcode }}</textarea><br>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                        ติดต่อ
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                        <div><span>เบอร์โทรศัพท์:</span> {{ $retail->retail_phone }}</div>
                                        <div><span>ช่องทางติดต่ออื่น:</span> {{ $retail->retail_contact }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                        วันที่สร้าง
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
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
            ประวัติออเดอร์
        </h2>

        @php
            $orders = $retail->orders()->paginate(10);
        @endphp
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
                  
                    @if (count($orders) == 0)
                    <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                        <td colspan="6" class="px-4 py-3">
                            ยังไม่มีข้อมูลรายการสั่งซื้อ...
                        </td>
                    </tr>
                    @endif

                    @foreach ($orders as $order)
                    
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
        <div
        class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
        <span class="flex items-center col-span-3">
            {{ __('pagination.showing') }} {{ $orders->firstItem() }}-{{ $orders->lastItem() }} {{ __('pagination.of') }} {{ $orders->total() }}
        </span>
        <span class="col-span-2"></span>
        <!-- Pagination -->
        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
            <nav aria-label="Table navigation">
                <ul class="inline-flex items-center">
                    
                    <li>
                        <a href="{{ $orders->url( $orders->currentPage() - 1 ) }}">
                            <button
                                class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                                aria-label="Previous">
                                <svg class="w-4 h-4 fill-current" aria-hidden="true"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </button>
                        </a>
                    </li>

                    @php

                    $curPage = $orders->currentPage();
                    $totalPage = $orders->lastPage();

                    $startPage = ($curPage < 5)? 1 : $curPage - 4;
                    $endPage = 8 + $startPage;
                    $endPage = ($totalPage < $endPage) ? $totalPage : $endPage;
                    $diff = $startPage - $endPage + 8;
                    $startPage -= ($startPage - $diff > 0) ? $diff : 0;

                    @endphp

                    @if($orders->total())
                        
                        @for ($i=$startPage; $i<=$endPage; $i++)
                            <li>
                                <a href="{{ $orders->url($i) }}">
                                    @php
                                        if ($curPage != $i) echo '<button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                        else echo '<button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                    @endphp
                                </a>
                            </li> 
                        @endfor
                
                    @endif

                    <li>
                        <a href="{{ $orders->nextPageUrl() }}">
                        <button
                            class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                            aria-label="Next">
                            <svg class="w-4 h-4 fill-current" aria-hidden="true"
                                viewBox="0 0 20 20">
                                <path
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                        </button>
                        </a>
                    </li>

                </ul>
            </nav>
        </span>
    </div>
    </div>

</x-app-layout>
