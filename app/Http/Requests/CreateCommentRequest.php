<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
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
            'blog_id' => 'required|exists:blogs,id',
            'message' => 'required|string',
        ];
    }


    public function messages(): array 
    {
        return [
            'blog_id.required' => 'The :attribute field is required.',
            'blog_id.exists' => 'The selected :attribute is invalid.',
            'message.required' => 'The :attribute field is required.',
        ];
    }
}
