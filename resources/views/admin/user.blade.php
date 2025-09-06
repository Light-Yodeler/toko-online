@extends('layouts.home')
@section('content')
    <div class="bg-white w-4,5/5 m-auto mb-10 border-1  border-dashed border-gray-100 shadow-md rounded-lg overflow-hidden">
        <img src="https://via.placeholder.com/400x300" alt="" class="w-full object-cover object-center" />
        <div class="flex p-3 shadow-2xs">
            {{-- <p class="mb-1 text-gray-900 font-semibold capitalize ">{{ $title }}</p> --}}
            <a href="{{ route('admin.user.add') }}"
                class="px-3 py-2 ml-2 bg-green-600 rounded text-xs font-semibold text-white mr-2 hover:bg-green-700 ">Tambah
                user</a>

        </div>
        <div class="p-4">
            <div class="mx-auto">
                <h1 class="text-xl font-bold mb-4 text-center">Daftar User</h1>
            </div>

            <div class="overflow-x-auto bg-white rounded shadow">
                <table id="users-table" class="min-w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Username</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Photo</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            {{-- <div class="mt-8 mb-3 p-3 shadow-2xs">
                <a href="#"
                    class="px-4 py-2 bg-teal-500 shadow-lg border rounded-lg text-white uppercase font-semibold tracking-wider focus:outline-none focus:shadow-outline hover:bg-teal-400 active:bg-teal-400">Card
                    Button</a>
            </div> --}}
        </div>
    </div>
    @if (session('flash'))
        <script>
            // jadikan objek tunggal, bukan array
            window.flashMessage = @json(session('flash'));
        </script>
    @endif
@endsection
