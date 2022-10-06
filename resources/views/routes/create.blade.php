<x-app-layout title="ออเดอร์ใหม่">
    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            ข้อมูลออเดอร์
        </h2>

    <div class="container">

        <form action="{{ route('routes.store') }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
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
            
            <!--1-->
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
                        <span class="block font-normal" id="input_amphoe">
                            {{ $order->retail_district }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">รหัสไปรษณีย์</label>
                        <span class="block font-normal">
                            {{ $order->retail_postcode }}
                        </span>
                    </div> 

                </div>
            </div>  
           
            <div class="mb-4">

                <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                    รายการสินค้า
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
                    ประวัติการส่ง
                </h4>

                <table class="w-full whitespace-no-wrap" id="routeProduct">
                    <thead>
                        <tr
                            class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">อัปเดตเมื่อ</th>
                            <th class="px-4 py-3">คนขับรถ</th>
                            <th class="px-4 py-3">รหัสสินค้า</th>
                            <th class="px-4 py-3">จำนวน</th>
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
                            @foreach ($routes->route as $route)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">{{ $routes["id"] }}</td>
                                <td class="px-4 py-3">{{ $routes["updated_at"] }}</td>
                                <td class="px-4 py-3">{{ $routes["truck_driver"] }} ({{ $routes["truck_plate"] }})</td>
                                <td class="px-4 py-3">{{ $route["product_id"] }}</td>
                                <td class="px-4 py-3">{{ $route["qty"] }}</td>
                            </tr>
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

                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">พาหนะที่ใช้ (ป้ายทะเบียน)</label>
                        <input type="hidden" class="hidden" name="truck_id" id="truck_id" value="{{ old('truck_id') }}" />
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="truck_plate" value="{{ old('truck_plate') }}" id="auto-trucks" placeholder="ป้อนชื่อคนขับหรือป้ายทะเบียนเพื่อค้นหา"/>
                    </div>
    
                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">คนขับรถ</label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="truck_driver" value="{{ old('truck_driver') }}" placeholder=""/>
                    </div>

                </div>

                <div class="col-span-1">
                    
                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">รายการสินค้ารอส่ง</label>
                       
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

                    <div class="flex mt-12 place-content-end pb-4">
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
        </form>  
        
    </div>
</div>

<script src="{{asset('js/routes.js')}}" defer></script>

</x-app-layout>