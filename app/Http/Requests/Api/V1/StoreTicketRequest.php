<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends BaseTicketRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /*
     * POSTMAN DATA
    {
        "data": {
            "attributes": {
                "title": "First ticket",
                "description": "This is the first ticket we created.",
                "status": "C"
            },
            "relationships": {
                "author": {
                    "data": { "id": 1 }
                }
            }
        }
    }
     */

    public function rules(): array
    {
        $rules = [
            'data.attributes.title' => 'required|string',
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => 'required|string|in:A,C,H,X',
        ];
        if ($this->routeIs('tickets.store')) {
            $rules['data.relationships.author.data.id'] = 'required|integer';
        }
        return $rules;
    }

}
