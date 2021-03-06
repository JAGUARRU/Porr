<x-app-layout title="พนักงาน">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            ข้อมูลพนักงาน
        </h2>

            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="flex place-content-end">
                <a href="{{'add-employee'}}">
                <button class="flex items-center justify-between px-6 py-3 text-sm font-medium leading-5  transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 py-0 px-7 border border-blue-500 hover:border-transparent rounded-full">   
                    <svg class="h-5 w-5 mr-2"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
                        <path stroke="none" d="M0 0h24v24H0z"/>  
                            <circle cx="12" cy="12" r="9" /> 
                            <line x1="9" y1="12" x2="15" y2="12" />  
                            <line x1="12" y1="9" x2="12" y2="15" />
                    </svg>
                    <span class="text-base">เพิ่มพนักงาน</span>
                </button>
                </a>
            </div>

            @if (session('success'))
                <h6 class="alert alert-success">{{ session('success') }}</h6>
            @endif


            <!-- With actions -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 ">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">รหัสพนักงาน</th>
                                <th class="px-4 py-3">ชื่อผู้ใช้</th>
                                <th class="px-4 py-3">ชื่อพนักงาน</th>
                                <th calss="px-4 py-3">นามสกุล</th>
                                <th class="px-4 py-3">ตำแหน่ง</th>
                                <th class="px-4 py-3">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                            @foreach ($employees as $employee)

                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                   {{$employee->emp_id}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{$employee->username}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{$employee->emp_firstname}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{$employee->emp_lastname}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{$employee->position}}
                                    @php
                                    if ($employee->position == 'Driver' && $employee->truck)
                                    {
                                        echo '('.$employee->truck->plateNumber.')';
                                    }
                                    @endphp
                                </td>
                                

                                <!--<div class="mt-4 mb-6">
                                    
                                    <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                                        รีเซ็ทรหัสผ่าน
                                    </p>
                                    
                                    <div class="mt-4">
                                        <label for="text-gray-700 dark:text-gray-400">ชื่อผู้ใช้ </label>
                                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ระบุชื่อผู้ใช้" />
                                    </div>
                                    <div class="mt-4">
                                        <label for="text-gray-700 dark:text-gray-400">รหัสผ่าน </label>
                                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ระบุรหัสผ่าน" />
                                    </div>
                                    
                                    <div class="mt-4">
                                    <label class="text-gray-700 dark:text-gray-400 col-span-2">
                                        สถานะใช้งาน
                                    </label>
                                    </div>
                                </div>-->

                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <button
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                            <a href="{{ url('edit-employee/'.$employee->emp_id) }}" class="btn btn-primary btn-sm">Edit</a>      
                                        </button>
                                        
                                        <form action="{{ route('delete-employee.destroy', $employee->emp_id) }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            
                                            <button
                                                type="submit"
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                                <span class="btn btn-primary btn-sm">Delete</span>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                          
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div
                    class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                    <span class="flex items-center col-span-3">
                        Showing {{$employees->firstItem() }}-{{$employees->lastItem() }} of {{$employees->total() }}
                    </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                        <nav aria-label="Table navigation">
                            <ul class="inline-flex items-center">
                                
                                <li>
                                    <a href="{{$employees->url($employees->currentPage() - 1 ) }}">
                                        <button
                                            class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                                            aria-label="Previous">
                                            <svg class="w-4 h-4 fill-current" aria-hidden="true"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </a>
                                </li>

                                @php

                                $curPage = $employees->currentPage();
                                $totalPage = $employees->lastPage();

                                $startPage = ($curPage < 5)? 1 : $curPage - 4;
                                $endPage = 8 + $startPage;
                                $endPage = ($totalPage < $endPage) ? $totalPage : $endPage;
                                $diff = $startPage - $endPage + 8;
                                $startPage -= ($startPage - $diff > 0) ? $diff : 0;

                                @endphp

                                @if($employees->total())
                                    
                                    @for ($i=$startPage; $i<=$endPage; $i++)
                                        <li>
                                            <a href="{{ $employees->url($i) }}">
                                                @php
                                                    if ($curPage != $i) echo '<button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                    else echo '<button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                @endphp
                                            </a>
                                        </li> 
                                    @endfor
                            
                                @endif

                                <li>
                                    <a href="{{ $employees->nextPageUrl() }}">
                                    <button
                                        class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                                        aria-label="Next">
                                        <svg class="w-4 h-4 fill-current" aria-hidden="true"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    </a>
                                </li>

                            </ul>
                        </nav>
                    </span>
                </div>
            </div>
        </div>
</x-app-layout>