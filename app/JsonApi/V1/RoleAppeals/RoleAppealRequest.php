<?php

namespace App\JsonApi\V1\Rolerequests;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class RoleAppealRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'role_id' => ['required', 'string'],
            'message' => ['nullable', 'string']
        ];
    }

}
