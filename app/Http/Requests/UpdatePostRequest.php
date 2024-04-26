<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        $post = $this->route('post');
        return $this->user()->id === $post->user_id;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ];
    }
}
