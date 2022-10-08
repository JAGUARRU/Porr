<x-app-layout title="กราฟสถิติ">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            กราฟสถิติ
        </h2>

        <div class="grid gap-6 mb-8 md:grid-cols-2">

            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
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

            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
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
            </div>
        </div>
    </div>

    <script src="{{asset('js/charts-lines.js')}}" defer></script>
    <script src="{{asset('js/charts-pie.js')}}" defer></script>
    <script src="{{asset('js/charts-bars.js')}}" defer></script>
    <script src="{{asset('js/sales-bar.js')}}" defer></script>
</x-app-layout>