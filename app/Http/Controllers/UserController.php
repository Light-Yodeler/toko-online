<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'user',
            'user' => Auth::id(),
        ];
        return view('admin.user', $data);
    }

    public function dataUser()
    {
        if (request()->ajax()) {
            $data = User::with('role') // eager load role dengan kolom id dan name
                ->select(['id', 'name', 'username', 'email', 'role_id']); // foreign key role_id dari tabel users/ pilih kolom yang dibutuhkan
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    return $row->role->name;
                })
                ->addColumn('photo', function ($row) {
                    $src = route('admin.user.photo', $row->id); // atau asset('storage/photos/'.$row->photo)
                    return '<img src="' . $src . '" alt="Avatar" class="w-10 h-10 object-cover border border-gray-300">';
                })
                ->addColumn('action', function ($row) {
                    $url = route('admin.user.delete', $row->id);
                    $editUrl = route('admin.user.edit', $row->id);
                    $id = $row->id;
                    // $url = '#';
                    return '
                    <a href="' . $editUrl . '" class="px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700 mr-2">
            Edit
        </a>
        <form id="delete-form-' . $row->id . '" action="' . $url . '" method="POST" style="display:inline">
            ' . csrf_field() . '
            ' . method_field('DELETE') . '
            <button type="submit"
            class="delete-btn px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700"
            data-id="' . $row->id . '">
            Delete
        </button>
        </form>
    ';
                })
                ->rawColumns(['action', 'photo'])
                ->make(true);
        }
    }

    public function addUser()
    {

        $data = [
            'role' => Role::select('id', 'name')->get(),
        ];
        return view('admin.adduser', $data);
    }

    public function createUser(StoreUserRequest $request)
    {
        $validated = $request->validated();

        //handle foto jika ada
        if ($request->hasFile('photo')) {
            //generate nama file
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            //simpan file di storage/app/public -> akan membuat folder users jika belum ada
            // $path = $request->file('photo')->storeAs('users', $filename, 'public');
            $path = $request->file('photo')->storeAs('users', $filename, 'private'); // <= private
        }

        User::create([
            'username' => $validated['username'],
            'role_id'  => $validated['role'],
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt('password'),
            'photo_path' => $path,
        ]);

        return redirect()->route('admin.user')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $currentData = User::with('role')->select('id', 'username', 'email', 'role_id', 'name', 'photo_path')->find($id);
        $data = [
            'editData' => $currentData,
            'role' => Role::select('id', 'name')->get(),
            'user' => User::find($id),
        ];

        return view('admin/edit', $data);
    }

    public function update(StoreUserRequest $request, string $id)
    {
        $validated = $request->validated();
        // $user = User::updateOrCreate(
        //     ['email' => $request->email], // kriteria untuk mencari data
        //     $request->validated()         // data untuk update atau create
        // );

        if ($request->hasFile('photo')) {
            $user = User::find($id);
            // hapus foto lama jika ada
            if ($user->photo_path && Storage::disk('public')->exists($user->photo_path)) {
                Storage::disk('public')->delete($user->photo_path);
            }
            // store file baru
            $path = $request->file('photo')->store('users', 'public');
        }
        $user = User::findOrFail($id);
        $user->update([
            'username' => $validated['username'],
            'role_id'  => $validated['role'],
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'photo_path' => $path,

        ]);
        return redirect()->route('admin.user');
    }

    public function destroy(string $id)
    {
        User::find($id)->delete();

        return back();
    }
}
