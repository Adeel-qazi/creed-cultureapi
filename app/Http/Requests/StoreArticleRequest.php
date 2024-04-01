<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            'link' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }


    public function messages(): array 
    {
        return [
          'link.required' => 'The :attribute field must be required',
          'image.required' => 'The :attribute field must be required',
          'image.mimes' => 'The :attribute field must be a file of type: png, jpg, jpeg',

        ];
    }
}
