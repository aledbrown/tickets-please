<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends BaseUserRequest
{
    public function authorize(): bool
    {
        // THIS MAKES AUTH CHECK COME BEFORE VALIDATION CHECK
        if (!$this->user()->tokenCan(Abilities::CreateUser)) {
            return false;
        }
        return true;
    }

    public function rules(): array
    {
        return [
            'data.attributes.name' => 'required|string',
            'data.attributes.email' => 'required|email|unique:users,email',
            'data.attributes.isManager' => 'required|boolean',
            'data.attributes.password' => 'required|string',
        ];
    }
}
