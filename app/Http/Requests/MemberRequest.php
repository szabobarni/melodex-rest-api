<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
                'instrument' => 'nullable|string|min:2',
                'year' => 'nullable|numeric',
                'artist_id' => 'nullable|numeric',
                'image' => 'nullable|string|min:2'
            ];
        }
        return [
            'name' => 'required|string|min:2',
            'instrument' => 'required|string|min:2',
            'year' => 'required|numeric',
            'artist_id' => 'required|numeric',
            'image' => 'required|string|min:2'
        ];
    }
}
