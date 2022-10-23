<x-app-layout title="รายละเอียดรถ">
    <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 ">
        <div class="container mx-auto">

            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                รายละเอียดรถ
            </h2>
            
            <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="flex">
                    <a href="{{ route('trucks.index') }}" class="flex items-center justify-between px-6 py-3 text-sm leading-5 mx-2 transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-lg">
                        <span class="text-base">กลับหน้าแรก</span>
                    </a>

                    @if (Gate::check('truck_access'))
                    <a href="{{ url('trucks/'.$truck->id.'/edit') }}" class="flex items-center justify-between px-6 py-3 text-sm leading-5 mx-2  transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-lg">
                        <span class="text-base">แก้ไข</span>
                    </a>
                    @endif
                </div>
            
                <div class="flex flex-col mt-6">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-100 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 w-full text-left text-sm">
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            รหัสรถ
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            {{ $truck->id }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            ป้ายทะเบียน
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            {{ $truck->plateNumber }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            สถานะ
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            {{ $truck->truck_status }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            เส้นทางหลัก
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" readonly>ตำบล{{ $truck->truck_sub_district }} อำเภอ{{ $truck->truck_district }} จังหวัด{{ $truck->truck_province }} {{ $truck->truck_postcode }}</textarea><br>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            คนขับ
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            {{ $truck->user ? $truck->user->name : ('(ยังไม่ได้ตั้งค่า)') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-gray-500 uppercase tracking-wider dark:text-gray-400 dark:bg-gray-800">
                                            วันที่สร้าง
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 bg-white divide-y divide-gray-200 dark:text-gray-400 dark:bg-gray-800">
                                            {{ $truck->created_at }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
