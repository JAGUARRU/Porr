<x-app-layout title="รายละเอียดออเดอร์">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            รายละเอียดออเดอร์
        </h2>
    </x-slot>

    <div class="container mx-auto">

        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            รายละเอียดออเดอร์
        </h2>
        
        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex">
                <a href="{{ route('orders.index') }}" class="flex items-center justify-between px-6 py-3 text-sm leading-5 mx-2 transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-lg">
                    <span class="text-base">กลับหน้าแรก</span>
                </a>

                <a href="{{ url('orders/'.$order->id.'/edit') }}" class="flex items-center justify-between px-6 py-3 text-sm leading-5 mx-2  transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-lg">
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
                                        รหัสออเดอร์
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $order->id }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        ที่อยู่
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" readonly>{{ $order->retail_address }} ตำบล{{ $order->retail_sub_district }} อำเภอ{{ $order->retail_district }} จังหวัด{{ $order->retail_province }} {{ $order->retail_postcode }}</textarea><br>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        สถานะ
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $order->order_status }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        วันที่สั่งซื้อ
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        <!-- \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->order_date)->thaidate('j F Y \เ\ว\ล\า H:i \น\า\ฬิ\ก\า') -->

                                        {{ $order->order_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        วันที่สร้าง
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $order->created_at }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col mt-4">

                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    รายการสินค้า
                </h2>

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

                        @if (count($order->products) == 0)
                        <tr class="text-gray-700 dark:text-gray-400" id="no-data">
                            <td colspan="6" class="px-4 py-3">
                                ยังไม่มีข้อมูลรายการสินค้า...
                            </td>
                        </tr>
                        @endif
                        
                        @foreach ($order->products as $product)
                        <tr class="text-gray-700 dark:text-gray-400" id="{{ $product['product_id'] }}">
                            <td class="px-4 py-3">
                               {{ $product["product_id"] }}
                            </td>
                            <td class="px-4 py-3">
                               {{ $product["product_name"] }}
                            </td>
                            <td class="px-4 py-3">
                                {{ number_format((float)$product["price"], 2, '.', '') }}฿
                             </td>
                            <td class="px-4 py-3">
                                {{ $product["qty"] }}
                             </td>
                             <td class="px-4 py-3">
                                {{ number_format((float)$product["total"], 2, '.', '') }}฿
                             </td>
                        </tr>
                        @endforeach

                        <tr class="text-gray-700 dark:text-gray-400">
                            <td colspan="4" class="px-4 py-3 text-right">
                                รวมทั้งสิ้น
                             </td>
                             <td class="px-4 py-3">
                                {{ number_format((float)$order->order_total, 2, '.', '') }}฿
                             </td>
                        </tr>

                    </tbody>
                </table>
                <div>
                    <span id="orderItems" class="flex justify-end py-6 text-green-600 transition-opacity ease-in duration-700 opacity-0">รายการสินค้าได้รับการอัปเดตแล้ว</span>
                </div>
            </div>
            
            <div class="flex flex-col mt-4">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    รายการจัดส่งสินค้า
                </h2>

                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @if (!count($order->routes))
                        ยังไม่มีข้อมูลการจัดส่งสินค้า...
                    @endif
                    @foreach ($order->routes as $route)
                    <div class="accordion-item border-t-0 border-l-0 border-r-0 rounded-none bg-white border border-gray-200">
                      <h2 class="accordion-header mb-0" id="flush-headingOne">
                        <button class="accordion-button
                            relative
                            flex
                            items-center
                            w-full
                            py-4
                            px-5
                            text-base text-gray-800 text-left
                            bg-white
                            border-0
                            rounded-none
                            transition
                            focus:outline-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                          aria-expanded="false" aria-controls="flush-collapseOne">
                          {{ $route->created_at }} #{{ $route->id }}
                        </button>
                      </h2>
                      <div id="flush-collapseOne" class="accordion-collapse border-0 collapse show"
                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body py-4 px-5">

                            <table class="min-w-full divide-y divide-gray-200 w-full text-left text-sm">
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        ป้ายทะเบียน
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        <span class="px-2">
                                            {{ $route->truck()->get()->first()->plateNumber }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        สถานะ
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        @if ($route->status)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            ได้รับการยืนยันแล้ว
                                        </span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-red-800">
                                            รอการยืนยัน
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        รายการสินค้า
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        <table class="w-full whitespace-no-wrap">
                                            <thead>
                                                <tr
                                                    class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                                    <th class="px-4 py-3">รหัสสินค้า</th>
                                                    <th class="px-4 py-3">จำนวน</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                                                @foreach ($route->lists()->get() as $list)
                                                <tr class="text-gray-700 dark:text-gray-400">
                                                    <td class="px-4 py-3">
                                                       {{ $list->product_id }}
                                                    </td>
                                                    <td class="px-4 py-3">
                                                       {{ $list->qty }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
            </div>
        </div>
    </div>

</x-app-layout>
