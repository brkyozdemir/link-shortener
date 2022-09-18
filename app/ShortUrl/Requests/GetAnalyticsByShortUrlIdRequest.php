<?php

namespace App\ShortUrl\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetAnalyticsByShortUrlIdRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'short_url_id' => 'required|exists:short_urls,id'
        ];
    }

    public function all($keys = null): array
    {
        $data = parent::all();
        $data['short_url_id'] = $this->route('id');

        return $data;
    }
}
