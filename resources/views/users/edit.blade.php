<x-app-layout title="แก้ไขผู้ใช้งาน">
    <div class="container grid px-6 mx-auto ">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            แก้ไขผู้ใช้งาน
        </h2>

        <div class="container">
            <div class="flex flex-row">
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                    </path>
                </svg>
                <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                    แก้ไขข้อมูลพนักงาน
                </h4>
            </div>

            <form method="post" action="{{ route('users.update', $user->id) }}" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
                @csrf
                @method('put')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="col-span-1">
                        <div>
                            <label for="name text-gray-700 dark:text-gray-400">ชื่อ-สกุลพนักงาน</label>
                            <input type="text" name="name" id="name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                                    value="{{ old('name', $user->name) }}" />
                            @error('name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="username text-gray-700 dark:text-gray-400">ชื่อผู้ใช้</label>
                            <input type="text" name="username" id="username" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                   value="{{ old('username', $user->username) }}" />

                            @error('username')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="email text-gray-700 dark:text-gray-400">อีเมล</label>
                            <input type="email" name="email" id="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                   value="{{ old('email', $user->email) }}" />
                            @error('email')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="password text-gray-700 dark:text-gray-400">รหัสผ่าน</label>
                            <input type="password" name="password" id="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="เว้นว่างไว้เมื่อไม่ต้องการที่จะเปลี่ยนรหัสผ่านใหม่" />
                            @error('password')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="positions text-gray-700 dark:text-gray-400">ตำแหน่ง</label>
                            <select name="positions[]" id="positions" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" multiple="multiple">
                                @foreach($positions as $id => $position)
                                    <option value="{{ $id }}"{{ in_array($id, old('positions', $user->positions->pluck('id')->toArray())) ? ' selected' : '' }}>
                                        {{ $position }}
                                    </option>
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
                                    <option value="{{ $id }}"{{ in_array($id, old('roles', $user->roles->pluck('id')->toArray())) ? ' selected' : '' }}>
                                        {{ $role }}
                                    </option>
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
                                <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="inactive" value="0" {{ !$user->inactive ? ('checked') : ('') }} />
                                <span class="ml-2">ปกติ</span>
                            </label>
                            <label class="inline-flex items-center text-gray-600 dark:text-gray-400 ml-9">
                                <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="inactive" value="1" {{ $user->inactive ? ('checked') : ('') }} />
                                <span class="ml-2">ระงับบัญชี</span>
                            </label>
                        </div>

                        <div class="flex mt-12 place-content-end pb-4">
                            <div class="pr-6">
                                <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    แก้ไข
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>