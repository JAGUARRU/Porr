<x-app-layout title="โหลดออเดอร์">

    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            ออเดอร์ #{{ $order->id }}
        </h2>

        @if ($errors->any())
        <div class="mb-4">
            <div class="font-medium text-red-600">เกิดข้อผิดพลาด</div>

            <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                @error('order_id')
                <li>{{ $message }}</li>
                @enderror
            </ul>
        </div>
        @endif

        <div class="w-full rounded-lg mt-4">

            <div class="px-4 py-3 mb-8 rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">

                <form action="{{ route('truckloads.store', ['order_id'=>$order->id]) }}" method="POST" class="flex flex-col my-4">
                    @csrf

                    <div class="flex mb-4">
    
                        <div class="w-full">
                            <div class="flex flex-col md:flex-row my-3">
                                <div class="w-full text-gray-700 dark:text-gray-100 flex-row">รถที่ใช้จัดส่งสินค้าในออเดอร์</div>
                                <div class="w-full">
                                    <button type="button" @click="openModal('transport-table-model')" class="flex flex-row float-none sm:float-right w-auto text-sm leading-5  transition-colors duration-150 bg-transparent hover:bg-teal-500 text-teal-700 font-semibold hover:text-white py-0 px-7 border border-teal-500 hover:border-transparent rounded bg-white">   
                                        <svg class="w-4 h-4" aria-hidden="true" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                        </path>
                                    </svg>
                                    <span>เลือกจากตาราง</span>
                                    </button>       
                                </div>
                            </div>
        
                            <div class="mb-4">
                                <input type="hidden" class="hidden" name="truck_id" id="truck_id" value="{{ old('truck_id') }}" />
                                <input type="hidden" class="hidden" name="truck_driver" value="{{ old('truck_driver') }}" />
                                <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="truck_plateNumber" value="{{ old('truck_plateNumber') }}" id="auto-trucks" placeholder="เลือกจากชื่อคนขับหรือป้ายทะเบียน"/>
                                @error('truck_id')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @else
                                    @error('truck_driver')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    
                                    @error('truck_plateNumber')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                @enderror
                            </div>

                            <div class="my-8">
                            
                                <div class="mb-4">
                                    <div class="w-full text-gray-700 dark:text-gray-100 flex-row">เลือกรอบที่ต้องการจัดส่ง</div>
                                    <table class="w-full overflow-x-auto p-2 mb-4" id="routeTable">
                                        <thead>
                                            <tr
                                                class="font-normal text-md tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                                <th class="px-4 py-3"></th>
                                                <th class="px-4 py-3">พื้นที่จัดส่ง</th>
                                                <th class="px-4 py-3">กำหนดส่ง</th>
                                                <th class="px-4 py-3">สถานะ</th>
                                                <th class="px-4 py-3">หมายเหตุ</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
    
                                            <tr class="text-gray-700 dark:text-gray-400">
                                                <td colspan="5" class="px-4 py-3">
                                                    เลือกรถเพื่อแสดงรายละเอียดเพิ่มเติม...
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
    
                                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-4">
                                        <input type="radio" class="w-4 h-4 form-radio text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="route_id" value="0" checked />
                                        <span class="ml-2">สร้างรอบส่งออเดอร์ใหม่</span>
                                    </label>
    
                                </div>
                                
                                <div class="flex mt-12 sm:place-content-end pb-4">
                                    <div class="pr-6">
                                        <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            โหลดออเดอร์เข้ารถ
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
 
                    
                </form>
            </div>
        </div>

        <div class="w-full rounded-lg mt-4">
            <div class="flex flex-col my-4">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-100 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 w-full text-left text-sm">
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            รหัสออเดอร์
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            {{ $order->id }}
                                            <input type="hidden" class="hidden" id="order_id" value="{{ $order->id }}" />
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            ร้านค้า
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            {{ $order->retail->retail_name }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            ติดต่อ
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            <div class="flex-col">
                                                <span class="flex">เบอร์โทรศัพท์: {{ $order->retail->retail_phone ? $order->retail->retail_phone : '-' }}</span>
                                                <span class="flex">ช่องทางติดต่ออื่น: {{ $order->retail->retail_contact ? $order->retail->retail_contact : '-' }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            ที่อยู่
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" readonly>{{ $order->retail_address }} ตำบล{{ $order->retail_sub_district }} อำเภอ{{ $order->retail_district }} จังหวัด{{ $order->retail_province }} {{ $order->retail_postcode }}</textarea><br>
                                            <input type="hidden" class="hidden" id="input_amphoe" value="{{ $order->retail_district }}" />
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            สถานะ
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            <span @class([
                                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                'bg-green-100 text-green-800' => $order->order_status == "สำเร็จแล้ว",
                                                'bg-yellow-100 text-green-800' => $order->order_status == "กำลังดำเนินการ",
                                                'bg-red-500 text-gray-100' => $order->order_status == "รอดำเนินการ"
                                            ])>
                                                {{ $order->order_status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            วันที่สั่งซื้อ
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->order_date )->thaidate('j F Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            กำหนดส่ง
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            @if($order->order_transportDate)
                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->order_transportDate )->thaidate('j F Y') }} ({{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Helper::DateTimeStringToEndOfDay($order->order_transportDate))->diffForHumans() }})
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="w-full rounded-lg mt-4">
            <div class="flex flex-col my-4">

                    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        รายการสินค้า
                    </h2>

                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="font-semibold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">รหัสสินค้า</th>
                                <th class="px-4 py-3">ชื่อสินค้า</th>
                                <th class="px-4 py-3 text-right">ราคา</th>
                                <th class="px-4 py-3 text-right">จำนวน</th>
                                <th class="px-4 py-3 text-right">รวม</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                            @if (count($order->products) == 0)
                            <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                                <td colspan="6" class="px-4 py-3">
                                    ยังไม่มีข้อมูลรายการสินค้า...
                                </td>
                            </tr>
                            @else

                            @foreach ($order->products as $product)
                            <tr class="text-gray-700 dark:text-gray-400 text-center">
                                <td class="px-4 py-3">
                                {{ $product->product_id }}
                                </td>
                                <td class="px-4 py-3">
                                {{ $product->product_name }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ number_format((float)$product->price, 2, '.', '') }}฿
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $product->qty }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ number_format((float)$product->total, 2, '.', '') }}฿
                                </td>
                            </tr>
                            @endforeach

                            <tr class="text-gray-200 dark:text-gray-700 dark:bg-gray-200 bg-gray-700 text-right">
                                <td colspan="4" class="px-4 py-3 text-right">
                                    รวมทั้งสิ้น
                                </td>
                                <td class="px-4 py-3">
                                    {{ number_format((float)$order->order_total, 2, '.', '') }}฿
                                </td>
                            </tr>
                            
                            @endif

                        </tbody>
                    </table>
                    <div>
                        <span id="orderItems" class="flex justify-end py-6 text-green-600 transition-opacity ease-in duration-700 opacity-0">รายการสินค้าได้รับการอัปเดตแล้ว</span>
                    </div>
            </div>
        </div>
   
 
    </div>

    <div x-show="isModalOpen" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" @click.away="closeModal" @keydown.escape="closeModal" role="dialog" id="transport-table-model">
        <div class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-7xl">
            
            <header class="flex justify-end">
                <button type="button" class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" type="button" @click="closeModal">
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
                            <th class="px-4 py-3">กำหนดส่ง</th>
                            <th class="px-4 py-3">สถานะ</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                      
        
                        @if (count($trucks) == 0)
                        <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                            <td colspan="7" class="px-4 py-3">
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
                                @if($truck->transportDate)
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $truck->transportDate )->thaidate('j F Y') }}
                                @else
                                -
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                @if($truck->transportDate)
                                {{ Helper::GetRouteStatus($truck->route_status) }} กำหนดส่ง ({{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Helper::DateTimeStringToEndOfDay($truck->transportDate))->diffForHumans() }})
                                @else
                                {{$truck->routes_count == 0 ? $truck->truck_status : Helper::GetRouteStatus($truck->route_status) }}
                                @endif
                            </td>

                            <td class="px-4 py-3 flex-row">

                                @php
                                    $diffDays = now()->diffInDays(Carbon\Carbon::parse($truck->transportDate), false);

                                    $transportDiff = 0;

                                    if ($truck->transportDate && $order->order_transportDate)
                                        $transportDiff = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Helper::DateTimeStringToEndOfDay($truck->transportDate))->diffInDays(Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->order_transportDate), false);

                                    $match_district = $truck->truck_district == $order->retail_district;
                                    $match_date = (
                                        (!$truck->transportDate && !$order->order_transportDate) ||  // ไม่กำหนดวันส่งเหมือนกัน
                                        ($diffDays > 0 && !$order->order_transportDate)  // ออเดอร์ไม่กำหนดวันส่ง และยังไม่ถึงวันจัดส่ง
                                    );
                                    
                                @endphp

                                <ul class="text-sm list-disc list-inside">
                                    @if($match_district)
                                        <li>พื้นที่จัดส่งอำเภอ{{ $order->retail_district}} <span class="text-green-500">ตรงกัน</span></li>
                                    @else
                                        <li>พื้นที่จัดส่งของรถ <span class="text-yellow-500">ไม่ตรงกัน</span> กับที่อยู่ของร้านค้า</li>
                                    @endif

                                    @if($transportDiff != 0)
                                        <li>
                                            @if($transportDiff > 0)
                                                ต้องเลื่อนนัดส่งสินค้า <span class="text-yellow-500">เร็วขึ้น {{ abs($transportDiff)}} วัน</span>
                                                @else
                                                ต้องเลื่อนนัดส่งสินค้า <span class="text-orange-500">ช้าลง {{ abs($transportDiff)}} วัน</span>
                                            @endif
                                        </li>
                                    @endif

                                    @if($truck->transportDate && $order->order_transportDate && Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $truck->transportDate)->diffInDays(Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->order_transportDate), false) == 0)
                                        <li>กำหนดส่งและวันส่งสินค้า <span class="text-green-500">ตรงกัน</span></li>
                                    @endif
                                </ul>
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