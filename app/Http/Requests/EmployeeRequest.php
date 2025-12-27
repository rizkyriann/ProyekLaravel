<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya user yang login dan role admin/superadmin yang boleh
        return Auth::check() && in_array(Auth::user()->role, ['superadmin', 'admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'alamat' => 'nullable|string|max:500',
            'no_telp' => 'required|string|max:20',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
            'ktp_document' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120', // max 5MB
        ];

        // Jika update (ada param employee id), abaikan unique email untuk user yang sama
        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $userId = $this->route('employee')->user_id ?? null;
            if ($userId) {
                $rules['email'] = 'required|email|max:255|unique:users,email,' . $userId;
            }
        }

        return $rules;
    }

    /**
     * Custom messages (opsional)
     */
    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Wajib isi nama lengkap.',
            'jenis_kelamin,required' => 'Wajib pilih jenis kelamin.',
            'no_telp.required' => 'Wajib isi nomor telepon aktif.',
            'photo.required' => 'Foto wajib diunggah.',
            'photo.image' => 'File foto harus berupa gambar.',
            'photo.mimes' => 'Foto harus berekstensi jpeg, jpg, atau png.',
            'photo.max' => 'Foto maksimal 2MB.',
            'ktp_document.required' => 'KTP wajib diunggah.',
            'ktp_document.mimes' => 'KTP harus berupa pdf, jpeg, jpg, atau png.',
            'ktp_document.max' => 'KTP maksimal 5MB.',
        ];
    }
}
