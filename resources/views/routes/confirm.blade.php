<x-app-layout title="ออเดอร์ใหม่">
    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            ข้อมูลออเดอร์
        </h2>

    <div class="container">

        <form action="{{ url('routes/confirmRoute') }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
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
                        <input type="hidden" class="hidden" name="order_id" id="order_id" value="{{ $orderRoute->id }}" />
                        <span class="block font-normal">
                            {{ $orderRoute->order->id }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">จังหวัด</label>
                        <span class="block font-normal">
                            {{ $orderRoute->order->retail_province }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">ตำบล</label>
                        <span class="block font-normal">
                            {{ $orderRoute->order->retail_sub_district }}
                        </span>
                    </div>
                    
                </div>

                <!--2-->
                <div class="col-span-1">

                    <div class="mb-4">
                        <div class="relative block w-full">
                            <label for="text-gray-700 dark:text-gray-400">ร้านค้า</label>
                            <span class="block font-normal">
                                {{ $orderRoute->order->retail_name }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">อำเภอ</label>
                        <span class="block font-normal" id="input_amphoe">
                            {{ $orderRoute->order->retail_district }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">รหัสไปรษณีย์</label>
                        <span class="block font-normal">
                            {{ $orderRoute->order->retail_postcode }}
                        </span>
                    </div> 

                </div>
            </div>  
           
            <div class="mb-4">

                <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                    รายการสินค้า
                </h4>

                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">รหัสสินค้า</th>
                            <th class="px-4 py-3">ชื่อสินค้า</th>
                            <th class="px-4 py-3">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                      

                        @if (count($orderRoute->order->products) == 0)
                        <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                            <td colspan="6" class="px-4 py-3">
                                ยังไม่มีข้อมูลรายการสินค้า...
                            </td>
                        </tr>
                        @endif
                        
                        @foreach ($orderRoute->order->products as $product)
                        <tr class="text-gray-700 dark:text-gray-400" id="{{ $product['product_id'] }}">
                            <td class="px-4 py-3">{{ $product["product_id"] }}</td>
                            <td class="px-4 py-3">{{ $product["product_name"] }}</td>
                            <td class="px-4 py-3">{{ $product["qty"] }}</td>
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
                    การยืนยันจำนวนสินค้า
                </h4>

                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">รหัสสินค้า</th>
                            <th class="px-4 py-3">จำนวน</th>
                            <th class="px-4 py-3">จำนวน (ยืนยัน)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                      

                        @if (count($orderRoute->lists) == 0)
                        <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                            <td colspan="6" class="px-4 py-3">
                                ยังไม่มีข้อมูลรายการสินค้า...
                            </td>
                        </tr>
                        @endif
                        
                        @foreach ($orderRoute->lists as $route)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">{{ $route["product_id"] }}<input class="hidden" type="hidden" name="products[]" value="{{ $route["product_id"] }}" /></td>
                                <td class="px-4 py-3">{{ $route["qty"] }}<input class="hidden" type="hidden" name="qty[]" value="{{ $route["qty"] }}" /></td>
                                <td class="px-4 py-3"><input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" type="number" name="changes[]" min="0" max="{{ $route["qty"] }}" value="{{ $route["qty"] }}" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    <span id="orderItems" class="flex justify-end py-6 text-green-600 transition-opacity ease-in duration-700 opacity-0">รายการสินค้าได้รับการอัปเดตแล้ว</span>
                </div>
            </div>

            <div class="mb-4">
                    <div class="flex mt-12 place-content-end pb-4">
                        <div class="pr-6">
                            <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                ยืนยัน
                            </button>
                        </div>
                        <div class="pr-4">
                            <button class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                กลับ
                            </button>
                        </div>
                    </div>
            </div>
        </form>  
        
    </div>
</div>

</x-app-layout>