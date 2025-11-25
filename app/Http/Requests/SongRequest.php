<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongRequest extends FormRequest
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
                'lyrics' => 'nullable|string|min:2',
                'songwriter' => 'nullable|string|min:2',
                'album_id' => 'nullable|numeric'
            ];
        }
        return [
            'name' => 'required|string|min:2',
            'lyrics' => 'nullable|string|min:2',
            'songwriter' => 'required|string|min:2',
            'album_id' => 'required|numeric'
        ];
    }
}
