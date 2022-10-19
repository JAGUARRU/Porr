<x-app-layout title="ยืนยันการขนส่ง">
    <div class="container grid px-6 mx-auto ">
        <div class="my-6">
            <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 ">

                <h2 class="m-5 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    รายการการจัดส่ง
                </h2>

                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">รหัสรถ</th>
                                <th class="px-4 py-3">คนขับ</th>
                                <th class="px-4 py-3">ป้ายทะเบียน</th>
                                <th class="px-4 py-3">กำหนดส่ง</th>
                                <th class="px-4 py-3">สถานะ</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($trucks as $truck)
                            <tr class="text-gray-700 dark:text-gray-400">

                                <td class="px-4 py-3">
                                {{ $truck->id }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $truck->user ? $truck->user->name : 'None' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $truck->plateNumber }}
                                </td>

                                <td class="px-4 py-3">
                                    @if($truck->transportDate)
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $truck->transportDate)->thaidate('j F Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    @if($truck->transportDate)
                                        {{ Helper::GetRouteStatus($truck->route_status) }}
                                        @if($truck->route_status != 2)
                                            กำหนดส่ง {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Helper::DateTimeStringToEndOfDay($truck->transportDate))->diffForHumans() }}
                                        @endif
                                    @else
                                        {{$truck->routes_count == 0 ? $truck->truck_status : Helper::GetRouteStatus($truck->route_status) }}
                                    @endif
                                    
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">

                                        <a href="{{ url('truckloads/route/'.$truck->route_id.'/edit') }}" class="btn btn-primary btn-sm">
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                จัดการ
                                            </button>
                                        </a>

                                        @if($truck->transportDate)
                                        <a href="{{ url('truckloads/route/'.$truck->route_id.'/print') }}" class="btn btn-primary btn-sm">
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Print">
                                                พิมพ์ใบส่งของ
                                            </button>
                                        </a>
                                        @endif

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
                        {{ __('pagination.showing') }} {{ $trucks->firstItem() }}-{{ $trucks->lastItem() }} {{ __('pagination.of') }} {{ $trucks->total() }}
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
</div>
</x-app-layout>