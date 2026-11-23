<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna boleh melakukan request
     */
    public function authorize(): bool
    {
        return $this->user()?->role === 'customer';
    }

    /**
     * Aturan validasi checkout
     */
    public function rules(): array
    {
        return [
            'recipient_name' => [
                'required',
                'string',
                'max:120',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'address' => [
                'required',
                'string',
                'max:1000',
            ],

            'shipping_service_id' => [
                'required',
                'exists:shipping_services,id',
            ],
        ];
    }

    /**
     * Pesan error validasi
     */
    public function messages(): array
    {
        return [
            'recipient_name.required' => 'Nama penerima wajib diisi.',
            'recipient_name.max' => 'Nama penerima maksimal 120 karakter.',

            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.max' => 'Nomor telepon maksimal 30 karakter.',

            'address.required' => 'Alamat wajib diisi.',
            'address.max' => 'Alamat maksimal 1000 karakter.',

            'shipping_service_id.required' => 'Silakan pilih layanan pengiriman.',
            'shipping_service_id.exists' => 'Layanan pengiriman tidak ditemukan.',
        ];
    }
}
