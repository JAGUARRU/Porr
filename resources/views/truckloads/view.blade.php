<x-app-layout title="จัดการขนส่ง">
    <div class="container grid px-6 my-6 mx-auto">

        <div class="flex">
            <a href="{{ route('truckloads.index') }}" class="flex items-center justify-between px-6 py-3 text-sm leading-5 mx-2 transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-lg">
                <span class="text-base">ย้อนกลับ</span>
            </a>
        </div>

        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            รอบการส่งของ
        </h2>

        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        รหัสรถ
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $truckRoutes->id }}
                    </p>
                </div>
            </div>
 
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        ป้ายทะเบียน
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $truckRoutes->plateNumber }}
                    </p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        คนขับ
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $truckRoutes->user ? $truckRoutes->user['name'] : 'ยังไม่ได้ตั้งค่า' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        สถานะ
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">

                        @if($truckRoutes->transportDate)

                            {{ Helper::GetRouteStatus($truckRoutes->route_status) }} 
                            
                            @if($truckRoutes->route_status != 2)
                                กำหนดส่ง {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Helper::DateTimeStringToEndOfDay($truckRoutes->transportDate))->diffForHumans() }}
                            @endif

                        @else
                            {{$truckRoutes->routes_count == 0 ? $truckRoutes->truck_status : Helper::GetRouteStatus($truckRoutes->route_status) }}
                        @endif

                    </p>
                </div>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 ">

            @php
                $trucks = $truckRoutes->routes()->withCount('lists')->orderBy(DB::raw('confirmDate IS NULL', 'confirmDate'), 'DESC')->orderBy('route_status', 'ASC')->paginate(5);
            @endphp

            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">กำหนดส่ง</th>
                            <th class="px-4 py-3">วันที่จัดส่งเสร็จสมบูรณ์</th>
                            <th class="px-4 py-3">จำนวนออเดอร์</th>
                            <th class="px-4 py-3">สถานะ</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
   
                        @foreach($trucks as $truck)

                        <tr class="text-gray-700 dark:text-gray-400">

                            <td class="px-4 py-3">
                                {{ $truck->id }}
                            </td>

                            <td class="px-4 py-3">
                                @if($truck->transportDate)
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $truck->transportDate)->thaidate('j F Y') }} 
                                    @if(!$truck->confirmDate)
                                        ({{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Helper::DateTimeStringToEndOfDay($truck->transportDate))->diffForHumans() }})
                                    @endif
                                @else
                                -
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                @if($truck->confirmDate)
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $truck->confirmDate)->thaidate('j F Y H:i:s') }} 
                                @else
                                -
                                @endif
                            </td>
                            
                            <td class="px-4 py-3">
                                {{ $truck->lists_count }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $truck->route_status }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                
                                    <a href="{{ url('truckloads/route/'.$truck->id.'/edit') }}" class="btn btn-primary btn-sm">
                                        <button
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            อัปเดต
                                        </button>
                                    </a>

                                    <a href="{{ url('truckloads/route/'.$truck->id.'/print') }}" class="btn btn-primary btn-sm">
                                        <button
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="View">
                                            พิมพ์ใบส่งของ
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
                    {{ __('pagination.showing') }} {{ $trucks->firstItem() }}-{{ $trucks->lastItem() }} {{ __('pagination.of') }} {{ $trucks->total() }}
                </span>
                <span class="col-span-2"></span>
                <!-- Pagination -->
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    <nav aria-label="Table navigation">
                        <ul class="inline-flex items-center">
                            
                            <li>
                                <a href="{{ $trucks->url( $trucks->currentPage() - 1 ) }}">
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

                            $curPage = $trucks->currentPage();
                            $totalPage = $trucks->lastPage();

                            $startPage = ($curPage < 5)? 1 : $curPage - 4;
                            $endPage = 8 + $startPage;
                            $endPage = ($totalPage < $endPage) ? $totalPage : $endPage;
                            $diff = $startPage - $endPage + 8;
                            $startPage -= ($startPage - $diff > 0) ? $diff : 0;

                            @endphp

                            @if($trucks->total())
                                
                                @for ($i=$startPage; $i<=$endPage; $i++)
                                    <li>
                                        <a href="{{ $trucks->url($i) }}">
                                            @php
                                                if ($curPage != $i) echo '<button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                else echo '<button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                            @endphp
                                        </a>
                                    </li> 
                                @endfor
                        
                            @endif

                            <li>
                                <a href="{{ $trucks->nextPageUrl() }}">
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

      
        <div class="flex flex-col mt-6">

            <div class="w-full my-6">

                <span class="inline-block text-2xl font-semibold text-gray-700 dark:text-gray-200">รายการสินค้าที่บรรทุกไว้</span>

                @if(Gate::check('employee_truck_print_access'))
                @if($truckRoutes->truck_id)
                <span class="inline-block float-right">
                    <a href="{{ route('trucks.product_print', ['id'=> $truckRoutes->truck_id]) }}">
                        <button type="button" class="bg-purple-600 rounded hover:bg-blue-700 text-white font-bold py-2 px-4" value="print">
                            พิมพ์ / PDF
                        </button>
                    </a>
                </span>
                @endif
                @endif

            </div>

            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="font-semibold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">รหัสออเดอร์</th>
                        <th class="px-4 py-3">รายการสินค้า</th>
                        <th class="px-4 py-3">จำนวน</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-center divide-y dark:divide-gray-700 dark:bg-gray-800">


                    @php
                        $count = 0;
                    @endphp


                    @foreach($truckRoutes->routes as $routes)

                        @foreach($routes->lists()->get() as $route)

                            @php
                                if($route->route_list_status != Helper::GetRouteListStatus(0))
                                    continue;
                            @endphp
                            
                            @foreach($route->order()->get() as $order)
                                @foreach($order->products()->get()->toArray() as $product)
                                <tr class="text-gray-700 dark:text-gray-400 {{ (!isset($currentOrder) || $currentOrder != $order->id) ? ('') : ('border-none')}}" id="{{ $product['product_id'] }}">
                                    <td class="px-4 py-3">
                                        @php
                                        if (!isset($currentOrder) || $currentOrder != $order->id)
                                        {
                                            $currentOrder = $order->id;
                                            echo $order->id;
                                        }
                                        @endphp
                                    </td>
                                    <td class="px-4 py-3 text-left truncate max-w-md">
                                        {{ $product['product_id'] }}: {{ $product['product_name'] }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $product['qty'] }}
                                    </td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                                @endforeach
                            @endforeach
                        @endforeach
                @endforeach

                @if ($count == 0)
                <tr class="text-gray-700 dark:text-gray-400 text-center" id="no-data">
                    <td colspan="4" class="px-4 py-3">
                        ไม่พบข้อมูล...
                    </td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
        
        </div>

</x-app-layout>