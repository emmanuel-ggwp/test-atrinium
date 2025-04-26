<?php

namespace App\JsonApi\V1\Users;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class UserRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $model = $this->model();
        $unique = Rule::unique('users');

        /** @var \App\Models\User|null $user */
        if ($user = $this->model()) {
            $unique->ignore($user);
        }

        return [
            'name' => [$model ? 'filled' : 'required', 'string'],
            'email' => [$model ? 'filled' : 'required', 'email', $unique, 'string'],
            'password' => [
                $model ? 'filled' : 'required',
                'string',
            ],
            'phone' => [
                'nullable',
                'string',
                $unique,
            ]
        ];
    }


}
