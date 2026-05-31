<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * PBI#29 – Validasi update profil langsung ke tabel users.
 * Field no_hp divalidasi di sini agar tersimpan ke kolom no_hp
 * pada tabel akun utama (arsitektur terpusat).
 */
class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // PBI#29: no_hp disimpan langsung di tabel users
            'no_hp' => [
                'nullable',
                'string',
                'regex:/^[0-9+\-\s]+$/',
                'min:10',
                'max:20',
            ],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'no_hp.regex' => 'Nomor telepon hanya boleh berisi angka, +, -, atau spasi.',
            'no_hp.min'   => 'Nomor telepon minimal 10 digit.',
            'no_hp.max'   => 'Nomor telepon maksimal 20 digit.',
        ];
    }
}
