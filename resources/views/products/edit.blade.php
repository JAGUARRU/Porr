<x-app-layout title="แก้ไขสินค้า">
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
                แก้ไขสินค้า
            </h4>
        </div>

        <form action="{{ url('products/'.$product->id) }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf
            @method('PUT')


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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <div class="col-span-1">
                    <div class="">
                        <label for="text-gray-700 dark:text-gray-400">รหัสสินค้า </label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $product->id }}" name="id" placeholder="ระบุรหัสสินค้า" />
                    </div>

                    <div class="mt-4">
                        <label for="text-gray-700 dark:text-gray-400">ชื่อสินค้า</label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $product->prod_name }}" name="prod_name" placeholder="ระบุชื่อสินค้า" />
                    </div>

                    <!--<div class="mt-4">
                        <label class="text-gray-700 dark:text-gray-400 col-span-2">
                            ประเภทสินค้า
                        </label>
                    </div>
                    <div class="mt-1">
                        <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                            <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="accountType" value="แท่ง" />
                            <span class="ml-2">แท่ง</span>
                        </label>
                        <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                            <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="accountType" value="แท่ง" />
                            <span class="ml-2">ถ้วย</span>
                        </label>
                    </div>-->

                    <div class="mt-4">
                        <label for="text-gray-700 dark:text-gray-400">ประเภทสินค้า

                            
                            <select id="productCategory" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="prod_type_name">
                                <option value="">- เลือก -</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ $product->prod_type_name == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>          

                            
                        </label>
                    </div>

                    <div class="mt-4">
                        <label for="text-gray-700 dark:text-gray-400">ราคา</label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $product->prod_price }}" name="prod_price"/>
                    </div>

                </div>


                <div class="col-span-1">
                    <div class="">
                        <label for="text-gray-700 dark:text-gray-400">รายละเอียดสินค้า
                            <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="prod_detail" rows="3" placeholder="รายละเอียดสินค้า">{{ $product->prod_detail }}</textarea>
                        </label>
                    </div>

                    <div class="mt-4">
                        <label for="text-gray-700 dark:text-gray-400">สต๊อก</label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ $product->stock }}" name="stock" placeholder="สต๊อก"/>
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

</x-app-layout>