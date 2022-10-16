<x-app-layout title="บรรทุกสินค้า">
    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            บรรทุกสินค้า
        </h2>

    <div class="container">

        <form action="{{ route('routes.store') }}" method="POST">
            @csrf

            @if($errors->any())
                @foreach($errors->all() as $error)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error</strong>
                    <span class="block sm:inline">{{ $error }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
                @endforeach
            @elseif (session('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Info</strong>
                    <span class="block sm:inline">{{ session('message') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            @endif
            
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
                <div class="mb-4">

                    <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                        รายการสินค้าในออเดอร์
                    </h4>
    
                    <table class="w-full whitespace-no-wrap" id="productOrder">
                        <thead>
                            <tr
                                class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3"></th>
                                <th class="px-4 py-3">รหัสสินค้า</th>
                                <th class="px-4 py-3">ชื่อสินค้า</th>
                                <th class="px-4 py-3">จำนวน</th>
                                <th class="px-4 py-3">คงเหลือ (ที่ต้องจัดส่ง)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                          
    
                            @if (count($order->products) == 0)
                            <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                                <td colspan="6" class="px-4 py-3">
                                    ยังไม่มีข้อมูลรายการสินค้า...
                                </td>
                            </tr>
                            @endif
                            
                            @foreach ($order->products as $product)
                            <tr class="text-gray-700 dark:text-gray-400" id="{{ $product['product_id'] }}">
                                <td class="px-4 py-3 w-6 h-6">
                                    <button type="button" id="loadProductOrder" data-id="{{ $product['product_id'] }}" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" aria-label="Like">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                          </svg>                                                                        
                                    </button>
                                 </td>
                                <td class="px-4 py-3">{{ $product["product_id"] }}</td>
                                <td class="px-4 py-3">{{ $product["product_name"] }}</td>
                                <td class="px-4 py-3">{{ $product["qty"] }}</td>
                                <td class="px-4 py-3"></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        <span id="orderItems" class="flex justify-end py-6 text-green-600 transition-opacity ease-in duration-700 opacity-0">รายการสินค้าได้รับการอัปเดตแล้ว</span>
                    </div>
                </div>
    
                <div class="mb-4">
    
                    <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                        ประวัติรายการจัดส่งที่ผ่านมา
                    </h4>
    
                    <table class="w-full whitespace-no-wrap" id="routeProduct">
                        <thead>
                            <tr
                                class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">กำหนดส่ง</th>
                                <th class="px-4 py-3">ส่งเมื่อ</th>
                                <th class="px-4 py-3">คนขับรถ</th>
                                <th class="px-4 py-3">สถานะ</th>
                                <th class="px-4 py-3">รหัสสินค้า</th>
                                <th class="px-4 py-3">จำนวน</th>
                                <th class="px-4 py-3">ถึงปลายทาง</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                          
    
                            @if (count($order->routes) == 0)
                            <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                                <td colspan="6" class="px-4 py-3">
                                    ยังไม่มีข้อมูลรายการสินค้า...
                                </td>
                            </tr>
                            @endif
                            
                            @foreach ($order->routes as $routes)
                                @php

                                    $routeCheck = \App\Models\OrderRouteLists::selectRaw('route_lists.*, sum(route_lists.qty) as amount, route_lists.product_id')
                                    ->leftJoin('order_routes', 'order_routes.id', '=', 'route_lists.order_route_id')
                                    ->where('order_routes.id', '=', $routes->id)
                                    ->groupBy('route_lists.product_id')
                                    ->get()->toArray();

                                @endphp
                                @foreach ($routeCheck as $route)
                                <tr class="text-gray-700 dark:text-gray-400 {{ (!isset($currentRoute) || $currentRoute != $routes["id"]) ? ('') : ('border-none')}}">
                                    
                                    <td class="px-4 py-3">

                                        @php
                                        if (!isset($currentRoute) || $currentRoute != $routes["id"])
                                        {
                                            echo $routes["id"];
                                        }
                                        @endphp

                                    </td>
                                    <td class="px-4 py-3">
                                        @if (!isset($currentRoute) || $currentRoute != $routes["id"])
                                        {{ $routes["transportDate"] }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if (!isset($currentRoute) || $currentRoute != $routes["id"])
                                        {{ $routes["confirmDate"] ? $routes["confirmDate"] : ('-') }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if (!isset($currentRoute) || $currentRoute != $routes["id"])
                                        {{ $routes["truck_driver"] }} ({{ $routes["truck_plate"] }})
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if (!isset($currentRoute) || $currentRoute != $routes["id"])
                                        {{ $routes["status"] ? ('ยืนยันการจัดส่งแล้ว') : ('อยู่ในระหว่างการจัดส่ง') }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $route["product_id"] }}</td>
                                    <!--<td class="px-4 py-3">{{ $route["qty"] }} {{ $route["qty"] - $route["amount"] > 0 ? ('(-'. ($route["qty"] - $route["amount"]).')') : ('')  }}</td>-->
                                    <td class="px-4 py-3 text-center">{{ $route["qty"] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $route["qty"] - ($route["qty"] - $route["amount"])  }}</td>
                                </tr>

                                @php
                                $currentRoute = $routes["id"];
                                @endphp

                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        <span id="orderItems" class="flex justify-end py-6 text-green-600 transition-opacity ease-in duration-700 opacity-0">รายการสินค้าได้รับการอัปเดตแล้ว</span>
                    </div>
                </div>
    
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
    
                    <div class="col-span-1">
    
                        <div class="block mb-4">
                            <label for="text-gray-700 dark:text-gray-400 inline-block">พาหนะที่ใช้</label>

                            <div class="sm:float-right mx-4 sm:mx-0 inline-block">
                                <button type="button" @click="openModal('transport-table-model')" class="flex items-center justify-between px-5 py-1 text-sm font-medium leading-5  transition-colors duration-150 bg-transparent hover:bg-teal-500 text-teal-700 font-semibold hover:text-white py-0 px-7 border border-teal-500 hover:border-transparent rounded">   
                                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                    </path>
                                </svg>
                                    <span>เลือกจากตารางการจัดส่ง</span>
                                </button>       
                            </div>

                        </div>

                        <div class="mb-4">
                            <input type="hidden" class="hidden" name="truck_id" id="truck_id" value="{{ old('truck_id') }}" />
                            <input type="hidden" class="hidden" name="truck_driver" value="{{ old('truck_driver') }}" />
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="truck_plate" value="{{ old('truck_plate') }}" id="auto-trucks" placeholder="ป้อนชื่อคนขับหรือป้ายทะเบียนเพื่อค้นหา"/>
                        </div>
        
                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">กำหนดส่ง</label>
                            <input type="datetime-local" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" id="transportDate" name="transportDate" value="{{ \Carbon\Carbon::now()->addDay(1)->toDateTimeString() }}"/>
                        </div> 

                        <!--<div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">คนขับรถ</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="truck_driver" value="{{ old('truck_driver') }}" placeholder=""/>
                        </div> -->
    
                    </div>
    
                    <div class="col-span-1">

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">รายการสินค้าที่ต้องการจัดส่ง</label>

                            <table class="w-full whitespace-no-wrap p-2" id="loadProduct">
                                <thead>
                                    <tr
                                        class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3">รหัสสินค้า</th>
                                        <th class="px-4 py-3">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td colspan="6" class="px-4 py-3">
                                            ยังไม่มีข้อมูลรายการสินค้า...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="flex mt-12 sm:place-content-end pb-4">
                            <div class="pr-6">
                                <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    สร้างเส้นทางการเดินรถ
                                </button>
                            </div>
                            <div class="pr-4">
                                <button class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    กลับ
                                </button>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>

            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                ข้อมูลออเดอร์
            </h2>

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 my-4">
                    <div class="col-span-1">

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">รหัสออเดอร์</label>
                            <input type="hidden" class="hidden" name="order_id" id="order_id" value="{{ $order->id }}" />
                            <span class="block font-normal">
                                {{ $order->id }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">จังหวัด</label>
                            <span class="block font-normal">
                                {{ $order->retail_province }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">ตำบล</label>
                            <span class="block font-normal">
                                {{ $order->retail_sub_district }}
                            </span>
                        </div>

                    </div>

                    <!--2-->
                    <div class="col-span-1">

                        <div class="mb-4">
                            <div class="relative block w-full">
                                <label for="text-gray-700 dark:text-gray-400">ร้านค้า</label>
                                <span class="block font-normal">
                                    {{ $order->retail_name }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">อำเภอ</label>
                            <span class="block font-normal" id="input_amphoe">{{ $order->retail_district }}</span>
                        </div>

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">รหัสไปรษณีย์</label>
                            <span class="block font-normal">
                                {{ $order->retail_postcode }}
                            </span>
                        </div> 

                    </div>
                </div>  
            </div>  
        </form>  
        
    </div>
</div>

<div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" @click.away="closeModal" @keydown.escape="closeModal" role="dialog" id="transport-table-model">
    <div class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-7xl">
        
        <header class="flex justify-end">
            <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" type="button" @click="closeModal">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                    <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </button>
        </header>

        <div class="w-full overflow-x-auto mt-4 mb-6">
            <table id="trucks" class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800 w-full">
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3">คนขับรถ</th>
                        <th class="px-4 py-3">ป้ายทะเบียน</th>
                        <th class="px-4 py-3">พื้นที่จัดส่ง</th>
                        <th class="px-4 py-3">กำหนดส่งสินค้า</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                  
    
                    @if (count($trucks) == 0)
                    <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                        <td colspan="4" class="px-4 py-3">
                            ยังไม่มีข้อมูลรถ...
                        </td>
                    </tr>
                    @endif
                    
                    @foreach ($trucks as $truck)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <button @click="closeModal" type="button" id="selectDriver" data-id="{{ json_encode($truck->toArray()) }}" data-driver="{{ json_encode($truck->user ? $truck->user->toArray() : []) }}" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">เลือก</button>
                        </td>
                        <td class="px-4 py-3">
                            {{ $truck->user ? $truck->user['name'] : 'ยังไม่ได้ตั้งค่า' }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $truck->plateNumber }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $truck->truck_district }}
                        </td>
                        <td class="px-4 py-3">

                            @php
                                $routeCount = 0;
                            @endphp

                            @foreach ($truck->routes as $route)
                                @if (!$route->status)
                                <div class="flex justify-between">
                                    <div>รหัสออเดอร์ <span>{{ $route['order_id'] }}</span></div>
                                    <div>อำเภอ<span>{{ $route->order['retail_district'] }}</span></div>
                                    <div><span>{{ $route['transportDate'] }} ({{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $route['transportDate'])->diffForHumans() }})</span></div>
                                </div>
                                    @php
                                        $routeCount++;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($routeCount == 0)
                            -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">

        </footer>
        
    </div>
</div>

<script src="{{asset('js/routes.js')}}" defer></script>

</x-app-layout>