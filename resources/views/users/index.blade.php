
<x-app-layout title="พนักงาน">
    <div class="container grid px-6 mx-auto">
            <div class="flex flex-row">
                <div class="flex w-full">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        ข้อมูลพนักงาน
                    </h2>
                </div>

                @if (Gate::check('user_access'))
                <div class="flex w-full place-content-end place-items-end">
                    <a href="{{ route('users.create') }}">
                    <button class="flex items-center justify-between px-6 py-3 text-sm leading-5  transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-full">   
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
                @endif
            </div>

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
                                <th class="px-4 py-3">รหัสพนักงาน</th>
                                <th class="px-4 py-3">ชื่อ-สกุลพนักงาน</th>
                                <th calss="px-4 py-3">อีเมล</th>
                                <th class="px-4 py-3">ตำแหน่ง</th>
                                <th class="px-4 py-3">สิทธิ์</th>
                                <th class="px-4 py-3">สถานะ</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                            @foreach ($users as $user)

                            <tr class="text-gray-700 dark:text-gray-400 ">
                                <td class="px-4 py-3 text-sm">
                                    {{ $user->empId }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $user->name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $user->positions }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    @foreach ($user->roles as $role)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $role->title }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($user->inactive)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500 text-gray-100">
                                            ถูกระงับ
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            ปกติ
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">

                                    <div class="flex items-center space-x-4 text-sm">
                                        
                                        <a href="{{ route('users.show', $user->id) }}">
                                        <button
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5 mx-1" fill="none" viewBox="0 0 24 24" stroke-width="1.0" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                              </svg>
                                              
                                            แสดง
                                        </button>
                                        </a>    

                                        @if (Gate::check('user_access'))
                                        <a href="{{ route('users.edit', $user->id) }}">
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                <svg class="w-5 h-5 mx-1" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                                แก้ไข
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
                    {{ __('pagination.showing') }} {{ $users->firstItem() }}-{{ $users->lastItem() }} {{ __('pagination.of') }} {{ $users->total() }}
                </span>
                <span class="col-span-2"></span>
                <!-- Pagination -->
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    <nav aria-label="Table navigation">
                        <ul class="inline-flex items-center">
                            
                            <li>
                                <a href="{{ $users->url( $users->currentPage() - 1 ) }}">
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

                            $curPage = $users->currentPage();
                            $totalPage = $users->lastPage();

                            $startPage = ($curPage < 5)? 1 : $curPage - 4;
                            $endPage = 8 + $startPage;
                            $endPage = ($totalPage < $endPage) ? $totalPage : $endPage;
                            $diff = $startPage - $endPage + 8;
                            $startPage -= ($startPage - $diff > 0) ? $diff : 0;

                            @endphp

                            @if($users->total())
                                
                                @for ($i=$startPage; $i<=$endPage; $i++)
                                    <li>
                                        <a href="{{ $users->url($i) }}">
                                            @php
                                                if ($curPage != $i) echo '<button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                else echo '<button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                            @endphp
                                        </a>
                                    </li> 
                                @endfor
                        
                            @endif

                            <li>
                                <a href="{{ $users->nextPageUrl() }}">
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