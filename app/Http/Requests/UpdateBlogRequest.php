<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
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
            'title' => 'min:3',
            'description' => 'nullable|min:10',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }


    public function messages(): array 
    {
        return [
          'title.min' => 'The :attribute field must be at least :min characters long',
          'image.mimes' => 'The :attribute field must be a file of type: png, jpg, jpeg',

        ];
    }
}
