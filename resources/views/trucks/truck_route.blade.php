<x-app-layout title="">
    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            จัดการข้อมูล
        </h2>

    <div class="container ">
        <div class="flex flex-row">
            <svg class="h-6 w-6 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                เพิ่มเส้นทางรถ
            </h4>
        </div>

        
        <form action="{{ url('') }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <div class="col-span-1">
                    <div class="">
                       
                    </div>
    
                    <div class="">
                        <label class="block text-base">
                            <span class="text-gray-700 dark:text-gray-400">
                                เพิ่มเส้นทาง
                            </span>
                            <div class="relative text-gray-500 focus-within:text-purple-600">
                                <input class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" placeholder="" />
                                <button class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    เพิ่ม
                                </button>
                            </div>
                        </label>
                    </div>
                </div>
            

                <div class="col-span-1">
                    <div class="">
                        <label for="text-gray-700 dark:text-gray-400">เส้นทาง
                            <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <option value="">- เลือก -</option>
                                <option>เส้นทางที่ 1</option>
                                <option>เส้นทางที่ 2</option>
                            </select>
                        </label>
                    </div>
                </div>
            </div>
        </form>

    </div>
    </div>
</x-app-layout>