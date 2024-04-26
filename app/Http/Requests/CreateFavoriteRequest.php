<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFavoriteRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user();
    }

    public function rules()
    {
        return [];
    }
}
