<x-app-layout title="">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            เส้นทางการเดินรถ
        </h2>

            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            
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
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">รหัสออเดอร์</th>
                                <th class="px-4 py-3">ข้อมูลรถ</th>
                                <th class="px-4 py-3">สถานที่ (อำเภอ)</th>
                                <th class="px-4 py-3">สถานะ</th>
                                <th class="px-4 py-3">สร้างเมื่อ</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                          
                            @foreach ($routes as $route)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    {{ $route->id }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $route->order->id }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $route->truck_driver }} ({{ $route->truck->plateNumber }})
                                </td>
                                <td class="px-4 py-3">
                                    {{ $route->order->retail_district }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($route->status)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        ได้รับการยืนยันแล้ว
                                    </span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-red-800">
                                        รอการยืนยัน
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    {{ $route->created_at }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a href="{{ url('routes/confirm/'.$route->id) }}">
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                                จัดการ
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
                        Showing {{ $routes->firstItem() }}-{{ $routes->lastItem() }} of {{ $routes->total() }}
                    </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                        <nav aria-label="Table navigation">
                            <ul class="inline-flex items-center">
                                
                                <li>
                                    <a href="{{ $routes->url( $routes->currentPage() - 1 ) }}">
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

                                $curPage = $routes->currentPage();
                                $totalPage = $routes->lastPage();

                                $startPage = ($curPage < 5)? 1 : $curPage - 4;
                                $endPage = 8 + $startPage;
                                $endPage = ($totalPage < $endPage) ? $totalPage : $endPage;
                                $diff = $startPage - $endPage + 8;
                                $startPage -= ($startPage - $diff > 0) ? $diff : 0;

                                @endphp

                                @if($routes->total())
                                    
                                    @for ($i=$startPage; $i<=$endPage; $i++)
                                        <li>
                                            <a href="{{ $routes->url($i) }}">
                                                @php
                                                    if ($curPage != $i) echo '<button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                    else echo '<button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                @endphp
                                            </a>
                                        </li> 
                                    @endfor
                            
                                @endif

                                <li>
                                    <a href="{{ $routes->nextPageUrl() }}">
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