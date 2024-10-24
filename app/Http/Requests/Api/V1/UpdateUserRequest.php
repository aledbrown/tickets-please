<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends BaseUserRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data.attributes.name' => 'sometimes|string',
            'data.attributes.email' => 'sometimes|email',
            'data.attributes.isManager' => 'sometimes|boolean',
            'data.attributes.password' => 'sometimes|string',
        ];
    }
}
