<x-app-layout title="รถ">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            จัดการข้อมูล
        </h2>

            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="flex place-content-end">
                <a href="{{ route('trucks.create') }}">
                <button class="flex items-center justify-between px-6 py-3 text-sm font-medium leading-5  transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 py-0 px-7 border border-blue-500 hover:border-transparent rounded-full">   
                    <svg class="h-5 w-5 mr-2"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
                        <path stroke="none" d="M0 0h24v24H0z"/>  
                            <circle cx="12" cy="12" r="9" /> 
                            <line x1="9" y1="12" x2="15" y2="12" />  
                            <line x1="12" y1="9" x2="12" y2="15" />
                    </svg>
                    <span class="text-base">ข้อมูลรถ</span>
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
                                <th class="px-4 py-3">รหัสรถ</th>
                                <th class="px-4 py-3">พนักงานขับรถ</th>
                                <th class="px-4 py-3">ป้ายทะเบียน</th>
                                <th class="px-4 py-3">สถานะรถ</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                          
                            @foreach ($trucks as $truck)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                   {{ $truck->id }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $truck->user ? $truck->user->name : 'None' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $truck->plateNumber }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($truck->status == "พร้อมใช้งาน" )
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            พร้อมใช้งาน
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500 text-gray-100">
                                            ไม่พร้อมใช้งาน
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    @if (count($truck->routes))
                                        @php
                                            $district = array();
                                        @endphp
                                        @foreach ($truck->routes as $route)
                                            @php
                                                array_push($district, $route->order->retail_district);
                                            @endphp
                                        @endforeach

                                        @foreach (array_unique($district) as $key=>$value)
                                        <!--@//foreach ($district as $key=>$value)-->
                                            <div>มีออเดอร์ที่อำเภอ{{$district[$key]}} 
                                                
                                                @foreach ($truck->routes as $route)
                                                    @if($route->order->retail_district == $district[$key])
                                                        <a class="text-blue-600 underline" href="{{ url('orders/'.$route->order->id) }}" >#{{$route->order->id}}</a>
                                                    @endif
                                                @endforeach
                                            
                                            </div>
                                        @endforeach

                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">

                                        <a href="{{ url('trucks/'.$truck->id) }}" class="btn btn-primary btn-sm">
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="View">
                                                แสดง
                                            </button>
                                        </a>

                                        <a href="{{ url('trucks/'.$truck->id.'/edit') }}" class="btn btn-primary btn-sm">
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                แก้ไข
                                            </button>
                                        </a>

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
                        Showing {{ $trucks->firstItem() }}-{{ $trucks->lastItem() }} of {{ $trucks->total() }}
                    </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                        <nav aria-label="Table navigation">
                            <ul class="inline-flex items-center">
                                
                                <li>
                                    <a href="{{ $trucks->url( $trucks->currentPage() - 1 ) }}">
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

                                $curPage = $trucks->currentPage();
                                $totalPage = $trucks->lastPage();

                                $startPage = ($curPage < 5)? 1 : $curPage - 4;
                                $endPage = 8 + $startPage;
                                $endPage = ($totalPage < $endPage) ? $totalPage : $endPage;
                                $diff = $startPage - $endPage + 8;
                                $startPage -= ($startPage - $diff > 0) ? $diff : 0;

                                @endphp

                                @if($trucks->total())
                                    
                                    @for ($i=$startPage; $i<=$endPage; $i++)
                                        <li>
                                            <a href="{{ $trucks->url($i) }}">
                                                @php
                                                    if ($curPage != $i) echo '<button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                    else echo '<button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                @endphp
                                            </a>
                                        </li> 
                                    @endfor
                            
                                @endif

                                <li>
                                    <a href="{{ $trucks->nextPageUrl() }}">
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