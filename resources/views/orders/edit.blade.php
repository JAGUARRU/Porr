<x-app-layout title="จัดการข้อมูลออเดอร์">
    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            จัดการข้อมูลออเดอร์
        </h2>

        <div class="container">
            <div class="flex flex-row">
                <svg class="w-6 h-6 text-white" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                    </path>
                </svg>
                <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                    แก้ไขรายการสินค้า
                </h4>
            </div>

            <div class="mb-4">

                <table class="w-full whitespace-no-wrap" id="productOrder">
                    <thead>
                        <tr
                            class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">รหัสสินค้า</th>
                            <th class="px-4 py-3">ชื่อสินค้า</th>
                            <th class="px-4 py-3">ราคา</th>
                            <th class="px-4 py-3">จำนวน</th>
                            <th class="px-4 py-3">รวม</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    

                        @if (count($data) == 0)
                        <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                            <td colspan="6" class="px-4 py-3">
                                ยังไม่มีข้อมูลรายการสินค้า...
                            </td>
                        </tr>
                        @endif
                        
                        @foreach ($data as $product)
                        <tr class="text-gray-700 dark:text-gray-400" id="{{ $product['product_id'] }}">
                            <td class="px-4 py-3">
                            {{ $product["product_id"] }}
                            </td>
                            <td class="px-4 py-3">
                            {{ $product["product_name"] }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $product["price"] }}
                            </td>
                            <td class="px-4 py-3">
                                <input class="block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" type="number" name="editItem" data-orderId="{{ $order->id }}" id="{{ $product["product_id"] }}" value="{{ $product['qty'] }}"/>
                            </td>
                            <td class="px-4 py-3">
                                {{ $product["total"] }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <button
                                        id="removeFromOrder"
                                        data-id="{{ $order->id }}"
                                        data-productId="{{ $product["product_id"] }}"
                                        type="button"
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    </a>    
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                <div>
                    <span id="orderItems" class="flex justify-end py-6 text-green-600 transition-opacity ease-in duration-700 opacity-0">รายการสินค้าได้รับการอัปเดตแล้ว</span>
                </div>
            </div>

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">

                <form id="searchForm" method="GET" action="{{ url('orders/'.$order->id.'/edit') }}">
                    @csrf
                    <div class="grid grid-cols-4 grid-rows-1 gap-4">  
                        <div class="col-span-3">
                        </div>
                        <div class="col-span-1">
                            <div class="grid grid-rows-1 grid-cols-3 gap-2">
                                <input id="name" name="name" placeholder="ชื่อสินค้า" class="col-span-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $searchInput }}"/>                 
                                <button type="submit" class="bg-gray-700 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded">
                                    ค้นหา
                                </button>
                            </div>           
                        </div>                
                    </div>
                </form>

                <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 ">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">รหัสสินค้า</th>
                                    <th class="px-4 py-3">ชื่อสินค้า</th>
                                    <th class="px-4 py-3">ราคา</th>
                                    <th class="px-4 py-3">ประเภทสินค้า</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            
                                @foreach ($products as $product)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                    {{ $product->id}}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $product->prod_name}}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ number_format((float)$product->prod_price, 2, '.', '') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $product->prod_type_name}}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-4 text-sm">
                                            
                                            <button
                                                id="addToOrder"
                                                data-id="{{ $order->id }}"
                                                data-productId="{{ $product->id}}"
                                                data-productName="{{ $product->prod_name}}"
                                                data-productPrice="{{ $product->prod_price}}"
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                </svg>
                                                เพิ่ม
                                            </button>
    
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
                            {{ __('pagination.showing') }} {{ $products->firstItem() }}-{{ $products->lastItem() }} {{ __('pagination.of') }} {{ $products->total() }}
                        </span>
                        <span class="col-span-2"></span>
                        <!-- Pagination -->
                        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                            <nav aria-label="Table navigation">
                                <ul class="inline-flex items-center">
                                    
                                    <li>
                                        <a href="{{ $products->url( $products->currentPage() - 1 ) }}">
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
        
                                    $curPage = $products->currentPage();
                                    $totalPage = $products->lastPage();
        
                                    $startPage = ($curPage < 5)? 1 : $curPage - 4;
                                    $endPage = 8 + $startPage;
                                    $endPage = ($totalPage < $endPage) ? $totalPage : $endPage;
                                    $diff = $startPage - $endPage + 8;
                                    $startPage -= ($startPage - $diff > 0) ? $diff : 0;
        
                                    @endphp
        
                                    @if($products->total())
                                        
                                        @for ($i=$startPage; $i<=$endPage; $i++)
                                            <li>
                                                <a href="{{ $products->url($i) }}">
                                                    @php
                                                        if ($curPage != $i) echo '<button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                        else echo '<button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                    @endphp
                                                </a>
                                            </li> 
                                        @endfor
                                
                                    @endif
        
                                    <li>
                                        <a href="{{ $products->nextPageUrl() }}">
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


            </div>
    
            <div class="flex flex-row">
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                    </path>
                </svg>
                <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                    แก้ไขออเดอร์
                </h4>
            </div>
            
            <form action="{{ url('orders/'.$order->id) }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
                @csrf
                @method('PUT')

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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="col-span-1">
                        <div class="">
                            <label for="text-gray-700 dark:text-gray-400">รหัสออเดอร์</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $order->id }}" name="order_id" placeholder="ระบุรหัสออเดอร์" />
                        </div>

                        <div class="mt-4">
                            <form autocomplete="off">
                                <div class="relative inline-block block w-full">
                                    <label for="text-gray-700 dark:text-gray-400">ร้านค้า</label>
                                    <input class="block w-full mt-1 text-sm dark:border-gray-200 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="retail_name" id="auto-retails" placeholder="พิมพ์เพื่อค้นหาร้านค้าในระบบ" value="{{ $order->retail_name }}" />
                                    <input type="hidden" class="hidden" name="retail_id" id="retail_id" value="{{ $order->retail_id }}" />
                                    <!--<div id="autocomplete-list" class="absolute border-l-2 border-r-2 border-gray-200 z-50 inset-x-0 top-full">
                                        <div class="autocomplete-items p-1 bg-white hover:bg-gray-200 cursor-pointer border-b border-gray-200"><strong>Sh</strong>op 1</div>
                                        <div class="autocomplete-items p-1 bg-white hover:bg-gray-200 cursor-pointer border-b border-gray-200">Shop 2</div>
                                    </div>-->
                                </div>

                                <div class="mt-4">
                                    <label for="text-gray-700 dark:text-gray-400">จังหวัด</label>
                                    <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_province" name="retail_province">
                                        <option value="">จังหวัด</option>
                                        @foreach($provinces as $item)
                                        <option value="{{ $item->province }}" {{ $order->retail_province == $item->province ? 'selected' : '' }}>{{ $item->province }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <label for="text-gray-700 dark:text-gray-400">อำเภอ</label>
                                    <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_amphoe" name="retail_district">
                                        <option value="">เขต/อำเภอ</option>
                                        @foreach($amphoes as $item)
                                        <option value="{{ $item->amphoe }}" {{ $order->retail_district == $item->amphoe ? 'selected' : '' }}>{{ $item->amphoe }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <label for="text-gray-700 dark:text-gray-400">ตำบล</label>
                                    <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_tambon" name="retail_sub_district">
                                        <option value="">แขวง/ตำบล</option>
                                        @foreach($tambons as $item)
                                        <option value="{{ $item->tambon }}" {{ $order->retail_sub_district == $item->tambon ? 'selected' : '' }}>{{ $item->tambon }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <label for="text-gray-700 dark:text-gray-400">รหัสไปรษณีย์</label>
                                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" id="input_zipcode" name="retail_postcode" value="{{ $order->retail_postcode }}"/>
                                </div> 
                            </form>

                        </div>
                    </div>

                    <!--2-->
                    <div class="col-span-1">

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">สถานะ</label>
                            <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="order_status" value="{{ $order->order_status }}">
                                <option value="รอดำเนินการ" {{ ($order->order_status == "รอดำเนินการ") ? ("selected") : ("")}}>รอดำเนินการ</option>
                                <option value="กำลังดำเนินการ" {{ ($order->order_status == "กำลังดำเนินการ") ? ("selected") : ("")}}>กำลังดำเนินการ</option>
                                <option value="สำเร็จแล้ว" {{ ($order->order_status == "สำเร็จแล้ว") ? ("selected") : ("")}}>สำเร็จแล้ว</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">วันที่สั่งซื้อ</label>
                            <input type="datetime-local" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" id="order_date" name="order_date" value="{{ $order->order_date }}"/>
                        </div> 

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">กำหนดส่ง</label>
                            <input type="datetime-local" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" id="order_transportDate" name="order_transportDate" value="{{ old('order_transportDate', $order->order_transportDate) }}"/>
                        </div> 

                        <div class="flex mt-12 place-content-end pb-4">
                            <div class="pr-6">
                                <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    บันทึก
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
    <script src="{{asset('js/orders.js')}}" defer></script>

</x-app-layout>