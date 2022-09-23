<x-app-layout title="รายละเอียดพนักงาน">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show User
        </h2>
    </x-slot>

    <div>
        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex">
                <a href="{{ route('users.index') }}" class="flex items-center justify-between px-6 py-3 text-sm leading-5  transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-lg">
                    <span class="text-base">กลับหน้าแรก</span>
                </a>
            </div>
           
            <div class="flex flex-col mt-6">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-100 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full text-left text-sm">
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        รหัสพนักงาน
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $user->id }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        ชื่อ-สกุลพนักงาน
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $user->name }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        อีเมล
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $user->email }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        ยืนยันอีเมลเมื่อ
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $user->email_verified_at }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        บทบาท
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        @foreach ($user->roles as $role)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $role->title }}
                                                </span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        ตำแหน่ง
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        @foreach ($user->positions as $position)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $position->title }}
                                                </span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider">
                                        สถานะการใช้งาน
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200">
                                        {{ $user->emp_status }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="block mt-8">
                <a href="{{ route('users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded">Back to list</a>
            </div>-->
        </div>
    </div>
</x-app-layout>
