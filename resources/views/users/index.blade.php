
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
                                <th class="px-4 py-3">บทบาท</th>
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
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    @foreach ($user->positions as $positions)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $positions->title }}
                                        </span>
                                    @endforeach
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

                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('users.show', $user->id) }}" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">แสดง</a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">แก้ไข</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                
            </div>
        </div>
</x-app-layout>