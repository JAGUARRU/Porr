<x-app-layout title="ออเดอร์ใหม่">
    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            ออเดอร์ใหม่
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

        <form action="{{ route('orders.store') }}" autocomplete="off" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
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
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="id" placeholder="ระบุรหัสออเดอร์" value="{{ old('id', $id) }}" />
                    </div>

                    <div class="mt-4">
                        <form autocomplete="off">
                            <div class="relative inline-block w-full">
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
                            <div class="mt-4">
                                <label for="text-gray-700 dark:text-gray-400">รหัสไปรษณีย์</label>
                                <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" id="input_zipcode" name="retail_postcode"/>
                            </div> 
                        </form>

                    </div>
                </div>

                <!--2-->
                <div class="col-span-1">

                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">สถานะ</label>
                        <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="order_status">
                            <option value="รอดำเนินการ" selected>รอดำเนินการ</option>
                            <option value="กำลังดำเนินการ">กำลังดำเนินการ</option>
                            <option value="สำเร็จแล้ว">สำเร็จแล้ว</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">วันที่สั่งซื้อ</label>
                        <input type="datetime-local" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" id="order_date" name="order_date" value="{{ \Carbon\Carbon::now()->toDateTimeString() }}"/>
                    </div> 

                    <div class="mb-4">
                        <label for="text-gray-700 dark:text-gray-400">กำหนดส่ง</label>
                        <input type="datetime-local" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" id="order_transportDate" name="order_transportDate" value="{{ \Carbon\Carbon::now()->add(1, 'day') }}"/>
                    </div> 

                    <div class="flex mt-12 place-content-end pb-4">
                        <div class="pr-6">
                            <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                สร้างออเดอร์
                            </button>
                        </div>
                        <div class="pr-4 mt-2">
                            <a href="{{ route('orders.index') }}" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded">
                                <span>ยกเลิก</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>  

        </form>  
  
    </div>
</div>


<script src="{{asset('js/orders.js')}}" defer></script>

</x-app-layout>