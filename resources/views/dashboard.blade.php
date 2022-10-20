<x-app-layout title="แดชบอร์ด">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            แดชบอร์ด
        </h2>

        <!-- Cards -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        พนักงานทั้งหมด
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ count(DB::table('users')->get()->toArray()) }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                      </svg>
                      
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        ออเดอร์ทั้งหมด
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ count(DB::table('orders')->get()->toArray()) }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                      </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        ออเดอร์ที่รอดำเนินการ
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ count(DB::table('orders')->where('order_status', '=', 'รอดำเนินการ')->get()->toArray()) }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                    </svg>                      
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        จำนวนร้านค้า
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ count(DB::table('retails')->get()->toArray()) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            กราฟสถิติ
        </h2>
        <div class="grid gap-12 mb-8 grid-cols-1">

                <div class="col-span-1 mx-52 min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        สถิติยอดขายประจำเดือน
                    </h4>
                    <canvas id="sales"></canvas>
                    <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                            <span>ยอดขาย</span>
                        </div>
                    </div>
                </div>
    
                <!--<div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        สถิติยอดสั่งซื้อประจำเดือน
                    </h4>
                    <canvas id="orders"></canvas>
                    <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                            <span>ยอดสั่งซื้อ</span>
                        </div>
                    </div>
                </div>-->
            </div>
    </div>

    <script src="{{asset('js/sales-bar.js')}}" defer></script>
</x-app-layout>