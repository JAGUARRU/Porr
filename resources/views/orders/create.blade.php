<x-app-layout title="ออเดอร์ใหม่">
    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            จัดการข้อมูล
        </h2>

    <div class="container">
        <div class="flex flex-row">
            <svg class="h-6 w-6 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                ออเดอร์ใหม่
            </h4>
        </div>

        <form action="{{ route('orders.store') }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf

            @if($errors->any())
                @foreach($errors->all() as $error)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mt-2 rounded relative" role="alert">
                    <strong class="font-bold">Error</strong>
                    <span class="block sm:inline">{{ $error }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
                @endforeach
            @elseif (session('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mt-2 rounded relative" role="alert">
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
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $id }}" name="order_id" placeholder="ระบุรหัสออเดอร์" value="{{ old('order_id') }}" />
                    </div>

                    <div class="mt-4">
                        <form autocomplete="off">
                            <div class="relative inline-block block w-full">
                                <label for="text-gray-700 dark:text-gray-400">ร้านค้า</label>
                                <input class="block w-full mt-1 text-sm dark:border-gray-200 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="retail_name" id="auto-retails" placeholder="พิมพ์เพื่อค้นหาร้านค้าในระบบ" value="{{ old('retail_name') }}" />
                                <input type="hidden" class="hidden" name="retail_id" id="retail_id" />

                                @if ($errors->has('retail_id'))
                                    <span class="text-red-600">{{ $errors->first('retail_id') }}</span>
                                @endif
                                
                            </div>

                            <div class="mt-4">
                                <label for="text-gray-700 dark:text-gray-400">จังหวัด</label>
                                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_province" name="retail_province">
                                    <option value="">จังหวัด</option>
                                    @foreach($provinces as $item)
                                    <option value="{{ $item->province }}">{{ $item->province }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4">
                                <label for="text-gray-700 dark:text-gray-400">อำเภอ</label>
                                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_amphoe" name="retail_district">
                                    <option value="">เขต/อำเภอ</option>
                                    @foreach($amphoes as $item)
                                    <option value="{{ $item->amphoe }}">{{ $item->amphoe }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4">
                                <label for="text-gray-700 dark:text-gray-400">ตำบล</label>
                                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_tambon" name="retail_sub_district">
                                    <option value="">แขวง/ตำบล</option>
                                    @foreach($tambons as $item)
                                    <option value="{{ $item->tambon }}">{{ $item->tambon }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label for="text-gray-700 dark:text-gray-400">รหัสไปรษณีย์</label>
                                <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" id="input_zipcode" name="retail_postcode"/>
                            </div> 
                        </form>

                    </div>
                </div>

                <!--2-->
                <div class="col-span-1">

                    <div class="">
                        <label for="text-gray-700 dark:text-gray-400">พาหนะที่ใช้ (ป้ายทะเบียน)</label>
                        <input type="hidden" class="hidden" name="truck_id" id="truck_id" value="{{ old('truck_id') }}"/>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="truck_plate" id="auto-trucks" placeholder="ป้อนชื่อคนขับหรือป้ายทะเบียนเพื่อค้นหา"/>
                    
                        @if ($errors->has('truck_id'))
                            <span class="text-red-600">{{ $errors->first('truck_id') }}</span>
                        @endif
                    </div>

                    <div class="">
                        <label for="text-gray-700 dark:text-gray-400">คนขับรถ</label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="truck_driver" value="{{ old('truck_driver') }}"/>
                        @if ($errors->has('truck_driver'))
                            <span class="text-red-600">{{ $errors->first('truck_driver') }}</span>
                        @endif
                    </div>

                    <div class="">
                        <label for="text-gray-700 dark:text-gray-400">สถานะ</label>
                        <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="order_status">
                            <option value="กำลังดำเนินการ" selected>กำลังดำเนินการ</option>
                            <option value="สำเร็จแล้ว">สำเร็จแล้ว</option>
                        </select>
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

<div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" @click.away="closeModal" @keydown.escape="closeModal" role="dialog" id="add-category-model">
    <!-- 
        สร้างไอดีไว้อ้างอิงกับ JS

        id: add-category-form / ฟอร์มที่แบกข้อมูลไว้
        model-id: add-category-model / ไว้อ้างอิงไอดีสำหรับ ปิดฟอร์มเมื่อส่งข้อมูลสำเร็จ
    -->
    <form data-action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" id="add-category-form" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
            <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                    <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </button>
        </header>
        <!-- Modal body -->
        <div class="mt-4 mb-6">
            @csrf
            <!-- Modal title -->
            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                เพิ่มประเภทสินค้า
            </p>
            <!-- Modal description -->
            <div class="mt-4">
                <label for="text-gray-700 dark:text-gray-400">รหัสประเภทสินค้า </label>
                <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="id" placeholder="ระบุรหัสประเภทสินค้า" />
            </div>
            <div class="mt-4">
                <label for="text-gray-700 dark:text-gray-400">ชื่อประเภทสินค้า </label>
                <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="name" placeholder="ระบุชื่อประเภทสินค้า" />
            </div>
        </div>
        <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
            <button type="button" @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                ปิด
            </button>
            <button type="submit" @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                เพิ่มประเภท
            </button>
        </footer>
    </form>
</div>

<script src="{{asset('js/orders.js')}}" defer></script>

</x-app-layout>