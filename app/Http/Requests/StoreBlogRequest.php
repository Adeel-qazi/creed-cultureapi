<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'title' => 'required|min:3',
            'description' => 'nullable|min:3',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }


    public function messages(): array 
    {
        return [
          'title.required' => 'The :attribute field must be required',
          'title.min' => 'The :attribute field must be at least :min characters long',
          'image.required' => 'The :attribute field must be required',
          'image.mimes' => 'The :attribute field must be a file of type: png, jpg, jpeg',

        ];
    }
}
