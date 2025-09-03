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
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'Form username tidak boleh kosong.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username hanya boleh huruf, angka, dan underscore.',

            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'role_id.required' => 'Role harus dipilih.',
            'role_id.integer'  => 'Role harus berupa angka.',
            'role_id.in'       => 'Role tidak valid.',
            'role_id.exists'   => 'Role tidak ditemukan.',
        ];
    }
}
