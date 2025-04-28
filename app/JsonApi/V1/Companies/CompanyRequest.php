<?php

namespace App\JsonApi\V1\Companies;

use App\Enums\CompanyStatusEnum;
use App\Enums\DocumentTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class CompanyRequest extends ResourceRequest
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
            'activityTypes' => JsonApiRule::toMany(),
            'phone' => 'nullable|string',
            'email' =>  ['required', 'string', Rule::unique('companies', 'email')],
            'website' => 'nullable|string',
            'address' => 'nullable|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'document_type' => [
                'required',
                new Enum(DocumentTypeEnum::class),
            ],
            'document' => 'required|string',
            'status' => [
                'required',
                new Enum(CompanyStatusEnum::class),
            ],
        ];
    }

}
