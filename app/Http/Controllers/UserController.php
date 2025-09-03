<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'user'
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
                ->rawColumns(['action'])
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

        User::create([
            'username' => $validated['username'],
            'role_id'  => $validated['role'],
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt('password'),
        ]);

        return redirect()->route('admin.user');
    }

    public function edit(string $id)
    {
        $currentData = User::with('role')->select('id', 'username', 'email', 'role_id', 'name')->find($id);
        $data = [
            'editData' => $currentData,
            'role' => Role::select('id', 'name')->get(),
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
        $user = User::findOrFail($id);
        $user->update([
            'username' => $validated['username'],
            'role_id'  => $validated['role'],
            'name'     => $validated['name'],
            'email'    => $validated['email']

        ]);
        return redirect()->route('admin.user');
    }

    public function destroy(string $id)
    {
        User::find($id)->delete();

        return back();
    }
}
