@extends('layouts.home');
@section('content')
    <div class="bg-white w-4,5/5 m-auto mb-10 border-1 border-dashed border-gray-100 shadow-md rounded-lg overflow-hidden">
        <div class="p4 bg-white w-auto flex shadow">
            <a href="{{ route('admin.user') }}"
                class="px-5 py-2 bg-amber-600 m-3 hover:bg-amber-700 rounded shadow shadow-black">Kembali</a>
        </div>
        <div class="p-4 shadow-2xl w-2/3 m-5 mx-auto ">
            <div class="p-4 mx-auto">
                <h1 class="text-center border-b-1">Edit data user</h1>
            </div>
            <form class="max-w-md mx-auto" method="POST" action="{{ route('admin.user.update', $editData->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="relative z-0 w-full mb-5 group">
                    <input type="email" name="email" id="email"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " value="{{ $editData->email }}" />
                    <label for="email"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                        address</label>
                    @error('email')
                        <div class="text-red-500 text-xs">{{ $message }}</div>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="username" id="username"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " value="{{ $editData->username }}" required />
                    <label for="username"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Username</label>
                    @error('username')
                        <div class="text-red-500 text-xs">{{ $message }}</div>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="name" id="name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " value="{{ $editData->name }}" required />
                    <label for="name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
                    @error('name')
                        <div class="text-red-500 text-xs">{{ $message }}</div>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-8 group">
                    <select name="role" id="role"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        required>
                        <option value="" selected disabled class="text-gray-400">Pilih role</option>
                        @foreach ($role as $r)
                            <option value="{{ $r->id }}" {{ $r->id == $editData->role_id ? 'selected' : '' }}>
                                {{ $r->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="text-red-500 text-xs">{{ $message }}</div>
                    @enderror
                </div>
                <label for="role"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Peran (Role)
                </label>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="file" name="photo" id="photo"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                    <label for="photo" class="mt-2 block text-sm text-gray-500">Upload Foto User</label>
                    @error('photo')
                        <div class="text-red-500 text-xs">{{ $message }}</div>
                    @enderror
                    <!-- Preview -->
                    <div class="mt-3">
                        <img id="photoPreview"
                            src="{{ route('admin.user.photo', $user) }}?v={{ $user->updated_at->timestamp }}"
                            alt="Preview Foto" class="w-32 h-32 rounded-full object-cover border border-gray-300">
                    </div>
                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </div>
    </div>
@endsection
