<x-app-layout title="จัดการข้อมูลรถ">

<form action="{{ url('trucks/'.$truck->id) }}" method="POST" class="container grid px-6 mx-auto ">
    @csrf
    @method('PUT')

    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            จัดการข้อมูลรถ
        </h2>

    <div class="container">
        <div class="flex flex-row">
            <svg class="w-6 h-6 dark:text-white" aria-hidden="true" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                </path>
            </svg>
            <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                แก้ไขข้อมูลรถ
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

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <div class="col-span-1">

                <div class="mb-4">
                    <label for="text-gray-700 dark:text-gray-400">รหัสรถ</label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="id" value="{{ $truck->id }}" />
                </div>

                <div class="mb-4">
                    <label for="text-gray-700 dark:text-gray-400">ป้ายทะเบียน</label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="plateNumber" value="{{ $truck->plateNumber }}" />
                </div>

            </div>

            <div class="col-span-1">

                <div class="mb-4">
                    <label for="text-gray-700 dark:text-gray-400">คนขับ</label>
                    <input type="hidden" class="hidden" name="user_id" id="user_id" placeholder="ชื่อหรือรหัสพนักงาน" value="{{ $truck->user_id }}" />

                    <div class="w-full inline-block">
                        
                        <div class="relative inline-block text-gray-600 focus-within:text-gray-400">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                <div id="validDriver" class="p-1 focus:outline-none focus:shadow-outline">
                                    @if($truck->user_id)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    @endif
                                </div>
                            </span>
                            <input type="search" id="auto-drivers" class="py-2 pl-10 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ป้อนรหัสพนักงานหรือชื่อพนักงาน" autocomplete="off" id="auto-drivers" value="{{ $truck->user ? $truck->user['name'] : ('') }}">
                        </div>

                        <input class="inline-block w-auto text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="emp_id" id="emp_id" value="{{ $truck->user ? $truck->user['empId'] : '' }}" disabled />
     
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-gray-700 dark:text-gray-400 col-span-2">
                        สถานะรถ
                    </label>
                </div>
                <div class="mt-4">
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                        <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="truck_status" value="1" {{ ($truck->truck_status == "พร้อมใช้งาน") ? ("checked") : ("")}} />
                        <span class="ml-2">พร้อมใช้งาน</span>
                    </label>
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                        <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="truck_status" value="0" {{ ($truck->truck_status == "ไม่พร้อมใช้งาน") ? ("checked") : ("")}} />
                        <span class="ml-2">ไม่พร้อมใช้งาน</span>
                    </label>
                </div>
            
            </div>

            </div>
        </div>    
    </div>

    <div class="container ">
        <div class="flex flex-row">
            <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                แก้ไขข้อมูลพื้นที่จัดส่ง
            </h4>
        </div>

            @if (session('status'))
            <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
           
            <div class="col-span-1"> 

                <div class="mb-4">
                    <label for="text-gray-700 dark:text-gray-400">จังหวัด</label>
                    <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_province" name="truck_province">
                        <option value="">จังหวัด</option>
                        @foreach($provinces as $item)
                        <option value="{{ $item->province }}" {{ $truck->truck_province == $item->province ? 'selected' : '' }}>{{ $item->province }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="text-gray-700 dark:text-gray-400">อำเภอ</label>
                    <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_amphoe" name="truck_district">
                        <option value="">เขต/อำเภอ</option>
                        @foreach($amphoes as $item)
                        <option value="{{ $item->amphoe }}" {{ $truck->truck_district == $item->amphoe ? 'selected' : '' }}>{{ $item->amphoe }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-span-1"> 

                <div class="mb-4">
                    <label for="text-gray-700 dark:text-gray-400">ตำบล</label>
                    <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="input_tambon" name="truck_sub_district">
                        <option value="">แขวง/ตำบล</option>
                        @foreach($tambons as $item)
                        <option value="{{ $item->tambon }}" {{ $truck->truck_sub_district == $item->tambon ? 'selected' : '' }}>{{ $item->tambon }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="text-gray-700 dark:text-gray-400">รหัสไปรษณีย์</label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" id="input_zipcode" name="truck_postcode" value="{{ $truck->truck_postcode }}" />
                </div> 
            </div>
 
            </div>

        </div>    
    </div>

    <div class="flex place-content-end pb-4">
        <div class="pr-6">
            <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                บันทึก
            </button>
        </div>
        <div class="pr-4 mt-2">
            <a href="{{ route('trucks.index') }}" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded">
                <span>ยกเลิก</span>
            </a>
        </div>
    </div>

</form>

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

<script src="{{asset('js/trucks.js')}}" defer></script>

</x-app-layout>