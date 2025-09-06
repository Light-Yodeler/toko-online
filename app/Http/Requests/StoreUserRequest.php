<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $userId = $this->route('user')->id ?? null;
        $this->merge([
            'user_id' => $this->route('id'),
        ]);
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->user_id),
                'regex:/^[A-Za-z0-9_]+$/'
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user_id)
            ],
            'role' => [
                'required',
                'integer',
                Rule::in([1, 2, 3]),        // hanya boleh 1, 2, atau 3
                Rule::exists('roles', 'id') // memastikan ID ada di tabel roles
            ],
            'photo'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'Form username tidak boleh kosong.',
            'username.unique'  => 'Username sudah digunakan.',
            'username.regex'   => 'Username hanya boleh huruf, angka, dan underscore.',

            'name.required'    => 'Nama lengkap wajib diisi.',
            'name.max'         => 'Nama maksimal 255 karakter.',

            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'email.unique'     => 'Email sudah terdaftar.',

            'role.required' => 'Role harus dipilih.',
            'role.integer'  => 'Role harus berupa angka.',
            'role.in'       => 'Role tidak valid.',
            'role.exists'   => 'Role tidak ditemukan.',

            'photo.image'      => 'Hanya file gambar diperbolehkan',
            'photo.mimes'      => 'Foto hanya boleh jpg, jpeg, atau png.',
            'photo.max'        => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
