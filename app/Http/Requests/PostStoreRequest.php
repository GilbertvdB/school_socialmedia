<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'post_groups' => 'array',
            'post_groups.*' => 'exists:post_groups,id',
    
            // Validate images
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048', // Images should be jpeg, png, jpg, or gif, max 2MB
    
            // Validate documents (allow pdf and docx)
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,docx|max:5120', // Documents should be pdf or docx, max 5MB
        ];
    }
}
