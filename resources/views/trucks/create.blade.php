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

        <form action="{{ url('add-trcuk') }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <div class="col-span-1">
                <div class="">
                    <label for="text-gray-700 dark:text-gray-400">รหัสรถ</label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ระบุรหัสพนักงาน" />
                </div>

                <div class="mt-3">
                    <label for="text-gray-700 dark:text-gray-400">คนขับ</label><!--ดึงชื่อ-สกุลจากตารางพนง.-->
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ระบุชื่อพนักงาน" />
                </div>

                <div class="mt-4">
                    <label for="text-gray-700 dark:text-gray-400">เส้นทางรถ

                        <div class="flex place-content-end">
                            <button  @click="openModal" class="flex items-center justify-between px-5 py-1 text-sm font-medium leading-5  transition-colors duration-150 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-0 px-7 border border-blue-500 hover:border-transparent rounded">   
                                <svg class="h-4 w-4 mr-2"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
                                    <path stroke="none" d="M0 0h24v24H0z"/>  
                                        <circle cx="12" cy="12" r="9" /> 
                                        <line x1="9" y1="12" x2="15" y2="12" />  
                                        <line x1="12" y1="9" x2="12" y2="15" />
                                </svg>
                                <span>เพิ่มเส้นทางรถ</span>
                            </button>
                        </div>

                        <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <option value="">- เลือก -</option>
                            <option>เส้นทางที่ 1</option>
                            <option>เส้นทางที่ 2</option>
                            <option>เส้นทางที่ 3</option>
                            <option>เส้นทางที่ 4</option>
                        </select>
                    </label>
                </div>

                <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
                    <!-- Modal -->
                    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal">
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
                            <!-- Modal title -->
                            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                                เพิ่มเส้นทางรถ
                            </p>
                            <!-- รู้ตำบล->รู้เอำเภอ->รู้เส้นทาง -->
                            <div class="mt-4">
                                <label for="text-gray-700 dark:text-gray-400">อำเภอ
                                    <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                        <option value="">- เลือก -</option>
                                        <option>อำเภอเมือง</option>
                                        <option>อำเภอวังทอง</option>
                                        <option>อำเภอพรหมพิราม</option>
                                        <option>อำเภอบางระกำ</option>
                                        <option>อำเภอบางกระทุ่ม</option>
                                        <option>อำเภอนครไทย</option>
                                        <option>อำเภอวัดโบสถ์</option>
                                        <option>อำเภอชาติตระการ</option>
                                        <option>อำเภอเนินมะปราง</option>
                                    </select>
                                </label>
                            </div>

                          <div class="relative">
                                <label for="text-gray-700 dark:text-gray-400">วันที่ส่ง</label>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input datepicker="" datepicker-buttons="" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 datepicker-input" placeholder="Select date">
                            </div>
    
                            <div class="mt-4">
                                <label class="text-gray-700 dark:text-gray-400 col-span-2" name="truck_status">
                                    สถานะรถ
                                </label>
                            </div>
                            <div class="mt-4">
                                <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                                    <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="truck_status" value="พร้อมใช้งาน" />
                                    <span class="ml-2">พร้อมใช้งาน</span>
                                </label>
                                <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                                    <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="truck_status" value="ไม่พร้อมใช้งาน" />
                                    <span class="ml-2">ไม่พร้อมใช้งาน</span>
                                </label>
                            </div>

                        </div>
                        
                        <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                            <button @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                                Cancel
                            </button>
                            <button class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Accept
                            </button>
                        </footer>
                    </div>
                </div>

            </div>

        </div>
        </form>    
    </div>
</div>
</x-app-layout>