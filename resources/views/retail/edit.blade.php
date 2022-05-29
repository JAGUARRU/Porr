<x-app-layout title="แก้ไขร้านค้า">
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
                แก้ไขร้านค้า
            </h4>
        </div>

            @if (session('status'))
            <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif

            <form action="{{ url('update-retail/'.$retail->retail_id) }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="col-span-1">
                        <div class="">
                            <label for="text-gray-700 dark:text-gray-400">รหัสร้านค้า</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $retail->retail_id }}" name="retail_id" placeholder="ระบุรหัสร้านค้า" />
                        </div>

                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">ชื่อร้านค้า</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $retail->retail_name }}" name="retail_name" placeholder="ระบุชื่อลูกค้า" />
                        </div>
                        
                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">ที่อยู่
                                <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" value="{{ $retail->retail_address }}" name="retail_address" placeholder="รายละเอียดที่อยู่"></textarea>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">อำเภอ
                                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" value="{{ $retail->retail_district }}" name="retail_district" >
                                    <option name="retail_district" value="">- เลือก -</option>
                                    <option name="retail_district" value="{{ $retail->retail_district }}">อำเภอเมือง</option>
                                    <option name="retail_district" value="{{ $retail->retail_district }}">อำเภอวังทอง</option>
                                    <option name="retail_district" value="{{ $retail->retail_district }}">อำเภอพรหมพิราม</option>
                                    <option name="retail_district" value="{{ $retail->retail_district }}">อำเภอบางระกำ</option>
                                    <option name="retail_district" value="{{ $retail->retail_district }}">อำเภอบางกระทุ่ม</option>
                                    <option name="retail_district" value="{{ $retail->retail_district }}">อำเภอนครไทย</option>
                                    <option name="retail_district" value="{{ $retail->retail_district }}">อำเภอวัดโบสถ์</option>
                                    <option name="retail_district" value="{{ $retail->retail_district }}">อำเภอชาติตระการ</option>
                                    <option name="retail_district" value="{{ $retail->retail_district }}">อำเภอเนินมะปราง</option>
                                </select>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">ตำบล
                                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" value="{{ $retail->retail_sub_district }}" name="retail_sub_district">
                                    <option name="retail_sub_district" value="">- เลือก -</option>
                                    <option name="retail_sub_district" value="ท่าทอง">ท่าทอง</option>
                                </select>
                            </label>
                        </div>
                    </div>
                

                    <div class="col-span-1">
                        <div class="">
                            <label for="text-gray-700 dark:text-gray-400">รหัสไปรษณีย์</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $retail->retail_postcode }}" name="retail_postcode"/>
                        </div> 
                        
                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">เบอร์โทรศัพท์</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $retail->retail_phone }}" name="retail_phone"/>
                        </div> 

                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">ช่องทางติดต่ออื่น</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $retail->retail_contact }}" name="retail_contact" placeholder="เช่น Line หรือ Facebook" />
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
</x-app-layout>