<?php

namespace App\JsonApi\V1\ActivityTypes;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class ActivityTypeRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

}
