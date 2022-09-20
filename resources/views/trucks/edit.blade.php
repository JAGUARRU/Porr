<x-app-layout title="เพิ่มข้อมูลรถ">
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
                เพิ่มข้อมูลรถ
            </h4>
        </div>

            @if (session('status'))
            <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif

        <form action="{{ url('trucks/'.$truck->id) }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <div class="col-span-1">
                <div class="">
                    <label for="text-gray-700 dark:text-gray-400">รหัสรถ</label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="id" value="{{ $truck->id }}" />
                </div>

                <div class="mt-4">
                    <label for="text-gray-700 dark:text-gray-400">ป้ายทะเบียน</label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="plateNumber" value="{{ $truck->plateNumber }}" />
                </div>

                <div class="mt-4">
                    <label for="text-gray-700 dark:text-gray-400">คนขับ</label>
                    <input type="hidden" class="hidden" name="user_id" id="user_id" placeholder="ชื่อหรือรหัสพนักงาน" value="{{ $truck->user_id }}" />
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="emp_id" id="emp_id" value="{{ $truck->user['empId'] }}" disabled />
     
                    <div class="relative text-gray-600 focus-within:text-gray-400">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                            <div id="validDriver" class="p-1 focus:outline-none focus:shadow-outline">
                                @if($truck->user_id)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                @endif
                            </div>
                        </span>
                        <input type="search" value="{{ $truck->user['name'] }}" id="auto-drivers" class="py-2 pl-10 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ป้อนรหัสพนักงานหรือชื่อพนักงาน" autocomplete="off" id="auto-drivers">
                    </div>
                </div>
            </div>

            <div class="col-span-1"> 
                
                <div class="mt-4">
                    <label class="text-gray-700 dark:text-gray-400 col-span-2" name="truck_status">
                        สถานะรถ
                    </label>
                </div>

                <div class="mt-4">
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                        <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="status" value="พร้อมใช้งาน" {{ ($truck->status == "พร้อมใช้งาน") ? ("checked") : ("")}} />
                        <span class="ml-2">พร้อมใช้งาน</span>
                    </label>
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                        <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="status" value="ไม่พร้อมใช้งาน" {{ ($truck->status == "ไม่พร้อมใช้งาน") ? ("checked") : ("")}} />
                        <span class="ml-2">ไม่พร้อมใช้งาน</span>
                    </label>
                </div>

                <div class="flex mt-12 place-content-end pb-4">
                    <div class="pr-6">
                        <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            บันทึก
                        </button>
                    </div>
                    <div class="pr-4">
                        <button class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            ยกเลิก
                        </button>
                    </div>
                </div>
            </div>
            </div>
        </form>    
    </div>
    </div>

    <script src="{{asset('js/trucks.js')}}" defer></script>

</x-app-layout>