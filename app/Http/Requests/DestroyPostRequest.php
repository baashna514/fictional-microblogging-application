<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestroyPostRequest extends FormRequest
{
    public function authorize()
    {
        $post = $this->route('post');
        return $this->user()->id === $post->user_id;
    }

    public function rules()
    {
        return [];
    }
}
