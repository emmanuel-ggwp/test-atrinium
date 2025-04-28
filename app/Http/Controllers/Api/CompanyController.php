<?php

namespace App\Http\Controllers\Api;


use App\Enums\CompanyStatusEnum;
use App\Enums\DocumentTypeEnum;
use App\JsonApi\V1\Companies\CompanyRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Company;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use App\Http\Controllers\Controller;

use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\ErrorResponse;

class CompanyController extends JsonApiController
{

    protected function creating(CompanyRequest $company): void
    {
        if (User::find(auth()->id())->company()->exists()) {
            abort(
                ErrorResponse::make(
                    Error::make()
                        ->setCode('COMPANY_LIMIT')
                        ->setTitle('Conflict')
                        ->setDetail('You can only own one company.')
                        ->setStatus(409)
                )
            );
        }
    }

}
