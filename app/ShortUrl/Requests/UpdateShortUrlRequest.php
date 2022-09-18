<?php

namespace App\ShortUrl\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShortUrlRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'short_url_id' => 'required|exists:short_urls,id',
            'name' => 'string',
            'link' => 'string',
            'slug' => 'string',
            'exit_page' => 'boolean',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['short_url_id'] = $this->route('id');

        return $data;
    }
}
