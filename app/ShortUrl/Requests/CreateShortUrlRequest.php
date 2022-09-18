<?php

namespace App\ShortUrl\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShortUrlRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'link' => 'required|string',
            'slug' => 'string|unique:short_urls,slug',
            'exit_page' => 'boolean',
        ];
    }
}
