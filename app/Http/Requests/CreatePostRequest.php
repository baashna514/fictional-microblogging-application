<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'image|mimes:jpeg,png,gif,webp',
        ];
    }
}
