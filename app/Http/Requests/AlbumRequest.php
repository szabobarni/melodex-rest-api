<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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
        if($this->method() == 'PATCH'){
            return [
                'name' => 'nullable|string|min:2',
                'cover' => 'nullable|string|min:2',
                'year' => 'nullable|numeric',
                'genre' => 'nullable|string|min:10',
                'artist_id' => 'nullable|numeric',
            ];
        }
        return [
            'name' => 'required|string|min:2',
            'cover' => 'required|string|min:2',
            'year' => 'required|numeric',
            'genre' => 'required|string|min:10',
            'artist_id' => 'required|numeric',
        ];
    }
}
