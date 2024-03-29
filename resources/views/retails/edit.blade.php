<x-app-layout title="แก้ไขร้านค้า">
    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            
        </h2>
        
    <div class="container">
        <div class="flex flex-row">
            <svg class="h-6 w-6 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                แก้ไขข้อมูลร้านค้า
            </h4>
        </div>

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

            <form action="{{ url('retails/'.$retail->id) }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="col-span-1">
                        <div class="">
                            <label for="text-gray-700 dark:text-gray-400">รหัสร้านค้า</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ old('id', $retail->id) }}" name="id" placeholder="ระบุรหัสร้านค้า" />
                        </div>

                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">ชื่อร้านค้า / เจ้าของกิจการ</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ old('retail_name', $retail->retail_name) }}" name="retail_name" placeholder="ระบุชื่อลูกค้า" />
                        </div>
                        
                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">ที่อยู่
                                <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" name="retail_address" placeholder="รายละเอียดที่อยู่">{{ $retail->retail_address }}</textarea>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">จังหวัด</label>
                            <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_province" value="{{ $retail->retail_province }}" name="retail_province">
                                <option value="">กรุณาเลือกจังหวัด</option>
                                @foreach($provinces as $item)
                                <option value="{{ $item->province }}" {{ $retail->retail_province == $item->province ? 'selected' : '' }}>{{ $item->province }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">อำเภอ</label>
                            <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_amphoe" value="{{ $retail->retail_district }}" name="retail_district">
                                <option value="">กรุณาเลือกเขต/อำเภอ</option>
                                @foreach($amphoes as $item)
                                <option value="{{ $item->amphoe }}" {{ $retail->retail_district == $item->amphoe ? 'selected' : '' }}>{{ $item->amphoe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="text-gray-700 dark:text-gray-400">ตำบล</label>
                            <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_tambon" value="{{ $retail->retail_sub_district }}" name="retail_sub_district">
                                <option value="">กรุณาเลือกแขวง/ตำบล</option>
                                @foreach($tambons as $item)
                                <option value="{{ $item->tambon }}" {{ $retail->retail_sub_district == $item->tambon ? 'selected' : '' }}>{{ $item->tambon }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                

                    <div class="col-span-1">
                        <div class="">
                            <label for="text-gray-700 dark:text-gray-400">รหัสไปรษณีย์</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $retail->retail_postcode }}" id="input_zipcode" name="retail_postcode"/>
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

    <script>   
        function showAmphoes() {
            let input_province = document.querySelector("#input_province");
            let url = "{{ url('/api/amphoes') }}?province=" + input_province.value;
            console.log(url);
            // if(input_province.value == "") return;
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    //UPDATE SELECT OPTION
                    let input_amphoe = document.querySelector("#input_amphoe");
                    input_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ</option>';
                    for (let item of result) {
                        let option = document.createElement("option");
                        option.text = item.amphoe;
                        option.value = item.amphoe;
                        input_amphoe.appendChild(option);
                    }
                    //QUERY AMPHOES
                    showTambons();
                });
        }
    function showTambons() {
            let input_province = document.querySelector("#input_province");
            let input_amphoe = document.querySelector("#input_amphoe");
            let url = "{{ url('/api/tambons') }}?province=" + input_province.value + "&amphoe=" + input_amphoe.value;
            console.log(url);        
            // if(input_province.value == "") return;        
            // if(input_amphoe.value == "") return;
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    //UPDATE SELECT OPTION
                    let input_tambon = document.querySelector("#input_tambon");
                    input_tambon.innerHTML = '<option value="">กรุณาเลือกแขวง/ตำบล</option>';
                    for (let item of result) {
                        let option = document.createElement("option");
                        option.text = item.tambon;
                        option.value = item.tambon;
                        input_tambon.appendChild(option);
                    }
                    //QUERY AMPHOES
                    showZipcode();
                });
        }
    function showZipcode() {
            let input_province = document.querySelector("#input_province");
            let input_amphoe = document.querySelector("#input_amphoe");
            let input_tambon = document.querySelector("#input_tambon");
            let url = "{{ url('/api/zipcodes') }}?province=" + input_province.value + "&amphoe=" + input_amphoe.value + "&tambon=" + input_tambon.value;
            console.log(url);        
            // if(input_province.value == "") return;        
            // if(input_amphoe.value == "") return;     
            // if(input_tambon.value == "") return;
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    //UPDATE SELECT OPTION
                    let input_zipcode = document.querySelector("#input_zipcode");
                    input_zipcode.value = "";
                    for (let item of result) {
                        input_zipcode.value = item.zipcode;
                        break;
                    }
                });
    }
    //EVENTS
        document.querySelector('#input_province').addEventListener('change', (event) => {
            showAmphoes();
        });
        document.querySelector('#input_amphoe').addEventListener('change', (event) => {
            showTambons();
        });
        document.querySelector('#input_tambon').addEventListener('change', (event) => {
            showZipcode();
        });
    </script>

</x-app-layout>