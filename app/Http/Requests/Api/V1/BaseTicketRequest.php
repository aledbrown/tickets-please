<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseTicketRequest extends FormRequest
{



    public function messages()
    {
        return [
            'data.attributes.title.required' => 'The title field is required.',
            'data.attributes.description.required' => 'The description field is required.',
            'data.attributes.status' => 'The data.attributes.status value is invalid. Please use A, C, H, or X.',
            'data.relationships.author.data.id.required' => 'The author field is required.',
        ];
    }
}
