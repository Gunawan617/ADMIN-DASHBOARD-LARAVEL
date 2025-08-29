<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp|max:5120',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format gambar yang didukung: JPEG, PNG, JPG, GIF, WebP, BMP.',
            'cover_image.max' => 'Ukuran gambar maksimal 5MB.',
        ];
    }
}
