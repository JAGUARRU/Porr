<x-app-layout title="พนักงานใหม่">
    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            
        </h2>

        <div class="container ">
            <div class="flex flex-row">
                <svg class="h-6 w-6 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                    สร้างข้อมูลพนักงาน
                </h4>
            </div>

            <form method="post" action="{{ route('users.store') }}" autocomplete="off" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="col-span-1">
                        <div>
                            <label for="empId text-gray-700 dark:text-gray-400">รหัสพนักงาน <span class="text-red-600">*</span></label>
                            <input type="text" name="empId" id="empId" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                                   value="{{ old('empId', $empId) }}" />
                            @error('empId')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="name text-gray-700 dark:text-gray-400">ชื่อ-สกุลพนักงาน <span class="text-red-600">*</span></label>
                            <input type="text" name="name" id="name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                   value="{{ old('name', '') }}" />

                            @error('name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="username text-gray-700 dark:text-gray-400">ชื่อผู้ใช้ <span class="text-red-600">*</span></label>
                            <input type="text" name="username" id="username" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                   value="{{ old('username', '') }}" />

                            @error('username')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="email text-gray-700 dark:text-gray-400">อีเมล <span class="text-red-600">*</span></label>
                            <input type="email" name="email" id="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                   value="{{ old('email', '') }}" />
                            @error('email')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="password text-gray-700 dark:text-gray-400">กำหนดรหัสผ่าน <span class="text-red-600">*</span></label>
                            <input type="password" name="password" id="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                            @error('password')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="positions text-gray-700 dark:text-gray-400">ชื่อตำแหน่ง</label>
                            <input type="text" name="positions" id="positions" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            value="{{ old('positions', '') }}" />
                            @error('positions')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="col-span-1">
                        <div class="">
                            <label for="roles text-gray-700 dark:text-gray-400"></label></label>สิทธิ์ <span class="text-red-600">*</span></label>
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
                            <label for="address" class="text-gray-700 dark:text-gray-400">ที่อยู่</label>
                            
                            <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" name="address" placeholder="รายละเอียดที่อยู่">{{ old('address') }}</textarea>

                            @error('address')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mt-4">
                            <label for="phoneNumber" class="text-gray-700 dark:text-gray-400">เบอร์ติดต่อ</label>
                            <input type="text" name="phoneNumber" id="phoneNumber" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                   value="{{ old('phoneNumber') }}" />

                            @error('phoneNumber')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="IDCardNumber" class="text-gray-700 dark:text-gray-400">หมายเลขบัตรประชาชน <span class="text-red-600">*</span></label>
                            <input type="text" name="IDCardNumber" id="IDCardNumber" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                   value="{{ old('IDCardNumber') }}" />
                            @error('IDCardNumber')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!--<div class="mt-4">
                            <label class="text-gray-700 dark:text-gray-400 col-span-2" name="emp_status">สถานะ</label>
                        </div>
                        <div class="mt-4">
                            <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                                <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="inactive" value="0" checked />
                                <span class="ml-2">ปกติ</span>
                            </label>
                            <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                                <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="inactive" value="1" />
                                <span class="ml-2">ระงับบัญชี</span>
                            </label>
                        </div>-->

                        <div class="flex mt-12 place-content-end pb-4">
                            <div class="pr-6">
                                    <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >
                                        <span>สร้าง</span>
                                    </button>
                            </div>
                            <div class="pr-4 mt-2">
                                <a href="{{ route('users.index') }}" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded">
                                    <span>ยกเลิก</span>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
</x-app-layout>