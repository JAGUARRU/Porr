<x-app-layout title="เพิ่มพนักงาน">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            จัดการข้อมูล
        </h2>

        <div class="container">
            <div class="flex flex-row">
                <svg class="h-6 w-6 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                    สร้างผู้ใช้
                </h4>
            </div>

            <form method="post" action="{{ route('users.store') }}" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="col-span-1">
                        <div>
                            <label for="empId text-gray-700 dark:text-gray-400">รหัสพนักงาน</label>
                            <input type="text" name="empId" id="empId" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                                   value="{{ old('empId', $empId) }}" />
                            @error('empId')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="name text-gray-700 dark:text-gray-400">ชื่อ-สกุลพนักงาน</label>
                            <input type="text" name="name" id="name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                   value="{{ old('name', '') }}" />
                            @error('name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="email text-gray-700 dark:text-gray-400">อีเมล</label>
                            <input type="email" name="email" id="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                   value="{{ old('email', '') }}" />
                            @error('email')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="password text-gray-700 dark:text-gray-400">รหัสผ่าน</label>
                            <input type="password" name="password" id="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                            @error('password')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="positions text-gray-700 dark:text-gray-400">ตำแหน่ง</label>
                            <select name="positions[]" id="positions" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" multiple="multiple">
                                @foreach($positions as $id => $position)
                                    <option value="{{ $id }}"{{ in_array($id, old('positions', [])) ? ' selected' : '' }}>{{ $position }}</option>
                                @endforeach
                            </select>
                            @error('positions')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="col-span-1">
                        <div class="">
                            <label for="roles text-gray-700 dark:text-gray-400"></label></label>บทบาท</label>
                            <select name="roles[]" id="roles" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" multiple="multiple">
                                @foreach($roles as $id => $role)
                                    <option value="{{ $id }}"{{ in_array($id, old('roles', [])) ? ' selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="text-gray-700 dark:text-gray-400 col-span-2" name="emp_status">สถานะ</label>
                        </div>
                        <div class="mt-4">
                            <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                                <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="emp_status" value="พร้อมใช้งาน" checked />
                                <span class="ml-2">พร้อมใช้งาน</span>
                            </label>
                            <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                                <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="emp_status" value="ไม่พร้อมใช้งาน" />
                                <span class="ml-2">ไม่พร้อมใช้งาน</span>
                            </label>
                        </div>

                        <div class="flex mt-12 place-content-end pb-4">
                            <div class="pr-6">
                                <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    สร้าง
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

    
</x-app-layout>